<?php
    include '../../config/function.php';
    $user_id = $_SESSION['loggedInUser']['user_id'];

    if(isset($_POST['submit-category'])){
        $category_name = validate(trim($_POST["category-name"]));

        if(!preg_match("/^[a-zA-Z0-9_-]*$/", $category_name)) {
            redirect('../category.php','Category name can only contain letters, numbers, hyphens and underscores.');
        }

        $query = "INSERT INTO user_category_tbl (pharmacy_id,category_name) VALUES('$user_id', '$category_name')";
        $data = mysqli_query($conn, $query);

        if ($data) {
            redirect('../category.php','Category Added');
        }
        else{
            redirect('../category.php','Category could Not Added');
        }
    }
?>