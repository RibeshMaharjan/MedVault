<?php
include_once('../../config/function.php');

// Get the logged in user's ID
$user_id = $_SESSION['loggedInUser']['user_id'];

// Get total stock
$totalStockQuery = "SELECT SUM(in_stock) as total FROM user_medicine_tbl WHERE pharmacy_id = '$user_id'";
$totalStockResult = mysqli_query($conn, $totalStockQuery);
$totalStock = mysqli_fetch_assoc($totalStockResult)['total'] ?? 0;

// Get low stock count (items with stock <= 10)
$lowStockQuery = "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE pharmacy_id = '$user_id' AND in_stock <= 10 AND in_stock > 0";
$lowStockResult = mysqli_query($conn, $lowStockQuery);
$lowStockCount = mysqli_fetch_assoc($lowStockResult)['count'] ?? 0;

// Get out of stock count
$outOfStockQuery = "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE pharmacy_id = '$user_id' AND in_stock = 0";
$outOfStockResult = mysqli_query($conn, $outOfStockQuery);
$outOfStockCount = mysqli_fetch_assoc($outOfStockResult)['count'] ?? 0;

// Get low stock items details
$lowStockItemsQuery = "SELECT medicine_name, in_stock, buy_price, sell_price 
                       FROM user_medicine_tbl 
                       WHERE pharmacy_id = '$user_id' AND in_stock <= 10
                       ORDER BY in_stock ASC";
$lowStockItemsResult = mysqli_query($conn, $lowStockItemsQuery);

$lowStockItems = [];
while ($row = mysqli_fetch_assoc($lowStockItemsResult)) {
    $lowStockItems[] = $row;
}

// Prepare and send response
$response = [
    'totalStock' => (int)$totalStock,
    'lowStockCount' => (int)$lowStockCount,
    'outOfStockCount' => (int)$outOfStockCount,
    'lowStockItems' => $lowStockItems
];

header('Content-Type: application/json');
echo json_encode($response);
?>