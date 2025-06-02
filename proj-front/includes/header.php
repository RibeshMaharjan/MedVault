<?php

    include('../config/function.php');

    // if(isset($_SESSION['auth']) || ($_SESSION['loggedInUserRole'] == 'admin')) {
    //     redirect('../proj-back/admin.php','Please Log In First!');
    // }


    if(!isset($_SESSION['auth'])){
        redirect('../proj-front/login.php','Please Log In First!');
    }else{
        $username = $_SESSION['loggedInUser']['name'];
        $user_id = $_SESSION['loggedInUser']['user_id'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/pop.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="assets/css/inventory/inventory.css">
    <link rel="stylesheet" href="assets/css/inventory/category.css">
    <link rel="stylesheet" href="assets/css/inventory/table.css">
    <link rel="stylesheet" href="assets/css/editprofile.css">
    <link rel="stylesheet" href="assets/css/product.css">
    <link rel="stylesheet" href="assets/css/medicine.css">
    <link rel="stylesheet" href="assets/css/toast.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />    <!-- Including our scripting file. -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/toast.js"></script>
    <!-- Including CSS file. -->
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    
    <!-- <link rel="stylesheet" href="../assets/css/contentslider.css">     -->
    <!-- <script src="slider.js"></script> -->
    <style>
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 650px;
        }
        .alert {
            margin-bottom: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-in-out;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Static sidebar and scrollable content */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 320px;
            overflow-y: auto;
            background-color: white;
            z-index: 100;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .main-container {
            min-height: 100vh;
            display: block;
        }
        
        .container-fluid {
            margin-left: 320px;
            padding-bottom: 30px;
            min-height: 100vh;
            width: calc(100% - 320px);
            overflow-y: auto;
        }
        
        /* Mobile responsive */
        @media (max-width: 767px) {
            .sidebar {
                margin-left: -320px;
                transition: all 0.3s;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .container-fluid {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Toast styles */
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
    </style>
    <title>MedVault</title>
</head>
<body>
    <?php include 'verification-status.php'; ?>
    <div class="toast-container">
        <?php alertmessage(); ?>
    </div>