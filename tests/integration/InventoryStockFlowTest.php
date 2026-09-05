<?php

namespace Tests\Integration;

use App\Controllers\Pharmacy\OrderController;
use App\Controllers\Pharmacy\SalesController;
use App\Core\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class InventoryStockFlowTest extends TestCase
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
    }

    protected function tearDown(): void
    {
        $_POST = [];
        $_SESSION = [];
        parent::tearDown();
    }

    public function testOrderCreateUsesPurchasePriceAndDoesNotChangeStockUntilReceived(): void
    {
        $medicineId = $this->seedMedicine(stock: 100, buyPrice: 20.00, sellPrice: 25.00);
        $_POST = [
            'm_id' => $medicineId,
            'price' => 1.00,
            'quantity' => 2,
            'total' => 1.00,
            'order_date' => date('Y-m-d', strtotime('+1 day')),
        ];

        $this->expectRedirect('/pharmacy/orders', fn() => (new OrderController())->store());

        $order = $this->pdo->query('SELECT * FROM user_order_tbl')->fetch();
        $stock = $this->stockFor($medicineId);

        $this->assertEquals(20.00, (float) $order['price']);
        $this->assertEquals(40.00, (float) $order['total_amount']);
        $this->assertEquals('pending', $order['status']);
        $this->assertEquals(100, $stock);
    }

    public function testCompletingPendingOrderAddsStock(): void
    {
        $medicineId = $this->seedMedicine(stock: 90, buyPrice: 20.00, sellPrice: 25.00);
        $orderId = $this->seedOrder($medicineId, quantity: 10, status: 'pending');
        $_POST = [
            'm_id' => $medicineId,
            'quantity' => 10,
            'status' => 'completed',
            'order_date' => date('Y-m-d', strtotime('+1 day')),
        ];

        $this->expectRedirect('/pharmacy/orders', fn() => (new OrderController())->update((string) $orderId));

        $this->assertEquals(100, $this->stockFor($medicineId));
    }

    public function testDeletingPendingOrderDoesNotChangeStock(): void
    {
        $medicineId = $this->seedMedicine(stock: 90, buyPrice: 20.00, sellPrice: 25.00);
        $orderId = $this->seedOrder($medicineId, quantity: 10, status: 'pending');

        $this->expectRedirect('/pharmacy/orders', fn() => (new OrderController())->destroy((string) $orderId));

        $this->assertEquals(90, $this->stockFor($medicineId));
    }

    public function testDeletingCompletedOrderReversesReceivedStock(): void
    {
        $medicineId = $this->seedMedicine(stock: 100, buyPrice: 20.00, sellPrice: 25.00);
        $orderId = $this->seedOrder($medicineId, quantity: 10, status: 'completed');

        $this->expectRedirect('/pharmacy/orders', fn() => (new OrderController())->destroy((string) $orderId));

        $this->assertEquals(90, $this->stockFor($medicineId));
    }

    public function testSaleCreateUsesSellingPriceAndReducesStock(): void
    {
        $medicineId = $this->seedMedicine(stock: 100, buyPrice: 10.00, sellPrice: 15.00);
        $_POST = [
            'm_id' => $medicineId,
            'price' => 1.00,
            'quantity' => 10,
            'total' => 1.00,
            'sales_date' => date('Y-m-d'),
        ];

        $this->expectRedirect('/pharmacy/sales', fn() => (new SalesController())->store());

        $sale = $this->pdo->query('SELECT * FROM user_sales_tbl')->fetch();
        $this->assertEquals(15.00, (float) $sale['price']);
        $this->assertEquals(150.00, (float) $sale['total_amount']);
        $this->assertEquals('completed', $sale['status']);
        $this->assertEquals(90, $this->stockFor($medicineId));
    }

    public function testSaleCompletionRejectsInsufficientStockWithoutMutation(): void
    {
        $medicineId = $this->seedMedicine(stock: 3, buyPrice: 10.00, sellPrice: 15.00);
        $saleId = $this->seedSale($medicineId, quantity: 1, status: 'pending');
        $_POST = [
            'm_id' => $medicineId,
            'quantity' => 5,
            'status' => 'completed',
            'sales_date' => date('Y-m-d'),
        ];

        $this->expectRedirect('/pharmacy/sales', fn() => (new SalesController())->update((string) $saleId), 'Not enough stock available');

        $this->assertEquals(3, $this->stockFor($medicineId));
    }

    public function testCompletedSaleUpdateUsesServerTotalAndAdjustsStockDelta(): void
    {
        $medicineId = $this->seedMedicine(stock: 90, buyPrice: 10.00, sellPrice: 15.00);
        $saleId = $this->seedSale($medicineId, quantity: 10, status: 'completed');
        $_POST = [
            'm_id' => $medicineId,
            'price' => 1.00,
            'quantity' => 5,
            'total' => 1.00,
            'status' => 'completed',
            'sales_date' => date('Y-m-d'),
        ];

        $this->expectRedirect('/pharmacy/sales', fn() => (new SalesController())->update((string) $saleId));

        $sale = $this->pdo->query('SELECT * FROM user_sales_tbl WHERE s_id = ' . $saleId)->fetch();
        $this->assertEquals(15.00, (float) $sale['price']);
        $this->assertEquals(75.00, (float) $sale['total_amount']);
        $this->assertEquals(95, $this->stockFor($medicineId));
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
                medicine_desc TEXT,
                c_id INTEGER,
                in_stock INTEGER DEFAULT 0,
                buy_price REAL DEFAULT 0,
                sell_price REAL DEFAULT 0,
                exp_date DATE
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
        ");
    }

    private function seedMedicine(int $stock, float $buyPrice, float $sellPrice): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name, in_stock, buy_price, sell_price, exp_date)
            VALUES (1, 'Test Medicine', :stock, :buy_price, :sell_price, :exp_date)
        ");
        $stmt->execute([
            'stock' => $stock,
            'buy_price' => $buyPrice,
            'sell_price' => $sellPrice,
            'exp_date' => date('Y-m-d', strtotime('+1 year')),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    private function seedOrder(int $medicineId, int $quantity, string $status): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_order_tbl (pharmacy_id, m_id, price, quantity, total_amount, order_date, status)
            VALUES (1, :m_id, 25.00, :quantity, :total, :order_date, :status)
        ");
        $stmt->execute([
            'm_id' => $medicineId,
            'quantity' => $quantity,
            'total' => 25.00 * $quantity,
            'order_date' => date('Y-m-d', strtotime('+1 day')),
            'status' => $status,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    private function seedSale(int $medicineId, int $quantity, string $status): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_sales_tbl (pharmacy_id, m_id, price, quantity, total_amount, sales_date, status)
            VALUES (1, :m_id, 15.00, :quantity, :total, :sales_date, :status)
        ");
        $stmt->execute([
            'm_id' => $medicineId,
            'quantity' => $quantity,
            'total' => 15.00 * $quantity,
            'sales_date' => date('Y-m-d'),
            'status' => $status,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    private function stockFor(int $medicineId): int
    {
        return (int) $this->pdo->query("SELECT in_stock FROM user_medicine_tbl WHERE m_id = {$medicineId}")->fetchColumn();
    }

    private function expectRedirect(string $url, callable $callback, ?string $message = null): void
    {
        try {
            $callback();
            $this->fail('Expected redirect exception.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString("Redirect to {$url}", $exception->getMessage());
            if ($message !== null) {
                $this->assertStringContainsString($message, $exception->getMessage());
            }
        }
    }
}
