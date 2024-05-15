<?php
    require('../../config/function.php');

    $paraResult = checkParamId('medicine_id');
    if(is_numeric($paraResult)){
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $medicine_id = validate($paraResult);

        $deletequery = "DELETE FROM `cart` WHERE pharmacy_id = '$user_id' 
                            AND medicine_id = '$medicine_id'";
        $cartitemdelete = mysqli_query($conn,$deletequery);
        
        if($cartitemdelete){
            redirect('../carts.php','Item Deleted Successfully');
        }else{
            redirect('../carts.php','Something Went Wrong!');
        }
        }
?>