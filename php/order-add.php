<?php
    include '../../config/function.php';

    $user_email = $_SESSION['loggedInUser']['email'];
    $user_id = $_SESSION['loggedInUser']['user_id'];
    $user = getById('tbl_pharmacy','email',$user_email);
    echo $user['status'];
    // echo $user['data']['pharmacy_id'];

    if(isset($_POST["add-order"])){
        $medicine_id = $_POST["m_id"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $total = $_POST["total"];
        $date = $_POST["order_date"];
        $status = "pending";
        
        $query = "INSERT INTO user_order_tbl (o_id, m_id,pharmacy_id, price, quantity, total_amount, status, order_date) VALUES ('','$medicine_id','$user_id','$price','$quantity','$total','$status','$date')";
        // $data = mysqli_query($conn,$query);

        if ($conn->query($query) === TRUE){
            redirect('../order-display.php','Your Order has been submitted.');
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