<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SeedDataTest extends TestCase
{
    public function testSeedSqlDoesNotContainNegativeStockOrPrices(): void
    {
        $sql = file_get_contents(dirname(__DIR__, 2) . '/pharmacy.sql');

        $this->assertDoesNotMatchRegularExpression('/,\s*-\d+(?:\.\d+)?/', $sql);
    }

    public function testCompletedOrderAnalyticsBadgeUsesSuccessStyle(): void
    {
        $view = file_get_contents(dirname(__DIR__, 2) . '/views/pharmacy/analytics/orders.php');

        $this->assertStringContainsString("order.status === 'completed' ? 'text-white bg-success'", $view);
        $this->assertStringNotContainsString("order.status === 'completed' ? 'text-white bg-danger'", $view);
    }
}
