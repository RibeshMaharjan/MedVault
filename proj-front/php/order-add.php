<?php
    include '../../config/function.php';

    $user_email = $_SESSION['loggedInUser']['email'];
    $user_id = $_SESSION['loggedInUser']['user_id'];
    $user = getById('tbl_pharmacy','email',$user_email);

    if(isset($_POST["add-order"])) {
        $medicine_id = $_POST["m_id"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $total = $_POST["total"];
        $date = $_POST["order_date"];
        $status = "pending";
        
        // Validate inputs
        if (!is_numeric($quantity) || $quantity <= 0) {
            redirect('../order-create.php', 'Invalid quantity');
            exit();
        }

        if (!is_numeric($price) || $price <= 0) {
            redirect('../order-create.php', 'Invalid price');
            exit();
        }

        // Validate date
        $order_date = strtotime($date);
        $current_date = strtotime(date('Y-m-d'));
        if ($order_date < $current_date) {
            redirect('../order-create.php', 'Order date cannot be in the past');
            exit();
        }
        
        // Check stock availability
        $stockQuery = "SELECT in_stock FROM user_medicine_tbl WHERE m_id = '$medicine_id'";
        $stockResult = mysqli_query($conn, $stockQuery);
        $currentStock = mysqli_fetch_assoc($stockResult)['in_stock'];

        if($currentStock < $quantity) {
            redirect('../order-create.php', 'Not enough stock available. Only ' . $currentStock . ' units in stock.');
            exit();
        }

        // Validate total amount
        $calculated_total = $price * $quantity;
        if(abs($calculated_total - $total) > 0.01) { // Allow for small floating point differences
            redirect('../order-create.php', 'Total amount calculation mismatch');
            exit();
        }

        // Insert the order
        $query = "INSERT INTO user_order_tbl (o_id, m_id, pharmacy_id, price, quantity, total_amount, status, order_date) 
                 VALUES ('','$medicine_id','$user_id','$price','$quantity','$total','$status','$date')";

        if ($conn->query($query)) {
            // Update stock count
            $updateStock = "UPDATE user_medicine_tbl 
                          SET in_stock = in_stock - $quantity 
                          WHERE m_id = '$medicine_id'";
            
            if ($conn->query($updateStock)) {
                redirect('../order-display.php', 'Order has been submitted successfully');
            } else {
                // If stock update fails, rollback the order
                $last_id = $conn->insert_id;
                mysqli_query($conn, "DELETE FROM user_order_tbl WHERE o_id = '$last_id'");
                redirect('../order-create.php', 'Error updating stock');
            }
        } else {
            redirect('../order-create.php', 'Could not add order: ' . $conn->error);
        }
    }
?>