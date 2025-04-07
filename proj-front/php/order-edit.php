<?php
    include_once('../../config/function.php');

    if(isset($_POST['update-order'])){
        $order_id = $_POST['update_id'];
        $medicine_id = $_POST['m_id'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $total = $_POST['total'];
        $status = $_POST['status'];
        $date = $_POST['order_date'];

        // Get current status before update
        $currentStatusQuery = "SELECT status FROM user_order_tbl WHERE o_id='$order_id'";
        $currentStatusResult = mysqli_query($conn, $currentStatusQuery);
        $currentStatus = mysqli_fetch_assoc($currentStatusResult)['status'];

        // Check stock if changing to completed
        if($currentStatus != 'completed' && $status == 'completed') {
            $stockQuery = "SELECT in_stock FROM user_medicine_tbl WHERE m_id = '$medicine_id'";
            $stockResult = mysqli_query($conn, $stockQuery);
            $currentStock = mysqli_fetch_assoc($stockResult)['in_stock'];

            if($currentStock < $quantity) {
                redirect('../order-display.php', 'Not enough stock to complete this order');
                exit();
            }
        }

        $query = "UPDATE user_order_tbl SET 
                    m_id = '$medicine_id',
                    price = '$price',
                    quantity = '$quantity',
                    total_amount = '$total',
                    status = '$status',
                    order_date = '$date'
                    WHERE o_id='$order_id'";
        $data = mysqli_query($conn,$query);

        // Update inventory when changing status
        if($currentStatus != 'completed' && $status == 'completed') {
            // Decrease stock when marking as completed
            $updateStock = "UPDATE user_medicine_tbl 
                          SET in_stock = in_stock + $quantity 
                          WHERE m_id = '$medicine_id'";
            mysqli_query($conn, $updateStock);
        }
        else if($currentStatus == 'completed' && $status != 'completed') {
            // Restore stock when unmarking as completed
            $updateStock = "UPDATE user_medicine_tbl 
                          SET in_stock = in_stock - $quantity 
                          WHERE m_id = '$medicine_id'";
            mysqli_query($conn, $updateStock);
        }

        if($data){
            redirect('../order-display.php','Order updated successfully');
        }
        else{
            redirect('../order-display.php','Could not update order');
        }
    }
?>