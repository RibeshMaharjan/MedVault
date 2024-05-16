<?php
    include_once('../config/function.php');
    $upload_dir = '../uploaded_img/';

    // ADD ADMIN
    if(isset($_POST['add-admin'])){
        $admin_name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $dob = $_POST['birth'];
        $formatted_Date = date("Y-m-d", strtotime($dob));
        $address= $_POST['address'];

        if($admin_name != '' || $email != '' || $phone != '' || $password != '')
        {
            $query = "INSERT INTO role VALUES('','$admin_name','$email','$password','admin')";
            // $data = mysqli_query($conn,$query);

            if ($conn->query($query) === TRUE) {
                // Retrieve the order_id generated for the newly inserted row
                $admin_id = $conn->insert_id;
            
                // Insert data into the order_address table using the retrieved order_id
                $sql_insert_order_address = "INSERT INTO tbl_admin (admin_id, name, email, gender, phone,dob,address)VALUES ('$admin_id', '$admin_name','$email','$gender','$phone','$formatted_Date','$address')";
            
                if ($conn->query($sql_insert_order_address) === TRUE) {
                    redirect('admin-create.php','Admin Added Successfully');
                    
                } else {
                    redirect('admin-create.php','Error Adding Admin '. $conn->error);
                }
            } else {
                redirect('admin-create.php','Error Adding Admin '. $conn->error);
            }
        }
        else{
            redirect('admin-create.php', 'Please fill all fields!');
        }
    }

    // UPDATE ADMIN
    if(isset($_POST['update-admin'])){
        $admin_name = validate($_POST['name']);
        $email = validate($_POST['email']);
        $gender = validate($_POST['gender']);
        $phone = validate($_POST['phone']);
        $dob = validate($_POST['birth']);
        $formatted_Date = date("Y-m-d", strtotime($dob));
        $address= validate($_POST['address']);

        $email = $_POST['email'];

        $query = "UPDATE tbl_admin SET 
                    name ='$admin_name',
                    email ='$email',
                    gender ='$gender',
                    phone ='$phone',
                    dob ='$formatted_Date',
                    address ='$address' 
                    WHERE email='$email'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('admin-display.php','Admin Data Updated');
        }
        else{
            redirect('admin-display.php','Admin Data Updated Failed');
        }
    }

    // ADD PHARMACY
    if(isset($_POST['add-user'])){
        $pan = $_POST['pan'];
        $pharmacy_name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $address= $_POST['address'];

        if($admin_name != '' || $email != '' || $phone != '' || $password != '')
        {
            $query = "INSERT INTO role VALUES('','$pharmacy_name','$email','$password','user')";
            // $query = "INSERT INTO tbl_pharmacy VALUES('','$pan','$pharmacy_name','$email','$phone','$address')";
            // $data = mysqli_query($conn,$query);

            if ($conn->query($query) === TRUE) {
                // Retrieve the order_id generated for the newly inserted row
                $pharmacy_id = $conn->insert_id;
            
                // Insert data into the order_address table using the retrieved order_id
                $sql_insert_order_address = "INSERT INTO tbl_pharmacy (pharmacy_id,pan, pharmacy_name, email, phone,address)VALUES('$pharmacy_id','$pan','$pharmacy_name','$email','$phone','$address')";
            
                if ($conn->query($sql_insert_order_address) === TRUE) {
                    redirect('pharmacy-create.php', "Data inserted successfully");
                } else {
                    echo "Error inserting data into order_address table: " . $conn->error;
                }
            } else {
                echo "Error inserting data into user_orders table: " . $conn->error;
            }
        }
        else{
            redirect('pharmacy-create.php', 'Please fill all fields!');
        }
    }

    // Update Pharmacy
    if(isset($_POST['update-pharmacy'])){
        $pan = $_POST['pan'];
        $pharmacy_name = $_POST['pharmacy_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address= $_POST['address'];

        $query = "UPDATE tbl_pharmacy SET 
                    pan ='$pan',
                    pharmacy_name ='$pharmacy_name',
                    email ='$email',
                    phone ='$phone',
                    address ='$address' 
                    WHERE pan='$pan'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('pharmacy-display.php','User Data Updated Successcully');
        }
        else{
            redirect('pharmacy-display.php','Could Not Update User Data');
        }
    }

    // ADD MEDICINE
    if(isset($_POST['add-medicine'])){
        $medicine_name = $_POST['name'];
        $manufacturer_name = $_POST['manufacturername'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $exp_date = $_POST['exp_date'];
        $formatted_Date = date("Y-m-d", strtotime($exp_date));
        $dosage = $_POST['dosage'];
        $imagename = $_FILES['images']['name'];
        $fileExt = explode('.',$imagename);
        $fileActualExt = strtolower(end($fileExt));
        $fileNameNew = uniqid('', true).".".$fileActualExt;

        $query = "INSERT INTO tbl_medicine (medicine_id,medicine_name,manufacturer,price,quantity,expiration_date,dosage, images) VALUES('','$medicine_name','$manufacturer_name','$price','$quantity','$formatted_Date','$dosage','../uploaded_img/$fileNameNew')";
        $data = mysqli_query($conn,$query);

        $upload_dir = "../uploaded_img/";

        // Create the directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Get the file details
        $file_tmp = $_FILES['images']['tmp_name'];
        $fileDestination = $upload_dir.$fileNameNew;

        // Move the uploaded file to the desired directory
        if(move_uploaded_file($file_tmp, $fileDestination)){
            echo "Image $file_name uploaded successfully!<br>";
        } else{
            echo "Error uploading image $file_name!<br>";
        }

        if($data){
            redirect('medicine-create.php','Medicine Added Successfully');
        }
        else{
            redirect('medicine-create.php','Could Not Add Medicine');
        }
    }

    // UPDATE MEDICINE
    if(isset($_POST['update-medicine'])){
        $medicine_id = $_POST['update_id'];
        $medicine_name = $_POST['name'];
        $manufacturer_name = $_POST['manufacturername'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $exp_date = validate($_POST['exp_date']);
        $formatted_Date = date("Y-m-d", strtotime($exp_date));;
        $dosage = $_POST['dosage'];

        $query = "UPDATE tbl_medicine SET 
                    medicine_name ='$medicine_name',
                    manufacturer ='$manufacturer_name',
                    price ='$price',
                    quantity ='$quantity',
                    expiration_date = '$formatted_Date',
                    dosage = '$dosage'
                    WHERE medicine_id='$medicine_id'";
        $data = mysqli_query($conn,$query);

        if(!empty($_FILES['images']['tmp_name'])) {
            $imagename = $_FILES['images']['name'];
            $fileExt = explode('.',$imagename);
            $fileActualExt = strtolower(end($fileExt));
            $fileNameNew = uniqid('', true).".".$fileActualExt;
            $imagequery = "UPDATE tbl_medicine SET 
                    images = '../uploaded_img/$fileNameNew'
                    WHERE medicine_id='$medicine_id'";
            $imagedata = mysqli_query($conn,$imagequery);
        
            $upload_dir = "../uploaded_img/";

            // Create the directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Get the file details
            $file_tmp = $_FILES['images']['tmp_name'];
            $fileDestination = $upload_dir.$fileNameNew;

            // Move the uploaded file to the desired directory
            if(move_uploaded_file($file_tmp, $fileDestination)){
                echo "Image $file_name uploaded successfully!<br>";
            } else{
                echo "Error uploading image $file_name!<br>";
            }
    }

        if($data){
            redirect('medicine-display.php','Medicine Added Successfully');
        }
        else{
            redirect('medicine-display.php','Could Not Update Medicine');
        }
    }

    if(isset($_POST['saveSetting'])){
        $title = validate($_POST['title']);
        $smalldescription = validate($_POST['small-description']);
        $subtitle = validate($_POST['sub-title']);
        $subdescription = validate($_POST['sub-description']);
        $phone = validate($_POST['phone']);
        $email = validate($_POST['email']);
        $settingId = validate($_POST['settingId']);

        if($settingId == 1){
            $query = "UPDATE settings SET 
                        title='$title',
                        small_description ='$smalldescription',
                        sub_title ='$subtitle',
                        sub_description ='$subdescription',
                        phone ='$phone',
                        email ='$email' 
                        WHERE id=1";
            $result = mysqli_query($conn,$query);
        }

        if($result){
            redirect("setting.php","Setting has been saved successfully");
        }else {
            echo "failed";
        }
    }

?>