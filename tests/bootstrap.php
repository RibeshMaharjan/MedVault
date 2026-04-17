<?php

/**
 * Bootstrap file for PHPUnit tests
 * Sets up autoloading and testing environment
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Set testing environment variables
$_ENV['APP_ENV'] = 'testing';
$_ENV['DB_DRIVER'] = 'sqlite';
$_ENV['DB_NAME'] = ':memory:';

// Reset session for each test
if (session_status() !== PHP_SESSION_NONE) {
    session_destroy();
}
$_SESSION = [];