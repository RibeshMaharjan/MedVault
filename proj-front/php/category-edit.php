<?php
    include '../../config/function.php';

    $paraResult = checkParamId('c_id');

    if(isset($_POST['update-category'])){
        $category_id = $_POST['update_id'];
        $category_name = $_POST['name'];

        $query = "UPDATE user_category_tbl SET category_name='$category_name' WHERE c_id=$category_id";

        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../category.php','Cateogry Updated Successfully');
        }
        else{
            redirect('../cateogory.php','Could Not Update Cateogry');
        }
    }
?>