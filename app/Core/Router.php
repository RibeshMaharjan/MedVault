<?php

namespace App\Core;

use App\Core\Security\Csrf;

class Router
{
    private array $routes = [];

    public function get(string $uri, string $action, array $middleware = []): void
    {
        $this->addRoute('GET', $uri, $action, $middleware);
    }

    public function post(string $uri, string $action, array $middleware = []): void
    {
        $this->addRoute('POST', $uri, $action, $middleware);
    }

    private function addRoute(string $method, string $uri, string $action, array $middleware): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = '/' . trim(parse_url($uri, PHP_URL_PATH), '/');
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = $this->uriToRegex($route['uri']);
            if (preg_match($pattern, $uri, $matches)) {
                if ($method === 'POST' && !Csrf::validate($_POST[Csrf::fieldName()] ?? null)) {
                    $_SESSION['status'] = 'Invalid CSRF token';
                    if (($_ENV['APP_ENV'] ?? '') === 'testing') {
                        throw new \RuntimeException('Invalid CSRF token');
                    }
                    http_response_code(403);
                    echo 'Invalid CSRF token';
                    return;
                }

                // Run middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    $mw = new $middlewareClass();
                    $mw->handle();
                }

                // Parse controller@method
                [$controllerName, $methodName] = explode('@', $route['action']);
                $controllerClass = "App\\Controllers\\{$controllerName}";
                $controller = new $controllerClass();

                // Extract named params
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }

        http_response_code(404);
        $viewPath = dirname(__DIR__, 2) . '/views/errors/404.php';
        if (is_file($viewPath)) {
            require $viewPath;
            return;
        }

        echo "404 - Page Not Found";
    }

    private function uriToRegex(string $uri): string
    {
        $uri = '/' . trim($uri, '/');
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }
}
