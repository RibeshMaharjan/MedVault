<?php
    include '../../config/function.php';

    $user_email = $_SESSION['loggedInUser']['email'];
    $user_id = $_SESSION['loggedInUser']['user_id'];
    $user = getById('tbl_pharmacy','email',$user_email);
    echo $user['status'];
    // echo $user['data']['pharmacy_id'];

    if(isset($_POST["add-sales"])){
        $medicine_id = $_POST["m_id"];
        $sell_price = $_POST["sellprice"];
        $quantity = $_POST["quantity"];
        $total = $_POST["total"];
        $date = $_POST["sales_date"];
        $status = "pending";
        
        $query = "INSERT INTO user_sales_tbl (s_id, m_id,pharmacy_id, price, quantity, total_amount, status, sales_date) VALUES ('','$medicine_id','$user_id','$sell_price','$quantity','$total','$status','$date')";
        // $data = mysqli_query($conn,$query);

        if ($conn->query($query) === TRUE){
            redirect('../sales-display.php','Your Order has been submitted.');
        } else {
            echo "Error inserting data into user_orders table: " . $conn->error;
        }

        // if($data){
        //     echo "<br>stored";
        //     // redirect('admin.php','data inserted');
        // }   
        // else{
        //     echo "failed";
        // }
    }
?>