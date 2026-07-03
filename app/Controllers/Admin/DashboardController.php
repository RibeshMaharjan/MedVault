<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Admin;
use App\Models\Pharmacy;

class DashboardController extends Controller
{
    public function index(): void
    {
        $admin = new Admin();
        $pharmacy = new Pharmacy();
        $db = Database::getInstance()->getConnection();

        $recentPharmacies = $db->query(
            "SELECT pharmacy_id, pharmacy_name, isverified FROM tbl_pharmacy ORDER BY pharmacy_id DESC LIMIT 5"
        )->fetchAll();

        $verificationQueue = $db->query(
            "SELECT pharmacy_id, pharmacy_name FROM tbl_pharmacy
             WHERE verification_request_date IS NOT NULL AND isverified = 0
             ORDER BY verification_request_date DESC LIMIT 5"
        )->fetchAll();

        $this->view('admin/dashboard', [
            'totalAdmins' => $admin->count(),
            'totalPharmacies' => $pharmacy->count(),
            'verifiedCount' => $pharmacy->count('isverified = 1'),
            'pendingCount' => $pharmacy->count('verification_request_date IS NOT NULL AND isverified = 0'),
            'recentPharmacies' => $recentPharmacies,
            'verificationQueue' => $verificationQueue,
            'currentPage' => 'dashboard',
        ], 'app');
    }
}
