<?php
    include '../../config/function.php';

    $user_email = $_SESSION['loggedInUser']['email'];
    $user_id = $_SESSION['loggedInUser']['user_id'];
    $user = getById('tbl_pharmacy','email',$user_email);
    echo $user['status'];

    if(isset($_POST["add-order"])){
        $medicine_id = $_POST["m_id"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $total = $_POST["total"];
        $date = $_POST["order_date"];
        $status = "pending";  // Default to pending
        
        // Only validate stock availability
        $stockQuery = "SELECT in_stock FROM user_medicine_tbl WHERE m_id = '$medicine_id'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $currentStock = mysqli_fetch_assoc($stockResult)['in_stock'];

        if($currentStock < $quantity) {
            redirect('../order-create.php', 'Not enough stock available');
            exit();
        }

        $query = "INSERT INTO user_order_tbl (o_id, m_id, pharmacy_id, price, quantity, total_amount, status, order_date) 
                 VALUES ('','$medicine_id','$user_id','$price','$quantity','$total','$status','$date')";

        if ($conn->query($query) === TRUE){
            redirect('../order-display.php','Order has been submitted.');
        } else {
            redirect('../order-display.php','Could not add order');
        }
    }
?>