<?php

namespace App\Core;

class App
{
    public static function boot(): void
    {
        // Load .env
        $envPath = dirname(__DIR__, 2) . '/.env';
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '#')) {
                    continue;
                }
                if (str_contains($line, '=')) {
                    [$key, $value] = explode('=', $line, 2);
                    $_ENV[trim($key)] = trim($value);
                }
            }
        }

        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Create router, load routes, dispatch
        $router = new Router();

        $routesFile = dirname(__DIR__, 2) . '/routes.php';
        if (file_exists($routesFile)) {
            require $routesFile;
        }

        $uri = $_SERVER['REQUEST_URI'];
        // Strip base path if app is in a subdirectory
        $basePath = parse_url($_ENV['APP_URL'] ?? '', PHP_URL_PATH) ?: '';
        if ($basePath && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        $router->dispatch($uri ?: '/', $_SERVER['REQUEST_METHOD']);
    }
}
