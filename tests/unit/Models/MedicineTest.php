<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\UserMedicine;
use PDO;

class MedicineTest extends TestCase
{
    private static ?PDO $pdo = null;
    private UserMedicine $model;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        self::$pdo->exec("
            CREATE TABLE user_medicine_tbl (
                m_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                medicine_name TEXT NOT NULL,
                medicine_desc TEXT,
                c_id INTEGER,
                in_stock INTEGER DEFAULT 0,
                buy_price REAL DEFAULT 0,
                sell_price REAL DEFAULT 0,
                exp_date DATE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_medicine_tbl");
        
        $this->model = new class(self::$pdo) extends UserMedicine {
            protected $db;
            public function __construct($pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    public function testFindByPharmacyReturnsMedicines(): void
    {
        $this->seedMedicine(1, 'Medicine 1');
        $this->seedMedicine(1, 'Medicine 2');
        $this->seedMedicine(2, 'Medicine 3');
        
        $results = $this->model->findByPharmacy(1);
        
        $this->assertCount(2, $results);
    }

    public function testPaginateByPharmacyReturnsPagination(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->seedMedicine(1, "Medicine $i");
        }
        
        $result = $this->model->paginateByPharmacy(1, 1, 5);
        
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('currentPage', $result);
        $this->assertArrayHasKey('totalPages', $result);
        $this->assertEquals(1, $result['currentPage']);
        $this->assertEquals(3, $result['totalPages']);
    }

    public function testPaginateWithConditions(): void
    {
        $this->seedMedicine(1, 'Aspirin', 10.00);
        $this->seedMedicine(1, 'Ibuprofen', 20.00);
        
        $result = $this->model->paginateByPharmacy(1, 1, 10, 'buy_price > :price', ['price' => 15.00]);
        
        $this->assertCount(1, $result['data']);
    }

    public function testCountByPharmacy(): void
    {
        $this->seedMedicine(1, 'Medicine 1');
        $this->seedMedicine(1, 'Medicine 2');
        $this->seedMedicine(2, 'Medicine 3');
        
        $count = $this->model->countByPharmacy(1);
        
        $this->assertEquals(2, $count);
    }

    public function testCreateInsertsMedicine(): void
    {
        $id = $this->model->create([
            'pharmacy_id' => 1,
            'medicine_name' => 'Test Medicine',
            'medicine_desc' => 'Description',
            'c_id' => 1,
            'in_stock' => 100,
            'buy_price' => 10.00,
            'sell_price' => 15.00,
            'exp_date' => '2025-12-31',
        ]);
        
        $this->assertEquals(1, $id);
        
        $medicine = $this->model->findById($id);
        $this->assertEquals('Test Medicine', $medicine['medicine_name']);
    }

    public function testSearchFindsMedicines(): void
    {
        $this->seedMedicine(1, 'Aspirin');
        $this->seedMedicine(1, 'Paracetamol');
        $this->seedMedicine(1, 'Ibuprofen');
        
        $results = $this->model->search(1, 'Asp');
        
        $this->assertCount(1, $results);
        $this->assertEquals('Aspirin', $results[0]['medicine_name']);
    }

    public function testSearchReturnsMultipleMatches(): void
    {
        $this->seedMedicine(1, 'Aspirin');
        $this->seedMedicine(1, 'Aspirin Plus');
        
        $results = $this->model->search(1, 'Asp');
        
        $this->assertCount(2, $results);
    }

    public function testSearchWithLimit(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->seedMedicine(1, "Medicine $i");
        }
        
        $results = $this->model->search(1, 'Medicine', 5);
        
        $this->assertCount(5, $results);
    }

    public function testUpdateStockIncreasesStock(): void
    {
        $this->seedMedicine(1, 'Test', 50);
        
        $result = $this->model->updateStock(1, 50);
        
        $this->assertTrue($result);
        
        $medicine = $this->model->findById(1);
        $this->assertEquals(100, $medicine['in_stock']);
    }

    public function testUpdateStockDecreasesStock(): void
    {
        $this->seedMedicine(1, 'Test', 100);
        
        $result = $this->model->updateStock(1, -30);
        
        $this->assertTrue($result);
        
        $medicine = $this->model->findById(1);
        $this->assertEquals(70, $medicine['in_stock']);
    }

    public function testHasRelatedRecordsReturnsCounts(): void
    {
        self::$pdo->exec("INSERT INTO user_medicine_tbl (m_id, pharmacy_id, medicine_name, in_stock) VALUES (1, 1, 'Test', 100)");
        
        $result = $this->model->hasRelatedRecords(1);
        
        $this->assertArrayHasKey('sales', $result);
        $this->assertArrayHasKey('orders', $result);
    }

    public function testFindById(): void
    {
        $id = $this->seedMedicine(1, 'Test Medicine');
        
        $result = $this->model->findById($id);
        
        $this->assertNotNull($result);
        $this->assertEquals('Test Medicine', $result['medicine_name']);
    }

    public function testDeleteMedicine(): void
    {
        $id = $this->seedMedicine(1, 'Test');
        
        $result = $this->model->delete($id);
        
        $this->assertTrue($result);
        
        $medicine = $this->model->findById($id);
        $this->assertNull($medicine);
    }

    public function testUpdateMedicine(): void
    {
        $id = $this->seedMedicine(1, 'Old Name');
        
        $result = $this->model->update($id, ['medicine_name' => 'New Name']);
        
        $this->assertTrue($result);
        
        $medicine = $this->model->findById($id);
        $this->assertEquals('New Name', $medicine['medicine_name']);
    }

    private function seedMedicine(int $pharmacyId, string $name, float $buyPrice = 10.00): int
    {
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name, buy_price, in_stock) VALUES ($pharmacyId, '$name', $buyPrice, 100)");
        return (int) self::$pdo->lastInsertId();
    }
}