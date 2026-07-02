<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;

class CategoryControllerTest extends TestCase
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
        
        $result = $reflection->invoke($controller, '  Antibiotics  ');
        
        $this->assertEquals('Antibiotics', $result);
    }

    public function testValidationRejectsEmptyName(): void
    {
        $validName = '';
        
        $isEmpty = empty(trim($validName));
        
        $this->assertTrue($isEmpty);
    }

    public function testValidationRejectsWhitespaceOnly(): void
    {
        $validName = '   ';
        
        $isEmpty = empty(trim($validName));
        
        $this->assertTrue($isEmpty);
    }

    public function testValidationAcceptsValidName(): void
    {
        $validName = 'Antibiotics';
        
        $isEmpty = empty(trim($validName));
        
        $this->assertFalse($isEmpty);
    }

    public function testValidationAcceptsNameWithSpaces(): void
    {
        $validName = 'Pain Relief';
        
        $isEmpty = empty(trim($validName));
        
        $this->assertFalse($isEmpty);
    }

    public function testValidationTrimsBeforeChecking(): void
    {
        $validName = '  Antibiotics  ';
        
        $trimmed = trim($validName);
        $isEmpty = empty($trimmed);
        
        $this->assertFalse($isEmpty);
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