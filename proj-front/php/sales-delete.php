<?php
    require('../../config/function.php');

    $paraResult = checkParamId('s_id');
    if(is_numeric($paraResult)){

        $sales_id = validate($paraResult);

        $sales = getById('user_sales_tbl','s_id', $sales_id);
        if($sales['status'] == 200){
            $salesdelete = deleteQuery('user_sales_tbl','s_id', $sales_id);
            if($salesdelete){
                redirect('../sales-display.php','Sales Removed Successfully');
            }else{
                redirect('../sales-display.php','Something Went Wrong!');
            }
        }else{
            redirect('../sales-display.php','Sales Not Found');
        }

    }else{
        redirect('../sales-display.php', $paraResult);
    }

?>