<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/login/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>MedVault - Login</title>
    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 350px;
        }
        .toast {
            margin-bottom: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-in-out;
            background-color: white;
            border-left: 4px solid #198754;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>

<body>
    <div class="toast-container">
        <?php alertMessage(); ?>
    </div>

    <div class="nav-bar">
        <div class="logo">
            <img src="/assets/images/med-removebg.png" alt="logo">
        </div>
        <div class="menu-bar">
            <a href="/"><h4>Home</h4></a>
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
                <!-- Registration Form -->
                <div class="sign-up" id="sign-up">
                    <form action="/register" method="POST" id="register_form">
                        <h1>Create Account</h1>
                        <input type="text" name="name" placeholder="name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="repassword" placeholder="Re-Password" required>
                        <span class="acc-text">Already Have an account? <span id="sign-in2">Sign In</span></span>
                        <div class="button">
                            <input type="submit" name="register" value="Register" class="signInBtn">
                        </div>
                    </form>
                </div>
                <!-- Login Form -->
                <div class="sign-in" id="sign-in">
                    <form action="/login" method="POST" id="login_form">
                        <h1>Sign In</h1>
                        <input type="email" name="email" placeholder="Email" id="uname" required>
                        <input type="password" name="password" placeholder="Password" id="pass" required>
                        <span class="acc-text">Dont Have an account? <span id="sign-up2">Sign Up</span></span>
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
        const signUp2Button = document.getElementById("sign-up2");
        const signIn2Button = document.getElementById("sign-in2");
        const main = document.getElementById("main");
        const signup = document.getElementById("sign-up");

        signUpButton.addEventListener('click', () => main.classList.add("right-panel-active"));
        signInButton.addEventListener('click', () => main.classList.remove("right-panel-active"));
        signUp2Button.addEventListener('click', () => signup.classList.add("active"));
        signIn2Button.addEventListener('click', () => signup.classList.remove("active"));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast.show');
            toasts.forEach(toast => {
                setTimeout(() => toast.classList.remove('show'), 5000);
            });
            document.querySelectorAll('.toast .btn-close').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.toast').classList.remove('show');
                });
            });
        });
    </script>
</body>
</html>
