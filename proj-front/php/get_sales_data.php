<?php
include_once('../../config/function.php');

// Get the logged in user's ID
$user_id = $_SESSION['loggedInUser']['user_id'];

// Get the period from query parameter
$period = $_GET['period'] ?? 'week';

// Calculate the start date and end date based on period
$end_date = date('Y-m-d');
$start_date = '';

switch($period) {
    case 'week':
        $start_date = date('Y-m-d', strtotime('-7 days'));
        break;
    case 'month':
        $start_date = date('Y-m-d', strtotime('-30 days'));
        break;
    case '3months':
        $start_date = date('Y-m-d', strtotime('-90 days'));
        break;
    default:
        $start_date = date('Y-m-d', strtotime('-7 days'));
}

// Query to get daily sales totals with date filling
$query = "WITH RECURSIVE date_range AS (
    SELECT '$start_date' as date
    UNION ALL
    SELECT DATE_ADD(date, INTERVAL 1 DAY)
    FROM date_range
    WHERE DATE_ADD(date, INTERVAL 1 DAY) <= '$end_date'
),
daily_sales AS (
    SELECT 
        DATE(sales_date) as sale_date,
        SUM(total_amount) as daily_total
    FROM user_sales_tbl 
    WHERE pharmacy_id = '$user_id'
    AND sales_date BETWEEN '$start_date' AND '$end_date'
    GROUP BY DATE(sales_date)
)
SELECT 
    date_range.date as sale_date,
    COALESCE(daily_sales.daily_total, 0) as daily_total
FROM date_range
LEFT JOIN daily_sales ON date_range.date = daily_sales.sale_date
ORDER BY date_range.date ASC";

$result = mysqli_query($conn, $query);

if (!$result) {
    // Log error for debugging
    error_log("MySQL Error: " . mysqli_error($conn));
    die(json_encode(['error' => 'Database query failed']));
}

$dates = [];
$amounts = [];
$total_amount = 0;
$count = 0;
$all_data = [];

// First, collect all data
while($row = mysqli_fetch_assoc($result)) {
    $all_data[] = [
        'date' => $row['sale_date'],
        'amount' => (float)$row['daily_total']
    ];
    $total_amount += (float)$row['daily_total'];
    if ($row['daily_total'] > 0) {
        $count++;
    }
}

// Determine interval based on period
$interval = 1;
switch($period) {
    case '3months':
        $interval = 3;
        break;
    case 'month':
        $interval = 1; // Changed from 2 to 1 to show more frequent data points
        break;
    default:
        $interval = 1;
}

// Process data according to interval
for($i = 0; $i < count($all_data); $i += $interval) {
    $dates[] = date('M d', strtotime($all_data[$i]['date']));
    
    // For intervals > 1, average the values in between
    $avg_amount = 0;
    $points_counted = 0;
    for($j = 0; $j < $interval && ($i + $j) < count($all_data); $j++) {
        $avg_amount += $all_data[$i + $j]['amount'];
        $points_counted++;
    }
    $amounts[] = $points_counted > 0 ? $avg_amount / $points_counted : 0;
}

// Calculate average sale for anomaly detection
$averageSale = $count > 0 ? $total_amount / $count : 0;

// Calculate future predictions
function calculatePredictions($amounts, $dates, $period = 'week') {
    if (empty($amounts)) {
        return [[], []];
    }

    // Set parameters based on period
    switch($period) {
        case 'week':
            $window_size = 7;
            $days_to_predict = 7;
            $prediction_interval = 1;
            break;
        case 'month':
            $window_size = 7;
            $days_to_predict = 30;
            $prediction_interval = 1; // Changed to 1 for smoother predictions
            break;
        case '3months':
            $window_size = 30;
            $days_to_predict = 90;
            $prediction_interval = 3;
            break;
        default:
            $window_size = 7;
            $days_to_predict = 7;
            $prediction_interval = 1;
    }

    // Calculate base level from last 7 non-zero values
    $non_zero_values = array_filter($amounts, function($value) { return $value > 0; });
    $recent_values = array_slice($non_zero_values, -7);
    $base_level = !empty($recent_values) ? array_sum($recent_values) / count($recent_values) : 0;

    // Calculate trend from non-zero values
    $trend = 0;
    if (count($non_zero_values) > 1) {
        $values_array = array_values($non_zero_values);
        $trend = ($values_array[count($values_array)-1] - $values_array[0]) / count($values_array);
    }

    // Calculate weekly pattern
    $day_totals = array_fill(0, 7, 0);
    $day_counts = array_fill(0, 7, 0);
    
    for ($i = 0; $i < count($amounts); $i++) {
        if ($amounts[$i] > 0) {  // Only consider non-zero values
            $day_of_week = date('w', strtotime($dates[$i]));
            $day_totals[$day_of_week] += $amounts[$i];
            $day_counts[$day_of_week]++;
        }
    }

    // Calculate average for each day of week
    $day_averages = array_fill(0, 7, $base_level);  // Default to base_level
    for ($i = 0; $i < 7; $i++) {
        if ($day_counts[$i] > 0) {
            $day_averages[$i] = $day_totals[$i] / $day_counts[$i];
        }
    }

    // Generate predictions
    $predicted_dates = [];
    $predicted_amounts = [];
    $last_date = end($dates);

    for ($i = 1; $i <= $days_to_predict; $i++) {
        $next_date = date('Y-m-d', strtotime($last_date . " +$i days"));
        $day_of_week = date('w', strtotime($next_date));
        
        // Use day of week average as base prediction
        $prediction = $day_averages[$day_of_week];
        
        // Apply trend with dampening
        $dampening = 1 / (1 + ($i / 30));  // Gradual dampening over time
        $prediction += $trend * $i * $dampening;
        
        // Add small random variation (±5%)
        $variation = $prediction * (mt_rand(-5, 5) / 100);
        $prediction += $variation;
        
        // Ensure prediction stays within reasonable bounds
        $max_value = max($amounts);
        $min_value = min(array_filter($amounts, function($value) { return $value > 0; }));
        $prediction = max($min_value * 0.7, min($max_value * 1.3, $prediction));

        if ($i % $prediction_interval == 0) {
            $predicted_dates[] = date('M d', strtotime($next_date));
            $predicted_amounts[] = round($prediction, 2);
        }
    }

    return [$predicted_dates, $predicted_amounts];
}

// Helper function to calculate historical volatility
function calculateVolatility($data) {
    if (empty($data)) {
        return 0;
    }
    $mean = array_sum($data) / count($data);
    $variance = 0;
    foreach ($data as $value) {
        $variance += pow($value - $mean, 2);
    }
    $variance /= count($data);
    return sqrt($variance) / $mean; // Coefficient of variation
}

// Calculate predictions with period-specific settings
list($predicted_dates, $predicted_amounts) = calculatePredictions($amounts, $dates, $period);

// Send JSON response
header('Content-Type: application/json');
echo json_encode([
    'dates' => $dates,
    'amounts' => $amounts,
    'averageSale' => $averageSale,
    'predictedDates' => $predicted_dates,
    'predictedAmounts' => $predicted_amounts
]);
?>