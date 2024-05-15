<?php

session_start();

    echo $_SESSION['username'];

    if(isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
        
        echo "Welcome, $username! Your user ID is $user_id.";
    } else {
        echo "Session data not found.";
    }
?>
