<?php

    include '../../config/function.php';
    $user_id = $_SESSION['loggedInUser']['user_id'];

    if(isset($_POST['add-medicine'])){
        $medicine_name = $_POST['name'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $instock = $_POST['quantity'];
        $buy_price = $_POST['buy_price'];
        $sell_price = $_POST['sell_price'];
        $exp_date = $_POST['exp_date'];
        $formatted_Date = date("Y-m-d", strtotime($exp_date));

        if($category == '' && $medicine_name ='' && $description ='' && $instock ='' && $buy_price ='' && $sell_price ='' && $exp_date =''){
            redirect('../medicine-create.php','Fill All the Field');
        }

        $query = "INSERT INTO user_medicine_tbl (m_id,pharmacy_id,medicine_name,medicine_desc,c_id,in_stock,buy_price,sell_price,exp_date) VALUES('','$user_id','$medicine_name','$description','$category','$instock','$buy_price','$sell_price','$formatted_Date')";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../medicine-create.php','Medicine Added Successfully');
        }
        else{
            redirect('../medicine-create.php','Could Not Add Medicine');
        }
    }
?>