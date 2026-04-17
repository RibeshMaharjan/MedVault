<?php

namespace App\Core;

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
        echo "404 - Page Not Found";
    }

    private function uriToRegex(string $uri): string
    {
        $uri = '/' . trim($uri, '/');
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }
}
