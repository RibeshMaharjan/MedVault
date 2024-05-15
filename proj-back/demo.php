<?php

    include '../config/function.php';

    $query = "SELECT * FROM tbl_admin";
    $data = mysqli_query($conn,$query);
    $result = mysqli_num_rows($data);


    if($data){
        echo $result;
    }else{
        echo "failed";
    }

        $medicine = getAll('tbl_medicine');
        $result = mysqli_fetch_assoc($medicine);
    function date_compare($element1, $element2) { 
        $datetime1 = strtotime($element1['expiration_date']); 
        $datetime2 = strtotime($element2['expiration_date']); 
        return $datetime1 - $datetime2; 
    }  

    // Sort the array  
    usort($result, 'date_compare'); 

    // Print the array 
    print_r($result);
?>