<?php include './includes/header.php'; ?>
<div class="container py-5">
    <div class="row">
        <div class="col"><h1 class="fw-normal mb-3">Carts</h1></div>
        <div class="col"><a class="text-white text-decoration-none float-end" href='php/remove-cart.php?removeall=1'  onclick="return confirm('You want to delete the data?')"><button class="btn btn-danger btn-danger-soft">Empty Cart</button></a></div>
    </div>
    <?php
        alertmessage();
        $user_id = $_SESSION['loggedInUser']['user_id'];
        $cartquery = "SELECT * FROM cart WHERE pharmacy_id = '$user_id'" ; 
        $queryresult = mysqli_query($conn, $cartquery);
    ?>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-danger">
            <tr>
                <th scope="col">#</th>
                <th scope="col">MEDICINE</th>
                <th scope="col">PRICE</th>
                <th scope="col">QUANTITY</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody class="fs-5  ">
        <?php 
            if(mysqli_num_rows($queryresult) > 0)
            $i=1;
            {
                while($result = mysqli_fetch_assoc($queryresult)){
                    $medicine = getById('tbl_medicine','medicine_id',$result['medicine_id']);
        ?>
            
            <tr>
            <th scope="row"><?php echo $i++; ?></th>
            <td><?= $medicine['data']['medicine_name'] ?></td>
            <td><?= $medicine['data']['price'] ?></td>
            <td><?= $result['quantity'] ?></td>
            <td class="row g-0 ">
                <div class="col">
                <a class="text-white text-decoration-none " href="buy.php?medicine_id=<?= $medicine['data']['medicine_id'] ?>"><button class="btn btn-success btn-md px-5 my-buy-button">Buy</button></a>
                </div>
                <div class="col">
                <a class="text-white text-decoration-none " id='cart_btn' href='php/remove-cart.php?medicine_id=<?=$medicine['data']['medicine_id'] ?>'  onclick="return confirm('You want to delete the data?')"><button class="btn btn-danger btn-md my-buy-button">REMOVE</button></a>
                </div>
            </td>
            </tr>
    <?php
                    }
                }
            ?>
        </tbody>
    </table>
    </div>
</div>
<!-- include footer -->
<?php include 'includes/footer.php'; ?>