<?php

namespace Tests\Integration;

use App\Controllers\Pharmacy\AjaxController;
use App\Core\Database;
use App\Core\Security\Csrf;
use PDO;
use PHPUnit\Framework\TestCase;

class ApiAnalyticsFlowTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = Database::getInstance()->getConnection();
        $this->resetSchema();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [
            'auth' => true,
            'loggedInUserRole' => 'user',
            'loggedInUser' => ['user_id' => 1, 'name' => 'Test Pharmacy'],
            'pharmacy_id' => 1,
        ];
        $_GET = [];
        $_POST = [];
    }

    protected function tearDown(): void
    {
        $_GET = [];
        $_POST = [];
        $_SESSION = [];
        parent::tearDown();
    }

    public function testSalesDataReturnsExpectedJsonShape(): void
    {
        $medicineId = $this->seedMedicine('Aspirin', 10);
        $this->seedSale($medicineId, 2, 30.00, 'completed', date('Y-m-d'));
        $_GET['period'] = 'week';

        $data = $this->captureJson(fn() => (new AjaxController())->getSalesData());

        $this->assertArrayHasKey('dates', $data);
        $this->assertArrayHasKey('amounts', $data);
        $this->assertArrayHasKey('averageSale', $data);
        $this->assertArrayHasKey('predictedDates', $data);
        $this->assertArrayHasKey('predictedAmounts', $data);
    }

    public function testOrderDataReturnsExpectedJsonShapeWithAmount(): void
    {
        $medicineId = $this->seedMedicine('Ibuprofen', 25);
        $this->seedOrder($medicineId, 3, 75.00, 'pending', date('Y-m-d'));
        $_GET['period'] = 'week';

        $data = $this->captureJson(fn() => (new AjaxController())->getOrderData());

        $this->assertArrayHasKey('dates', $data);
        $this->assertArrayHasKey('orders', $data);
        $this->assertArrayHasKey('statusDistribution', $data);
        $this->assertArrayHasKey('stats', $data);
        $this->assertArrayHasKey('recentOrders', $data);
        $this->assertArrayHasKey('amount', $data['recentOrders'][0]);
    }

    public function testInventoryLevelsReturnsExpectedJsonShape(): void
    {
        $this->seedMedicine('Low Stock', 5);
        $this->seedMedicine('Out Stock', 0);
        $this->seedMedicine('Healthy Stock', 20);

        $data = $this->captureJson(fn() => (new AjaxController())->getInventoryLevels());

        $this->assertSame(25, $data['totalStock']);
        $this->assertSame(1, $data['lowStockCount']);
        $this->assertSame(1, $data['outOfStockCount']);
        $this->assertCount(2, $data['lowStockItems']);
    }

    public function testMedicineSearchEscapesScriptOutput(): void
    {
        $this->seedMedicine('<script>alert(1)</script>', 10);
        $_POST = [
            '_csrf_token' => Csrf::token(),
            'search' => '<script>',
        ];

        ob_start();
        (new AjaxController())->searchMedicine();
        $output = ob_get_clean();

        $this->assertStringNotContainsString('<script>alert(1)</script>', $output);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $output);
    }

    private function captureJson(callable $callback): array
    {
        ob_start();
        try {
            $callback();
        } catch (\RuntimeException $exception) {
            $this->assertStringStartsWith('JSON response', $exception->getMessage());
        }
        $output = ob_get_clean();

        $decoded = json_decode($output, true);
        $this->assertIsArray($decoded);
        return $decoded;
    }

    private function resetSchema(): void
    {
        $this->pdo->exec('DROP TABLE IF EXISTS user_sales_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS user_order_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS user_medicine_tbl');
        $this->pdo->exec("
            CREATE TABLE user_medicine_tbl (
                m_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                medicine_name TEXT NOT NULL,
                in_stock INTEGER DEFAULT 0,
                sell_price REAL DEFAULT 0
            );
            CREATE TABLE user_sales_tbl (
                s_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                m_id INTEGER,
                price REAL DEFAULT 0,
                quantity INTEGER DEFAULT 0,
                total_amount REAL DEFAULT 0,
                sales_date DATE,
                status TEXT DEFAULT 'pending'
            );
            CREATE TABLE user_order_tbl (
                o_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                m_id INTEGER,
                price REAL DEFAULT 0,
                quantity INTEGER DEFAULT 0,
                total_amount REAL DEFAULT 0,
                order_date DATE,
                status TEXT DEFAULT 'pending'
            );
        ");
    }

    private function seedMedicine(string $name, int $stock): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name, in_stock, sell_price)
            VALUES (1, :name, :stock, 15.00)
        ");
        $stmt->execute(['name' => $name, 'stock' => $stock]);
        return (int) $this->pdo->lastInsertId();
    }

    private function seedSale(int $medicineId, int $quantity, float $total, string $status, string $date): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_sales_tbl (pharmacy_id, m_id, price, quantity, total_amount, sales_date, status)
            VALUES (1, :m_id, 15.00, :quantity, :total, :sales_date, :status)
        ");
        $stmt->execute([
            'm_id' => $medicineId,
            'quantity' => $quantity,
            'total' => $total,
            'sales_date' => $date,
            'status' => $status,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    private function seedOrder(int $medicineId, int $quantity, float $total, string $status, string $date): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_order_tbl (pharmacy_id, m_id, price, quantity, total_amount, order_date, status)
            VALUES (1, :m_id, 25.00, :quantity, :total, :order_date, :status)
        ");
        $stmt->execute([
            'm_id' => $medicineId,
            'quantity' => $quantity,
            'total' => $total,
            'order_date' => $date,
            'status' => $status,
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
