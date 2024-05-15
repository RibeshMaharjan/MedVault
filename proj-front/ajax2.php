<?php
    include_once '../config/function.php';

    if(isset($_POST['m_name']) && strlen($_POST['m_name']))
    {
    $medicine_name = $_POST['m_name'];
    $results = getById('user_medicine_tbl','medicine_name',$medicine_name);

        if ($results['status'] == 200) {
            
            echo '
            <tr>
                <input type="hidden" name="m_id" value="'.$results['data']['m_id'].'">
                <td id="m_name">'.$results['data']['medicine_name'].'</td>
                <td>
                    <input type="text"  name="price" value="'.$results['data']['buy_price'].'">
                </td>
                <td id="s_qty">
                    <input type="text"  name="quantity" value="1">
                </td>
                <td>
                    <input type="text"  name="total" value="'.$results['data']['buy_price'].'">
                </td>
                <td>
                    <input type="date" class="input" name="order_date">
                </td>
                <td>
                    <div class="button" style="background-color: limegreen;">
                        <button type="submit" style="border:none;background-color: transparent; color: white;" name="add-order">Submit</button>
                    </div>
                </td>
            </tr>';
        }else{
            echo '<tr><td>product name not resgister in database</td></tr>';
        }

    // echo json_encode($html);
    }

    if(isset($_POST['m2_name']) && strlen($_POST['m2_name']))
    {
    $medicine_name = $_POST['m2_name'];
    $results = getById('user_medicine_tbl','medicine_name',$medicine_name);

        if ($results['status'] == 200) {
            echo '
            <tr>
                <input type="hidden" name="m_id" value="'.$results['data']['m_id'].'">
                <td id="m_name">'.$results['data']['medicine_name'].'</td>
                <td>
                    <input type="text"  name="sellprice" value="'.$results['data']['sell_price'].'">
                </td>
                <td id="s_qty">
                    <input type="text"  name="quantity" value="1">
                </td>
                <td>
                    <input type="text"  name="total" value="'.$results['data']['sell_price'].'">
                </td>
                <td>
                    <input type="date" class="input" name="sales_date">
                </td>
                <td>
                <div class="button" style="background-color: limegreen;">
                        <button type="submit" style="border:none;background-color: transparent; color: white;" name="add-sales">Submit</button>
                    </div>
                </td>
            </tr>';
        }else{
            echo '<tr><td>product name not resgister in database</td></tr>';
        }

    // echo json_encode($html);
    }
?>