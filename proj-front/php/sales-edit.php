<?php
    include '../../config/function.php';

    if(isset($_POST['update-sales'])){
        $sales_id = $_POST['s_id'];
        $quantity = $_POST['quantity'];
        $status = $_POST['status'];
        $date = $_POST['date'];

        $query = "UPDATE user_sales_tbl SET 
                    quantity = '$quantity',
                    status = '$status',
                    sales_date = '$date'
                    WHERE s_id='$sales_id'";
        $data = mysqli_query($conn,$query);

        if($data){
            redirect('../sales-display.php','Sales Added Successfully');
        }
        else{
            redirect('../sales-display.php','Could Not Update Sales');
        }
    }
?>
<form action="" method="post">
    <?php
        $paraResult = checkParamId("s_id");
        if (!is_numeric($paraResult)) {
            echo '<h5>'.$paraReult.'<br /></h5>';
            return;
        }
        $sales = getById('user_sales_tbl','s_id',checkParamId("s_id"));
        if($sales['status'] == 200)
        {
    ?>
    <h1>Append Sales From</h1>
        <input type="hidden" name="s_id" value="<?=$sales['data']['s_id']?>">
        <label for="quantity">Quanitity</label>
        <input type="text"  name="quantity" value="<?=$sales['data']['quantity']?>"><br>
        <label for="statys">Status</label>
        <input type="text"  name="status" value="<?=$sales['data']['status']?>"><br>
        <label for="date">Date</label>
        <input type="date" value="<?=$sales['data']['sales_date']?>" name="date"><br>
        <input type="submit" value="Submit Order" name="update-sales">
    <?php
        }
        else
        {
            echo '<h5'.$order['message'].'</h5>';
        }
        ?>
</form>