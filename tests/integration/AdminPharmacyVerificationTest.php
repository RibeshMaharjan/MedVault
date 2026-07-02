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
                pan INTEGER,
                pharmacy_name TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT,
                address TEXT,
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
        self::$pdo->exec("DELETE FROM tbl_pharmacy");
    }

    public function testPharmacyRequestVerificationStoresRequiredFields(): void
    {
        $this->seedPharmacy(1);

        self::$pdo->exec("
            UPDATE tbl_pharmacy
            SET license_number = 'LIC-123',
                reg_document = 'uploads/documents/1_doc.pdf',
                verification_request_date = '2026-07-02 10:00:00'
            WHERE pharmacy_id = 1
        ");

        $pharmacy = $this->findPharmacy(1);

        $this->assertEquals('LIC-123', $pharmacy['license_number']);
        $this->assertEquals('uploads/documents/1_doc.pdf', $pharmacy['reg_document']);
        $this->assertEquals('2026-07-02 10:00:00', $pharmacy['verification_request_date']);
        $this->assertEquals(0, $pharmacy['isverified']);
    }

    public function testAdminApprovesPharmacy(): void
    {
        $this->seedPharmacy(1, [
            'license_number' => 'LIC-123',
            'verification_request_date' => '2026-07-02 10:00:00',
        ]);

        self::$pdo->exec("
            UPDATE tbl_pharmacy
            SET isverified = 1,
                verification_date = '2026-07-02 12:00:00',
                verification_notes = 'Approved'
            WHERE pharmacy_id = 1
        ");

        $pharmacy = $this->findPharmacy(1);

        $this->assertEquals(1, $pharmacy['isverified']);
        $this->assertEquals('2026-07-02 12:00:00', $pharmacy['verification_date']);
        $this->assertEquals('Approved', $pharmacy['verification_notes']);
    }

    public function testAdminRejectsPharmacy(): void
    {
        $this->seedPharmacy(1, [
            'license_number' => 'LIC-123',
            'verification_request_date' => '2026-07-02 10:00:00',
        ]);

        self::$pdo->exec("
            UPDATE tbl_pharmacy
            SET verification_request_date = NULL,
                verification_notes = 'Bad document'
            WHERE pharmacy_id = 1
        ");

        $pharmacy = $this->findPharmacy(1);

        $this->assertNull($pharmacy['verification_request_date']);
        $this->assertEquals(0, $pharmacy['isverified']);
        $this->assertEquals('Bad document', $pharmacy['verification_notes']);
    }

    public function testListPendingPharmacies(): void
    {
        $this->seedPharmacy(1, ['verification_request_date' => '2026-07-02 10:00:00']);
        $this->seedPharmacy(2, ['isverified' => 1, 'verification_date' => '2026-07-02 12:00:00']);
        $this->seedPharmacy(3, ['verification_request_date' => '2026-07-02 11:00:00']);

        $pending = self::$pdo
            ->query("SELECT * FROM tbl_pharmacy WHERE verification_request_date IS NOT NULL AND isverified = 0")
            ->fetchAll();

        $this->assertCount(2, $pending);
    }

    public function testListVerifiedPharmacies(): void
    {
        $this->seedPharmacy(1, ['isverified' => 1, 'verification_date' => '2026-07-02 12:00:00']);
        $this->seedPharmacy(2);

        $verified = self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE isverified = 1")->fetchAll();

        $this->assertCount(1, $verified);
    }

    public function testDeletePharmacy(): void
    {
        $this->seedPharmacy(1);

        $deleted = self::$pdo->exec("DELETE FROM tbl_pharmacy WHERE pharmacy_id = 1");

        $this->assertEquals(1, $deleted);
        $this->assertFalse(self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE pharmacy_id = 1")->fetch());
    }

    public function testPharmacyCountsByVerificationState(): void
    {
        $this->seedPharmacy(1, ['isverified' => 1]);
        $this->seedPharmacy(2);
        $this->seedPharmacy(3, ['isverified' => 1]);

        $verified = self::$pdo->query("SELECT COUNT(*) as count FROM tbl_pharmacy WHERE isverified = 1")->fetch();
        $unverified = self::$pdo->query("SELECT COUNT(*) as count FROM tbl_pharmacy WHERE isverified = 0")->fetch();

        $this->assertEquals(2, $verified['count']);
        $this->assertEquals(1, $unverified['count']);
    }

    private function seedPharmacy(int $id, array $overrides = []): void
    {
        $data = array_merge([
            'pharmacy_id' => $id,
            'pan' => 12345,
            'pharmacy_name' => "Pharmacy {$id}",
            'email' => "pharmacy{$id}@example.com",
            'phone' => '9800000000',
            'address' => 'Kathmandu',
            'isverified' => 0,
            'license_number' => null,
            'reg_document' => null,
            'verification_request_date' => null,
            'verification_date' => null,
            'verification_notes' => null,
        ], $overrides);

        $stmt = self::$pdo->prepare("
            INSERT INTO tbl_pharmacy (
                pharmacy_id, pan, pharmacy_name, email, phone, address, isverified,
                license_number, reg_document, verification_request_date, verification_date, verification_notes
            ) VALUES (
                :pharmacy_id, :pan, :pharmacy_name, :email, :phone, :address, :isverified,
                :license_number, :reg_document, :verification_request_date, :verification_date, :verification_notes
            )
        ");
        $stmt->execute($data);
    }

    private function findPharmacy(int $id): array
    {
        return self::$pdo->query("SELECT * FROM tbl_pharmacy WHERE pharmacy_id = {$id}")->fetch();
    }
}
