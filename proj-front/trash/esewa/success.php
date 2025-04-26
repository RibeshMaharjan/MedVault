// File has no purpose - E-commerce functionality has been removed from the project
<?php
include '../../../config/function.php';

$data = isset($_GET['data']) ? $_GET['data'] : '';
if (empty($data)) {
    redirect('../../medicine.php', 'Invalid payment response received');
    exit();
}

$decodeddata = base64_decode($data);
$json_string = substr($decodeddata, strpos($decodeddata, '{'));
$response = json_decode($json_string, true);

if (!$response || $response['status'] !== 'COMPLETE') {
    redirect('../../medicine.php', 'Transaction failed or incomplete. Please try again.');
    exit();
}

$message = $response['signed_field_names'];
$array = explode(",", $message);
$signaturemessage = "";

foreach ($array as $value) {
    if ($value == 'total_amount') {
        $amount = str_replace(',', '', $response[$value]);
        $signaturemessage = $signaturemessage.$value.'='.$amount.',';
    } else {
        $signaturemessage = $signaturemessage.$value.'='.$response[$value].',';
    }
}

$signaturemessage = rtrim($signaturemessage, ',');
$secret = "8gBm/:&EnhH.1/q";
$s = hash_hmac('sha256', "$signaturemessage", $secret, true);
$signature = base64_encode($s);

if ($signature !== $response['signature']) {
    redirect('../../medicine.php', 'Payment verification failed. Please contact support if your account was charged.');
    exit();
}

// Update order status in database
$order_id = mysqli_real_escape_string($conn, $response['transaction_uuid']);
$updateQuery = "UPDATE user_orders SET order_status = 'PAID', payment_status = 'COMPLETED' WHERE order_id = ?";
$stmt = mysqli_prepare($conn, $updateQuery);
mysqli_stmt_bind_param($stmt, "s", $order_id);

if(mysqli_stmt_execute($stmt)) {
    redirect('../../medicine.php', 'Thank you! Your payment was successful and your order has been confirmed.');
} else {
    // Log error for admin investigation
    error_log("Failed to update order status for order ID: " . $order_id);
    redirect('../../medicine.php', 'Your payment was received but order status update failed. Our team will investigate and confirm your order shortly.');
}
?>