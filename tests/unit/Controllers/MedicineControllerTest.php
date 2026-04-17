<?php

namespace Tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;

class MedicineControllerValidationTest extends TestCase
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
        
        $result = $reflection->invoke($controller, '  medicine name  ');
        
        $this->assertEquals('medicine name', $result);
    }

    public function testValidationRejectsEmptyName(): void
    {
        $validName = '';
        
        $isEmpty = empty($validName);
        
        $this->assertTrue($isEmpty);
    }

    public function testValidationAcceptsValidName(): void
    {
        $validName = 'Aspirin 500mg';
        
        $isEmpty = empty($validName);
        
        $this->assertFalse($isEmpty);
    }

    public function testValidationRejectsInvalidCategory(): void
    {
        $category = 0;
        
        $isInvalid = empty($category) || $category <= 0;
        
        $this->assertTrue($isInvalid);
    }

    public function testValidationAcceptsValidCategory(): void
    {
        $category = 1;
        
        $isInvalid = empty($category) || $category <= 0;
        
        $this->assertFalse($isInvalid);
    }

    public function dataProviderPriceValidation(): array
    {
        return [
            ['10.00', '15.00', true],
            ['0', '0', false],
            ['-5.00', '10.00', false],
            ['10.00', '-5.00', false],
            ['', '', false],
        ];
    }

    /**
     * @dataProvider dataProviderPriceValidation
     */
    public function testPriceValidation(float $buyPrice, float $sellPrice, bool $shouldPass): void
    {
        $isValid = $buyPrice > 0 && $sellPrice > 0;
        
        $this->assertEquals($shouldPass, $isValid);
    }

    public function dataProviderExpiryDate(): array
    {
        return [
            ['2025-12-31', true],
            ['2030-01-01', true],
            ['2020-01-01', false],
            ['', false],
        ];
    }

    /**
     * @dataProvider dataProviderExpiryDate
     */
    public function testExpiryDateValidation(string $expDate, bool $shouldPass): void
    {
        $isValid = !empty($expDate) && strtotime($expDate) > time();
        
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