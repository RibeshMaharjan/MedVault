<?php
    require('../../config/function.php');

    $paraResult = checkParamId('o_id');
    if(is_numeric($paraResult)){

        $order_id = validate($paraResult);

        $order = getById('user_order_tbl','o_id', $order_id);
        if($order['status'] == 200){
            $orderdelete = deleteQuery('user_order_tbl','o_id', $order_id);
            if($orderdelete){
                redirect('../order-display.php','Order Removed Successfully');
            }else{
                redirect('../order-display.php','Something Went Wrong!');
            }
        }else{
            redirect('../order-display.php','Order Not Found');
        }

    }else{
        redirect('../order-display.php', $paraResult);
    }

?>