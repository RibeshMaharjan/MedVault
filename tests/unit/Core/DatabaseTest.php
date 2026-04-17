<?php

namespace Tests\Unit\Core;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testGetInstanceReturnsSingleton(): void
    {
        $instance1 = \App\Core\Database::getInstance();
        $instance2 = \App\Core\Database::getInstance();

        $this->assertSame($instance1, $instance2);
    }

    public function testGetInstanceCreatesNewInstance(): void
    {
        $instance = \App\Core\Database::getInstance();

        $this->assertNotNull($instance);
    }

    public function testGetConnectionReturnsPdo(): void
    {
        $instance = \App\Core\Database::getInstance();
        $pdo = $instance->getConnection();

        $this->assertInstanceOf(\PDO::class, $pdo);
    }

    public function testConnectionHasCorrectAttributes(): void
    {
        $instance = \App\Core\Database::getInstance();
        $pdo = $instance->getConnection();

        $this->assertEquals(\PDO::ERRMODE_EXCEPTION, $pdo->getAttribute(\PDO::ATTR_ERRMODE));
        $this->assertEquals(\PDO::FETCH_ASSOC, $pdo->getAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE));
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}