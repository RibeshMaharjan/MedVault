<?php

namespace App\Middleware;

class AdminMiddleware
{
    public function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
            $_SESSION['status'] = 'Please login to continue';
            if (($_ENV['APP_ENV'] ?? '') === 'testing') {
                throw new \RuntimeException('Unauthenticated');
            }
            header('Location: /login');
            exit;
        }

        if (($_SESSION['loggedInUserRole'] ?? '') !== 'admin') {
            $_SESSION['status'] = 'Access denied';
            if (($_ENV['APP_ENV'] ?? '') === 'testing') {
                throw new \RuntimeException('Access denied');
            }
            header('Location: /login');
            exit;
        }
    }
}
