<?php
    include_once('../../config/function.php');

    if(isset($_POST['update-order'])){
        $order_id = $_POST['o_id'];
        $quantity = $_POST['quantity'];
        $status = $_POST['status'];
        $date = $_POST['date'];

        $query = "UPDATE user_order_tbl SET 
                    quantity = '$quantity',
                    status = '$status',
                    order_date = '$date'
                    WHERE o_id='$order_id'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../order-display.php','Order Added Successfully');
        }
        else{
            redirect('../order-display.php','Could Not Update Order');
        }
    }
?>
    <form action="" method="POST" enctype="multipart/form-data">
        <?php
            $paraResult = checkParamId("o_id");
            if (!is_numeric($paraResult)) {
                echo '<h5>'.$paraReult.'<br /></h5>';
                return;
            }
            $order = getById('user_order_tbl','o_id',checkParamId("o_id"));
            if($order['status'] == 200)
            {
        ?>
        <h1>Append Order From</h1>
            <input type="hidden" name="o_id" value="<?=$order['data']['o_id']?>">
            <label for="quantity">Quanitity</label>
            <input type="text"  name="quantity" value="<?=$order['data']['quantity']?>"><br>
            <label for="statys">Status</label>
            <input type="text"  name="status" value="<?=$order['data']['status']?>"><br>
            <label for="date">Date</label>
            <input type="date" value="<?=$order['data']['order_date']?>" name="date"><br>
            <input type="submit" value="Submit Order" name="update-order">
        <?php
        }
        else
        {
            echo '<h5'.$order['message'].'</h5>';
        }
        ?>
    </form>