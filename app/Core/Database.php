<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        try {
            [$dsn, $user, $pass, $options] = $this->buildConnectionConfig();
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    private function buildConnectionConfig(): array
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $connectionString = $_ENV['DATABASE_URL'] ?? $_ENV['DB_URL'] ?? null;

        if ($connectionString) {
            [$dsn, $user, $pass, $sslMode] = $this->parseConnectionString($connectionString);
        } else {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $name = $_ENV['DB_NAME'] ?? 'pharmacy';
            $user = $_ENV['DB_USER'] ?? 'root';
            $pass = $_ENV['DB_PASS'] ?? '';
            $port = $_ENV['DB_PORT'] ?? null;
            $sslMode = $_ENV['DB_SSL_MODE'] ?? null;

            $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
            if ($port) {
                $dsn .= ";port={$port}";
            }
        }

        $this->applySslOptions($options, $sslMode);

        return [$dsn, $user, $pass, $options];
    }

    private function parseConnectionString(string $connectionString): array
    {
        $parts = parse_url($connectionString);

        if ($parts === false || ($parts['scheme'] ?? '') !== 'mysql') {
            throw new PDOException('Invalid MySQL connection string. Expected mysql://user:pass@host:port/database');
        }

        parse_str($parts['query'] ?? '', $query);

        $host = $parts['host'] ?? 'localhost';
        $port = $parts['port'] ?? null;
        $name = isset($parts['path']) ? ltrim($parts['path'], '/') : 'pharmacy';
        $user = isset($parts['user']) ? urldecode($parts['user']) : ($_ENV['DB_USER'] ?? 'root');
        $pass = isset($parts['pass']) ? urldecode($parts['pass']) : ($_ENV['DB_PASS'] ?? '');
        $charset = $query['charset'] ?? 'utf8mb4';
        $sslMode = $query['ssl-mode'] ?? $query['ssl_mode'] ?? null;

        $dsn = "mysql:host={$host};dbname={$name};charset={$charset}";
        if ($port) {
            $dsn .= ";port={$port}";
        }

        return [$dsn, $user, $pass, $sslMode];
    }

    private function applySslOptions(array &$options, ?string $sslMode): void
    {
        $sslMode = strtolower((string) ($_ENV['DB_SSL_MODE'] ?? $sslMode ?? ''));

        if ($sslMode === '' || $sslMode === 'disabled') {
            return;
        }

        if (!empty($_ENV['DB_SSL_CA']) && defined('PDO::MYSQL_ATTR_SSL_CA')) {
            $options[PDO::MYSQL_ATTR_SSL_CA] = $_ENV['DB_SSL_CA'];
        }

        if (!empty($_ENV['DB_SSL_CERT']) && defined('PDO::MYSQL_ATTR_SSL_CERT')) {
            $options[PDO::MYSQL_ATTR_SSL_CERT] = $_ENV['DB_SSL_CERT'];
        }

        if (!empty($_ENV['DB_SSL_KEY']) && defined('PDO::MYSQL_ATTR_SSL_KEY')) {
            $options[PDO::MYSQL_ATTR_SSL_KEY] = $_ENV['DB_SSL_KEY'];
        }

        if (in_array($sslMode, ['required', 'preferred'], true) && defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
            $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
