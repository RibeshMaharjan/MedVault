<?php

    require '../config/function.php';

    $admin_table = 'role';

    if(isset($_POST['signIn']))
    {
        $emailInput = validate($_POST['email']);
        $passwordInput = validate($_POST['password']);

        $email = filter_var($emailInput,FILTER_SANITIZE_EMAIL);
        $password = filter_var($passwordInput,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        if($email != '' && $password != ''){
            
            $query = "SELECT * FROM $admin_table WHERE email = '$email'";
            $result = mysqli_query($conn,$query);

            if($result)
            {
                if(mysqli_num_rows($result) == 1)
                {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if(password_verify($passwordInput, $row['password'])) {
                        if($row['role'] == 'admin')
                        {
                            $_SESSION['auth'] =true;
                            $_SESSION['loggedInUserRole'] = $row['role'];
                            $_SESSION['loggedInUser'] = [
                                'name' => $row['name'],
                                'user_id' =>  $row['user_id'],
                                'email' => $row['email']
                            ];
                            redirect('../proj-back/admin.php','Logged In Successfully');
                        }
                        else
                        {
                            $_SESSION['auth'] =true;
                            $_SESSION['loggedInUserRole'] = $row['role'];
                            $_SESSION['loggedInUser'] = [
                                'name' => $row['name'],
                                'user_id' =>  $row['user_id'],
                                'email' => $row['email']
                            ];
                            redirect('home.php','Logged In Successfully');
                        }
                    }
                    else
                    {
                        redirect('login.php','Invalid Email or Password');
                    }
                }
                else
                {
                    redirect('login.php','Invalid Email or Password');
                }
            }
            else
            {
                redirect('login.php','Invalid Email');
            }
        }
    }

    if(isset($_POST['register']))
    {
        $pan = $_POST['pan'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];

        if($email != '' || $password != '' || $pan != '' || $name != ''){

            // PAN validation
            if(!is_numeric($pan)) {
                redirect('login.php','Invalid PAN Number');
            }

            // Name validation
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                redirect('login.php','Only letters and white space allowed');
            }

            // Email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect('login.php','Invalid email format');
            }

            // Passowrd validation
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/'; 

            if (!preg_match($pattern, $password)) { 
                redirect('login.php','Invalid Password');
            }
            
            if($passwordInput != $repasswordInput){
                redirect('login.php','Password Doesnot Match');
            }
            
            $query = "SELECT * FROM tbl_pharmacy";
            $panresult = $conn->query($query);
            while($row = mysqli_fetch_array($panresult, MYSQLI_ASSOC)){
                // pan repeat check
                if($pan == $row['pan']){
                    redirect('login.php','Pan Already Exist');
                }
                if($email == $row['email']){
                    redirect('login.php','Email Already Exist');
                }
            }
            
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO role VALUES('','$name','$email','$passwordHash','user')";

            if ($conn->query($query) === TRUE) {
                // Retrieve the order_id generated for the newly inserted row
                $user_id = $conn->insert_id;
            
                // Insert data into the order_address table using the retrieved order_id
                $sql_insert = "INSERT INTO tbl_pharmacy (pharmacy_id, pan, pharmacy_name, email) VALUES('$user_id','$pan','$name','$email')";
            
                if ($conn->query($sql_insert) === TRUE) {
                    redirect('login.php','Registeration Successfull!');
                } else {
                    echo "Error inserting data into order_address table: " . $conn->error;
                }
            } else {
                echo "Error inserting data into user_orders table: " . $conn->error;
            }
        } else {
            redirect('login.php','Fill all the Fields');
        }
    }

?>