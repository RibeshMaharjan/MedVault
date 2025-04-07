<?php
include '../config/conn.php';
include '../config/function.php';

if(isset($_POST['export_orders'])) {
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="orders_export_'.date('Y-m-d').'.csv"');

    // Create output stream
    $output = fopen('php://output', 'w');

    // Add headers to CSV
    fputcsv($output, array('Order ID', 'User ID', 'Medicine ID', 'Invoice', 'Total Products', 'Total Amount', 'Status', 'Date'));

    // Get filtered data
    $query = "SELECT * FROM user_orders";
    if(isset($_POST['status_filter']) && !empty($_POST['status_filter'])) {
        $status = mysqli_real_escape_string($conn, $_POST['status_filter']);
        $query .= " WHERE status='$status'";
    }
    if(isset($_POST['date_from']) && isset($_POST['date_to'])) {
        $from = mysqli_real_escape_string($conn, $_POST['date_from']);
        $to = mysqli_real_escape_string($conn, $_POST['date_to']);
        $query .= isset($_POST['status_filter']) ? " AND" : " WHERE";
        $query .= " created_at BETWEEN '$from' AND '$to'";
    }

    $result = mysqli_query($conn, $query);

    // Output each row
    while($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}
?>