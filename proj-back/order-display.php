<?php include './includes/header.php'; ?>

    <div class="dashboard-content px-3 pt-4 ">
    <?php
        alertmessage();
        $orders = getAll('user_orders');

        if(mysqli_num_rows($orders) > 0)
        {
    ?>
    <div class="container-fluid bg-white ">
        <div class="row px-3 pt-4">
            <div class="col"><h1 class="fw-normal mb-3">Order Table</h1></div>
        </div>
        <div class="table-responsive px-3 pt-4 mb-5">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr>
                    <th scope="col">ORDER ID</th>
                                <th scope="col">USER ID</th>
                                <th scope="col">MEDICINE ID</th>
                                <th scope="col">INVOICE</th>
                                <th scope="col">TOTAL PRODUCTS</th>
                                <th scope="col">TOTAL AMOUNT</th>
                                <th scope="col">ORDER DATE</th>
                                <th scope="col">ORDER STATUS</th>
                                <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    while($result = mysqli_fetch_assoc($orders)){
                        ?>
                        <tr>
                            <td><?= $result['order_id'] ?></td>
                            <td><?= $result['user_id'] ?></td>
                            <td><?= $result['medicine_id'] ?></td>
                            <td><?= $result['invoice_number'] ?></td>
                            <td><?= $result['total_products'] ?></td>
                            <td><?= $result['amount'] ?></td>
                            <td><?= $result['order_date'] ?></td>
                            <td><p id="status" class="btn m-0 w-75 text-light px-3 py-2 my-2" style="background-color: <?= ($result['order_status'] == 'COMPLETED') ? 'red' : 'grey' ?>;"><?= $result['order_status'] ?></p></td>
                            <?php
                                if($result['order_status'] != 'COMPLETED'){
                                    ?>
                                    <td class="row g-0 ">
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="order-approve-code.php?order_id=<?= $result['order_id'] ?>"><button class="btn btn-success btn-md px-3 py-2 my-2"><i class="fa-solid fa-check"></i></button></a>
                                        </div>
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="order-delete.php?order_id=<?= $result['order_id'] ?>"  onclick="return confirm('You want to delete the data?')"><button class="btn btn-danger btn-md px-3 py-2 my-2 btn-md"><i class="fa-solid fa-xmark"></i></button></a>
                                        </div>
                                    </td>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <td></td>
                                        <?php
                                    }
                            ?>
                                </tr>
                                <?php
                        }
                    }
                    else{
                        ?>
                        <tr>
                            <td colspan='7'>No Data Found</td>
                        </tr>
                    <?php
                        }
                    
                ?>
            </tbody>
        </table>
        </div>
    </div>
    
    </div>
<?php include './includes/footer.php'; ?>