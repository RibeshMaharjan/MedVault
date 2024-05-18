<?php
    require_once '../config/function.php';

    include('authentication.php');

    if(!isset($_SESSION['auth'])){
        redirect('../proj-front/login.php','Please Log In First!');
    }
    $user_email = $_SESSION['loggedInUser']['email'];
    $user = getById('tbl_admin','email',$user_email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="assets/css/new-sidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <title>Document</title>
</head>
<body>
<div class="main-container d-flex">
    <?php include 'new-sidebar.php'; ?>
        <div class="container-fluid bg-body-tertiary">
            <nav class="navbar navbar-expand-md bg-white rounded mx-3 mt-3 header">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between d-md-none d-block">
                        <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
                        <a class="navbar-brand fs-4" href="#"><span class="bg-dark rounded px-2 py-0 text-white">MedVault</span></a>
                    </div>
                    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fal fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item ">
                                <a class="nav-link d-flex align-items-center justify-content-center" href="../proj-front/home.php">
                                <span class="material-symbols-outlined me-1 ">home</span>Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex  align-items-center justify-content-center ">
                                    <span class="material-symbols-outlined me-1 " >person</span><?= $user['data']['name'] ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex  align-items-center justify-content-center " href="logout.php">
                                    <span class="material-symbols-outlined me-1 ">logout</span>Log Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            
        