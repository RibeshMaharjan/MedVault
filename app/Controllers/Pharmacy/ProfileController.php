<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
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

        $updateData = [
            'license_number' => $licenseNumber,
            'verification_request_date' => date('Y-m-d H:i:s'),
        ];

        // Handle file upload
        if (isset($_FILES['reg_document']) && $_FILES['reg_document']['error'] === 0) {
            $targetDir = dirname(__DIR__, 3) . '/public/uploads/documents/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

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

            $newFilename = $pharmacyId . '_' . bin2hex(random_bytes(16)) . '.' . $allowedTypes[$detectedType];
            $targetFile = $targetDir . $newFilename;

            if (move_uploaded_file($_FILES['reg_document']['tmp_name'], $targetFile)) {
                $updateData['reg_document'] = 'uploads/documents/' . $newFilename;
            } else {
                $this->redirect('/pharmacy/profile', 'Error uploading document. Please try again.');
            }
        } else {
            $this->redirect('/pharmacy/profile', 'Registration document is required.');
        }

        $this->pharmacy->update($pharmacyId, $updateData, 'pharmacy_id');
        $this->redirect('/pharmacy/profile', 'Verification request submitted successfully! Your request is now under review.');
    }
}
