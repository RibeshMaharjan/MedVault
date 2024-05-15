<?php

    require '../config/function.php';

    if(isset($_SESSION['auth']))
    {
        redirect('../proj-back/admin.php','Already Logged In');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login/login.css">
    <link rel="stylesheet" href="assets/css/login/toggle.css">
    <title>Document</title>
</head>
<body>
    <div class="nav-bar">
    <div class="logo">
        <!-- <h1>MedVault</h1> -->
        <img src="image/med-removebg.png" alt="logo">
    </div>
        <!-- <a href="#" class="logo"><img src="logo.png" alt="logo"></a> -->
        <div  class="menu-bar">
            <a href="home.php"><h4>Home</h4></a>
            <a href="#login_form"><h4>Log In</h4></a>
            <a href="#register_form"><h4>Registration</h4></a>
        </div>
    </div>
    <div class="header">
        <h3>Welcome To</h3>
        <p><br>Pharmaceutical</p>
    </div>
    <div class="content">
        <div class="form">
            <div class="container" id="main">
                <div class="sign-up">
                    <form action="validation.php" method="POST" id="register_form">
                        <h1>Create Account</h1>
                        <p>or use your email for Registration</p>
                        <input type="text" name="name" placeholder="name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="repassword" placeholder="Re-Password" required>
                        <!-- <button>Registration</button> -->
                        <div class="button">
                            <input type="submit" name="register" value="Register" class="signInBtn">
                        </div>
                    </form>
                </div>
                <div class="sign-in">
                
                    <form action="validation.php" method="POST" id="login_form">
                        <?php alertmessage() ?>
                        <h1>Sign In</h1>
                        <input type="email" name="email" placeholder="Email" id="uname" required>
                        <input type="password" name="password" placeholder="Password" id="pass" required>
                        <b style="color: red; display: none;" id="invalid">Password Inavlid!</b>
                        <a href="#">Forgot your Password?</a>
                        <div class="button">
                            <input type="submit" name="signIn" value="signIn" class="signInBtn">
                        </div>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-left">
                            <h1>Welcome Back!</h1>
                            <p>To keep connected with us please login with your personal info</p>
                            <button id="signIn">Sign In</button>
                        </div>
                        <div class="overlay-right">
                            <h1>Hello!</h1>
                            <p>Enter your personal details and start your journery</p>
                            <button id="signUp">Register</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const signUpButton = document.getElementById("signUp");
        const signInButton = document.getElementById("signIn");
        const main = document.getElementById("main");

        signUpButton.addEventListener('click', () => {
            main.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            main.classList.remove("right-panel-active");
        });
    </script>
</body>
</html>

<?php
    

    // $servername = "localhost";
    // $username   = "root";
    // $password   = ""; 
    // $dbname     = "pharmacy";
    
    // $connection = mysqli_connect($servername,$username,$password,$dbname);
    // if($connection)
    // {
    //     echo "Connection ok<br>";
    // }
    // else
    // {
    //     echo "Connection fail".mysqli_connect_error();
    // }

    // if(isset($_POST['signIn'])){
    //     $u_email = $_POST['email'];
    //     $u_password = $_POST['password'];

    //     if($u_email){
    //         $query = "SELECT * FROM admin_table WHERE email = '$u_email' AND password = '$u_password'";
    //         $data = mysqli_query($connection,$query);
    //         $total = mysqli_num_rows($data);
            
    //         if($total == 1){

    //             $_SESSION['auth'] = true;
    //             $_SESSION['username'] = $u_email;
    //             $_SESSION['password'] = $u_password;
    //             header("location: ../proj-back/admin.php");
    //         }else{
    //             echo "
    //             <script>
    //                 alert('invalid');
    //             </script>
    //             ";
    //         }
    //     }
        
    // }
?>

<script>
    function validation(){
        event.preventDefault();
        if (document.getElementById("uname").value == "") {
            alert("Username is empty.");
        } 
        else if (document.getElementById("pass").value == "") {
            alert("Password is empty.");
        } 
        else {
            document.querySelector("#login_form").submit();
        }
    }
</script>