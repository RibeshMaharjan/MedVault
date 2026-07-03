<?php

namespace App\Core;

class ErrorView
{
    public static function render(int $statusCode, string $viewName, string $fallbackText): void
    {
        http_response_code($statusCode);
        $viewPath = dirname(__DIR__, 2) . "/views/errors/{$viewName}.php";
        if (is_file($viewPath)) {
            require $viewPath;
            return;
        }
        echo $fallbackText;
    }
}
