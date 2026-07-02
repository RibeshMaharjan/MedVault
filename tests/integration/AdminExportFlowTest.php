<?php

namespace Tests\Integration;

use App\Controllers\Admin\ExportController;
use App\Core\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class AdminExportFlowTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = Database::getInstance()->getConnection();
        $this->resetSchema();
        $_GET = [];
    }

    protected function tearDown(): void
    {
        $_GET = [];
        parent::tearDown();
    }

    public function testEmptyExportStillWritesCsvHeader(): void
    {
        $csv = $this->captureExport();

        $this->assertStringContainsString('o_id,pharmacy_id,pharmacy_name,m_id,medicine_name,price,quantity,total_amount,status,order_date', $csv);
    }

    public function testExportUsesCurrentOrderSchemaAndJoinsNames(): void
    {
        $medicineId = $this->seedMedicine('Aspirin');
        $this->seedOrder($medicineId, 'pending', '2026-07-02');

        $csv = $this->captureExport();

        $this->assertStringContainsString('Test Pharmacy', $csv);
        $this->assertStringContainsString('Aspirin', $csv);
        $this->assertStringContainsString('pending', $csv);
    }

    public function testExportFiltersByStatusAndDate(): void
    {
        $medicineId = $this->seedMedicine('Aspirin');
        $this->seedOrder($medicineId, 'pending', '2026-07-02');
        $this->seedOrder($medicineId, 'completed', '2026-06-01');
        $_GET = [
            'status' => 'pending',
            'date_from' => '2026-07-01',
            'date_to' => '2026-07-31',
        ];

        $csv = $this->captureExport();

        $this->assertStringContainsString('pending', $csv);
        $this->assertStringNotContainsString('completed', $csv);
    }

    private function captureExport(): string
    {
        ob_start();
        try {
            (new ExportController())->orders();
        } catch (\RuntimeException $exception) {
            $this->assertSame('CSV export complete', $exception->getMessage());
        }
        return ob_get_clean();
    }

    private function resetSchema(): void
    {
        $this->pdo->exec('DROP TABLE IF EXISTS user_order_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS user_medicine_tbl');
        $this->pdo->exec('DROP TABLE IF EXISTS tbl_pharmacy');
        $this->pdo->exec("
            CREATE TABLE tbl_pharmacy (
                pharmacy_id INTEGER PRIMARY KEY,
                pharmacy_name TEXT NOT NULL
            );
            CREATE TABLE user_medicine_tbl (
                m_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                medicine_name TEXT NOT NULL
            );
            CREATE TABLE user_order_tbl (
                o_id INTEGER PRIMARY KEY AUTOINCREMENT,
                pharmacy_id INTEGER NOT NULL,
                m_id INTEGER,
                price REAL DEFAULT 0,
                quantity INTEGER DEFAULT 0,
                total_amount REAL DEFAULT 0,
                status TEXT DEFAULT 'pending',
                order_date DATE
            );
        ");
        $this->pdo->exec("INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name) VALUES (1, 'Test Pharmacy')");
    }

    private function seedMedicine(string $name): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name)
            VALUES (1, :name)
        ");
        $stmt->execute(['name' => $name]);
        return (int) $this->pdo->lastInsertId();
    }

    private function seedOrder(int $medicineId, string $status, string $date): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_order_tbl (pharmacy_id, m_id, price, quantity, total_amount, status, order_date)
            VALUES (1, :m_id, 15.00, 2, 30.00, :status, :order_date)
        ");
        $stmt->execute([
            'm_id' => $medicineId,
            'status' => $status,
            'order_date' => $date,
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
