<?php

//Including Database configuration file.

include '../config/function.php';

//Getting value of "search" variable from "script.js".

if (isset($_POST['search'])) {

//Search box value assigning to $Name variable.

    $Name = $_POST['search'];

    //Search query.

    $Query = "SELECT medicine_name FROM user_medicine_tbl WHERE medicine_name LIKE '%$Name%' LIMIT 5";

    //Query execution

    $ExecQuery = MySQLi_query($conn, $Query);

    //Creating unordered list to display result.

    echo '

    <ul class="suggestion-box" style="list-style: none;
                                        width:300px;
                                        border-radius: 0 0 5px 5px;
                                        border:1px solid black;">

    ';

    //Fetching result from database.

    while ($Result = MySQLi_fetch_array($ExecQuery)) {

        $res_name = $Result['medicine_name']; ?>

    <!-- Creating unordered list items.

            Calling javascript function named as "fill" found in "script.js" file.

            By passing fetched result as parameter. -->
            <style>
                .suggestion-list{
                    background-color: white;
                    border-radius: 0 0 5px 5px;
                    padding: 10px 5px;
                }
                .suggestion-list:hover{
                    background-color: #dddddd;
                    cursor: pointer;
                }
            </style>
    <li class="suggestion-list" style="" onclick='fill("<?php echo $res_name; ?>")'>
    <a class="suggestion-item" style="color: black;">

    <!-- Assigning searched result in "Search box" in "search.php" file. -->

        <?php echo $Result['medicine_name']; ?>

    </li></a>

    <!-- Below php code is just for closing parenthesis. Don't be confused. -->

    <?php

}}

?>

</ul>

<?php 

if(isset($_POST['m_name']) && strlen($_POST['m_name']))
{
$medicine_name = $_POST['m_name'];
$results = getById('user_medicine_tbl','medicine_name',$medicine_name);
if($results){

    echo '
        <tr>
            <td id="m_name"'.$results['medicine_name'].'></td>
                <input type="hidden" name="s_id" value="'.$result['m_id'].'">
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