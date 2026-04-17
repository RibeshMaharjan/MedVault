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
                supplier_name TEXT NOT NULL,
                order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                quantity INTEGER DEFAULT 0,
                total_amount REAL DEFAULT 0,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_order_tbl");
        
        $this->model = new class(self::$pdo) extends Order {
            protected $db;
            public function __construct($pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    public function testFindByPharmacy(): void
    {
        $this->seedOrder(1, 'Supplier 1');
        $this->seedOrder(1, 'Supplier 2');
        $this->seedOrder(2, 'Supplier 3');
        
        $results = $this->model->findByPharmacy(1);
        
        $this->assertCount(2, $results);
    }

    public function testPaginateByPharmacy(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->seedOrder(1, "Supplier $i");
        }
        
        $result = $this->model->paginateByPharmacy(1, 1, 5);
        
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals(3, $result['totalPages']);
    }

    public function testFindByIdAndPharmacy(): void
    {
        $id = $this->seedOrder(1, 'Test Supplier');
        
        $result = $this->model->findByIdAndPharmacy($id, 1);
        
        $this->assertNotNull($result);
        $this->assertEquals('Test Supplier', $result['supplier_name']);
    }

    public function testFindByIdAndPharmacyReturnsNullForWrongPharmacy(): void
    {
        $id = $this->seedOrder(1, 'Test');
        
        $result = $this->model->findByIdAndPharmacy($id, 999);
        
        $this->assertNull($result);
    }

    public function testDeleteByPharmacy(): void
    {
        $id = $this->seedOrder(1, 'Test');
        
        $result = $this->model->deleteByPharmacy($id, 1);
        
        $this->assertTrue($result);
    }

    public function testUpdateByPharmacy(): void
    {
        $id = $this->seedOrder(1, 'Test');
        
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
        $id = $this->seedOrder(1, 'Test');
        
        $result = $this->model->deleteByPharmacy($id, 999);
        
        $this->assertFalse($result);
    }

    public function testGetRecentOrders(): void
    {
        $this->seedOrder(1, 'Supplier');
        $this->seedOrder(1, 'Supplier 2');
        
        $reflection = new \ReflectionMethod($this->model, 'findAll');
        $results = $reflection->invoke($this->model);
        
        $this->assertCount(2, $results);
    }

    private function seedOrder(int $pharmacyId, string $supplierName): int
    {
        self::$pdo->exec("INSERT INTO user_order_tbl (pharmacy_id, supplier_name, quantity, total_amount, status) VALUES ($pharmacyId, '$supplierName', 10, 100.00, 'pending')");
        return (int) self::$pdo->lastInsertId();
    }
}