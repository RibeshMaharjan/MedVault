<?php
    $servername = "localhost";
    $username   = "root";
    $password   = ""; 
    $dbname     = "pharmacy";
    
    $conn = mysqli_connect($servername,$username,$password,$dbname);
    if($conn)
    {
        // echo "Connection ok<br>";
    }
    else
    {
        echo "Connection fail".mysqli_connect_error();
    }
?>