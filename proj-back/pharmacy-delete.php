<?php
    require('../config/function.php');

    $paraResult = checkParamId('email');
    if(!is_numeric($paraResult)){

        $pharmacyemail = validate($paraResult);

        $pharmacy = getById('tbl_pharmacy','email', $pharmacyemail);
        if($pharmacy['status'] == 200){
            $pharmacydelete = deleteQuery('tbl_pharmacy','email', $pharmacyemail);
            if($pharmacydelete){
                redirect('pharmacy-display.php','User Deleted Successfully');
            }else{
                redirect('pharmacy-display.php','Something Went Wrong!');
            }
        }else{
            redirect('pharmacy-display.php','User Not Found');
        }

    }else{
        redirect('pharmacy-display.php', $paraResult);
    }

?>