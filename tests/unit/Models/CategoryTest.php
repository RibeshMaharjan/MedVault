<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Category;
use PDO;

class CategoryTest extends TestCase
{
    private static ?PDO $pdo = null;
    private Category $model;

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
                c_id INTEGER,
                medicine_name TEXT NOT NULL,
                in_stock INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM user_category_tbl");
        self::$pdo->exec("DELETE FROM user_medicine_tbl");
        
        $this->model = new class(self::$pdo) extends Category {
            protected $db;
            public function __construct($pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    public function testFindByPharmacyReturnsCategories(): void
    {
        $this->seedCategory(1, 'Category 1');
        $this->seedCategory(1, 'Category 2');
        $this->seedCategory(2, 'Category 3');
        
        $results = $this->model->findByPharmacy(1);
        
        $this->assertCount(2, $results);
    }

    public function testCreateInsertsCategory(): void
    {
        $id = $this->model->create(1, 'Antibiotics');
        
        $this->assertEquals(1, $id);
        
        $category = $this->model->findById($id);
        $this->assertEquals('Antibiotics', $category['category_name']);
    }

    public function testHasMedicinesReturnsZeroForEmptyCategory(): void
    {
        $id = $this->seedCategory(1, 'Empty Category');
        
        $count = $this->model->hasMedicines($id);
        
        $this->assertEquals(0, $count);
    }

    public function testHasMedicinesReturnsCorrectCount(): void
    {
        $catId = $this->seedCategory(1, 'Category');
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, c_id, medicine_name) VALUES (1, $catId, 'Medicine 1')");
        self::$pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id, c_id, medicine_name) VALUES (1, $catId, 'Medicine 2')");
        
        $count = $this->model->hasMedicines($catId);
        
        $this->assertEquals(2, $count);
    }

    public function testFindById(): void
    {
        $id = $this->seedCategory(1, 'Test Category');
        
        $result = $this->model->findById($id);
        
        $this->assertNotNull($result);
        $this->assertEquals('Test Category', $result['category_name']);
    }

    public function testUpdateCategory(): void
    {
        $id = $this->seedCategory(1, 'Old Name');
        
        $result = $this->model->update($id, ['category_name' => 'New Name']);
        
        $this->assertTrue($result);
        
        $category = $this->model->findById($id);
        $this->assertEquals('New Name', $category['category_name']);
    }

    public function testDeleteCategory(): void
    {
        $id = $this->seedCategory(1, 'Test');
        
        $result = $this->model->delete($id);
        
        $this->assertTrue($result);
        
        $category = $this->model->findById($id);
        $this->assertNull($category);
    }

    private function seedCategory(int $pharmacyId, string $name): int
    {
        self::$pdo->exec("INSERT INTO user_category_tbl (pharmacy_id, category_name) VALUES ($pharmacyId, '$name')");
        return (int) self::$pdo->lastInsertId();
    }
}