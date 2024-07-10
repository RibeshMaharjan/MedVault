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
                redirect('login.php','Something went Wrong');
            }
        }
    }

    if(isset($_POST['register']))
    {
        $nameInput = validate($_POST['name']);
        $emailInput = validate($_POST['email']);
        $passwordInput = validate($_POST['password']);
        $repasswordInput = validate($_POST['repassword']);

        $name = filter_var($nameInput,FILTER_SANITIZE_STRING);
        $email = filter_var($emailInput,FILTER_SANITIZE_EMAIL);
        $password = filter_var($passwordInput,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        $repassword = filter_var($repasswordInput,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        if($passwordInput != $repasswordInput){
            redirect('login.php','Password Doesnot Match');
        }
        if($email != '' && $password != ''){
            
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO role VALUES('','$name','$email','$passwordHash','user')";

            if ($conn->query($query) === TRUE) {
                // Retrieve the order_id generated for the newly inserted row
                $user_id = $conn->insert_id;
            
                // Insert data into the order_address table using the retrieved order_id
                $sql_insert_order_address = "INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, email) VALUES('$user_id','$name','$email')";
            
                if ($conn->query($sql_insert_order_address) === TRUE) {
                    redirect('login.php','Registeration Successfull!');
                } else {
                    echo "Error inserting data into order_address table: " . $conn->error;
                }
            } else {
                echo "Error inserting data into user_orders table: " . $conn->error;
            }

            // if($result)
            // {
            //     if(mysqli_num_rows($result) == 1)
            //     {
            //         $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //         if($row['role'] == 'admin')
            //         {
            //             $_SESSION['auth'] =true;
            //             $_SESSION['loggedInUserRole'] = $row['role'];
            //             $_SESSION['loggedInUser'] = [
            //                 'name' => $row['name'],
            //                 'email' => $row['email']
            //             ];
            //             redirect('../proj-back/admin.php','Logged In Successfully');
            //         }
            //         else
            //         {
            //             $_SESSION['auth'] =true;
            //             $_SESSION['loggedInUserRole'] = $row['role'];
            //             $_SESSION['loggedInUser'] = [
            //                 'name' => $row['name'],
            //                 'email' => $row['email']
            //             ];
            //             redirect('home.php','Logged In Successfully');
            //         }
            //     }
            //     else
            //     {
            //         redirect('login.php','Invalid Email or Password');
            //     }
            // }
            // else
            // {
            //     redirect('login.php','Something went Wrong');
            // }
        }
    }

?>