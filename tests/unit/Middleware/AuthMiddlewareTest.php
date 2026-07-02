<?php

namespace Tests\Unit\Middleware;

use PHPUnit\Framework\TestCase;
use App\Middleware\AuthMiddleware;

class AuthMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
        session_start();
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        parent::tearDown();
    }

    public function testHandleRedirectsUnauthenticatedUser(): void
    {
        $middleware = new AuthMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleBlocksWhenAuthNotSet(): void
    {
        $_SESSION['auth'] = null;
        
        $middleware = new AuthMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleBlocksWhenAuthFalse(): void
    {
        $_SESSION['auth'] = false;
        
        $middleware = new AuthMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleAllowsAuthenticatedUser(): void
    {
        $_SESSION['auth'] = true;
        
        $middleware = new AuthMiddleware();
        
        try {
            $middleware->handle();
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Should not throw for authenticated user');
        }
    }

    public function testHandleSetsFlashMessageForUnauthenticated(): void
    {
        $middleware = new AuthMiddleware();
        
        try {
            $middleware->handle();
        } catch (\Exception $e) {
            $this->assertEquals('Please login to continue', $_SESSION['status']);
        }
    }
}
