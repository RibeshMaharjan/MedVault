<?php
    include_once('../../config/function.php');

    if(isset($_POST['update-medicine'])){
        $medicine_id = $_POST['update_id'];
        $medicine_name = $_POST['name'];
        $medicine_desc = $_POST['description'];
        $category = $_POST['category'];
        $in_stock = $_POST['in_stock'];
        $buy_price = $_POST['buy_price'];
        $sell_price = $_POST['sell_price'];
        $exp_date = $_POST['exp_date'];
        $formatted_Date = date("Y-m-d", strtotime($exp_date));

        if($category == '' && $medicine_name ='' && $description ='' && $instock ='' && $buy_price ='' && $sell_price ='' && $exp_date =''){
            redirect('../medicine-display.php','Fill All the Field');
            exit();
        }

        if(!preg_match("/^[a-zA-Z0-9_-]*$/", $medicine_name)) {
            redirect('../medicine-display.php','Medicine name can only contain letters, numbers, hyphens and underscores.');
            exit();
        }

        if (!preg_match("/^[0-9]+$/", $in_stock)) {
            redirect('../medicine-display.php','Quantity can only contain numbers.');
            exit();
        }

        if (!preg_match("/^[0-9]+$/", $buy_price)) {
            redirect('../medicine-display.php','Buy price can only contain numbers.');
            exit();
        }

        if (!preg_match("/^[0-9]+$/", $sell_price)) {
            redirect('../medicine-display.php','Sell price can only contain numbers.');
            exit();
        }

        if($buy_price >= $sell_price){
          redirect('../medicine-display.php','Buy price must be greater than sell price.');
          exit();
        }

        $today = new DateTime();
        $oneMonthLater = (clone $today)->modify('+1 month')->format('Y-m-d');

        if ($formatted_Date <= $oneMonthLater) {
            redirect('../medicine-display.php', 'Expiry date must be more than one month from today.');
            exit();
        }

        $query = "UPDATE user_medicine_tbl SET 
                    medicine_name = '$medicine_name',
                    medicine_desc = '$medicine_desc',
                    c_id = '$category',
                    in_stock = '$in_stock',
                    buy_price = '$buy_price',
                    sell_price = '$sell_price',
                    exp_date = '$formatted_Date'
                    WHERE m_id='$medicine_id'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../medicine-display.php', 'Medicine updated successfully');
        } else {
            redirect('../medicine-display.php', 'Could not update medicine');
        }
    }
?>

<?php
if(isset($_GET['medicine_id'])) {
    $paraResult = checkParamId("medicine_id");
    if (!is_numeric($paraResult)) {
        echo '<h5>' . $paraResult . '</h5>';
        return;
    }
    $medicine = getById('user_medicine_tbl', 'm_id', $paraResult);
    if($medicine['status'] == 200) {
?>
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Update Medicine Form</h1>
        <input type="hidden" name="update_id" value="<?=$medicine['data']['m_id']?>">
        <div class="input_field">
            <label for="name">Medicine Name</label>
            <input type="text" class="input" name="name" value="<?=$medicine['data']['medicine_name']?>" required>
        </div>
        <div class="input_field">
            <label for="description">Description</label>
            <textarea class="input" name="description" required><?=$medicine['data']['medicine_desc']?></textarea>
        </div>
        <div class="input_field">
            <label for="category">Category</label>
            <select class="selectbox" name="category" required>
                <option value="">Select Category</option>
                <?php
                    $categories = getAll('user_category_tbl');
                    while($cat = mysqli_fetch_assoc($categories)){
                        $selected = ($medicine['data']['c_id'] == $cat['c_id']) ? 'selected' : '';
                        echo '<option value="'.$cat['c_id'].'" '.$selected.'>'.$cat['category_name'].'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="input_field">
            <label for="in_stock">In Stock</label>
            <input type="number" class="input" name="in_stock" value="<?=$medicine['data']['in_stock']?>" required>
        </div>
        <div class="input_field">
            <label for="buy_price">Buy Price</label>
            <input type="number" class="input" name="buy_price" value="<?=$medicine['data']['buy_price']?>" required>
        </div>
        <div class="input_field">
            <label for="sell_price">Sell Price</label>
            <input type="number" class="input" name="sell_price" value="<?=$medicine['data']['sell_price']?>" required>
        </div>
        <div class="input_field">
            <label for="exp_date">Expiration Date</label>
            <input type="date" class="input" name="exp_date" value="<?=$medicine['data']['exp_date']?>" required>
        </div>
        <div class="input_field">
            <input type="submit" value="Update" class="btn" name="update-medicine">
        </div>
    </form>
<?php
    } else {
        echo "<h5>" . $medicine['message'] . "</h5>";
    }
}
?>