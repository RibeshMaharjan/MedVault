<?php
    include '../../config/function.php';
    $user_id = $_SESSION['loggedInUser']['user_id'];

    if(isset($_POST['submit-category'])){
        $category_name = validate(trim($_POST["category-name"]));

        $query = "INSERT INTO user_category_tbl VALUES('', '$user_id', '$category_name')";
        $data = mysqli_query($conn, $query);

        if ($data) {
            redirect('../category.php','Category Added');
        }
        else{
            redirect('../category.php','Category Culd Not Added');
        }
    }

?>