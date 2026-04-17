<?php

namespace Tests\Unit\Middleware;

use PHPUnit\Framework\TestCase;
use App\Middleware\PharmacyMiddleware;

class PharmacyMiddlewareTest extends TestCase
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
        $middleware = new PharmacyMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleBlocksAdminUser(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'admin';
        
        $middleware = new PharmacyMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleAllowsUserRole(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'user';
        
        $middleware = new PharmacyMiddleware();
        
        try {
            $middleware->handle();
        } catch (\Exception $e) {
            $this->fail('Should not throw for user role');
        }
    }

    public function testHandleBlocksWhenRoleNotUser(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'superadmin';
        
        $middleware = new PharmacyMiddleware();
        
        $this->expectException(\Exception::class);
        
        $middleware->handle();
    }

    public function testHandleSetsAccessDeniedMessage(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'admin';
        
        $middleware = new PharmacyMiddleware();
        
        try {
            $middleware->handle();
        } catch (\Exception $e) {
            $this->assertEquals('Access denied', $_SESSION['status']);
        }
    }
}