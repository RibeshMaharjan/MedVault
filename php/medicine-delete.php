<?php
    require('../../config/function.php');

    $paraResult = checkParamId('m_id');
    if(is_numeric($paraResult)){

        $medicine_id = validate($paraResult);

        $medicine = getById('user_medicine_tbl','m_id', $medicine_id);
        if($medicine['status'] == 200){
            $medicinedelete = deleteQuery('user_medicine_tbl','m_id', $medicine_id);
            if($medicinedelete){
                redirect('../medicine-display.php','Medicine Removed Successfully');
            }else{
                redirect('../medicine-display.php','Something Went Wrong!');
            }
        }else{
            redirect('../medicine-display.php','Medicine Not Found');
        }

    }else{
        redirect('../medicine-display.php', $paraResult);
    }

?>