<?php
    require('../../config/function.php');

    // Check if request is coming from modal form
    if(isset($_POST['delete-medicine']) && isset($_POST['delete_medicine_id'])) {
        $medicine_id = validate($_POST['delete_medicine_id']);
        
        // Process deletion
        processMedicineDeletion($medicine_id);
    }
    // Check if request is coming from direct link (backwards compatibility)
    else if(isset($_GET['m_id'])) {
        $paraResult = checkParamId('m_id');
        if(is_numeric($paraResult)){
            $medicine_id = validate($paraResult);
            
            // Process deletion
            processMedicineDeletion($medicine_id);
        }else{
            redirect('../medicine-display.php', $paraResult);
        }
    }
    else {
        redirect('../medicine-display.php', 'Invalid request');
    }
    
    // Function to handle medicine deletion process
    function processMedicineDeletion($medicine_id) {
        global $conn;
        
        // Check if medicine is referenced in other tables before deletion
        $sales_check = mysqli_query($conn, "SELECT COUNT(*) as count FROM user_sales_tbl WHERE m_id = '$medicine_id'");
        $order_check = mysqli_query($conn, "SELECT COUNT(*) as count FROM user_order_tbl WHERE m_id = '$medicine_id'");
        
        $sales_count = mysqli_fetch_assoc($sales_check)['count'];
        $order_count = mysqli_fetch_assoc($order_check)['count'];
        
        if($sales_count > 0 || $order_count > 0) {
            // Medicine has related records - show warning
            redirect('../medicine-display.php', 'Cannot delete: This medicine has related sales or order records');
            return;
        }
        
        // Get medicine info before deletion
        $medicine = getById('user_medicine_tbl', 'm_id', $medicine_id);
        if($medicine['status'] == 200){
            $medicinedelete = deleteQuery('user_medicine_tbl', 'm_id', $medicine_id);
            if($medicinedelete){
                redirect('../medicine-display.php','Medicine deleted successfully');
            }else{
                redirect('../medicine-display.php','Something went wrong!');
            }
        }else{
            redirect('../medicine-display.php','Medicine not found');
        }
    }
?>