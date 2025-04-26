<?php
    require('../config/function.php');

    $paraResult = checkParamId('medicine_id');
    if(is_numeric($paraResult)){

        $medicine_id = validate($paraResult);

        $medicine = getById('tbl_medicine','medicine_id', $medicine_id);
        if($medicine['status'] == 200){
            $medicinedelete = deleteQuery('tbl_medicine','medicine_id', $medicine_id);
            if($medicinedelete){
                redirect('medicine-display.php','Medicine Removed Successfully');
            }else{
                redirect('medicine-display.php','Something Went Wrong!');
            }
        }else{
            redirect('medicine-display.php','Medicine Not Found');
        }

    }else{
        redirect('medicine-display.php', $paraResult);
    }

?>