<?php

namespace Tests\Unit\Middleware;

use PHPUnit\Framework\TestCase;
use App\Middleware\AdminMiddleware;

class AdminMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        parent::tearDown();
    }

    public function testHandleBlocksUnauthenticatedUser(): void
    {
        $middleware = new AdminMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleBlocksNonAdminUser(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'user';
        
        $middleware = new AdminMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleAllowsAdminUser(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'admin';
        
        $middleware = new AdminMiddleware();
        
        try {
            $middleware->handle();
        } catch (\Exception $e) {
            $this->fail('Should not throw for admin user');
        }
    }

    public function testHandleBlocksWhenRoleNotSet(): void
    {
        $_SESSION['auth'] = true;
        
        $middleware = new AdminMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleSetsAccessDeniedMessage(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'user';
        
        $middleware = new AdminMiddleware();
        
        try {
            $middleware->handle();
        } catch (\Exception $e) {
            $this->assertEquals('Access denied', $_SESSION['status']);
        }
    }
}