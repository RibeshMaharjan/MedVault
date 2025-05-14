<?php
include '../../config/function.php';

$period = $_GET['period'] ?? 'week';
$user_id = $_SESSION['loggedInUser']['user_id'];

// Calculate date range based on period
$end_date = date('Y-m-d');
switch ($period) {
    case 'week':
        $start_date = date('Y-m-d', strtotime('-1 week'));
        break;
    case 'month':
        $start_date = date('Y-m-d', strtotime('-1 month'));
        break;
    case '6months':
        $start_date = date('Y-m-d', strtotime('-6 months'));
        break;
    default:
        $start_date = date('Y-m-d', strtotime('-1 week'));
}

// Get daily orders count
$daily_orders_query = "SELECT DATE(order_date) as date, COUNT(*) as count 
                      FROM user_order_tbl 
                      WHERE pharmacy_id = '$user_id' 
                      AND order_date BETWEEN '$start_date' AND '$end_date' 
                      GROUP BY DATE(order_date)
                      ORDER BY date";
$daily_result = mysqli_query($conn, $daily_orders_query);

$dates = [];
$orders = [];
while ($row = mysqli_fetch_assoc($daily_result)) {
    $dates[] = date('M d', strtotime($row['date']));
    $orders[] = (int)$row['count'];
}

// Get status distribution
$status_query = "SELECT status, COUNT(*) as count 
                FROM user_order_tbl 
                WHERE pharmacy_id = '$user_id' 
                AND order_date BETWEEN '$start_date' AND '$end_date'
                GROUP BY status";
$status_result = mysqli_query($conn, $status_query);

$status_distribution = [
    'completed' => 0,
    'pending' => 0,
    'cancelled' => 0
];

while ($row = mysqli_fetch_assoc($status_result)) {
    $status_distribution[strtolower($row['status'])] = (int)$row['count'];
}

// Get statistics
$stats_query = "SELECT 
                COUNT(*) as total,
                ROUND(AVG(total_amount)) as avg_order_value,
                COUNT(CASE WHEN status = 'completed' THEN 1 END) * 100.0 / COUNT(*) as completion_rate,
                COUNT(CASE WHEN DATE(order_date) = CURDATE() THEN 1 END) as today_orders,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_orders
                FROM user_order_tbl 
                WHERE pharmacy_id = '$user_id' 
                AND order_date BETWEEN '$start_date' AND '$end_date'";
$stats_result = mysqli_fetch_assoc(mysqli_query($conn, $stats_query));

// Get top ordered medicines
$top_orders_query = "SELECT m.medicine_name, 
                    COUNT(o.o_id) as order_count,
                    SUM(o.quantity) as total_quantity
                    FROM user_order_tbl o
                    JOIN user_medicine_tbl m ON o.m_id = m.m_id
                    WHERE o.pharmacy_id = '$user_id' 
                    AND o.order_date BETWEEN '$start_date' AND '$end_date'
                    GROUP BY m.m_id, m.medicine_name
                    ORDER BY order_count DESC
                    LIMIT 5";
$top_orders_result = mysqli_query($conn, $top_orders_query);

$top_orders = [];
while ($row = mysqli_fetch_assoc($top_orders_result)) {
    $top_orders[] = $row;
}

// Prepare response
$response = [
    'dates' => $dates,
    'orders' => $orders,
    'statusDistribution' => $status_distribution,
    'stats' => [
        'total' => $stats_result['total'],
        'average' => round($stats_result['total'] / count($dates), 1),
        'completionRate' => round($stats_result['completion_rate'], 1),
        'avgOrderValue' => round($stats_result['avg_order_value']),
        'todayOrders' => $stats_result['today_orders'],
        'pendingOrders' => $stats_result['pending_orders']
    ],
    'topOrders' => $top_orders
];

header('Content-Type: application/json');
echo json_encode($response);
?>