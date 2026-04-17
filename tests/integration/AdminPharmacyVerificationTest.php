<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use PDO;

class AdminPharmacyVerificationTest extends TestCase
{
    private static ?PDO $pdo = null;

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
    }

    public function testAdminApprovesPharmacy(): void
    {
        self::$pdo->exec("
            INSERT INTO tbl_pharmacy (pharmacy_id, user_id, pharmacy_name, email, verified, status)
            VALUES (1, 1, 'Test Pharmacy', 'test@pharmacy.com', 0, 'pending')
        ");
        
        self::$pdo->exec("
            UPDATE tbl_pharmacy 
            SET verified = 1, status = 'active'
            WHERE pharmacy_id = 1
        ");
        
        $pharmacy = self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE pharmacy_id = 1")->fetch();
        
        $this->assertEquals(1, $pharmacy['verified']);
        $this->assertEquals('active', $pharmacy['status']);
    }

    public function testAdminRejectsPharmacy(): void
    {
        self::$pdo->exec("
            INSERT INTO tbl_pharmacy (pharmacy_id, user_id, pharmacy_name, email, verified, status)
            VALUES (1, 1, 'Test Pharmacy', 'test@pharmacy.com', 0, 'pending')
        ");
        
        self::$pdo->exec("
            UPDATE tbl_pharmacy 
            SET status = 'rejected'
            WHERE pharmacy_id = 1
        ");
        
        $pharmacy = self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE pharmacy_id = 1")->fetch();
        
        $this->assertEquals('rejected', $pharmacy['status']);
    }

    public function testListPendingPharmacies(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, status) VALUES (1, 'Pharmacy 1', 'pending')");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, status) VALUES (2, 'Pharmacy 2', 'active')");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, status) VALUES (3, 'Pharmacy 3', 'pending')");
        
        $pending = self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE status = 'pending'")->fetchAll();
        
        $this->assertCount(2, $pending);
    }

    public function testListVerifiedPharmacies(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, verified, status) VALUES (1, 'P1', 1, 'active')");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, verified, status) VALUES (2, 'P2', 0, 'pending')");
        
        $verified = self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE verified = 1")->fetchAll();
        
        $this->assertCount(1, $verified);
    }

    public function testDeletePharmacy(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name) VALUES (1, 'Test Pharmacy')");
        
        $deleted = self::$pdo->exec("DELETE FROM tbl_pharmacy WHERE pharmacy_id = 1");
        
        $this->assertEquals(1, $deleted);
        
        $pharmacy = self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE pharmacy_id = 1")->fetch();
        $this->assertFalse($pharmacy);
    }

    public function testPharmacyCountsByStatus(): void
    {
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, status) VALUES (1, 'active')");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, status) VALUES (2, 'pending')");
        self::$pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, status) VALUES (3, 'active')");
        
        $active = self::$pdo->query("SELECT COUNT(*) as count FROM tbl_pharmacy WHERE status = 'active'")->fetch();
        $pending = self::$pdo->query("SELECT COUNT(*) as count FROM tbl_pharmacy WHERE status = 'pending'")->fetch();
        
        $this->assertEquals(2, $active['count']);
        $this->assertEquals(1, $pending['count']);
    }
}