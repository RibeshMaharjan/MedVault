<?php
include_once('../../config/function.php');

// Get the logged in user's ID
$user_id = $_SESSION['loggedInUser']['user_id'];

// Get the period from query parameter
$period = $_GET['period'] ?? 'week';

// Calculate the start date based on period
$end_date = date('Y-m-d');
switch($period) {
    case 'week':
        $start_date = date('Y-m-d', strtotime('-7 days'));
        break;
    case 'month':
        $start_date = date('Y-m-d', strtotime('-30 days'));
        break;
    case '6months':
        $start_date = date('Y-m-d', strtotime('-180 days'));
        break;
    default:
        $start_date = date('Y-m-d', strtotime('-7 days'));
}

// Query to get daily sales totals
$query = "SELECT 
            DATE(sales_date) as sale_date,
            SUM(total_amount) as daily_total
          FROM user_sales_tbl 
          WHERE pharmacy_id = '$user_id'
          AND sales_date BETWEEN '$start_date' AND '$end_date'
          GROUP BY DATE(sales_date)
          ORDER BY sale_date ASC";

$result = mysqli_query($conn, $query);

$dates = [];
$amounts = [];
$total_amount = 0;
$count = 0;

while($row = mysqli_fetch_assoc($result)) {
    $dates[] = date('M d', strtotime($row['sale_date']));
    $amounts[] = (float)$row['daily_total'];
    $total_amount += (float)$row['daily_total'];
    $count++;
}

// Calculate average sale for anomaly detection
$averageSale = $count > 0 ? $total_amount / $count : 0;

// Send JSON response
header('Content-Type: application/json');
echo json_encode([
    'dates' => $dates,
    'amounts' => $amounts,
    'averageSale' => $averageSale
]);
?>