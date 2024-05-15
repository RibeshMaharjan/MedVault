<?php
    include_once('../../config/function.php');
    $user_id = $_SESSION['loggedInUser']['user_id'];

    if(isset($_POST['update-profile'])){
        $pan = $_POST['pan'];
        $pharmacy_name = $_POST['pharmacy_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address= $_POST['address'];

        if($_POST['oldpassword'] != ''){

            $oldpassword= $_POST['oldpassword'];
            $newpassword= $_POST['newpassword'];
            $confirmnewpassword= $_POST['confirmnewpassword'];

            $pharmacypassword = getById('role','user_id', $user_id);

            if($oldpassword != $pharmacypassword['data']['password']){
                redirect('../edit-profile.php','Incorrect Password!');
            }
            if($newpassword != $confirmnewpassword){
                redirect('../edit-profile.php','Password Does not Match');
            }

            $passwordquery = "UPDATE role SET 
                            password ='$newpassword' 
                            WHERE user_id='$user_id'";

            $passworddata = mysqli_query($conn,$passwordquery);

            if(!$passworddata){
                redirect('../edit-profile.php','Could Not Change Password');
            }
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