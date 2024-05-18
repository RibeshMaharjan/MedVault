<?php include './includes/header.php'; ?>

    <div class="dashboard-content px-3 pt-4 ">
    <?php
        alertmessage();
        $orders = getAll('order_completed');

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
                    <th scope="col">ORDER STATUS</th>
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
                            <td><p id="status" class="btn m-0 text-light" style="background-color: red;"><?= $result['order_status'] ?></p></td>
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


<?php include './includes/header.php'; ?>
        <div class="table">
            <div class="display-element ordercompleted-table" id="order-orderdisplay"  style="display: block;">
                <?php
                    alertmessage();
                    $orders = getAll('order_completed');

                    if(mysqli_num_rows($orders) > 0)
                    {
                ?>
                        <h1 style="padding: 20px 0px 40px 0px;">Order Table</h1>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>ORDER ID</th>
                                <th>USER ID</th>
                                <th>MEDICINE ID</th>
                                <th>INVOICE</th>
                                <th>TOTAL PRODUCTS</th>
                                <th>TOTAL AMOUNT</th>
                                <th>ORDER STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php 
                    while($result = mysqli_fetch_assoc($orders)){
                        ?> <tr>
                                    <td><?= $result['order_id'] ?></td>
                                    <td><?= $result['user_id'] ?></td>
                                    <td><?= $result['medicine_id'] ?></td>
                                    <td><?= $result['invoice_number'] ?></td>
                                    <td><?= $result['total_products'] ?></td>
                                    <td><?= $result['amount'] ?></td>
                                    <td><p id="status" style="background-color: limegreen;"><?= $result['order_status'] ?></p></td>
                                </tr>
                        <?php
                        }
                    }
                    else{
                        echo "<h4 style='font-size: 26px; text-align: center;'>No Data Found!</h4>";
                    }
                ?>
                    </tbody>
                    </table>
            </div>

            
        </div>
    </div>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/dropmenu.js"></script>
</body>
</html>