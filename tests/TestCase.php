<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use PDO;

if (!class_exists('PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase_Hack');
}

if (!class_exists('PHPUnit\Framework\Assert')) {
    class_alias('\PHPUnit\Framework\Assert', 'PHPUnit_Framework_Assert_Hack');
}

abstract class TestCase extends BaseTestCase
{
    protected static ?PDO $pdo = null;
    protected static bool $initialized = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cleanSession();
        
        if (!self::$initialized) {
            $this->initializeTestDatabase();
            self::$initialized = true;
        }
    }

    protected function tearDown(): void
    {
        $this->cleanSession();
        parent::tearDown();
    }

    protected function cleanSession(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
    }

    protected function initializeTestDatabase(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $sql = "
            CREATE TABLE role (
                user_id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                role TEXT DEFAULT 'user',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

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
            );

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
            );

            CREATE TABLE user_sales_tbl (
                s_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                m_id INTEGER,
                quantity INTEGER DEFAULT 0,
                total_price REAL DEFAULT 0,
                sale_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                status TEXT DEFAULT 'completed'
            );
        ";

        self::$pdo->exec($sql);
    }

    public static function getPdo(): PDO
    {
        return self::$pdo;
    }

    protected function createUser(array $overrides = []): int
    {
        $defaults = [
            'name' => 'Test User',
            'email' => 'test' . uniqid() . '@example.com',
            'password' => password_hash('Test1234', PASSWORD_DEFAULT),
            'role' => 'user',
        ];

        $data = array_merge($defaults, $overrides);
        $stmt = self::$pdo->prepare("
            INSERT INTO role (name, email, password, role) 
            VALUES (:name, :email, :password, :role)
        ");
        $stmt->execute($data);
        
        return (int) self::$pdo->lastInsertId();
    }

    protected function createPharmacy(int $userId, array $overrides = []): int
    {
        $defaults = [
            'pharmacy_id' => $userId,
            'user_id' => $userId,
            'pharmacy_name' => 'Test Pharmacy',
            'email' => 'pharmacy' . $userId . '@example.com',
            'verified' => 1,
            'status' => 'active',
        ];

        $data = array_merge($defaults, $overrides);
        
        $stmt = self::$pdo->prepare("
            INSERT INTO tbl_pharmacy (pharmacy_id, user_id, pharmacy_name, email, verified, status)
            VALUES (:pharmacy_id, :user_id, :pharmacy_name, :email, :verified, :status)
        ");
        $stmt->execute($data);
        
        return $userId;
    }

    protected function createCategory(int $pharmacyId, string $name = 'Test Category'): int
    {
        $stmt = self::$pdo->prepare("
            INSERT INTO user_category_tbl (pharmacy_id, category_name)
            VALUES (:pharmacy_id, :category_name)
        ");
        $stmt->execute(['pharmacy_id' => $pharmacyId, 'category_name' => $name]);
        
        return (int) self::$pdo->lastInsertId();
    }

    protected function createMedicine(int $pharmacyId, array $overrides = []): int
    {
        $defaults = [
            'pharmacy_id' => $pharmacyId,
            'medicine_name' => 'Test Medicine ' . uniqid(),
            'medicine_desc' => 'Test description',
            'c_id' => null,
            'in_stock' => 100,
            'buy_price' => 10.00,
            'sell_price' => 15.00,
            'exp_date' => '2025-12-31',
        ];

        $data = array_merge($defaults, $overrides);
        
        $stmt = self::$pdo->prepare("
            INSERT INTO user_medicine_tbl 
            (pharmacy_id, medicine_name, medicine_desc, c_id, in_stock, buy_price, sell_price, exp_date)
            VALUES (:pharmacy_id, :medicine_name, :medicine_desc, :c_id, :in_stock, :buy_price, :sell_price, :exp_date)
        ");
        $stmt->execute($data);
        
        return (int) self::$pdo->lastInsertId();
    }

    protected function createOrder(int $pharmacyId, array $overrides = []): int
    {
        $defaults = [
            'pharmacy_id' => $pharmacyId,
            'm_id' => null,
            'supplier_name' => 'Test Supplier',
            'quantity' => 10,
            'total_amount' => 100.00,
            'status' => 'pending',
        ];

        $data = array_merge($defaults, $overrides);
        
        $stmt = self::$pdo->prepare("
            INSERT INTO user_order_tbl 
            (pharmacy_id, m_id, supplier_name, quantity, total_amount, status)
            VALUES (:pharmacy_id, :m_id, :supplier_name, :quantity, :total_amount, :status)
        ");
        $stmt->execute($data);
        
        return (int) self::$pdo->lastInsertId();
    }

    protected function createSale(int $pharmacyId, array $overrides = []): int
    {
        $defaults = [
            'pharmacy_id' => $pharmacyId,
            'm_id' => null,
            'quantity' => 5,
            'total_price' => 75.00,
            'status' => 'completed',
        ];

        $data = array_merge($defaults, $overrides);
        
        $stmt = self::$pdo->prepare("
            INSERT INTO user_sales_tbl 
            (pharmacy_id, m_id, quantity, total_price, status)
            VALUES (:pharmacy_id, :m_id, :quantity, :total_price, :status)
        ");
        $stmt->execute($data);
        
        return (int) self::$pdo->lastInsertId();
    }

    protected function authenticateSession(array $user): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = $user['role'] ?? 'user';
        $_SESSION['loggedInUser'] = $user;
        if ($user['role'] === 'user') {
            $_SESSION['pharmacy_id'] = $user['user_id'];
        }
    }
}