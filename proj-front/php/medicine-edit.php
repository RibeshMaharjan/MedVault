<?php
    include_once('../../config/function.php');

    if(isset($_POST['update-medicine'])){
        $medicine_id = $_POST['m_id'];
        $medicine_name = $_POST['name'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $buy_price = $_POST['buy_price'];
        $sell_price = $_POST['sell_price'];

        $query = "UPDATE user_medicine_tbl SET 
                    medicine_name = '$medicine_name',
                    medicine_desc = '$description',
                    c_id = '$category',
                    buy_price = '$buy_price',
                    sell_price = '$sell_price'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../medicine-display.php','Medicine Added Successfully');
        }
        else{
            redirect('../medicine-display.php','Could Not Update Medicine');
        }
    }
?>
    <form action="" method="POST" enctype="multipart/form-data">
        <?php
            $paraResult = checkParamId("m_id");
            if (!is_numeric($paraResult)) {
                echo '<h5>'.$paraReult.'<br /></h5>';
                return;
            }
            $medicine = getById('user_medicine_tbl','m_id',checkParamId("m_id"));
            if($medicine['status'] == 200)
            {
        ?>
        <h1>Append Medicine From</h1>
        <input type="hidden" name="m_id" value="<?=$medicine['data']['m_id']?>">
        <div class="input_field">
                        <label for="name">Medicine Name</label>
                        <input type="text" class="input" name="name" value="<?=$medicine['data']['medicine_name']?>" required>
                    </div>
                    <div class="input_field">
                        <label for="description">Description</label>
                        <input type="text" class="input" name="description" value="<?=$medicine['data']['medicine_desc']?>">
                    </div>
                    <div class="input_field">
                        <label for="category">Category</label>
                        <select class="selectbox" name="category">
                            <?php
                                $result = getAll('user_category_tbl');
                                while($category = mysqli_fetch_assoc($result)){
                                    echo '<option value='.$category['c_id'].' value="'. ($medicine['data']['c_id'] == $category['c_id'] ? 'selected' : '') .'" >'.$category['category_name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input_field">
                        <label for="buy_price">Buying Price</label>
                        <input type="number" class="input" name="buy_price" value="<?=$medicine['data']['buy_price']?>" required>
                    </div>
                    <div class="input_field">
                        <label for="sell_price">Selling Price</label>
                        <input type="number" class="input" name="sell_price"  value="<?=$medicine['data']['sell_price']?>" required>
                    </div>
        <div class="input_field">
            <input type="submit" value="Add" class="btn" name="update-medicine">
        </div>
        <?php
        }
        else
        {
            echo '<h5'.$medicine['message'].'</h5>';
        }
        ?>
    </form>