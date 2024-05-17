<?php
    include_once('../../config/function.php');

    if(isset($_POST['update-order'])){
        $order_id = $_POST['update_id'];
        $medicine_id = $_POST['m_id'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $total = $_POST['total'];
        $status = $_POST['status'];
        $date = $_POST['order_date'];

        $query = "UPDATE user_order_tbl SET 
                    m_id = '$medicine_id',
                    price = '$price',
                    quantity = '$quantity',
                    total_amount = '$total',
                    status = '$status',
                    order_date = '$date'
                    WHERE o_id='$order_id'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../order-display.php','Order Added Successfully');
        }
        else{
            redirect('../order-display.php','Could Not Update Order');
        }
    }
?>