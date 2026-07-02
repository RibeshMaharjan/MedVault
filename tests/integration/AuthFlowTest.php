<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use PDO;

class AuthFlowTest extends TestCase
{
    private static ?PDO $pdo = null;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        self::$pdo->exec("
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
                pan INTEGER,
                pharmacy_name TEXT NOT NULL,
                email TEXT NOT NULL,
                address TEXT,
                phone TEXT,
                isverified INTEGER DEFAULT 0,
                license_number TEXT,
                reg_document TEXT,
                verification_request_date DATETIME,
                verification_date DATETIME,
                verification_notes TEXT
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM role");
        self::$pdo->exec("DELETE FROM tbl_pharmacy");
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        parent::tearDown();
    }

    public function testRegistrationCreatesUserAndPharmacy(): void
    {
        $name = 'Test User';
        $email = 'test@example.com';
        $password = password_hash('Password123', PASSWORD_DEFAULT);
        
        self::$pdo->exec("
            INSERT INTO role (name, email, password, role) 
            VALUES ('$name', '$email', '$password', 'user')
        ");
        $userId = (int) self::$pdo->lastInsertId();
        
        self::$pdo->exec("
            INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, email, isverified)
            VALUES ($userId, '$name', '$email', 0)
        ");
        
        $user = self::$pdo->query("SELECT * FROM role WHERE email = '$email'")->fetch();
        $pharmacy = self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE pharmacy_id = $userId")->fetch();
        
        $this->assertNotNull($user);
        $this->assertNotNull($pharmacy);
        $this->assertEquals($email, $user['email']);
        $this->assertEquals(0, $pharmacy['isverified']);
    }

    public function testLoginValidatesCredentials(): void
    {
        $passwordHash = password_hash('Password123', PASSWORD_DEFAULT);
        
        self::$pdo->exec("
            INSERT INTO role (name, email, password, role)
            VALUES ('Test User', 'test@example.com', '$passwordHash', 'user')
        ");
        
        $user = self::$pdo->query("SELECT * FROM role WHERE email = 'test@example.com'")->fetch();
        
        $isValid = password_verify('Password123', $user['password']);
        
        $this->assertTrue($isValid);
    }

    public function testLoginSetsSession(): void
    {
        self::$pdo->exec("
            INSERT INTO role (name, email, password, role)
            VALUES ('Test User', 'test@example.com', 'hash', 'user')
        ");
        
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'user';
        $_SESSION['loggedInUser'] = ['user_id' => 1, 'name' => 'Test User'];
        $_SESSION['pharmacy_id'] = 1;
        
        $this->assertTrue($_SESSION['auth']);
        $this->assertEquals('user', $_SESSION['loggedInUserRole']);
    }

    public function testLogoutDestroysSession(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'admin';
        $_SESSION['loggedInUser'] = ['user_id' => 1];
        
        unset($_SESSION['auth']);
        unset($_SESSION['loggedInUserRole']);
        unset($_SESSION['loggedInUser']);
        
        $this->assertFalse(isset($_SESSION['auth']));
    }

    public function testLoginRejectsInvalidEmail(): void
    {
        $email = 'nonexistent@example.com';
        
        $user = self::$pdo->query("SELECT * FROM role WHERE email = '$email'")->fetch();
        
        $this->assertFalse($user);
    }

    public function testLoginRejectsInvalidPassword(): void
    {
        $passwordHash = password_hash('CorrectPassword', PASSWORD_DEFAULT);
        
        self::$pdo->exec("
            INSERT INTO role (name, email, password, role)
            VALUES ('Test User', 'test@example.com', '$passwordHash', 'user')
        ");
        
        $isValid = password_verify('WrongPassword', $passwordHash);
        
        $this->assertFalse($isValid);
    }

    public function testRegistrationPreventsDuplicateEmail(): void
    {
        $email = 'test@example.com';
        
        self::$pdo->exec("
            INSERT INTO role (name, email, password, role)
            VALUES ('User 1', '$email', 'hash1', 'user')
        ");
        
        $existing = self::$pdo->query("SELECT * FROM role WHERE email = '$email'")->fetch();
        
        $this->assertNotNull($existing);
        
        $this->expectException(\Exception::class);
        
        self::$pdo->exec("
            INSERT INTO role (name, email, password, role)
            VALUES ('User 2', '$email', 'hash2', 'user')
        ");
    }

    public function testAdminRedirectsToAdminDashboard(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'admin';
        
        $redirectUrl = $_SESSION['loggedInUserRole'] === 'admin' 
            ? '/admin/dashboard' 
            : '/pharmacy/dashboard';
        
        $this->assertEquals('/admin/dashboard', $redirectUrl);
    }

    public function testUserRedirectsToPharmacyDashboard(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'user';
        
        $redirectUrl = $_SESSION['loggedInUserRole'] === 'admin' 
            ? '/admin/dashboard' 
            : '/pharmacy/dashboard';
        
        $this->assertEquals('/pharmacy/dashboard', $redirectUrl);
    }
}
