<?php

namespace Tests\Integration;

use App\Core\Router;
use App\Core\Security\Csrf;
use PHPUnit\Framework\TestCase;

class SecurityPostFlowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        $_POST = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        $_POST = [];
        parent::tearDown();
    }

    public function testPostRouteRejectsMissingCsrfTokenBeforeController(): void
    {
        $router = new Router();
        $router->post('/test-post', 'SecurityTestController@store');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid CSRF token');

        $router->dispatch('/test-post', 'POST');
    }

    public function testPostRouteAcceptsValidCsrfToken(): void
    {
        $router = new Router();
        $router->post('/test-post', 'SecurityTestController@store');
        $_POST['_csrf_token'] = Csrf::token();

        ob_start();
        $router->dispatch('/test-post', 'POST');
        $output = ob_get_clean();

        $this->assertSame('stored', $output);
    }
}

namespace App\Controllers;

class SecurityTestController
{
    public function store(): void
    {
        echo 'stored';
    }
}
