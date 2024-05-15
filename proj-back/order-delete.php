<?php
    require('../config/function.php');

    $paraResult = checkParamId('order_id');
    if(is_numeric($paraResult)){

        $orderid = validate($paraResult);

        $order = getById('user_orders','order_id', $orderid);
        if($order['status'] == 200){
            $orderdelete = deleteQuery('user_orders','order_id', $orderid);
            if($orderdelete){
                redirect('order-display.php','Order Declined Successfully');
            }else{
                redirect('order-display.php','Something Went Wrong!');
            }
        }else{
            redirect('order-display.php','Order Not Found');
        }

    }else{
        redirect('order-display.php', $paraResult);
    }

?>