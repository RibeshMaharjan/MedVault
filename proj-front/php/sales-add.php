<?php
    include '../../config/function.php';

    $user_email = $_SESSION['loggedInUser']['email'];
    $user_id = $_SESSION['loggedInUser']['user_id'];
    $user = getById('tbl_pharmacy','email',$user_email);
    echo $user['status'];

    if(isset($_POST["add-sales"])){
        $medicine_id = $_POST["m_id"];
        $sell_price = $_POST["sellprice"];
        $quantity = $_POST["quantity"];
        $total = $_POST["total"];
        $date = $_POST["sales_date"];
        $status = "pending";  // Changed to pending by default
        
        // Check if there's enough stock
        $stockQuery = "SELECT in_stock FROM user_medicine_tbl WHERE m_id = '$medicine_id'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $currentStock = mysqli_fetch_assoc($stockResult)['in_stock'];

        if($currentStock < $quantity) {
            redirect('../sales-create.php', 'Not enough stock available');
            exit();
        }

        // Insert the sale
        $query = "INSERT INTO user_sales_tbl (m_id, pharmacy_id, price, quantity, total_amount, status, sales_date) 
                 VALUES ('$medicine_id','$user_id','$sell_price','$quantity','$total','$status','$date')";

        if ($conn->query($query) === TRUE) {
            redirect('../sales-display.php','Sale added successfully');
        } else {
            redirect('../sales-display.php','Could not add sale');
        }
    }
?>