<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Sale;
use PDO;

class SaleTest extends TestCase
{
    private static ?PDO $pdo = null;
    private Sale $model;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        self::$pdo->exec("
            CREATE TABLE user_sales_tbl (
                s_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                m_id INTEGER,
                price REAL DEFAULT 0,
                quantity INTEGER DEFAULT 0,
                total_amount REAL DEFAULT 0,
                sales_date DATE,
                status TEXT DEFAULT 'completed'
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_sales_tbl");
        self::$pdo->exec("DELETE FROM sqlite_sequence WHERE name = 'user_sales_tbl'");
        
        $this->model = new class(self::$pdo) extends Sale {            public function __construct($pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    public function testPaginateByPharmacy(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->seedSale(1, 50.00);
        }
        
        $result = $this->model->paginateByPharmacy(1, 1, 5);
        
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals(3, $result['totalPages']);
    }

    public function testPaginateByPharmacyWithConditions(): void
    {
        $this->seedSale(1, 50.00);
        $this->seedSale(1, 100.00);
        
        $result = $this->model->paginateByPharmacy(1, 1, 10, 'total_amount > :price', ['price' => 75.00]);
        
        $this->assertCount(1, $result['data']);
    }

    public function testFindByIdAndPharmacy(): void
    {
        $id = $this->seedSale(1, 50.00);
        
        $result = $this->model->findByIdAndPharmacy($id, 1);
        
        $this->assertNotNull($result);
        $this->assertEquals(50.00, $result['total_amount']);
    }

    public function testFindByIdAndPharmacyReturnsNullForWrongPharmacy(): void
    {
        $id = $this->seedSale(1, 50.00);
        
        $result = $this->model->findByIdAndPharmacy($id, 999);
        
        $this->assertNull($result);
    }

    public function testDeleteByPharmacy(): void
    {
        $id = $this->seedSale(1, 50.00);
        
        $result = $this->model->deleteByPharmacy($id, 1);
        
        $this->assertTrue($result);
    }

    public function testDeleteByPharmacyFailsForWrongPharmacy(): void
    {
        $id = $this->seedSale(1, 50.00);
        
        $result = $this->model->deleteByPharmacy($id, 999);
        
        $this->assertFalse($result);
    }

    public function testUpdateByPharmacy(): void
    {
        $id = $this->seedSale(1, 50.00);
        
        $result = $this->model->updateByPharmacy($id, 1, [
            'quantity' => 10,
            'total_amount' => 100.00,
        ]);
        
        $this->assertTrue($result);
        
        $sale = $this->model->findByIdAndPharmacy($id, 1);
        $this->assertEquals(10, $sale['quantity']);
    }

    public function testFindAllReturnsAllSales(): void
    {
        $this->seedSale(1, 50.00);
        $this->seedSale(1, 75.00);
        $this->seedSale(2, 100.00);
        
        $reflection = new \ReflectionMethod($this->model, 'findAll');
        $results = $reflection->invoke($this->model);
        
        $this->assertCount(3, $results);
    }

    private function seedSale(int $pharmacyId, float $totalPrice): int
    {
        self::$pdo->exec("INSERT INTO user_sales_tbl (pharmacy_id, price, quantity, total_amount, sales_date, status) VALUES ($pharmacyId, 10.00, 5, $totalPrice, '2026-07-02', 'completed')");
        return (int) self::$pdo->lastInsertId();
    }
}
