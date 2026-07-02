<?php

namespace Tests\Integration;

use App\Controllers\Admin\PharmacyController;
use App\Core\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class AdminPharmacyDeleteFlowTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = Database::getInstance()->getConnection();
        $this->resetSchema();
        $_POST = [];
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [
            'auth' => true,
            'loggedInUserRole' => 'admin',
            'loggedInUser' => ['user_id' => 99, 'name' => 'Admin'],
        ];
    }

    protected function tearDown(): void
    {
        $_POST = [];
        $_SESSION = [];
        parent::tearDown();
    }

    public function testAdminDeleteBlocksPharmacyWithMedicines(): void
    {
        $this->seedPharmacy(1);
        $this->pdo->exec("INSERT INTO user_medicine_tbl (pharmacy_id) VALUES (1)");

        $this->expectRedirect('/admin/pharmacies', fn() => (new PharmacyController())->destroy('1'), 'Cannot delete pharmacy');

        $this->assertSame(1, $this->countRows('tbl_pharmacy', 'pharmacy_id = 1'));
        $this->assertSame(1, $this->countRows('role', 'user_id = 1'));
    }

    public function testAdminDeleteBlocksPharmacyWithOrdersOrSales(): void
    {
        $this->seedPharmacy(1);
        $this->pdo->exec("INSERT INTO user_order_tbl (pharmacy_id) VALUES (1)");
        $this->pdo->exec("INSERT INTO user_sales_tbl (pharmacy_id) VALUES (1)");

        $this->expectRedirect('/admin/pharmacies', fn() => (new PharmacyController())->destroy('1'), 'Cannot delete pharmacy');

        $this->assertSame(1, $this->countRows('tbl_pharmacy', 'pharmacy_id = 1'));
        $this->assertSame(1, $this->countRows('role', 'user_id = 1'));
    }

    public function testAdminDeleteRemovesCleanPharmacyAndRole(): void
    {
        $this->seedPharmacy(1);

        $this->expectRedirect('/admin/pharmacies', fn() => (new PharmacyController())->destroy('1'), 'Pharmacy deleted successfully');

        $this->assertSame(0, $this->countRows('tbl_pharmacy', 'pharmacy_id = 1'));
        $this->assertSame(0, $this->countRows('role', 'user_id = 1'));
    }

    private function resetSchema(): void
    {
        $this->pdo->exec('DROP TABLE IF EXISTS user_sales_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS user_order_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS user_medicine_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS user_category_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS tbl_pharmacy');
        $this->pdo->exec('DROP TABLE IF EXISTS role');
        $this->pdo->exec("
            CREATE TABLE role (
                user_id INTEGER PRIMARY KEY,
                name TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                role TEXT DEFAULT 'user'
            );

            CREATE TABLE tbl_pharmacy (
                pharmacy_id INTEGER PRIMARY KEY,
                pharmacy_name TEXT NOT NULL,
                email TEXT NOT NULL
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
            );
        ");
    }

    private function seedPharmacy(int $id): void
    {
        $hash = password_hash('Password123', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("
            INSERT INTO role (user_id, name, email, password, role)
            VALUES (:id, :name, :email, :password, 'user')
        ");
        $stmt->execute([
            'id' => $id,
            'name' => "Pharmacy {$id}",
            'email' => "pharmacy{$id}@example.com",
            'password' => $hash,
        ]);

        $stmt = $this->pdo->prepare("
            INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, email)
            VALUES (:id, :name, :email)
        ");
        $stmt->execute([
            'id' => $id,
            'name' => "Pharmacy {$id}",
            'email' => "pharmacy{$id}@example.com",
        ]);
    }

    private function countRows(string $table, string $where): int
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM {$table} WHERE {$where}")->fetchColumn();
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
