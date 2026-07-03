<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Models\UserMedicine;
use App\Models\Category;
use App\Models\Order;
use App\Models\Sale;

class DashboardController extends Controller
{
    private UserMedicine $medicine;
    private Category $category;
    private Order $order;
    private Sale $sale;

    public function __construct()
    {
        parent::__construct();
        $this->medicine = new UserMedicine();
        $this->category = new Category();
        $this->order = new Order();
        $this->sale = new Sale();
    }

    public function index(): void
    {
        $userId = $this->session->pharmacyId();

        $today = date('Y-m-d');
        $last7Start = date('Y-m-d', strtotime('-6 days'));
        $last30Start = date('Y-m-d', strtotime('-29 days'));

        $revenueLast7 = $this->sale->getSalesData($userId, $last7Start, $today);
        $revenueLast30 = $this->sale->getSalesData($userId, $last30Start, $today);
        $revenue30d = array_sum(array_column($revenueLast30, 'daily_total'));

        $data = [
            'totalMedicines' => $this->medicine->countByPharmacy($userId),
            'totalCategories' => $this->category->count("pharmacy_id = :pid", ['pid' => $userId]),
            'lowStockCount' => $this->medicine->countByPharmacy($userId, "in_stock <= :threshold", ['threshold' => 10]),
            'outOfStockCount' => $this->medicine->countByPharmacy($userId, "in_stock = :zero", ['zero' => 0]),
            'pendingOrders' => $this->order->count("pharmacy_id = :pid AND status = :status", ['pid' => $userId, 'status' => 'pending']),
            'revenue30d' => $revenue30d,
            'revenueLast7' => $revenueLast7,
            'categoryDistribution' => $this->medicine->getCategoryDistribution($userId),
            'lowStockItems' => $this->medicine->getLowStock($userId),
            'recentActivities' => $this->medicine->getRecentActivities($userId),
            'currentPage' => 'dashboard',
        ];

        $this->view('pharmacy/dashboard', $data, 'app');
    }
}
