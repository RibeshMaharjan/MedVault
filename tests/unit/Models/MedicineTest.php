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
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_medicine_tbl");
        self::$pdo->exec("DELETE FROM sqlite_sequence WHERE name = 'user_medicine_tbl'");
        
        $this->model = new class(self::$pdo) extends UserMedicine {            public function __construct($pdo)
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

    public function testFindByIdAndPharmacyDoesNotReturnOtherPharmacyMedicine(): void
    {
        $id = $this->seedMedicine(2, 'Other Pharmacy Medicine');

        $result = $this->model->findByIdAndPharmacy($id, 1);

        $this->assertNull($result);
    }

    public function testFindByNameAndPharmacyDoesNotReturnOtherPharmacyMedicine(): void
    {
        $this->seedMedicine(2, 'Shared Name');

        $result = $this->model->findByNameAndPharmacy('Shared Name', 1);

        $this->assertNull($result);
    }

    public function testUpdateByPharmacyDoesNotMutateOtherPharmacyMedicine(): void
    {
        $id = $this->seedMedicine(2, 'Original');

        $result = $this->model->updateByPharmacy($id, 1, ['medicine_name' => 'Changed']);

        $this->assertFalse($result);
        $this->assertEquals('Original', $this->model->findById($id)['medicine_name']);
    }

    public function testDeleteByPharmacyDoesNotDeleteOtherPharmacyMedicine(): void
    {
        $id = $this->seedMedicine(2, 'Protected');

        $result = $this->model->deleteByPharmacy($id, 1);

        $this->assertFalse($result);
        $this->assertNotNull($this->model->findById($id));
    }

    public function testUpdateStockByPharmacyDoesNotMutateOtherPharmacyMedicine(): void
    {
        $id = $this->seedMedicine(2, 'Protected', 10.00, 25);

        $result = $this->model->updateStockByPharmacy($id, 1, -10);

        $this->assertFalse($result);
        $this->assertEquals(25, $this->model->findById($id)['in_stock']);
    }

    public function testHasRelatedRecordsByPharmacyIgnoresOtherPharmacyRecords(): void
    {
        $id = $this->seedMedicine(2, 'Protected');
        self::$pdo->exec("INSERT INTO user_sales_tbl (pharmacy_id, m_id, quantity) VALUES (2, $id, 1)");
        self::$pdo->exec("INSERT INTO user_order_tbl (pharmacy_id, m_id, quantity) VALUES (2, $id, 1)");

        $result = $this->model->hasRelatedRecordsByPharmacy($id, 1);

        $this->assertEquals(['sales' => 0, 'orders' => 0], $result);
    }

    public function testGetInventoryLevelsReturnsSummaryAndLowStockItems(): void
    {
        $this->seedMedicine(1, 'Low', 10.00, 5);
        $this->seedMedicine(1, 'Out', 10.00, 0);
        $this->seedMedicine(1, 'Healthy', 10.00, 25);
        $this->seedMedicine(2, 'Other Pharmacy', 10.00, 1);

        $result = $this->model->getInventoryLevels(1, 10);

        $this->assertEquals(30, $result['totalStock']);
        $this->assertEquals(1, $result['lowStockCount']);
        $this->assertEquals(1, $result['outOfStockCount']);
        $this->assertCount(2, $result['lowStockItems']);
    }

    public function testUpdateStockIncreasesStock(): void
    {
        $this->seedMedicine(1, 'Test', 10.00, 50);
        
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

    private function seedMedicine(int $pharmacyId, string $name, float $buyPrice = 10.00, int $stock = 100): int
    {
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name, buy_price, in_stock) VALUES ($pharmacyId, '$name', $buyPrice, $stock)");
        return (int) self::$pdo->lastInsertId();
    }
}
