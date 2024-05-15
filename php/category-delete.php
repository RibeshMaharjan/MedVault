<?php
    require('../../config/function.php');

    $paraResult = checkParamId('c_id');
    if(is_numeric($paraResult)){

        $category_id = validate($paraResult);

        $category = getById('user_category_tbl','c_id', $category_id);
        if($category['status'] == 200){
            $categorydelete = deleteQuery('user_category_tbl','c_id', $category_id);
            if($categorydelete){
                redirect('../category.php','Category Deleted Successfully');
            }else{
                redirect('../category.php','Something Went Wrong!');
            }
        }else{
            redirect('../category.php','User Not Found');
        }

    }else{
        redirect('../category.php', $paraResult);
    }
?>