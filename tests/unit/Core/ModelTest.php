<?php

namespace Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Database;
use App\Core\Model;
use PDO;

class TestModel extends Model
{
    protected string $table = 'test_table';
    protected string $primaryKey = 'id';
}

class ModelTest extends TestCase
{
    private static ?PDO $testPdo = null;

    public static function setUpBeforeClass(): void
    {
        self::$testPdo = new PDO('sqlite::memory:');
        self::$testPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        self::$testPdo->exec("
            CREATE TABLE test_table (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT UNIQUE,
                status TEXT DEFAULT 'active'
            )
        ");
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::$testPdo->exec("DELETE FROM test_table");
        self::$testPdo->exec("DELETE FROM sqlite_sequence WHERE name = 'test_table'");
    }

    public function testFindAllReturnsAllRecords(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $results = $model->findAll();
        
        $this->assertCount(3, $results);
    }

    public function testFindAllWithConditions(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $results = $model->findAll('status = :status', ['status' => 'active']);
        
        $this->assertCount(2, $results);
    }

    public function testFindByIdReturnsRecord(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $result = $model->findById(1);
        
        $this->assertNotNull($result);
        $this->assertEquals('Test 1', $result['name']);
    }

    public function testFindByIdReturnsNullForNonExistent(): void
    {
        $model = $this->createModel();
        $result = $model->findById(999);
        
        $this->assertNull($result);
    }

    public function testFindOneByReturnsSingleRecord(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $result = $model->findOneBy('email', 'test1@example.com');
        
        $this->assertNotNull($result);
        $this->assertEquals('Test 1', $result['name']);
    }

    public function testFindAllByReturnsMultipleRecords(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $results = $model->findAllBy('status', 'active');
        
        $this->assertCount(2, $results);
    }

    public function testCountReturnsCorrectNumber(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $count = $model->count();
        
        $this->assertEquals(3, $count);
    }

    public function testCountWithConditions(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $count = $model->count('status = :status', ['status' => 'active']);
        
        $this->assertEquals(2, $count);
    }

    public function testInsertReturnsLastInsertId(): void
    {
        $model = $this->createModel();
        $id = $model->insert([
            'name' => 'New Record',
            'email' => 'new@example.com',
            'status' => 'active',
        ]);
        
        $this->assertEquals(1, $id);
        
        $result = $model->findById($id);
        $this->assertEquals('New Record', $result['name']);
    }

    public function testUpdateReturnsTrue(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $result = $model->update(1, ['name' => 'Updated Name']);
        
        $this->assertTrue($result);
        
        $record = $model->findById(1);
        $this->assertEquals('Updated Name', $record['name']);
    }

    public function testDeleteReturnsTrueForExistingRecord(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $result = $model->delete(1);
        
        $this->assertTrue($result);
        
        $record = $model->findById(1);
        $this->assertNull($record);
    }

    public function testDeleteReturnsFalseForNonExistent(): void
    {
        $model = $this->createModel();
        $result = $model->delete(999);
        
        $this->assertFalse($result);
    }

    public function testPaginateReturnsCorrectStructure(): void
    {
        $this->seedTestData(20);
        
        $model = $this->createModel();
        $result = $model->paginate(1, 5);
        
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('currentPage', $result);
        $this->assertArrayHasKey('totalPages', $result);
        $this->assertArrayHasKey('totalRecords', $result);
        $this->assertArrayHasKey('hasNextPage', $result);
        $this->assertArrayHasKey('hasPrevPage', $result);
    }

    public function testPaginateReturnsCorrectData(): void
    {
        $this->seedTestData(20);
        
        $model = $this->createModel();
        $result = $model->paginate(1, 5);
        
        $this->assertCount(5, $result['data']);
        $this->assertEquals(1, $result['currentPage']);
        $this->assertEquals(4, $result['totalPages']);
        $this->assertEquals(20, $result['totalRecords']);
        $this->assertTrue($result['hasNextPage']);
        $this->assertFalse($result['hasPrevPage']);
    }

    public function testPaginateSecondPage(): void
    {
        $this->seedTestData(20);
        
        $model = $this->createModel();
        $result = $model->paginate(2, 5);
        
        $this->assertCount(5, $result['data']);
        $this->assertEquals(2, $result['currentPage']);
        $this->assertTrue($result['hasNextPage']);
        $this->assertTrue($result['hasPrevPage']);
    }

    public function testPaginateLastPage(): void
    {
        $this->seedTestData(20);
        
        $model = $this->createModel();
        $result = $model->paginate(4, 5);
        
        $this->assertCount(5, $result['data']);
        $this->assertEquals(4, $result['currentPage']);
        $this->assertFalse($result['hasNextPage']);
        $this->assertTrue($result['hasPrevPage']);
    }

    public function testPaginateWithConditions(): void
    {
        $this->seedTestData();
        
        $model = $this->createModel();
        $result = $model->paginate(1, 5, 'status = :status', ['status' => 'active']);
        
        $this->assertEquals(2, $result['totalRecords']);
    }

    private function createModel(): TestModel
    {
        return new class(self::$testPdo) extends TestModel {
            private PDO $pdo;
            
            public function __construct(PDO $pdo)
            {
                $this->db = $pdo;
            }
        };
    }

    private function seedTestData(int $count = 3): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $status = $i <= ($count - 1) ? 'active' : 'inactive';
            self::$testPdo->exec("INSERT INTO test_table (name, email, status) VALUES ('Test $i', 'test$i@example.com', '$status')");
        }
    }
}
