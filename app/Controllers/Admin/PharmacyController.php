<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\ErrorView;
use App\Core\VerificationDocument;
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

        if (!preg_match('/^[0-9]{1,9}$/', $pan)) {
            $this->redirect('/admin/pharmacies', 'PAN number must be 1-9 digits');
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

    public function show(string $id): void
    {
        $pharmacy = $this->pharmacy->findDetailedById((int) $id);
        if (!$pharmacy) {
            ErrorView::render(404, '404', 'Pharmacy not found');
            return;
        }

        $this->view('admin/pharmacies/show', [
            'pharmacy' => $pharmacy,
            'currentPage' => 'pharmacy-display',
        ], 'admin');
    }

    public function document(string $id): void
    {
        $pharmacy = $this->pharmacy->findById((int) $id, 'pharmacy_id');
        $path = VerificationDocument::resolve($pharmacy['reg_document'] ?? null);
        if (!$pharmacy || !$path) {
            ErrorView::render(404, '404', 'Registration document not found');
            return;
        }

        $this->streamDocument($path);
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

        $pharmacy = $this->pharmacy->findById($pharmacyId, 'pharmacy_id');
        if (!$pharmacy) {
            $this->redirect('/admin/pharmacies/verify', 'Pharmacy not found');
        }
        if ((int) $pharmacy['isverified'] === 1) {
            $this->redirect($this->verificationRedirect($pharmacyId), 'Pharmacy is already verified');
        }
        if (empty($pharmacy['verification_request_date']) || empty($pharmacy['reg_document'])) {
            $this->redirect($this->verificationRedirect($pharmacyId), 'A submitted verification request and document are required');
        }

        $this->pharmacy->update($pharmacyId, [
            'isverified' => 1,
            'verification_date' => date('Y-m-d H:i:s'),
            'verification_notes' => $notes,
        ], 'pharmacy_id');

        $this->redirect($this->verificationRedirect($pharmacyId), 'Pharmacy verified successfully!');
    }

    public function reject(string $id): void
    {
        $pharmacyId = (int) $id;
        $notes = $this->validate($_POST['verification_notes'] ?? '');

        $pharmacy = $this->pharmacy->findById($pharmacyId, 'pharmacy_id');
        if (!$pharmacy) {
            $this->redirect('/admin/pharmacies/verify', 'Pharmacy not found');
        }
        if (empty($pharmacy['verification_request_date']) || (int) $pharmacy['isverified'] === 1) {
            $this->redirect($this->verificationRedirect($pharmacyId), 'No pending verification request was found');
        }
        if ($notes === '') {
            $this->redirect($this->verificationRedirect($pharmacyId), 'A rejection reason is required');
        }

        $sql = "UPDATE tbl_pharmacy SET verification_request_date = NULL, verification_notes = :notes WHERE pharmacy_id = :id";
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute(['notes' => $notes, 'id' => $pharmacyId]);

        $this->redirect($this->verificationRedirect($pharmacyId), 'Pharmacy verification request rejected!');
    }

    private function verificationRedirect(int $pharmacyId): string
    {
        return ($_POST['return_to'] ?? '') === 'details'
            ? "/admin/pharmacies/{$pharmacyId}"
            : '/admin/pharmacies/verify';
    }

    private function streamDocument(string $path): void
    {
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($path) ?: 'application/octet-stream';
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($path));
        header('Content-Disposition: inline; filename="' . basename($path) . '"');
        header('X-Content-Type-Options: nosniff');
        readfile($path);
        if (($_ENV['APP_ENV'] ?? '') !== 'testing') {
            exit;
        }
    }
}
