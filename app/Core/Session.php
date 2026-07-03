<?php

namespace App\Core;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['status'] = $message;
        $_SESSION['status_type'] = $type;
    }

    public function getFlash(): ?string
    {
        $msg = $_SESSION['status'] ?? null;
        unset($_SESSION['status']);
        return $msg;
    }

    public function isAuth(): bool
    {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
    }

    public function role(): ?string
    {
        return $_SESSION['loggedInUserRole'] ?? null;
    }

    public function user(): ?array
    {
        return $_SESSION['loggedInUser'] ?? null;
    }

    public function pharmacyId(): ?int
    {
        return isset($_SESSION['pharmacy_id']) ? (int) $_SESSION['pharmacy_id'] : null;
    }

    public function setAuth(array $user, string $role): void
    {
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id(true);
        }
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = $role;
        $_SESSION['loggedInUser'] = $user;
        if ($role === 'user') {
            $_SESSION['pharmacy_id'] = $user['user_id'];
        }
    }

    public function destroy(): void
    {
        unset($_SESSION['auth']);
        unset($_SESSION['loggedInUserRole']);
        unset($_SESSION['loggedInUser']);
        unset($_SESSION['pharmacy_id']);
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id(true);
        }
    }
}
