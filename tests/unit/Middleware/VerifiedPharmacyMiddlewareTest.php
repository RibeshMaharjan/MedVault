<?php

namespace Tests\Unit\Middleware;

use App\Middleware\VerifiedPharmacyMiddleware;
use App\Models\Pharmacy;
use PHPUnit\Framework\TestCase;

class VerifiedPharmacyMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_ENV['APP_ENV'] = 'testing';
        $_SESSION = ['pharmacy_id' => 42];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        parent::tearDown();
    }

    public function testAllowsVerifiedPharmacy(): void
    {
        $middleware = new VerifiedPharmacyMiddleware($this->pharmacyStub(true));

        $middleware->handle();

        $this->assertArrayNotHasKey('status', $_SESSION);
    }

    public function testBlocksUnverifiedPharmacy(): void
    {
        $middleware = new VerifiedPharmacyMiddleware($this->pharmacyStub(false));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Verification required');
        $middleware->handle();
    }

    public function testBlocksSessionWithoutPharmacyId(): void
    {
        unset($_SESSION['pharmacy_id']);
        $middleware = new VerifiedPharmacyMiddleware($this->pharmacyStub(true));

        $this->expectException(\RuntimeException::class);
        $middleware->handle();
    }

    private function pharmacyStub(bool $verified): Pharmacy
    {
        return new class($verified) extends Pharmacy {
            public function __construct(private bool $verified)
            {
            }

            public function isVerified(int $pharmacyId): bool
            {
                return $this->verified;
            }
        };
    }
}
