<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Models\UserMedicine;
use App\Models\Category;

class DashboardController extends Controller
{
    private UserMedicine $medicine;
    private Category $category;

    public function __construct()
    {
        parent::__construct();
        $this->medicine = new UserMedicine();
        $this->category = new Category();
    }

    public function index(): void
    {
        $userId = $this->session->pharmacyId();
        $expirySummary = $this->medicine->getExpirySummary($userId);

        $data = [
            'totalMedicines' => $this->medicine->countByPharmacy($userId),
            'totalCategories' => $this->category->count("pharmacy_id = :pid", ['pid' => $userId]),
            'lowStockCount' => $this->medicine->countByPharmacy($userId, "in_stock <= :threshold", ['threshold' => 10]),
            'outOfStockCount' => $this->medicine->countByPharmacy($userId, "in_stock = :zero", ['zero' => 0]),
            'expiredCount' => $expirySummary['expiredCount'],
            'expiringSoonCount' => $expirySummary['expiringSoonCount'],
            'expiryAlerts' => $this->medicine->getExpiryAlerts($userId),
            'categoryDistribution' => $this->medicine->getCategoryDistribution($userId),
            'lowStockItems' => $this->medicine->getLowStock($userId),
            'recentActivities' => $this->medicine->getRecentActivities($userId),
            'currentPage' => 'dashboard',
        ];

        $this->view('pharmacy/dashboard', $data, 'pharmacy');
    }
}
