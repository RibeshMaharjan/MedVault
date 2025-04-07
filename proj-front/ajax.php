<?php

include '../config/function.php';
$userId = $_SESSION['loggedInUser']['user_id'];

if (isset($_POST['search'])) {
    $Name = $_POST['search'];
    $Query = "SELECT m.*, m.in_stock as in_stock 
              FROM user_medicine_tbl m 
              WHERE m.pharmacy_id = $userId 
              AND m.medicine_name LIKE '%$Name%' 
              LIMIT 5";

    $ExecQuery = MySQLi_query($conn, $Query);

    if (mysqli_num_rows($ExecQuery) > 0) {
        echo '<ul class="list-group shadow-sm">';
        while ($Result = MySQLi_fetch_array($ExecQuery)) {
            ?>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" 
                onclick="fill('<?php echo $Result['medicine_name']; ?>')">
                <div>
                    <strong><?php echo $Result['medicine_name']; ?></strong>
                    <small class="d-block text-muted">Price: Rs.<?php echo $Result['sell_price']; ?></small>
                </div>
                <span class="badge <?php echo ($Result['in_stock'] > 0) ? 'bg-success' : 'bg-danger'; ?> rounded-pill">
                    Stock: <?php echo $Result['in_stock']; ?>
                </span>
            </li>
            <?php
        }
        echo '</ul>';
    } else {
        echo '<div class="list-group-item text-center text-muted">No medicines found</div>';
    }
}
?>

<?php 

if(isset($_POST['m_name']) && strlen($_POST['m_name']))
{
$medicine_name = $_POST['m_name'];
$results = getById('user_medicine_tbl','medicine_name',$medicine_name);
if($results){

    echo '
        <tr>
            <td id="m_name"'.$results['medicine_name'].'></td>
                <input class="form-control" type="hidden" name="s_id" value="'.$result['m_id'].'">
                <td>
                <input type="text" class="form-control" name="price" value="'.$result['buy_price'].'">
                </td>
            <td id="s_qty">
            <input type="text" class="form-control" name="quantity" value="1">
                </td>
                <td>
                <input type="text" class="form-control" name="total" value="'.$result['buy_price'].'">
                </td>
                <td>
                <input type="date" class="form-control datePicker" name="date" data-date data-date-format="yyyy-mm-dd">
                </td>
                <td>
                <button type="submit" name="add_sale" class="btn btn-primary">Add sale</button>
                </td>
        </tr>';
} else {
    echo '<tr><td>product name not resgister in database</td></tr>';
}

// echo json_encode($html);
}

?>