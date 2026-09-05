<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Core\ErrorView;
use App\Core\VerificationDocument;
use App\Models\Pharmacy;
use App\Models\User;

class ProfileController extends Controller
{
    private Pharmacy $pharmacy;
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->pharmacy = new Pharmacy();
        $this->user = new User();
    }

    public function edit(): void
    {
        $pharmacyId = $this->session->pharmacyId();
        $data = $this->pharmacy->findById($pharmacyId, 'pharmacy_id');

        $this->view('pharmacy/profile', [
            'pharmacy' => $data,
            'pharmacyVerified' => (int) ($data['isverified'] ?? 0) === 1,
            'currentPage' => 'profile',
        ], 'pharmacy');
    }

    public function update(): void
    {
        $pharmacyId = $this->session->pharmacyId();

        $name = $this->validate($_POST['pharmacy_name'] ?? '');
        $email = $this->validate($_POST['email'] ?? '');
        $phone = $this->validate($_POST['phone'] ?? '');
        $address = $this->validate($_POST['address'] ?? '');
        $pan = $this->validate($_POST['pan'] ?? '');

        if (empty($name) || empty($email)) {
            $this->redirect('/pharmacy/profile', 'Name and email are required');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/pharmacy/profile', 'Invalid email format');
        }
        if ($phone !== '' && !preg_match('/^[0-9]{10}$/', $phone)) {
            $this->redirect('/pharmacy/profile', 'Invalid phone number');
        }
        if ($pan !== '' && (!is_numeric($pan) || $pan <= 0)) {
            $this->redirect('/pharmacy/profile', 'Invalid PAN number');
        }

        $existing = $this->user->findByEmail($email);
        if ($existing && (int) $existing['user_id'] !== $pharmacyId) {
            $this->redirect('/pharmacy/profile', 'Email already in use by another account');
        }

        try {
            $this->pharmacy->beginTransaction();
            $this->pharmacy->update($pharmacyId, [
                'pharmacy_name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'pan' => $pan,
            ], 'pharmacy_id');

            // Keep role table in sync.
            $this->user->update($pharmacyId, [
                'name' => $name,
                'email' => $email,
            ], 'user_id');
            $this->pharmacy->commit();
        } catch (\Throwable $e) {
            $this->pharmacy->rollBack();
            error_log('Profile update failed: ' . $e->getMessage());
            $this->redirect('/pharmacy/profile', 'Profile update failed. Please try again.');
        }

        $this->redirect('/pharmacy/profile', 'Profile updated successfully!');
    }

    public function requestVerification(): void
    {
        $pharmacyId = $this->session->pharmacyId();
        $licenseNumber = $this->validate($_POST['license_number'] ?? '');

        if (empty($licenseNumber)) {
            $this->redirect('/pharmacy/profile', 'License number is required.');
        }

        $current = $this->pharmacy->findById($pharmacyId, 'pharmacy_id');
        if ($current && (int) $current['isverified'] === 1) {
            $this->redirect('/pharmacy/profile', 'Your pharmacy is already verified.');
        }

        $updateData = [
            'isverified' => 0,
            'license_number' => $licenseNumber,
            'verification_request_date' => date('Y-m-d H:i:s'),
            'verification_date' => null,
            'verification_notes' => null,
        ];

        // Handle file upload
        if (isset($_FILES['reg_document']) && $_FILES['reg_document']['error'] === 0) {
            $allowedTypes = [
                'application/pdf' => 'pdf',
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
            ];
            $maxBytes = 5 * 1024 * 1024;
            $tmpName = $_FILES['reg_document']['tmp_name'];
            $detectedType = (new \finfo(FILEINFO_MIME_TYPE))->file($tmpName) ?: '';

            if ($_FILES['reg_document']['size'] > $maxBytes || !isset($allowedTypes[$detectedType])) {
                $this->redirect('/pharmacy/profile', 'Invalid document. Upload a PDF, JPG, or PNG under 5MB.');
            }

            $storedPath = VerificationDocument::store(
                $_FILES['reg_document'],
                $pharmacyId,
                $allowedTypes[$detectedType]
            );
            if (!$storedPath) {
                $this->redirect('/pharmacy/profile', 'Error uploading document. Please try again.');
            }
            $updateData['reg_document'] = $storedPath;
        } else {
            $this->redirect('/pharmacy/profile', 'Registration document is required.');
        }

        $this->pharmacy->update($pharmacyId, $updateData, 'pharmacy_id');
        $this->redirect('/pharmacy/profile', 'Verification request submitted successfully! Your request is now under review.');
    }

    public function document(): void
    {
        $pharmacyId = $this->session->pharmacyId();
        $pharmacy = $this->pharmacy->findById($pharmacyId, 'pharmacy_id');
        $path = VerificationDocument::resolve($pharmacy['reg_document'] ?? null);
        if (!$pharmacy || !$path) {
            ErrorView::render(404, '404', 'Registration document not found');
            return;
        }

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
