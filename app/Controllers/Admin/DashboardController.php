<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin;
use App\Models\Pharmacy;

class DashboardController extends Controller
{
    public function index(): void
    {
        $admin = new Admin();
        $pharmacy = new Pharmacy();

        $this->view('admin/dashboard', [
            'totalAdmins' => $admin->count(),
            'totalPharmacies' => $pharmacy->count(),
            'verifiedCount' => $pharmacy->count('isverified = 1'),
            'pendingCount' => $pharmacy->count('verification_request_date IS NOT NULL AND isverified = 0'),
            'recentPharmacies' => $pharmacy->recent(4),
            'verificationQueue' => $pharmacy->pendingVerifications(5),
            'currentPage' => 'dashboard',
        ], 'admin');
    }
}
