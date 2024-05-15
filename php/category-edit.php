<?php
    include '../../config/function.php';

    $paraResult = checkParamId('c_id');

    if(isset($_POST['update-category'])){
        $category_id = $_POST['c_id'];
        $category_name = $_POST['category-name'];

        $query = "UPDATE user_category_tbl SET category_name='$category_name' WHERE c_id=$category_id";

        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../category.php','Cateogry Updated Successfully');
        }
        else{
            redirect('../cateogory.php','Could Not Update Cateogry');
        }
    }
?>

    <form action="category-edit.php" method="post">
        <?php
            $paraResult = checkParamId("c_id");
            if (!is_numeric($paraResult)) {
                echo '<h5>'.$paraReult.'<br /></h5>';
                return;
            }
            $category = getById('user_category_tbl','c_id',checkParamId("c_id"));
            if($category['status'] == 200)
            {
        ?>
        <input type="hidden" name="c_id" value="<?= $category['data']['c_id'] ?>">
        <input type="text" name="category-name" value="<?= $category['data']['category_name'] ?>" placeholder="Category Name">
        <button type="submit" name="update-category">Update</button>
        <?php
        }
        else
        {
            echo '<h5'.$category['message'].'</h5>';
        }
        ?>
    </form>