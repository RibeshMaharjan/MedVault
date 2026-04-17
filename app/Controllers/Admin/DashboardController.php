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
            'currentPage' => 'dashboard',
        ], 'admin');
    }
}
