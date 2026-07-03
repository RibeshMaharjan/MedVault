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
        $term = $_POST['term'] ?? ($_POST['search'] ?? '');

        $medicine = new UserMedicine();
        $results = $medicine->search($userId, $term, 8);

        $options = array_map(function ($row) {
            return [
                'value' => (string) $row['m_id'],
                'label' => $row['medicine_name'],
                'description' => 'Rs.' . $row['sell_price'] . ' · ' . $row['in_stock'] . ' in stock',
                'm_id' => (int) $row['m_id'],
                'sell_price' => (float) $row['sell_price'],
                'in_stock' => (int) $row['in_stock'],
            ];
        }, $results);

        $this->json($options);
    }

    public function getMedicineRow(): void
    {
        $userId = $this->session->pharmacyId();
        $name = $_POST['m_name'] ?? '';

        $medicine = new UserMedicine();
        $result = $medicine->findByNameAndPharmacy($name, $userId);

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

    public function getInventoryLevels(): void
    {
        $userId = $this->session->pharmacyId();
        $medicine = new UserMedicine();

        $this->json($medicine->getInventoryLevels($userId));
    }

    public function getStockLevels(): void
    {
        $userId = $this->session->pharmacyId();
        $medicine = new UserMedicine();

        $this->json($medicine->getStockLevels($userId));
    }

    public function getTopSelling(): void
    {
        $userId = $this->session->pharmacyId();
        $sale = new Sale();

        $this->json($sale->getTopSelling($userId));
    }

    public function getRevenueTrend(): void
    {
        $userId = $this->session->pharmacyId();
        $days = max(1, (int) ($_GET['days'] ?? 14));

        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-' . ($days - 1) . ' days'));

        $sale = new Sale();
        $data = $sale->getSalesData($userId, $startDate, $endDate);

        $labels = [];
        $amounts = [];
        foreach ($data as $row) {
            $labels[] = date('M d', strtotime($row['sale_date']));
            $amounts[] = round((float) $row['daily_total'], 2);
        }

        $this->json(['labels' => $labels, 'amounts' => $amounts]);
    }
}
