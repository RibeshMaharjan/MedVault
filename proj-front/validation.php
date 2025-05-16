<?php

require '../config/function.php';

$user_table = 'role';

if (isset($_POST['signIn'])) {
    $email = validate($_POST['email']);
    $passwordInput = validate($_POST['password']);

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       redirect('login.php', 'Invalid email format');
    }

    $password = filter_var($passwordInput, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    if ($email != '' && $password != '') {

        $query = "SELECT * FROM $user_table WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if (password_verify($passwordInput, $row['password'])) {
                    if ($row['role'] == 'admin') {
                        $_SESSION['auth'] = true;
                        $_SESSION['loggedInUserRole'] = $row['role'];
                        $_SESSION['loggedInUser'] = [
                            'name' => $row['name'],
                            'user_id' =>  $row['user_id'],
                            'email' => $row['email']
                        ];
                        redirect('../proj-back/admin.php', 'Logged In Successfully');
                    } else {
                        $_SESSION['auth'] = true;
                        $_SESSION['loggedInUserRole'] = $row['role'];
                        $_SESSION['loggedInUser'] = [
                            'name' => $row['name'],
                            'user_id' =>  $row['user_id'],
                            'email' => $row['email']
                        ];
                        redirect('view-inventory.php', 'Logged In Successfully');
                    }
                } else {
                    redirect('login.php', 'Invalid Password');
                }
            } else {
                redirect('login.php', 'Email does not exist');
            }
        } else {
            redirect('login.php', 'Email does not exist');
        }
    }
}

if (isset($_POST['register'])) {
    // $pan = $_POST['pan'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    if ($email != '' && $password != '' /* || $pan != '' */ && $name != '') {

        $name = preg_replace('/\s+/', ' ', $name);
        //    $_SESSION['fullname'] = $fullName;

        // Check if empty
        if (empty($name)) {
            redirect('login.php', 'Full name is required');
        }

        // Check length
        if (strlen($name) < 3) {
            redirect('login.php', 'Full name must be at least 3 characters');
        }

        // Check format: only letters, spaces, hyphens, apostrophes
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            redirect('login.php', 'Full name can only contain letters, spaces');
        }

        if (empty($email)) {
            redirect('login.php', 'Email is required');
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect('login.php', 'Invalid email');
        }

        $query = "SELECT * FROM tbl_pharmacy WHERE email = '$email'";
        $emailExistResult = $conn->query(($query));
        if(mysqli_num_rows($emailExistResult)) {
           redirect('login.php', 'Email already exist');
        }


        // Passowrd validation
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';

        if (!preg_match($pattern, $password)) {
            redirect('login.php', 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
        }

        if ($password != $repassword) {
            redirect('login.php', 'Password does not Match');
        }

        // passwordhash
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO role (`name`, `email`, `password`, `role`) VALUES('$name','$email','$passwordHash','user')";

        if ($conn->query($query) === TRUE) {
            // Retrieve the order_id generated for the newly inserted row
            $user_id = $conn->insert_id;

            // Insert data into the order_address table using the retrieved order_id
            $sql_insert = "INSERT INTO tbl_pharmacy (pharmacy_id, pharmacy_name, email) VALUES('$user_id', '$name','$email')";

            if ($conn->query($sql_insert) === TRUE) {
                redirect('login.php', 'Registration Successful!');
            } else {
                echo "Error inserting data into order_address table: " . $conn->error;
            }
        } else {
            echo "Error inserting data into user_orders table: " . $conn->error;
        }
    } else {
        redirect('login.php', 'Fill all the Fields');
    }
}