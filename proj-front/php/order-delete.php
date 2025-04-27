<?php
    session_start();
    require_once '../../config/function.php';

    if(isset($_POST['delete-order'])) {
        $order_id = validate($_POST['delete_order_id']);
        
        // Get current user ID
        $pharmacy_id = $_SESSION['loggedInUser']['user_id'];
        
        // Check if the order exists and belongs to the current user
        $checkQuery = "SELECT * FROM user_order_tbl WHERE o_id = '$order_id' AND pharmacy_id = '$pharmacy_id'";
        $checkResult = mysqli_query($conn, $checkQuery);
        
        if(mysqli_num_rows($checkResult) > 0) {
            $orderData = mysqli_fetch_assoc($checkResult);
            
            // If the order was completed, we need to restore the stock
            if($orderData['status'] == 'completed') {
                $m_id = $orderData['m_id'];
                $quantity = $orderData['quantity'];
                
                // Restore the stock (increase by order quantity)
                $restoreStockQuery = "UPDATE user_medicine_tbl SET in_stock = in_stock + $quantity WHERE m_id = '$m_id' AND pharmacy_id = '$pharmacy_id'";
                mysqli_query($conn, $restoreStockQuery);
            }
            
            // Delete the order
            $query = "DELETE FROM user_order_tbl WHERE o_id = '$order_id' AND pharmacy_id = '$pharmacy_id'";
            $result = mysqli_query($conn, $query);
            
            if($result) {
                redirect('../order-display.php', 'Order deleted successfully.');
            } else {
                redirect('../order-display.php', 'Something went wrong when deleting the order.');
            }
        } else {
            redirect('../order-display.php', 'Order not found or you do not have permission to delete it.');
        }
    } else {
        redirect('../order-display.php', 'Access denied.');
    }
?>