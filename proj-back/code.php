<?php
    include_once('../config/function.php');

   /* // ADD ADMIN
    if(isset($_POST['add-admin'])){
        $admin_name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $dob = $_POST['birth'];
        $formatted_Date = date("Y-m-d", strtotime($dob));
        $address= $_POST['address'];

        if($admin_name != '' || $email != '' || $phone != '' || $password != '' || $gender != '' || $address != '' || $email != '')
        {
            // Name validation
            if (!preg_match("/^[a-zA-Z-' ]*$/",$admin_name)) {
                redirect('admin-create.php','Only letters and white space allowed');
            }

            // Email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect('admin-create.php','Invalid email format');
            }

            // Passowrd validation
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/'; 

            if (!preg_match($pattern, $password)) { 
                redirect('admin-create.php','Invalid Password');
            }

            // Phone number Validation
            if(!preg_match('/^[0-9]{10}+$/', $phone)) {
                redirect('admin-create.php','InValid Phone Number');
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO role VALUES('','$admin_name','$email','$passwordHash','admin')";
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
        $admin_id = $_POST['update_id'];
        $admin_name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $dob = $_POST['birth'];
        $formatted_Date = date("Y-m-d", strtotime($dob));
        $address= $_POST['address'];

        // Name validation
        if (!preg_match("/^[a-zA-Z-' ]*$/",$admin_name)) {
            redirect('admin-create.php','Only letters and white space allowed');
        }

        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect('admin-create.php','Invalid email format');
        }

        // Phone number Validation
        if(!preg_match('/^[0-9]{10}+$/', $phone)) {
            redirect('admin-create.php','InValid Phone Number');
        }

        if($formatted_Date<date("Y/m/d")) {
            redirect('medicine-create.php','Invalid Date');
        }

        $query = "UPDATE tbl_admin SET 
                    name ='$admin_name',
                    email ='$email',
                    gender ='$gender',
                    phone ='$phone',
                    dob ='$formatted_Date',
                    address ='$address' 
                    WHERE admin_id='$admin_id'";
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
        $pharmacy_name = validate($_POST['name']);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $address= $_POST['address'];
        $isverified = $_POST['isverified'];
        $verification_notes = $_POST['verification_notes'];
        $pan = isset($_POST['pan']) ? $_POST['pan'] : '';

        if($pharmacy_name != '' && $email != '' && $password != '')
        {
            // Name validation
            if (!preg_match("/^[a-zA-Z-' ]*$/", $pharmacy_name)) {
                redirect('pharmacy-create.php','Only letters and white space allowed');
            }

            // Email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect('pharmacy-create.php','Invalid email format');
            }

            // Passowrd validation
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';

            if (!preg_match($pattern, $password)) {
                redirect('pharmacy-create.php','Invalid Password');
            }

            $conn->begin_transaction();
            try {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO role (`name`,`email`,`password`,`role`) VALUES('$pharmacy_name','$email','$passwordHash','user')";

                if ($conn->query($query) === TRUE) {
                    // Retrieve the user_id generated for the newly inserted row
                    $pharmacy_id = $conn->insert_id;

                    // Set verification dates based on status
                    $verification_request_date = 'NULL';
                    $verification_date = 'NULL';
                    $reg_document = '';

                    if($isverified == 1) {
                        $verification_request_date = "'" . date('Y-m-d H:i:s') . "'";
                        $verification_date = "'" . date('Y-m-d H:i:s') . "'";

                        if($pan != '') {
                            $conn->rollback();
                            redirect('pharmacy-create.php','Pan Number is required for verification');
                        }

                        // PAN validation
                        if(!is_numeric($pan) || $pan <= 0) {
                            $conn->rollback();
                            redirect('pharmacy-create.php','Invalid PAN Number');
                        }

                        // Handle file upload for registration document
                        if(isset($_FILES['reg_document']) && $_FILES['reg_document']['error'] == 0) {
                            $upload_dir = '../uploads/verification/';
                            $fileExt = explode('.', $_FILES['reg_document']['name']);
                            $fileActualExt = strtolower(end($fileExt));
                            $allowedExts = array("jpg", "jpeg", "png", "pdf");;

                            if(!in_array($fileActualExt, $allowedExts)) {
                                $conn->rollback();
                                redirect('pharmacy-create.php', "You can only upload files with the following extensions: jpg, jpeg, png, pdf.");
                            }

                            if($_FILES['reg_document']['size'] > 5000000) {
                                $conn->rollback();
                                redirect('pharmacy-create.php', "File size must be less than 5 MB.");
                            }

                            // Create the directory if it doesn't exist
                            if (!file_exists($upload_dir)) {
                                mkdir($upload_dir, 0777, true);
                            }

                            $filename = time() . '_' . $_FILES['reg_document']['name'];
                            $file_tmp = $_FILES['reg_document']['tmp_name'];
                            $fileDestination = $upload_dir . $filename;

                            // Move the uploaded file
                            if(!move_uploaded_file($file_tmp, $fileDestination)) {
                                $conn->rollback();
                                redirect('pharmacy-create.php', "There was an error uploading your file.");
                            }

                            $reg_document = 'uploads/verification/' . $filename;
                        } else {
                            $conn->rollback();
                            redirect('pharmacy-create.php', "Please select a file to upload.");
                        }
                    }

                    // Insert data into the tbl_pharmacy table with verification details
                    $sql_insert = "INSERT INTO tbl_pharmacy (pharmacy_id, pan, pharmacy_name, email, phone, address, 
                    isverified, reg_document, verification_request_date, verification_date, verification_notes) 
                    VALUES('$pharmacy_id', '$pan', '$pharmacy_name', '$email', '$phone', '$address', 
                    '$isverified', '$reg_document', $verification_request_date, $verification_date, '$verification_notes')";

                    if ($conn->query($sql_insert) === TRUE) {
                        $conn->commit();
                        redirect('pharmacy-display.php', "Pharmacy Added successfully");
                    } else {
                        $conn->rollback();
                        redirect('pharmacy-create.php', 'Failed to add pharmacy!');
                    }
                } else {
                    $conn->rollback();
                    redirect('pharmacy-create.php', 'Failed to add pharmacy!');
                }
            } catch (Exception $e) {
                $conn->rollback();
                redirect('pharmacy-create.php', 'Failed to add pharmacy!');
            }
        }
        else{
            redirect('pharmacy-create.php', 'Please fill all required fields!');
        }
    }*/

    // Update Pharmacy
    if(isset($_POST['update-pharmacy'])){
        $pharmacy_id = $_POST['pharmacy_id'];
        $pharmacy_name = $_POST['pharmacy_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address= $_POST['address'];
        $isverified = $_POST['isverified'];
        $verification_notes = $_POST['verification_notes'];
        $pan = isset($_POST['pan']) ? $_POST['pan'] : '';
        
        // Handle file upload for updated registration document
        $reg_document_update = '';
        if(isset($_FILES['reg_document']) && $_FILES['reg_document']['error'] == 0) {
            $upload_dir = '../uploads/verification/';
            
            // Create the directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $filename = time() . '_' . $_FILES['reg_document']['name'];
            $file_tmp = $_FILES['reg_document']['tmp_name'];
            $fileDestination = $upload_dir . $filename;
            
            // Move the uploaded file
            if(move_uploaded_file($file_tmp, $fileDestination)) {
                $reg_document_update = "reg_document = 'uploads/verification/$filename',";
            }
        }

        if($pan != '') {
            // PAN validation
            if(!is_numeric($pan)) {
                redirect('pharmacy-edit.php?id='.$pharmacy_id,'Invalid PAN Number');
            }
        }

        // Name validation
        if (!preg_match("/^[a-zA-Z-' ]*$/",$pharmacy_name)) {
            redirect('pharmacy-edit.php?id='.$pharmacy_id,'Only letters and white space allowed');
        }

        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect('pharmacy-edit.php?id='.$pharmacy_id,'Invalid email format');
        }

        // Set verification dates based on status change
        $verification_date_update = '';
        
        // Get current verification status
        $check_query = "SELECT isverified FROM tbl_pharmacy WHERE pharmacy_id='$pharmacy_id'";
        $result = mysqli_query($conn, $check_query);
        if($result && mysqli_num_rows($result) > 0) {
            $current_status = mysqli_fetch_assoc($result)['isverified'];
            
            // If status changed from unverified to verified, update verification date
            if($current_status == 0 && $isverified == 1) {
                $verification_date_update = "verification_date = '".date('Y-m-d H:i:s')."',";
            }
        }

        $query = "UPDATE tbl_pharmacy SET 
                    pan = '$pan',
                    pharmacy_name = '$pharmacy_name',
                    email = '$email',
                    phone = '$phone',
                    address = '$address',
                    isverified = '$isverified',
                    $reg_document_update
                    $verification_date_update
                    verification_notes = '$verification_notes'
                    WHERE pharmacy_id='$pharmacy_id'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('pharmacy-display.php','Pharmacy Data Updated Successfully');
        }
        else{
            redirect('pharmacy-edit.php?id='.$pharmacy_id,'Could Not Update Pharmacy Data');
        }
    }

    /*// ADD MEDICINE
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
        $fileError = $_FILES['images']['error'];
        $fileSize = $_FILES['images']['size'];

        if (!preg_match("/^[a-zA-Z-' ]*$/",$medicine_name)) {
            redirect('medicine-create.php','Only letters and white space allowed');
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/",$manufacturer_name)) {
            redirect('medicine-create.php','Only letters and white space allowed');
        }

        if(!is_numeric($price) || $price<0) {
            redirect('medicine-create.php','Invalid Price Number');
        }

        if($quantity<0){
            redirect('medicine-create.php','Invalid quantity Number');
        }
        if($formatted_Date<date("Y/m/d")) {
            redirect('medicine-create.php','Invalid Date');
        }



        // Image Add
        $allowed = array('jpg', 'jpeg', 'png');
        if (!in_array($fileActualExt, $allowed)) {
            redirect('medicine-create.php','You cannot upload files of this type!');
        }

        if ($fileError === 0) {
            if ($fileSize < 1000000) {
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
                redirect('medicine-create.php','Error uploading image');
            }
            // image add end

            $query = "INSERT INTO tbl_medicine (medicine_id,medicine_name,manufacturer,price,quantity,expiration_date,dosage, images) VALUES('','$medicine_name','$manufacturer_name','$price','$quantity','$formatted_Date','$dosage','../uploaded_img/$fileNameNew')";
            $data = mysqli_query($conn,$query);

            if($data){
                redirect('medicine-create.php','Medicine Added Successfully');
            }
            else{
                redirect('medicine-create.php','Could Not Add Medicine');
            }
            }else {
                redirect('medicine-create.php','Your file is too big!');
            }
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

        if (!preg_match("/^[a-zA-Z-' ]*$/",$medicine_name)) {
            redirect('medicine-create.php','Only letters and white space allowed');
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/",$manufacturer_name)) {
            redirect('medicine-create.php','Only letters and white space allowed');
        }

        if(!is_numeric($price)) {
            redirect('medicine-create.php','Invalid Price Number');
        }

        if(!empty($_FILES['images']['tmp_name'])) {
            $imagename = $_FILES['images']['name'];

            $fileExt = explode('.',$imagename);
            $fileActualExt = strtolower(end($fileExt));
            $fileNameNew = uniqid('', true).".".$fileActualExt;
            $fileError = $_FILES['images']['error'];
            $fileSize = $_FILES['images']['size'];

            $allowed = array('jpg', 'jpeg', 'png');
            if (!in_array($fileActualExt, $allowed)) {
                redirect('medicine-create.php','You cannot upload files of this type!');
            }

            if ($fileError === 0) {
                if ($fileSize < 1000000) {
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
                        redirect('medicine-display.php','Error uploading image!');
                    }
                }else {
                    redirect('medicine-display.php','Your file is too big!');
                }
            }else {
                redirect('medicine-display.php','Could Not Update Image');
            }
        }
        $query = "UPDATE tbl_medicine SET
                    medicine_name ='$medicine_name',
                    manufacturer ='$manufacturer_name',
                    price ='$price',
                    quantity ='$quantity',
                    expiration_date = '$formatted_Date',
                    dosage = '$dosage'
                    WHERE medicine_id='$medicine_id'";
        $data = mysqli_query($conn,$query);
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
    }*/
?>