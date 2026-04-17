<?php

namespace App\Core;

class Controller
{
    protected Session $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    protected function view(string $path, array $data = [], ?string $layout = null): void
    {
        extract($data);
        $session = $this->session;

        $viewPath = dirname(__DIR__, 2) . "/views/{$path}.php";

        if ($layout) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();

            $layoutPath = dirname(__DIR__, 2) . "/views/layouts/{$layout}.php";
            require $layoutPath;
        } else {
            require $viewPath;
        }
    }

    protected function redirect(string $url, string $message = ''): void
    {
        if ($message) {
            $this->session->flash($message);
        }
        header("Location: {$url}");
        exit;
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function validate(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}
