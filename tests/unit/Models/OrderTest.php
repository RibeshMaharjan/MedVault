<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Order;
use PDO;

class OrderTest extends TestCase
{
    private static ?PDO $pdo = null;
    private Order $model;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        self::$pdo->exec("
            CREATE TABLE user_order_tbl (
                o_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                m_id INTEGER,
                price REAL DEFAULT 0,
                quantity INTEGER DEFAULT 0,
                total_amount REAL DEFAULT 0,
                order_date DATE,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        self::$pdo->exec("
            CREATE TABLE user_medicine_tbl (
                m_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                medicine_name TEXT NOT NULL
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_order_tbl");
        self::$pdo->exec("DELETE FROM sqlite_sequence WHERE name = 'user_order_tbl'");
        
        $this->model = new class(self::$pdo) extends Order {            public function __construct($pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    public function testFindByPharmacy(): void
    {
        $this->seedOrder(1, 100.00);
        $this->seedOrder(1, 200.00);
        $this->seedOrder(2, 300.00);
        
        $results = $this->model->findByPharmacy(1);
        
        $this->assertCount(2, $results);
    }

    public function testPaginateByPharmacy(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->seedOrder(1, 100.00 + $i);
        }

        $result = $this->model->paginateByPharmacy(1, 1, 5);

        $this->assertArrayHasKey('data', $result);
        $this->assertEquals(3, $result['totalPages']);
    }

    public function testPaginateByPharmacyIncludesMedicineName(): void
    {
        $mId = $this->seedMedicine(1, 'Paracetamol');
        $this->seedOrder(1, 100.00, $mId);

        $result = $this->model->paginateByPharmacy(1, 1, 10);

        $this->assertSame('Paracetamol', $result['data'][0]['medicine_name']);
    }

    public function testPaginateByPharmacySortsNewestOrdersFirst(): void
    {
        $oldestId = $this->seedOrder(1, 100.00, null, '2026-07-01');
        $newestId = $this->seedOrder(1, 150.00, null, '2026-07-03');
        $sameDayLaterId = $this->seedOrder(1, 200.00, null, '2026-07-03');

        $result = $this->model->paginateByPharmacy(1, 1, 10);

        $this->assertSame([$sameDayLaterId, $newestId, $oldestId], array_column($result['data'], 'o_id'));
    }

    public function testFindByIdAndPharmacy(): void
    {
        $id = $this->seedOrder(1, 125.00);
        
        $result = $this->model->findByIdAndPharmacy($id, 1);
        
        $this->assertNotNull($result);
        $this->assertEquals(125.00, $result['total_amount']);
    }

    public function testFindByIdAndPharmacyReturnsNullForWrongPharmacy(): void
    {
        $id = $this->seedOrder(1, 100.00);
        
        $result = $this->model->findByIdAndPharmacy($id, 999);
        
        $this->assertNull($result);
    }

    public function testDeleteByPharmacy(): void
    {
        $id = $this->seedOrder(1, 100.00);
        
        $result = $this->model->deleteByPharmacy($id, 1);
        
        $this->assertTrue($result);
    }

    public function testUpdateByPharmacy(): void
    {
        $id = $this->seedOrder(1, 100.00);
        
        $result = $this->model->updateByPharmacy($id, 1, [
            'status' => 'completed',
            'quantity' => 20,
        ]);
        
        $this->assertTrue($result);
        
        $order = $this->model->findByIdAndPharmacy($id, 1);
        $this->assertEquals('completed', $order['status']);
    }

    public function testDeleteByPharmacyFailsForWrongPharmacy(): void
    {
        $id = $this->seedOrder(1, 100.00);
        
        $result = $this->model->deleteByPharmacy($id, 999);
        
        $this->assertFalse($result);
    }

    public function testGetRecentOrders(): void
    {
        $this->seedOrder(1, 100.00);
        $this->seedOrder(1, 150.00);
        
        $reflection = new \ReflectionMethod($this->model, 'findAll');
        $results = $reflection->invoke($this->model);
        
        $this->assertCount(2, $results);
    }

    private function seedOrder(int $pharmacyId, float $totalAmount, ?int $mId = null, string $orderDate = '2026-07-02'): int
    {
        $stmt = self::$pdo->prepare("INSERT INTO user_order_tbl (pharmacy_id, m_id, price, quantity, total_amount, status, order_date) VALUES (:pharmacy_id, :m_id, 10.00, 10, :total_amount, 'pending', :order_date)");
        $stmt->execute(['pharmacy_id' => $pharmacyId, 'm_id' => $mId, 'total_amount' => $totalAmount, 'order_date' => $orderDate]);
        return (int) self::$pdo->lastInsertId();
    }

    private function seedMedicine(int $pharmacyId, string $name): int
    {
        $stmt = self::$pdo->prepare("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (:pharmacy_id, :name)");
        $stmt->execute(['pharmacy_id' => $pharmacyId, 'name' => $name]);
        return (int) self::$pdo->lastInsertId();
    }
}
