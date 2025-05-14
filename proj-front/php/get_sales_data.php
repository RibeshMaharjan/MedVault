<?php
include_once('../../config/function.php');
global $conn;

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

// Calculate future predictions using weighted moving average
function calculatePredictions($amounts, $dates, $period = 'week') {
    // If no historical data, return empty arrays
    if (empty($amounts)) {
        return [[], []];
    }

    // Step 1: Determine how many days to predict based on selected period
    switch($period) {
        case 'week':
            $days_to_predict = 7;      // Predict next 7 days for weekly view
            $prediction_interval = 1;  // Show every day
            break;
        case 'month':
            $days_to_predict = 30;     // Predict next 30 days for monthly view
            $prediction_interval = 1;  // Show every day
            break;
        case '3months':
            $days_to_predict = 90;     // Predict next 90 days for quarterly view
            $prediction_interval = 3;  // Show every 3 days to avoid overcrowding
            break;
        default:
            $days_to_predict = 7;
            $prediction_interval = 1;
    }

    // Step 2: Set up parameters for weighted moving average
    $window_size = 5;  // Window size: number of recent data points to consider (5 days in this case)

    // Weights give more importance to recent values
    // For example: 40% to most recent, 30% to second most recent, etc.
    $weights = [0.4, 0.3, 0.15, 0.1, 0.05]; 

    // Step 3: Prepare arrays for prediction results
    $predicted_dates = [];
    $predicted_amounts = [];
    $last_date = end($dates);  // Get the most recent date from historical data

    // Make a copy of historical amounts to use for predictions
    $prediction_data = $amounts;

    // Step 4: Generate predictions starting from today (i=0) and then one day at a time
    for ($i = 0; $i <= $days_to_predict; $i++) {
        // Calculate the date (for i=0, this is today's date)
        $next_date = date('Y-m-d', strtotime($last_date . " +$i days"));

        if ($i == 0) {
            // For today, use the last actual sales value
            $prediction = end($amounts);
        } else {
            // For future days, calculate prediction using weighted moving average
            $prediction = calculateWeightedMovingAverage($prediction_data, $window_size, $weights);

            // Add this prediction to our data for calculating the next day's prediction
            // This allows each prediction to influence future predictions
            $prediction_data[] = $prediction;
        }

        // Only add to results at specified intervals (to avoid overcrowding the chart)
        if ($i % $prediction_interval == 0) {
            $predicted_dates[] = date('M d', strtotime($next_date));
            $predicted_amounts[] = round($prediction, 2);
        }
    }

    // Return the predicted dates and amounts
    return [$predicted_dates, $predicted_amounts];
}

// Helper function to calculate weighted moving average
function calculateWeightedMovingAverage($data, $window_size, $weights = null) {
    // Step 1: Check if all values are zero, if so return a small default value
    // This prevents a flat zero forecast line
    $all_zeros = true;
    foreach ($data as $value) {
        if ($value > 0) {
            $all_zeros = false;
            break;
        }
    }

    if ($all_zeros) {
        return 10; // Return a small default value
    }

    // Step 2: Set up default weights if none provided
    // For example, with window_size = 3, weights might be [0.5, 0.3, 0.2]
    // This gives more importance to recent values
    if ($weights === null) {
        // Create simple decreasing weights
        $weights = [];
        for ($i = 0; $i < $window_size; $i++) {
            $weights[$i] = $window_size - $i;
        }
    }

    // Step 3: Get the most recent data points (up to window_size)
    $data_length = count($data);
    $recent_data = array_slice($data, max(0, $data_length - $window_size));
    $recent_count = count($recent_data);

    // Step 4: If we don't have enough data points, adjust the weights array
    if ($recent_count < $window_size) {
        $weights = array_slice($weights, 0, $recent_count);
    }

    // Step 5: Calculate the weighted sum and the sum of weights
    $weighted_sum = 0;
    $weight_sum = 0;

    for ($i = 0; $i < $recent_count; $i++) {
        $weighted_sum += $recent_data[$i] * $weights[$i];
        $weight_sum += $weights[$i];
    }

    // Step 6: Calculate and return the weighted average
    return $weighted_sum / $weight_sum;
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
