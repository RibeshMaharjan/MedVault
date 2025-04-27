<?php
// Connect to database
include_once('../../config/function.php');

// Check if user is logged in
if (!isset($_SESSION['loggedInUser'])) {
    die("User not logged in");
}

// Get the user ID of the logged-in pharmacy
$user_id = $_SESSION['loggedInUser']['user_id'];
echo "Adding sample sales data for user ID: $user_id<br>";

// Function to insert a sale record
function insertSale($conn, $pharmacy_id, $date, $m_id, $quantity, $total_amount) {
    $query = "INSERT INTO user_sales_tbl (pharmacy_id, m_id, sales_date, quantity, total_amount) 
              VALUES ('$pharmacy_id', '$m_id', '$date', '$quantity', '$total_amount')";
    
    if (mysqli_query($conn, $query)) {
        echo "Added sale: Date = $date, Amount = $total_amount<br>";
        return true;
    } else {
        echo "Error inserting sale: " . mysqli_error($conn) . "<br>";
        return false;
    }
}

// First check if we have any medicines in the inventory
$result = mysqli_query($conn, "SELECT m_id FROM user_medicine_tbl WHERE pharmacy_id = '$user_id' LIMIT 5");

if (!$result || mysqli_num_rows($result) == 0) {
    echo "No medicines found in inventory. Adding a sample medicine first.<br>";
    
    // Insert a sample medicine first
    $query = "INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name, medicine_desc, in_stock, c_id, buy_price)
              VALUES ('$user_id', 'Sample Medicine', 'For testing', 100, 1, 50)";
    
    if (!mysqli_query($conn, $query)) {
        die("Failed to add sample medicine: " . mysqli_error($conn));
    }
    
    $m_id = mysqli_insert_id($conn);
    echo "Added sample medicine with ID: $m_id<br>";
} else {
    // Get the first medicine ID from inventory
    $medicines = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $medicines[] = $row['m_id'];
    }
}

// Use the first medicine or the one we just created
$medicine_ids = isset($m_id) ? [$m_id] : $medicines;

// Generate sales data for the past 60 days (covers week, month, and 3 months views)
$days = 60;
$sales_added = 0;

for ($i = $days; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    
    // Skip some days to simulate days with no sales (about 30% of days)
    if (mt_rand(1, 10) <= 3 && $i > 0) { // Skip some days but ensure today has data
        continue;
    }
    
    // Generate 1-3 sales for this day
    $num_sales = mt_rand(1, 3);
    
    for ($j = 0; $j < $num_sales; $j++) {
        // Randomly select a medicine from the available ones
        $m_id = $medicine_ids[array_rand($medicine_ids)];
        
        // Generate random quantity (1-20) and amount (50-2000)
        $quantity = mt_rand(1, 20);
        $amount = round($quantity * (mt_rand(50, 100) + mt_rand(0, 100) / 100), 2);
        
        // Insert the sale
        if (insertSale($conn, $user_id, $date, $m_id, $quantity, $amount)) {
            $sales_added++;
        }
    }
}

echo "<br>Sample data generation complete. Added $sales_added sales records.";
echo "<br><a href='../analysis-sales.php'>Go to Sales Analysis</a>";
?> 