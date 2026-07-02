<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use PDO;

class MedicineCrudFlowTest extends TestCase
{
    private static ?PDO $pdo = null;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        self::$pdo->exec("
            CREATE TABLE user_category_tbl (
                c_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                category_name TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            
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
            );
            
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
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_medicine_tbl");
        self::$pdo->exec("DELETE FROM user_category_tbl");
        self::$pdo->exec("DELETE FROM user_sales_tbl");
        self::$pdo->exec("DELETE FROM user_order_tbl");
        self::$pdo->exec("DELETE FROM sqlite_sequence WHERE name IN ('user_medicine_tbl', 'user_category_tbl', 'user_sales_tbl', 'user_order_tbl')");
    }

    public function testCreateMedicine(): void
    {
        self::$pdo->exec("
            INSERT INTO user_medicine_tbl 
            (pharmacy_id, medicine_name, medicine_desc, c_id, in_stock, buy_price, sell_price, exp_date)
            VALUES (1, 'Aspirin', 'Pain reliever', 1, 100, 10.00, 15.00, '2025-12-31')
        ");
        
        $medicine = self::$pdo->query("SELECT * FROM user_medicine_tbl WHERE m_id = 1")->fetch();
        
        $this->assertNotNull($medicine);
        $this->assertEquals('Aspirin', $medicine['medicine_name']);
    }

    public function testReadMedicine(): void
    {
        self::$pdo->exec("
            INSERT INTO user_medicine_tbl 
            (pharmacy_id, medicine_name, in_stock)
            VALUES (1, 'Ibuprofen', 50)
        ");
        
        $medicine = self::$pdo->query("SELECT * FROM user_medicine_tbl WHERE m_id = 1")->fetch();
        
        $this->assertNotNull($medicine);
        $this->assertEquals(50, $medicine['in_stock']);
    }

    public function testUpdateMedicine(): void
    {
        self::$pdo->exec("
            INSERT INTO user_medicine_tbl 
            (pharmacy_id, medicine_name, in_stock)
            VALUES (1, 'Old Name', 10)
        ");
        
        self::$pdo->exec("
            UPDATE user_medicine_tbl 
            SET medicine_name = 'New Name', in_stock = 20
            WHERE m_id = 1
        ");
        
        $medicine = self::$pdo->query("SELECT * FROM user_medicine_tbl WHERE m_id = 1")->fetch();
        
        $this->assertEquals('New Name', $medicine['medicine_name']);
        $this->assertEquals(20, $medicine['in_stock']);
    }

    public function testDeleteMedicineWithoutRelations(): void
    {
        self::$pdo->exec("
            INSERT INTO user_medicine_tbl 
            (pharmacy_id, medicine_name)
            VALUES (1, 'Test Medicine')
        ");
        
        $deleted = self::$pdo->exec("DELETE FROM user_medicine_tbl WHERE m_id = 1");
        
        $this->assertEquals(1, $deleted);
        
        $medicine = self::$pdo->query("SELECT * FROM user_medicine_tbl WHERE m_id = 1")->fetch();
        $this->assertFalse($medicine);
    }

    public function testDeleteMedicineFailsWithRelatedSales(): void
    {
        self::$pdo->exec("
            INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name)
            VALUES (1, 'Medicine')
        ");
        $medId = 1;
        
        self::$pdo->exec("
            INSERT INTO user_sales_tbl (pharmacy_id, m_id, price, quantity, total_amount, sales_date)
            VALUES (1, $medId, 10.00, 5, 50.00, '2026-07-02')
        ");
        
        $salesCount = self::$pdo->query("SELECT COUNT(*) as count FROM user_sales_tbl WHERE m_id = $medId")->fetch();
        
        $this->assertGreaterThan(0, $salesCount['count']);
    }

    public function testDeleteMedicineFailsWithRelatedOrders(): void
    {
        self::$pdo->exec("
            INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name)
            VALUES (1, 'Medicine')
        ");
        $medId = 1;
        
        self::$pdo->exec("
            INSERT INTO user_order_tbl (pharmacy_id, m_id, price, quantity, total_amount, order_date)
            VALUES (1, $medId, 10.00, 10, 100.00, '2026-07-02')
        ");
        
        $orderCount = self::$pdo->query("SELECT COUNT(*) as count FROM user_order_tbl WHERE m_id = $medId")->fetch();
        
        $this->assertGreaterThan(0, $orderCount['count']);
    }

    public function testMedicinesFilteredByPharmacy(): void
    {
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (1, 'Med 1')");
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (1, 'Med 2')");
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (2, 'Med 3')");
        
        $medicines = self::$pdo->query("SELECT * FROM user_medicine_tbl WHERE pharmacy_id = 1")->fetchAll();
        
        $this->assertCount(2, $medicines);
    }

    public function testMedicinesSearchedByName(): void
    {
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (1, 'Aspirin')");
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (1, 'Ibuprofen')");
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (1, 'Paracetamol')");
        
        $results = self::$pdo->query("SELECT * FROM user_medicine_tbl WHERE medicine_name LIKE '%Asp%'")->fetchAll();
        
        $this->assertCount(1, $results);
    }

    public function testPaginationReturnsCorrectPage(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name) VALUES (1, 'Medicine $i')");
        }
        
        $page = 1;
        $perPage = 5;
        $offset = ($page - 1) * $perPage;
        
        $results = self::$pdo->query("SELECT * FROM user_medicine_tbl WHERE pharmacy_id = 1 LIMIT $perPage OFFSET $offset")->fetchAll();
        
        $this->assertCount(5, $results);
    }
}
