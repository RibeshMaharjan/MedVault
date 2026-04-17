<?php

namespace App\Controllers\Pharmacy;

use App\Core\Controller;
use App\Models\UserMedicine;
use App\Models\Sale;
use App\Models\Order;

class AjaxController extends Controller
{
    public function searchMedicine(): void
    {
        $userId = $this->session->pharmacyId();
        $term = $_POST['search'] ?? '';

        $medicine = new UserMedicine();
        $results = $medicine->search($userId, $term, 5);

        if (!empty($results)) {
            echo '<ul class="list-group shadow-sm">';
            foreach ($results as $row) {
                $stockClass = ($row['in_stock'] > 0) ? 'bg-success' : 'bg-danger';
                echo "<li class=\"list-group-item list-group-item-action d-flex justify-content-between align-items-center\"
                          onclick=\"fill('{$row['medicine_name']}')\">
                        <div>
                            <strong>" . htmlspecialchars($row['medicine_name']) . "</strong>
                            <small class=\"d-block text-muted\">Price: Rs.{$row['sell_price']}</small>
                        </div>
                        <span class=\"badge {$stockClass} rounded-pill\">Stock: {$row['in_stock']}</span>
                      </li>";
            }
            echo '</ul>';
        } else {
            echo '<div class="list-group-item text-center text-muted">No medicines found</div>';
        }
    }

    public function getMedicineRow(): void
    {
        $userId = $this->session->pharmacyId();
        $name = $_POST['m_name'] ?? '';

        $medicine = new UserMedicine();
        $result = $medicine->findOneBy('medicine_name', $name);

        if ($result) {
            $this->json($result);
        } else {
            $this->json(['error' => 'Medicine not found'], 404);
        }
    }

    public function getSalesData(): void
    {
        $userId = $this->session->pharmacyId();
        $period = $_GET['period'] ?? 'week';

        $endDate = date('Y-m-d');
        $startDate = match ($period) {
            'month' => date('Y-m-d', strtotime('-30 days')),
            '3months' => date('Y-m-d', strtotime('-90 days')),
            default => date('Y-m-d', strtotime('-7 days')),
        };

        $sale = new Sale();
        $data = $sale->getSalesData($userId, $startDate, $endDate);

        $dates = [];
        $amounts = [];
        $totalAmount = 0;
        $count = 0;

        foreach ($data as $row) {
            $dates[] = date('M d', strtotime($row['sale_date']));
            $amount = (float) $row['daily_total'];
            $amounts[] = $amount;
            $totalAmount += $amount;
            if ($amount > 0) $count++;
        }

        $averageSale = $count > 0 ? $totalAmount / $count : 0;

        // Simple prediction
        $predictedDates = [];
        $predictedAmounts = [];
        if (!empty($amounts)) {
            $nonZero = array_filter($amounts, fn($v) => $v > 0);
            $baseLevel = !empty($nonZero) ? array_sum($nonZero) / count($nonZero) : 0;
            $lastDate = end($data)['sale_date'];
            $daysToPredict = match ($period) { '3months' => 90, 'month' => 30, default => 7 };
            for ($i = 1; $i <= $daysToPredict; $i++) {
                $nextDate = date('Y-m-d', strtotime($lastDate . " +{$i} days"));
                $prediction = $baseLevel * (1 + (mt_rand(-5, 5) / 100));
                $predictedDates[] = date('M d', strtotime($nextDate));
                $predictedAmounts[] = round($prediction, 2);
            }
        }

        $this->json([
            'dates' => $dates,
            'amounts' => $amounts,
            'averageSale' => $averageSale,
            'predictedDates' => $predictedDates,
            'predictedAmounts' => $predictedAmounts,
        ]);
    }

    public function getOrderData(): void
    {
        $userId = $this->session->pharmacyId();
        $period = $_GET['period'] ?? 'week';

        $endDate = date('Y-m-d');
        $startDate = match ($period) {
            'month' => date('Y-m-d', strtotime('-1 month')),
            '6months' => date('Y-m-d', strtotime('-6 months')),
            default => date('Y-m-d', strtotime('-1 week')),
        };

        $order = new Order();
        $dailyOrders = $order->getDailyOrders($userId, $startDate, $endDate);
        $statusDist = $order->getStatusDistribution($userId, $startDate, $endDate);
        $stats = $order->getStats($userId, $startDate, $endDate);
        $topOrders = $order->getTopOrdered($userId, $startDate, $endDate);
        $recentOrders = $order->getRecentOrders($userId);

        $dates = [];
        $orders = [];
        foreach ($dailyOrders as $row) {
            $dates[] = date('M d', strtotime($row['date']));
            $orders[] = (int) $row['count'];
        }

        foreach ($recentOrders as &$r) {
            $r['date'] = date('M d, Y', strtotime($r['order_date']));
        }

        $dayCount = max(count($dates), 1);
        $this->json([
            'dates' => $dates,
            'orders' => $orders,
            'statusDistribution' => $statusDist,
            'stats' => [
                'total' => $stats['total'],
                'average' => round($stats['total'] / $dayCount, 1),
                'completionRate' => round($stats['completion_rate'] ?? 0, 1),
                'avgOrderValue' => round($stats['avg_order_value'] ?? 0),
                'todayOrders' => $stats['today_orders'],
                'pendingOrders' => $stats['pending_orders'],
            ],
            'topOrders' => $topOrders,
            'recentOrders' => $recentOrders,
        ]);
    }
}
