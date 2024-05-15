<?php

    include_once '../../config/function.php';
    
    if (isset($_GET['medicine_id'])) {
        global $conn;
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $product_id = $_GET['medicine_id'];

        $delete_query = "DELETE FROM cart WHERE pharmacy_id = '$user_id' AND medicine_id = '$product_id'";
        $result_query = mysqli_query($conn,$delete_query);
        if($result_query){
            redirect('back','Item Deleted from cart');
        }else{
            redirect('back','Item not Deleted from cart');
        }
    }
    
    if (isset($_GET['removeall'])) {
        global $conn;
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $product_id = $_GET['medicine_id'];

        $delete_query = "DELETE FROM cart WHERE pharmacy_id = '$user_id'";
        $result_query = mysqli_query($conn,$delete_query);
        if($result_query){
            redirect('back','Cart Empty');
        }else{
            redirect('back','Cart Empty Failed');
        }
    }
?>