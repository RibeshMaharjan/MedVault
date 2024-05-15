<?php
    require '../config/function.php';

    if(isset($_SESSION['auth'])){
        logoutsession();
        redirect('../proj-front/login.php','Logged Out Successfully!');
    }

?>