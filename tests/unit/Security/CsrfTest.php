<?php

namespace Tests\Unit\Security;

use App\Core\Security\Csrf;
use PHPUnit\Framework\TestCase;

class CsrfTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        parent::tearDown();
    }

    public function testTokenCreatesSessionValue(): void
    {
        $token = Csrf::token();

        $this->assertIsString($token);
        $this->assertSame($token, $_SESSION['_csrf_token']);
        $this->assertGreaterThanOrEqual(64, strlen($token));
    }

    public function testValidateAcceptsCurrentToken(): void
    {
        $token = Csrf::token();

        $this->assertTrue(Csrf::validate($token));
    }

    public function testValidateRejectsMissingOrWrongToken(): void
    {
        Csrf::token();

        $this->assertFalse(Csrf::validate(null));
        $this->assertFalse(Csrf::validate('bad-token'));
    }

    public function testFieldRendersHiddenInput(): void
    {
        $field = Csrf::field();

        $this->assertStringContainsString('name="_csrf_token"', $field);
        $this->assertStringContainsString('type="hidden"', $field);
        $this->assertStringContainsString($_SESSION['_csrf_token'], $field);
    }
}
