// File has no purpose - E-commerce functionality has been removed from the project
<?php
include '../../../config/function.php';

$order_id = isset($_GET['transaction_uuid']) ? $_GET['transaction_uuid'] : '';

if (empty($order_id)) {
    redirect('../../medicine.php', 'Invalid payment response received');
    exit();
}

// Update order status to failed using prepared statement
$updateQuery = "UPDATE user_orders SET payment_status = 'FAILED' WHERE order_id = ?";
$stmt = mysqli_prepare($conn, $updateQuery);
mysqli_stmt_bind_param($stmt, "s", $order_id);

if(mysqli_stmt_execute($stmt)) {
    // Log failed payment attempt for monitoring
    error_log("Payment failed for order ID: " . $order_id);
    redirect('../../medicine.php', 'Your payment was not successful. Please try again or contact support if you need assistance.');
} else {
    error_log("Failed to update payment status for failed payment. Order ID: " . $order_id);
    redirect('../../medicine.php', 'Payment processing error occurred. Please contact support if you need assistance.');
}
?>