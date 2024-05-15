<?php

    include '../../config/function.php';
    $user_id = $_SESSION['loggedInUser']['user_id'];

    if(isset($_POST['add-medicine'])){
        $medicine_name = $_POST['name'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $buy_price = $_POST['buy_price'];
        $sell_price = $_POST['sell_price'];
        $images = $_FILES['images']['name'];
        $fileNameNew = uniqid('', true).".".$images;

        $query = "INSERT INTO user_medicine_tbl (m_id,pharmacy_id,image,medicine_name,medicine_desc,c_id,in_stock,buy_price,sell_price) VALUES('','$user_id','../image/meds_img/$fileNameNew','$medicine_name','$description','$category','0','$buy_price','$sell_price')";
        $data = mysqli_query($conn,$query);

        $upload_dir = '../image/meds_img/';

        // Create the directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Get the file details
        $file_tmp = $_FILES['images']['tmp_name'];

        // Move the uploaded file to the desired directory
        if(move_uploaded_file($file_tmp, $upload_dir.$fileNameNew)){
            echo "Image $file_name uploaded successfully!<br>";
        } else{
            echo "Error uploading image $file_name!<br>";
        }

        if($data){
            redirect('../medicine-create.php','Medicine Added Successfully');
        }
        else{
            redirect('../medicine-create.php','Could Not Add Medicine');
        }
    }
?>