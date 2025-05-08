<?php
    require('../config/function.php');

    $paraResult = checkParamId('email');
    if(!is_numeric($paraResult)){

        $pharmacyemail = validate($paraResult);

        $pharmacy = getById('tbl_pharmacy','email', $pharmacyemail);
        if($pharmacy['status'] == 200){
            $conn->begin_transaction();
            $pharmacydelete = deleteQuery('tbl_pharmacy','email', $pharmacyemail);
            $roledelete = deleteQuery('role','email', $pharmacyemail);
            if($pharmacydelete && $roledelete){
                $conn->commit();
                redirect('pharmacy-display.php','User Deleted Successfully');
            }else{
                $conn->rollback();
                redirect('pharmacy-display.php','Something Went Wrong!');
            }
        }else{
            redirect('pharmacy-display.php','User Not Found');
        }

    }else{
        redirect('pharmacy-display.php', $paraResult);
    }

?>