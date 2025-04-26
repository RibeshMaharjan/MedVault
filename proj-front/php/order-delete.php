<?php
    require('../../config/function.php');

    // Check if request is coming from modal form
    if(isset($_POST['delete-order']) && isset($_POST['delete_id'])) {
        $order_id = validate($_POST['delete_id']);
        
        // Process deletion
        processOrderDeletion($order_id);
    }
    // Check if request is coming from direct link (backwards compatibility)
    else if(isset($_GET['o_id'])) {
        $paraResult = checkParamId('o_id');
        if(is_numeric($paraResult)){
            $order_id = validate($paraResult);
            
            // Process deletion
            processOrderDeletion($order_id);
        }else{
            redirect('../order-display.php', $paraResult);
        }
    }
    else {
        redirect('../order-display.php', 'Invalid request');
    }
    
    // Function to handle order deletion process
    function processOrderDeletion($order_id) {
        global $conn;
        
        // Get order info before deletion
        $order = getById('user_order_tbl', 'o_id', $order_id);
        if($order['status'] == 200){
            // If order was completed, restore inventory
            if($order['data']['status'] == 'completed') {
                $medicine_id = $order['data']['m_id'];
                $quantity = $order['data']['quantity'];
                $restoreQuery = "UPDATE user_medicine_tbl 
                                SET in_stock = in_stock + $quantity 
                                WHERE m_id = '$medicine_id'";
                mysqli_query($conn, $restoreQuery);
            }
            
            $orderdelete = deleteQuery('user_order_tbl', 'o_id', $order_id);
            if($orderdelete){
                redirect('../order-display.php','Order removed and inventory restored successfully');
            }else{
                redirect('../order-display.php','Something went wrong!');
            }
        }else{
            redirect('../order-display.php','Order not found');
        }
    }
?>