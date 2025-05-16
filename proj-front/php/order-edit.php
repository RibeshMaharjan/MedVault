<?php
    session_start();
    require_once '../../config/function.php';

    if(isset($_POST['update-order'])) {
        $update_id = validate($_POST['update_id']);
        $m_id = validate($_POST['m_id']);
        $price = validate($_POST['price']);
        $quantity = validate($_POST['quantity']);
        $total_amount = validate($_POST['total']);
        $status = validate($_POST['status']);
        $order_date = validate($_POST['order_date']);
        
        // Get current user ID
        $pharmacy_id = $_SESSION['loggedInUser']['user_id'];
        
        // Check if the order exists and belongs to the current user
        $checkQuery = "SELECT * FROM user_order_tbl WHERE o_id = '$update_id' AND pharmacy_id = '$pharmacy_id'";
        $checkResult = mysqli_query($conn, $checkQuery);
        
        if(mysqli_num_rows($checkResult) > 0) {
            $orderData = mysqli_fetch_assoc($checkResult);
            $oldStatus = $orderData['status'];
            
            // If changing from pending to completed, check medicine stock
            if($oldStatus != 'completed' && $status == 'completed') {
                // Get current stock of the medicine
                $stockQuery = "SELECT in_stock FROM user_medicine_tbl WHERE m_id = '$m_id' AND pharmacy_id = '$pharmacy_id'";
                $stockResult = mysqli_query($conn, $stockQuery);
                
                if(mysqli_num_rows($stockResult) > 0) {
                    $stockData = mysqli_fetch_assoc($stockResult);
                    $currentStock = $stockData['in_stock'];
                    
//                    // Check if we have enough stock
//                    if($currentStock < $quantity) {
//                        redirect('../order-display.php', 'Not enough stock to complete this order.');
//                        exit();
//                    }
                    
                    // Update stock (increase by order quantity)
                    $updateStockQuery = "UPDATE user_medicine_tbl SET in_stock = in_stock + $quantity WHERE m_id = '$m_id' AND pharmacy_id = '$pharmacy_id'";
                    mysqli_query($conn, $updateStockQuery);
                }
            }
            // If changing from completed to pending, restore stock
            else if($oldStatus == 'completed' && $status != 'completed') {
                // Restore stock (decrease by order quantity)
                $restoreStockQuery = "UPDATE user_medicine_tbl SET in_stock = in_stock - {$orderData['quantity']} WHERE m_id = '$m_id' AND pharmacy_id = '$pharmacy_id'";
                mysqli_query($conn, $restoreStockQuery);
            }
            
            // Update order
            $query = "UPDATE user_order_tbl SET 
                price = '$price',
                quantity = '$quantity',
                total_amount = '$total_amount',
                status = '$status',
                order_date = '$order_date'
                WHERE o_id = '$update_id' AND pharmacy_id = '$pharmacy_id'";
                
            $result = mysqli_query($conn, $query);
            
            if($result) {
                redirect('../order-display.php', 'Order updated successfully.');
            } else {
                redirect('../order-display.php', 'Something went wrong when updating the order.');
            }
        } else {
            redirect('../order-display.php', 'Order not found or you do not have permission to edit it.');
        }
    } else {
        redirect('../order-display.php', 'Access denied.');
    }
?>