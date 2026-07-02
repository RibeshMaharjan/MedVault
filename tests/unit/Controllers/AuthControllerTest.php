<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    public function testValidateSanitizesInput(): void
    {
        $controller = $this->getMockedController();
        
        $reflection = new \ReflectionMethod($controller, 'validate');
        $reflection->setAccessible(true);
        
        $result = $reflection->invoke($controller, '  <script>alert("xss")</script>  ');
        
        $this->assertEquals('&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', $result);
    }

    public function testValidateTrimsWhitespace(): void
    {
        $controller = $this->getMockedController();
        
        $reflection = new \ReflectionMethod($controller, 'validate');
        $reflection->setAccessible(true);
        
        $result = $reflection->invoke($controller, '  test value  ');
        
        $this->assertEquals('test value', $result);
    }

    public function testValidatePreservesNormalText(): void
    {
        $controller = $this->getMockedController();
        
        $reflection = new \ReflectionMethod($controller, 'validate');
        $reflection->setAccessible(true);
        
        $result = $reflection->invoke($controller, 'John Doe');
        
        $this->assertEquals('John Doe', $result);
    }

    public static function dataProviderValidateName(): array
    {
        return [
            ['John Doe', true],
            ["O'Brien", true],
            ['Mary-Jane', true],
            ['123', false],
            ['Test@Name', false],
            ['', false],
            ['   ', false],
        ];
    }

    /**
     * @dataProvider dataProviderValidateName
     */
    public function testNameValidationPattern(string $name, bool $shouldPass): void
    {
        $pattern = "/^[a-zA-Z-' ]*$/";
        
        $isValid = trim($name) !== '' && (bool) preg_match($pattern, $name);
        
        $this->assertEquals($shouldPass, (bool) $isValid);
    }

    public static function dataProviderValidateEmail(): array
    {
        return [
            ['test@example.com', true],
            ['user.name@domain.org', true],
            ['user+tag@example.com', true],
            ['invalid', false],
            ['@example.com', false],
            ['test@', false],
            ['', false],
        ];
    }

    /**
     * @dataProvider dataProviderValidateEmail
     */
    public function testEmailValidation(string $email, bool $shouldPass): void
    {
        $isValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        
        $this->assertEquals($shouldPass, $isValid);
    }

    public static function dataProviderValidatePassword(): array
    {
        return [
            ['Password123', true],
            ['Test1234', true],
            ['pass', false],
            ['PASSWORD', false],
            ['12345678', false],
            ['short', false],
            ['NoNumbers', false],
        ];
    }

    /**
     * @dataProvider dataProviderValidatePassword
     */
    public function testPasswordValidation(string $password, bool $shouldPass): void
    {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        
        $isValid = (bool) preg_match($pattern, $password);
        
        $this->assertEquals($shouldPass, $isValid);
    }

    private function getMockedController(): object
    {
        return new class extends \App\Core\Controller {
            public function __construct()
            {
            }
        };
    }
}
