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
            CREATE TABLE role (
                user_id INTEGER PRIMARY KEY,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                password TEXT NOT NULL,
                role TEXT NOT NULL
            );

            CREATE TABLE tbl_pharmacy (
                pharmacy_id INTEGER PRIMARY KEY,
                pan INTEGER,
                pharmacy_name TEXT NOT NULL,
                email TEXT,
                address TEXT,
                phone TEXT,
                isverified INTEGER DEFAULT 0,
                license_number TEXT,
                reg_document TEXT,
                verification_request_date DATETIME,
                verification_date DATETIME,
                verification_notes TEXT
            );

            CREATE TABLE user_category_tbl (
                c_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL
            );

            CREATE TABLE user_medicine_tbl (
                m_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL
            );

            CREATE TABLE user_order_tbl (
                o_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL
            );

            CREATE TABLE user_sales_tbl (
                s_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_sales_tbl");
        self::$pdo->exec("DELETE FROM user_order_tbl");
        self::$pdo->exec("DELETE FROM user_medicine_tbl");
        self::$pdo->exec("DELETE FROM user_category_tbl");
        self::$pdo->exec("DELETE FROM tbl_pharmacy");
        self::$pdo->exec("DELETE FROM role");
        
        $this->model = new class(self::$pdo) extends Pharmacy {            public function __construct($pdo)
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

    public function testFindByEmailReturnsPharmacy(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, email) VALUES (1, 'Test', 'test@example.com')");
        
        $result = $this->model->findOneBy('email', 'test@example.com');
        
        $this->assertNotNull($result);
        $this->assertEquals('test@example.com', $result['email']);
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

    public function testFindAllByVerificationState(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, isverified) VALUES (1, 'P1', 1)");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, isverified) VALUES (2, 'P2', 0)");
        
        $results = $this->model->findAllBy('isverified', 1);
        
        $this->assertCount(1, $results);
    }

    public function testIsVerifiedReadsCurrentVerificationState(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, isverified) VALUES (1, 'Verified', 1)");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, isverified) VALUES (2, 'Pending', 0)");

        $this->assertTrue($this->model->isVerified(1));
        $this->assertFalse($this->model->isVerified(2));
        $this->assertFalse($this->model->isVerified(999));
    }

    public function testFindDetailedByIdIncludesAccountAndVerificationFields(): void
    {
        self::$pdo->exec("INSERT INTO role (user_id, name, email, password, role) VALUES (1, 'Account Owner', 'owner@example.com', 'hash', 'user')");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, email, isverified, license_number, reg_document) VALUES (1, 'Detail Pharmacy', 'pharmacy@example.com', 0, 'LIC-123', 'verification-documents/1_doc.pdf')");

        $result = $this->model->findDetailedById(1);

        $this->assertSame('Account Owner', $result['account_name']);
        $this->assertSame('owner@example.com', $result['account_email']);
        $this->assertSame('LIC-123', $result['license_number']);
        $this->assertSame('verification-documents/1_doc.pdf', $result['reg_document']);
    }

    public function testHasBusinessRecordsReturnsFalseWhenPharmacyHasNoData(): void
    {
        $this->seedPharmacy(1, 'Clean Pharmacy');

        $this->assertFalse($this->model->hasBusinessRecords(1));
    }

    public function testHasBusinessRecordsReturnsTrueWhenPharmacyHasData(): void
    {
        $this->seedPharmacy(1, 'Busy Pharmacy');
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id) VALUES (1)");

        $this->assertTrue($this->model->hasBusinessRecords(1));
    }

    private function seedPharmacy(int $id, string $name): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name) VALUES ($id, '$name')");
    }
}
