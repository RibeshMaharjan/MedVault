<?php
    require('../config/function.php');

    $paraResult = checkParamId('admin_id');
    if(is_numeric($paraResult)){

        $adminid = validate($paraResult);

        $admin = getById('tbl_admin','admin_id', $adminid);
        if($admin['status'] == 200){
            $admindelete = deleteQuery('role','user_id', $adminid);
            if($admindelete){
                redirect('admin-display.php','Admin Deleted Successfully');
            }else{
                redirect('admin-display.php','Something Went Wrong!');
            }
        }else{
            redirect('admin-display.php','Admin Not Found');
        }

    }else{
        redirect('admin-display.php', $paraResult);
    }

?>