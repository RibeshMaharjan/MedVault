<?php
    require_once('../config/function.php');

    $paraResult = checkParamId("order_id");

    if(is_numeric($paraResult)){
        $order_id = validate($paraResult);

        $orders = getById('user_orders','order_id',$order_id);
        if($orders['status'] == 200){
            $order_id = $orders['data']['order_id'];
            $user_id = $orders['data']['user_id'];
            $medicine_id = $orders['data']['medicine_id'];
            $invoice_number = $orders['data']['invoice_number'];
            $total_products = $orders['data']['total_products'];
            $total_amount = $orders['data']['amount'];
            $insertquery = "INSERT INTO order_completed VALUES ('$order_id','$user_id','$medicine_id','$invoice_number','$total_products','$total_amount','COMPLETED')";
            $data = mysqli_query($conn,$insertquery);
            if($data){
                $updateorder = "UPDATE user_orders SET order_status = 'COMPLETED' WHERE order_id='$order_id'";
                $updateorderresult =mysqli_query($conn, $updateorder);
                $deletependingorder = deleteQuery('order_pending','order_id',$order_id);
                if($updateorderresult === TRUE && $deletependingorder === TRUE){
                    redirect('order-approve.php',"Order Approved");
                }
            }
        }else{
            redirect('order-display.php','Order Approval Failed!');
        }
    }
?>