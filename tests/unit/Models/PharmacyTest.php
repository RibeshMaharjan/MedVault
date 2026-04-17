<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Pharmacy;
use PDO;

class PharmacyTest extends TestCase
{
    private static ?PDO $pdo = null;
    private Pharmacy $model;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        self::$pdo->exec("
            CREATE TABLE tbl_pharmacy (
                pharmacy_id INTEGER PRIMARY KEY,
                user_id INTEGER,
                pharmacy_name TEXT NOT NULL,
                email TEXT,
                address TEXT,
                phone TEXT,
                verified INTEGER DEFAULT 0,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM tbl_pharmacy");
        
        $this->model = new class(self::$pdo) extends Pharmacy {
            protected $db;
            public function __construct($pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    public function testCreateMinimalInsertsPharmacy(): void
    {
        $result = $this->model->createMinimal(1, 'Test Pharmacy', 'test@example.com');
        
        $this->assertTrue($result);
        
        $pharmacy = $this->model->findById(1);
        $this->assertNotNull($pharmacy);
        $this->assertEquals('Test Pharmacy', $pharmacy['pharmacy_name']);
    }

    public function testFindByIdReturnsPharmacy(): void
    {
        $this->seedPharmacy(1, 'Test Pharmacy');
        
        $result = $this->model->findById(1);
        
        $this->assertNotNull($result);
        $this->assertEquals('Test Pharmacy', $result['pharmacy_name']);
    }

    public function testFindByIdReturnsNullForNonExistent(): void
    {
        $result = $this->model->findById(999);
        
        $this->assertNull($result);
    }

    public function testFindByUserIdReturnsPharmacy(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, user_id, pharmacy_name) VALUES (1, 5, 'Test')");
        
        $result = $this->model->findOneBy('user_id', 5);
        
        $this->assertNotNull($result);
        $this->assertEquals(5, $result['user_id']);
    }

    public function testFindAllReturnsAllPharmacies(): void
    {
        $this->seedPharmacy(1, 'Pharmacy 1');
        $this->seedPharmacy(2, 'Pharmacy 2');
        
        $results = $this->model->findAll();
        
        $this->assertCount(2, $results);
    }

    public function testUpdatePharmacy(): void
    {
        $this->seedPharmacy(1, 'Old Name');
        
        $result = $this->model->update(1, ['pharmacy_name' => 'New Name']);
        
        $this->assertTrue($result);
        
        $pharmacy = $this->model->findById(1);
        $this->assertEquals('New Name', $pharmacy['pharmacy_name']);
    }

    public function testDeletePharmacy(): void
    {
        $this->seedPharmacy(1, 'Test');
        
        $result = $this->model->delete(1);
        
        $this->assertTrue($result);
        
        $pharmacy = $this->model->findById(1);
        $this->assertNull($pharmacy);
    }

    public function testFindAllByStatus(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, status) VALUES (1, 'P1', 'active')");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, status) VALUES (2, 'P2', 'pending')");
        
        $results = $this->model->findAllBy('status', 'active');
        
        $this->assertCount(1, $results);
    }

    private function seedPharmacy(int $id, string $name): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name) VALUES ($id, '$name')");
    }
}