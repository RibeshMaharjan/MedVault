<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Pharmacy;
use App\Models\User;

class PharmacyController extends Controller
{
    private Pharmacy $pharmacy;
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->pharmacy = new Pharmacy();
        $this->user = new User();
    }

    public function index(): void
    {
        $pharmacies = $this->pharmacy->findAll();
        $this->view('admin/pharmacies/index', [
            'pharmacies' => $pharmacies,
            'currentPage' => 'pharmacy-display',
        ], 'admin');
    }

    public function store(): void
    {
        $pan = $this->validate($_POST['pan'] ?? '');
        $name = $this->validate($_POST['name'] ?? '');
        $email = $this->validate($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $phone = $this->validate($_POST['phone'] ?? '');
        $address = $this->validate($_POST['address'] ?? '');

        if (empty($name) || empty($email) || empty($password)) {
            $this->redirect('/admin/pharmacies', 'Please fill all fields!');
        }

        if (!is_numeric($pan) || $pan <= 0) {
            $this->redirect('/admin/pharmacies', 'Invalid PAN Number');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/admin/pharmacies', 'Invalid email format');
        }
        if ($phone !== '' && !preg_match('/^[0-9]{10}$/', $phone)) {
            $this->redirect('/admin/pharmacies', 'Invalid Phone Number');
        }
        if ($this->user->findByEmail($email)) {
            $this->redirect('/admin/pharmacies', 'Email Already Exists');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->user->beginTransaction();
            $userId = $this->user->create($name, $email, $passwordHash, 'user');
            $this->pharmacy->insert([
                'pharmacy_id' => $userId,
                'pan' => $pan,
                'pharmacy_name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
            ]);
            $this->user->commit();
        } catch (\Throwable $e) {
            $this->user->rollBack();
            error_log('Pharmacy create failed: ' . $e->getMessage());
            $this->redirect('/admin/pharmacies', 'Pharmacy creation failed. Please try again.');
        }

        $this->redirect('/admin/pharmacies', 'Pharmacy Added successfully');
    }

    public function destroy(string $id): void
    {
        $pharmacyId = (int) $id;
        if ($this->pharmacy->hasBusinessRecords($pharmacyId)) {
            $this->redirect('/admin/pharmacies', 'Cannot delete pharmacy with existing medicines, orders, or sales');
        }

        try {
            $this->pharmacy->beginTransaction();
            $this->pharmacy->delete($pharmacyId, 'pharmacy_id');
            $this->user->delete($pharmacyId, 'user_id');
            $this->pharmacy->commit();
        } catch (\Throwable $e) {
            $this->pharmacy->rollBack();
            error_log('Pharmacy delete failed: ' . $e->getMessage());
            $this->redirect('/admin/pharmacies', 'Pharmacy delete failed. Please try again.');
        }

        $this->redirect('/admin/pharmacies', 'Pharmacy deleted successfully');
    }

    public function verify(): void
    {
        $pendingSql = "SELECT p.*, r.name, r.email as user_email
                       FROM tbl_pharmacy p JOIN role r ON p.pharmacy_id = r.user_id
                       WHERE p.verification_request_date IS NOT NULL AND p.isverified = 0
                       ORDER BY p.verification_request_date DESC";
        $verifiedSql = "SELECT p.*, r.name, r.email as user_email
                        FROM tbl_pharmacy p JOIN role r ON p.pharmacy_id = r.user_id
                        WHERE p.isverified = 1 ORDER BY p.verification_date DESC";

        $db = \App\Core\Database::getInstance()->getConnection();
        $pending = $db->query($pendingSql)->fetchAll();
        $verified = $db->query($verifiedSql)->fetchAll();

        $totalCount = $this->pharmacy->count();
        $verifiedCount = $this->pharmacy->count("isverified = 1");
        $pendingCount = count($pending);

        $this->view('admin/pharmacies/verify', [
            'pending' => $pending,
            'verified' => $verified,
            'totalCount' => $totalCount,
            'verifiedCount' => $verifiedCount,
            'pendingCount' => $pendingCount,
            'currentPage' => 'verify',
        ], 'admin');
    }

    public function approve(string $id): void
    {
        $pharmacyId = (int) $id;
        $notes = $this->validate($_POST['verification_notes'] ?? '');

        if (!$this->pharmacy->findById($pharmacyId, 'pharmacy_id')) {
            $this->redirect('/admin/pharmacies/verify', 'Pharmacy not found');
        }

        $this->pharmacy->update($pharmacyId, [
            'isverified' => 1,
            'verification_date' => date('Y-m-d H:i:s'),
            'verification_notes' => $notes,
        ], 'pharmacy_id');

        $this->redirect('/admin/pharmacies/verify', 'Pharmacy verified successfully!');
    }

    public function reject(string $id): void
    {
        $pharmacyId = (int) $id;
        $notes = $this->validate($_POST['verification_notes'] ?? '');

        if (!$this->pharmacy->findById($pharmacyId, 'pharmacy_id')) {
            $this->redirect('/admin/pharmacies/verify', 'Pharmacy not found');
        }

        $sql = "UPDATE tbl_pharmacy SET verification_request_date = NULL, verification_notes = :notes WHERE pharmacy_id = :id";
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute(['notes' => $notes, 'id' => $pharmacyId]);

        $this->redirect('/admin/pharmacies/verify', 'Pharmacy verification request rejected!');
    }
}
