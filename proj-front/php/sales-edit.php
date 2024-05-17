<?php
    include_once('../../config/function.php');

    if(isset($_POST['update-sales'])){
        $sales_id = $_POST['update_id'];
        $medicine_id = $_POST['m_id'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $total = $_POST['total'];
        $status = $_POST['status'];
        $date = $_POST['sales_date'];

        $query = "UPDATE user_sales_tbl SET 
                    m_id = '$medicine_id',
                    price = '$price',
                    quantity = '$quantity',
                    total_amount = '$total',
                    status = '$status',
                    sales_date = '$date'
                    WHERE s_id='$sales_id'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../sales-display.php','Sales Added Successfully');
        }
        else{
            redirect('../sales-display.php','Could Not Update Sales');
        }
    }
?>