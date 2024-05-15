<?php
    include_once '../../config/function.php';

    // if ($conn->connect_error) {
    //     $response = [
    //         'status' => 'error',
    //         'message' => 'Database connection error: ' . $conn->connect_error
    //     ];
    // } else {
    //     // Get the product_id and quantity from the request
    //     $product_id = $_POST['product_id'];
    //     $quantity = $_POST['quantity'];
    
    //     // Insert the data into the database
    //     $sql = "INSERT INTO cart (product_id, quantity) VALUES ('$product_id', '$quantity')";
    
    //     if ($conn->query($sql) === TRUE) {
    //         $response = [
    //             'status' => 'success',
    //             'message' => 'New record created successfully'
    //         ];
    //     } else {
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Error: ' . $sql . ' <br>' . $conn->error
    //         ];
    //     }
    // }

    if (isset($_GET['add_to_cart'])) {
        global $conn;
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $product_id = $_GET['add_to_cart'];

        $select_query = "SELECT * FROM cart WHERE pharmacy_id = '$user_id' AND medicine_id = '$product_id'";
        $result_query = mysqli_query($conn,$select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if($num_of_rows>0){
            $result = mysqli_fetch_assoc($result_query);
            $quantity = $result['quantity'] + 1;
            $updatequery = "UPDATE cart
                                SET quantity ='$quantity' 
                                WHERE pharmacy_id = '$user_id' 
                                AND medicine_id = '$product_id'";
            $data = mysqli_query($conn,$updatequery);
        }else{
            $insertquery = "INSERT INTO `cart`(`pharmacy_id`, `medicine_id`, `quantity`) VALUES ('$user_id','$product_id','1')";
            $data = mysqli_query($conn,$insertquery);
            // $result = mysqli_num_rows($data);
        }
            if($data){
                redirect('back','Item added to cart');
            }else{
                redirect('back','Item not added to cart');
        }
    }
    
    if(isset($_GET['minus'])) {
        global $conn;
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $product_id = $_GET['minus'];

        $select_query = "SELECT * FROM cart WHERE pharmacy_id = '$user_id' AND medicine_id = '$product_id'";
        $result_query = mysqli_query($conn,$select_query);
        $result = mysqli_fetch_assoc($result_query);
        if($result['quantity'] == 1){
            $deletequery = "DELETE FROM `cart` WHERE pharmacy_id = '$user_id' 
                            AND medicine_id = '$product_id'";
            $data = mysqli_query($conn,$deletequery);
        }else{
            $quantity = $result['quantity'] - 1;
            $updatequery = "UPDATE cart
                                SET quantity ='$quantity' 
                                WHERE pharmacy_id = '$user_id' 
                                AND medicine_id = '$product_id'";
            $data = mysqli_query($conn,$updatequery);
        }
            if($data){
                redirect('back','Item Decreased from cart');
            }else{
                redirect('back','Item not Decreased from cart');
        }
    }

    if(isset($_GET['plus'])) {
        global $conn;
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $product_id = $_GET['plus'];

        $select_query = "SELECT * FROM cart WHERE pharmacy_id = '$user_id' AND medicine_id = '$product_id'";
        $result_query = mysqli_query($conn,$select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if($num_of_rows>0){
            $result = mysqli_fetch_assoc($result_query);
            $quantity = $result['quantity'] + 1;
            $updatequery = "UPDATE cart
                                SET quantity ='$quantity' 
                                WHERE pharmacy_id = '$user_id' 
                                AND medicine_id = '$product_id'";
            $data = mysqli_query($conn,$updatequery);
        }
            if($data){
                redirect('back','Item Increased from cart');
            }else{
                redirect('back','Item not Increased from cart');
        }
    }
?>