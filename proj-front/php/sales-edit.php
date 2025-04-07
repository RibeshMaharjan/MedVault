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

        // Get current status before update
        $currentStatusQuery = "SELECT status FROM user_sales_tbl WHERE s_id='$sales_id'";
        $currentStatusResult = mysqli_query($conn, $currentStatusQuery);
        $currentStatus = mysqli_fetch_assoc($currentStatusResult)['status'];

        $query = "UPDATE user_sales_tbl SET 
                    m_id = '$medicine_id',
                    price = '$price',
                    quantity = '$quantity',
                    total_amount = '$total',
                    status = '$status',
                    sales_date = '$date'
                    WHERE s_id='$sales_id'";
        $data = mysqli_query($conn,$query);

        // Update inventory if status changes to completed
        if($currentStatus != 'completed' && $status == 'completed') {
            $query = "UPDATE user_medicine_tbl 
                     SET in_stock = in_stock - $quantity 
                     WHERE m_id = '$medicine_id'";
            mysqli_query($conn, $query);
        }
        // Restore inventory if status changes from completed
        else if($currentStatus == 'completed' && $status != 'completed') {
            $query = "UPDATE user_medicine_tbl 
                     SET in_stock = in_stock + $quantity 
                     WHERE m_id = '$medicine_id'";
            mysqli_query($conn, $query);
        }

        if($data){
            redirect('../sales-display.php','Sales Updated Successfully');
        }
        else{
            redirect('../sales-display.php','Could Not Update Sales');
        }
    }
?>