<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use PDO;

class UserTest extends TestCase
{
    private static ?PDO $pdo = null;
    private User $model;

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
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$pdo->exec("DELETE FROM role");
        self::$pdo->exec("DELETE FROM sqlite_sequence WHERE name = 'role'");
        
        $this->model = new class(self::$pdo) extends User {            public function __construct($pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    public function testFindByEmailReturnsUserWhenExists(): void
    {
        $this->seedUser('test@example.com');
        
        $result = $this->model->findByEmail('test@example.com');
        
        $this->assertNotNull($result);
        $this->assertEquals('test@example.com', $result['email']);
    }

    public function testFindByEmailReturnsNullWhenNotExists(): void
    {
        $result = $this->model->findByEmail('nonexistent@example.com');
        
        $this->assertNull($result);
    }

    public function testCreateReturnsUserId(): void
    {
        $userId = $this->model->create('Test User', 'test@example.com', 'hash123', 'user');
        
        $this->assertEquals(1, $userId);
        
        $result = $this->model->findById($userId);
        $this->assertNotNull($result);
        $this->assertEquals('Test User', $result['name']);
        $this->assertEquals('test@example.com', $result['email']);
        $this->assertEquals('user', $result['role']);
    }

    public function testCreateWithAdminRole(): void
    {
        $userId = $this->model->create('Admin User', 'admin@example.com', 'hash123', 'admin');
        
        $result = $this->model->findById($userId);
        $this->assertEquals('admin', $result['role']);
    }

    public function testFindByIdReturnsUser(): void
    {
        $id = $this->seedUser('test@example.com');
        
        $result = $this->model->findById($id);
        
        $this->assertNotNull($result);
        $this->assertEquals('test@example.com', $result['email']);
    }

    public function testFindByIdReturnsNullForNonExistent(): void
    {
        $result = $this->model->findById(999);
        
        $this->assertNull($result);
    }

    public function testUpdateUpdatesUser(): void
    {
        $id = $this->seedUser('test@example.com');
        
        $result = $this->model->update($id, ['name' => 'Updated Name']);
        
        $this->assertTrue($result);
        
        $user = $this->model->findById($id);
        $this->assertEquals('Updated Name', $user['name']);
    }

    public function testDeleteRemovesUser(): void
    {
        $id = $this->seedUser('test@example.com');
        
        $result = $this->model->delete($id);
        
        $this->assertTrue($result);
        
        $user = $this->model->findById($id);
        $this->assertNull($user);
    }

    public function testFindAllByRole(): void
    {
        $this->seedUser('user1@example.com', 'user');
        $this->seedUser('user2@example.com', 'user');
        $this->seedUser('admin@example.com', 'admin');
        
        $results = $this->model->findAllBy('role', 'user');
        
        $this->assertCount(2, $results);
    }

    private function seedUser(string $email, string $role = 'user'): int
    {
        self::$pdo->exec("INSERT INTO role (name, email, password, role) VALUES ('Test', '$email', 'hash', '$role')");
        return (int) self::$pdo->lastInsertId();
    }
}
