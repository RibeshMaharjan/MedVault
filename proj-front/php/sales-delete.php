<?php
    require('../../config/function.php');

    $paraResult = checkParamId('s_id');
    if(is_numeric($paraResult)){
        $sales_id = validate($paraResult);

        // Get sale info before deletion
        $sales = getById('user_sales_tbl', 's_id', $sales_id);
        if($sales['status'] == 200){
            // If sale was completed, restore inventory
            if($sales['data']['status'] == 'completed') {
                $medicine_id = $sales['data']['m_id'];
                $quantity = $sales['data']['quantity'];
                $restoreQuery = "UPDATE user_medicine_tbl 
                                SET in_stock = in_stock + $quantity 
                                WHERE m_id = '$medicine_id'";
                mysqli_query($conn, $restoreQuery);
            }
            
            $salesdelete = deleteQuery('user_sales_tbl','s_id', $sales_id);
            if($salesdelete){
                redirect('../sales-display.php','Sales removed and inventory restored successfully');
            }else{
                redirect('../sales-display.php','Something went wrong!');
            }
        }else{
            redirect('../sales-display.php','Sales not found');
        }
    }else{
        redirect('../sales-display.php', $paraResult);
    }
?>