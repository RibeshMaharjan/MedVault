<?php
    require('../../config/function.php');

    // Check if request is coming from modal form
    if(isset($_POST['delete-sales']) && isset($_POST['delete_sales_id'])) {
        $sales_id = validate($_POST['delete_sales_id']);
        
        // Process deletion
        processSalesDeletion($sales_id);
    }
    // Check if request is coming from direct link (backwards compatibility)
    else if(isset($_GET['s_id'])) {
        $paraResult = checkParamId('s_id');
        if(is_numeric($paraResult)){
            $sales_id = validate($paraResult);
            
            // Process deletion
            processSalesDeletion($sales_id);
        }else{
            redirect('../sales-display.php', $paraResult);
        }
    }
    else {
        redirect('../sales-display.php', 'Invalid request');
    }
    
    // Function to handle sales deletion process
    function processSalesDeletion($sales_id) {
        global $conn;
        
        // Get sales info before deletion
        $sales = getById('user_sales_tbl', 's_id', $sales_id);
        if($sales['status'] == 200){
            // If sales was completed, adjust inventory accordingly
            if($sales['data']['status'] == 'completed') {
                $medicine_id = $sales['data']['m_id'];
                $quantity = $sales['data']['quantity'];
                
                // When a sale is deleted, return items to inventory
                $restoreQuery = "UPDATE user_medicine_tbl 
                                SET in_stock = in_stock + $quantity 
                                WHERE m_id = '$medicine_id'";
                mysqli_query($conn, $restoreQuery);
            }
            
            $salesdelete = deleteQuery('user_sales_tbl', 's_id', $sales_id);
            if($salesdelete){
                redirect('../sales-display.php','Sales record removed and inventory adjusted successfully');
            }else{
                redirect('../sales-display.php','Something went wrong!');
            }
        }else{
            redirect('../sales-display.php','Sales record not found');
        }
    }
?>