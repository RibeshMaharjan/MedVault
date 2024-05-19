<?php
    if(!isset($_SESSION['auth'])){
        redirect('../proj-front/login.php','Please Log In First!');
    }
?>
<nav class="navbar navbar-expand-lg bg-white border-bottom border-4 border-danger main-nav" style="min-height: 100px;">
    <div class="container">
        <a class="navbar-brand" href="home.php"><img class="logo" src="image/logo.png" alt="logo" ></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 h5">
                <li class="nav-item">
                <a class="nav-link" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="medicine.php">Medicine</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="aboutus.php">About us</a>
                </li>
            </ul>
        <form class="d-flex my-3" role="search" action="search.php" method="get" style="height: 50px;">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="medicine_name" >
            <button class="btn btn-outline-danger" type="submit" name="search">Search</button>
        </form>
        <div class="add-to-cart ms-5" >
            <!-- <div class="add-to-cart" onclick="togglecart()"> -->
                <?php
                    $user_id = $_SESSION['loggedInUser']['user_id'];
                    $cartitemtotal = getAll('cart');
                    $query ="SELECT * FROM cart WHERE pharmacy_id='$user_id'";
                    $result = mysqli_query($conn, $query);
                    $cartcount = getTotalById('cart','pharmacy_id',$user_id);
                    $total = countcartitem();
                    ?>
                <a href="carts.php">
                    <span class="material-symbols-rounded" style="font-size:2rem; cursor: pointer;color: black;">shopping_cart</span>
                    <span id="cartnum"><?= $total ?></span>
                </a>
            </div>
        <?php
            if(isset($_SESSION['auth'])){
                $user_name = $_SESSION['loggedInUser']['name'];
        ?>
        <ul class="navbar-nav mx-5  mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="material-symbols-rounded" onclick="togglemenu()" style="font-size:2.5rem; cursor: pointer;color: black;">account_circle</span>
                </a>
                
                <ul class="dropdown-menu mt-3 p-2">
                    <li><a class="dropdown-item mt-3" href="#">
                        <div class="user-info">
                            <span class="material-symbols-outlined">account_circle</span>
                            <h3><?= $user_name ?></h3>
                        </div>
                    </a></li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="sub-menu-link px-3" href="edit-profile.php">
                            <span class="material-symbols-outlined" id="icon">person</span>
                            <p>Edit Profile</p>
                            <span>></span>
                        </a>
                    </li>
                    <li>
                        <a class="sub-menu-link px-3" href="view-inventory.php">
                            <span class="material-symbols-outlined" id="icon">inventory_2</span>
                            <p>View Inventory</p>
                            <span>></span>
                        </a>
                    </li>
                    <li>
                        <a class="sub-menu-link px-3" href="transaction.php">
                            <span class="material-symbols-outlined" id="icon">inventory_2</span>
                            <p>View Transaction</p>
                            <span>></span>
                        </a>
                    </li>
                    
                    <li><a class="sub-menu-link px-3" href="../proj-back/logout.php">
                        <span class="material-symbols-outlined" id="icon">logout</span>
                        <p>Log Out</p>
                        <span>></span>
                    </a></li>
                </ul>
            </li>
        </ul>
            
            <?php 
        }else{
            echo '
            <div >
                <h3><a href="login.php">Log IN</a></h3>
            </div>';
            }
    ?>
    </div>
    </div>
</nav>