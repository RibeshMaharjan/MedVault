<?php
include '../../config/function.php';

// Handle order form search
if(isset($_POST['m_name']) && strlen($_POST['m_name'])) {
    $medicine_name = $_POST['m_name'];
    $userId = $_SESSION['loggedInUser']['user_id'];
    $results = mysqli_query($conn, "SELECT m.* 
                                  FROM user_medicine_tbl m 
                                  WHERE m.pharmacy_id = '$userId'
                                  AND m.medicine_name = '$medicine_name'
                                  LIMIT 1");
    
    if($result = mysqli_fetch_assoc($results)) {
        echo '<tr>
                <td>
                    '.$result['medicine_name'].'
                    <input type="hidden" name="m_id" value="'.$result['m_id'].'">
                </td>
                <td>
                    <input type="number" class="form-control price-input" name="price" value="'.$result['buy_price'].'" readonly>
                </td>
                <td>
                    <input type="number" class="form-control quantity-input" name="quantity" value="1" min="1" max="'.$result['in_stock'].'" data-stock="'.$result['in_stock'].'">
                    <small class="text-muted">Available: '.$result['in_stock'].'</small>
                    <div class="quantity-warning"></div>
                </td>
                <td>
                    <input type="number" class="form-control total-input" name="total" value="'.$result['buy_price'].'" readonly>
                </td>
                <td>
                    <input type="date" class="form-control date-input" name="order_date" value="'.date('Y-m-d').'" required>
                    <div class="date-warning"></div>
                </td>
                <td>
                    <button type="submit" name="add-order" class="btn btn-danger submit-order-btn" data-bs-toggle="tooltip">Add Order</button>
                </td>
            </tr>';
    } else {
        echo '<tr><td colspan="6" class="text-center">Medicine not found in database</td></tr>';
    }
}

// Handle sales form search
if(isset($_POST['m2_name']) && strlen($_POST['m2_name'])) {
    $medicine_name = $_POST['m2_name'];
    $userId = $_SESSION['loggedInUser']['user_id'];
    $results = mysqli_query($conn, "SELECT m.* 
                                  FROM user_medicine_tbl m 
                                  WHERE m.pharmacy_id = '$userId'
                                  AND m.medicine_name = '$medicine_name'
                                  LIMIT 1");
    
    if($result = mysqli_fetch_assoc($results)) {
        echo '<tr>
                <td>
                    '.$result['medicine_name'].'
                    <input type="hidden" name="m_id" value="'.$result['m_id'].'">
                </td>
                <td>
                    <input type="number" class="form-control price-input" name="sellprice" value="'.$result['sell_price'].'" readonly>
                </td>
                <td>
                    <input type="number" class="form-control quantity-input" name="quantity" value="1" min="1" max="'.$result['in_stock'].'" data-stock="'.$result['in_stock'].'">
                    <small class="text-muted">Available: '.$result['in_stock'].'</small>
                    <div class="quantity-warning"></div>
                </td>
                <td>
                    <input type="number" class="form-control total-input" name="total" value="'.$result['sell_price'].'" readonly>
                </td>
                <td>
                    <input type="date" class="form-control date-input" name="sales_date" value="'.date('Y-m-d').'" required>
                    <div class="date-warning"></div>
                </td>
                <td>
                    <button type="submit" name="add-sales" class="btn btn-danger submit-order-btn">Add Sale</button>
                </td>
            </tr>';
    } else {
        echo '<tr><td colspan="6" class="text-center">Medicine not found in database</td></tr>';
    }
}
?>