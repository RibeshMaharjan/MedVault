<?php

namespace Tests\Integration;

use App\Controllers\AuthController;
use App\Controllers\Pharmacy\ProfileController;
use App\Core\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class TransactionFlowTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = Database::getInstance()->getConnection();
        $this->resetSchema();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_POST = [];
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_POST = [];
        $_SESSION = [];
        parent::tearDown();
    }

    public function testRegistrationRollsBackUserWhenPharmacyCreateFails(): void
    {
        $_POST = [
            'name' => 'Rollback User',
            'email' => 'fail@example.com',
            'password' => 'Password123',
            'repassword' => 'Password123',
        ];

        $this->expectRedirect('/login', fn() => (new AuthController())->register(), 'Registration failed');

        $count = (int) $this->pdo->query("SELECT COUNT(*) FROM role WHERE email = 'fail@example.com'")->fetchColumn();
        $this->assertSame(0, $count);
    }

    public function testProfileUpdateRollsBackPharmacyWhenRoleUpdateFails(): void
    {
        $this->seedUserAndPharmacy();
        $_SESSION = [
            'auth' => true,
            'loggedInUserRole' => 'user',
            'loggedInUser' => ['user_id' => 1, 'name' => 'Original Pharmacy'],
            'pharmacy_id' => 1,
        ];
        $_POST = [
            'pharmacy_name' => 'Changed Pharmacy',
            'email' => 'bad@example.com',
            'phone' => '9800000000',
            'address' => 'Changed Address',
            'pan' => '12345',
        ];

        $this->expectRedirect('/pharmacy/profile', fn() => (new ProfileController())->update(), 'Profile update failed');

        $pharmacy = $this->pdo->query('SELECT * FROM tbl_pharmacy WHERE pharmacy_id = 1')->fetch();
        $user = $this->pdo->query('SELECT * FROM role WHERE user_id = 1')->fetch();

        $this->assertSame('Original Pharmacy', $pharmacy['pharmacy_name']);
        $this->assertSame('original@example.com', $pharmacy['email']);
        $this->assertSame('Original Pharmacy', $user['name']);
        $this->assertSame('original@example.com', $user['email']);
    }

    private function resetSchema(): void
    {
        $this->pdo->exec('DROP TABLE IF EXISTS tbl_pharmacy');
        $this->pdo->exec('DROP TABLE IF EXISTS role');
        $this->pdo->exec("
            CREATE TABLE role (
                user_id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL CHECK (email != 'bad@example.com'),
                password TEXT NOT NULL,
                role TEXT DEFAULT 'user',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE tbl_pharmacy (
                pharmacy_id INTEGER PRIMARY KEY,
                pan INTEGER,
                pharmacy_name TEXT NOT NULL,
                email TEXT NOT NULL CHECK (email != 'fail@example.com'),
                address TEXT,
                phone TEXT,
                isverified INTEGER DEFAULT 0,
                license_number TEXT,
                reg_document TEXT,
                verification_request_date DATETIME,
                verification_date DATETIME,
                verification_notes TEXT
            );
        ");
    }

    private function seedUserAndPharmacy(): void
    {
        $hash = password_hash('Password123', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("
            INSERT INTO role (user_id, name, email, password, role)
            VALUES (1, 'Original Pharmacy', 'original@example.com', :password, 'user')
        ");
        $stmt->execute(['password' => $hash]);

        $this->pdo->exec("
            INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, email, phone, address, pan)
            VALUES (1, 'Original Pharmacy', 'original@example.com', '9700000000', 'Original Address', 11111)
        ");
    }

    private function expectRedirect(string $url, callable $callback, ?string $message = null): void
    {
        try {
            $callback();
            $this->fail('Expected redirect exception.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString("Redirect to {$url}", $exception->getMessage());
            if ($message !== null) {
                $this->assertStringContainsString($message, $exception->getMessage());
            }
        }
    }
}
