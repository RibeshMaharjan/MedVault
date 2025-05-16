<?php
    include_once('../../config/function.php');
    $user_id = $_SESSION['loggedInUser']['user_id'];

    if(isset($_POST['update-profile'])){
        $pan = $_POST['pan'];
        $pharmacy_name = $_POST['pharmacy_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address= $_POST['address'];

        // Password validation
        if($_POST['oldpassword'] != ''){

            $oldpassword= $_POST['oldpassword'];
            $newpassword= $_POST['newpassword'];
            $confirmnewpassword= $_POST['confirmnewpassword'];

            // Passowrd validation
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/'; 

            if (!preg_match($pattern, $newpassword)) { 
                redirect('../edit-profile.php','Invalid Password! At least one lowercase letter, one uppercase letter, one digit and Minimum length of 8 characters.');
            }

            $pharmacypassword = getById('role','email', $email);

            password_verify($oldpassword, $pharmacypassword['data']['password']);
            if(!password_verify($oldpassword, $pharmacypassword['data']['password'])){
                redirect('../edit-profile.php','Incorrect Password!');
            }
            if($newpassword != $confirmnewpassword){
                redirect('../edit-profile.php','Password Does not Match');
            }

            $passwordHash = password_hash($newpassword, PASSWORD_DEFAULT);
            $passwordquery = "UPDATE role SET 
                            password ='$passwordHash' 
                            WHERE user_id='$user_id'";

            $passworddata = mysqli_query($conn,$passwordquery);

            if(!$passworddata){
                redirect('../edit-profile.php','Could Not Change Password');
            }
        }

        if($pharmacy_name == '' && $email == '' && $phone == '' && $address == ''){
            redirect('../edit-profile.php','Fill All the Fields');
            exit();
        }

        if($pharmacy_name == ''){
            redirect('../edit-profile.php','Pharmacy Name is Required');
            exit();
        }

        if($email == ''){
            redirect('../edit-profile.php','Email is Required');
            exit();
        }

        if($phone == ''){
            redirect('../edit-profile.php','Phone Number is Required');
            exit();
        }

        if($address == ''){
            redirect('../edit-profile.php','Address is Required');
            exit();
        }

        if($pan == ''){
            redirect('../edit-profile.php','PAN Number is Required');
            exit();
        }

        $email_check = "SELECT * FROM tbl_pharmacy WHERE email='$email'";
        $email_check_result = mysqli_query($conn, $email_check);
        $email_check_row = mysqli_fetch_assoc($email_check_result);
        $email_check_count = mysqli_num_rows($email_check_result);
        if($email_check_count > 0 && $email_check_row['email'] != $email){
            redirect('../edit-profile.php','Email Already Exists');
            exit();
        }

        if(!is_numeric($pan)) {
            redirect('../edit-profile.php','Invalid PAN Number');
        }

        // Name validation
        if (!preg_match("/^[a-zA-Z-' ]*$/",$pharmacy_name)) {
            redirect('../edit-profile.php','Only letters and white space allowed');
        }

        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect('../edit-profile.php','Invalid email format');
        }

        // Pan number Validation
        if(!preg_match('/^[0-9]{9}+$/', $phone)) {
            redirect('../edit-profile.php','InValid Phone Number');
        }

        // Phone number Validation
        if(!preg_match('/^[0-9]{10}+$/', $pan)) {
            redirect('../edit-profile.php','InValid Pan Number');
        }

        $query = "UPDATE tbl_pharmacy SET 
                    pan ='$pan',
                    pharmacy_name ='$pharmacy_name',
                    email ='$email',
                    phone ='$phone',
                    address ='$address' 
                    WHERE pharmacy_id='$user_id'";
        
        $query2 = "UPDATE role SET 
                    name ='$pharmacy_name',
                    email ='$email'
                    WHERE user_id ='$user_id'";

        $data = mysqli_query($conn,$query);
        $data2 = mysqli_query($conn,$query2);

        if($data && $data2){
            redirect('../edit-profile.php','User Data Updated Successcully');
        }
        else{
            redirect('../edit-profile.php','Could Not Update User Data');
        }
    }
?>