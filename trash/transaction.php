<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-4">
            <div class="row">
                <div class="col"><h1 class="fw-normal fs-3 mb-3">Transaction Records</h1></div>
            </div>
            <?php
                $user_id = $_SESSION['loggedInUser']['user_id'];
                $orders = getAll('user_orders');

                if(mysqli_num_rows($orders) > 0)
                {
                    $i = 1;
            ?>
            <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-danger">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">DATE</th>
                        <th scope="col">INVOICE NUMBER</th>
                        <th scope="col">AMOUNT</th>
                        <th scope="col">ORDER</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        while($result = mysqli_fetch_assoc($orders)){
                                    
                            if($result['user_id'] == $user_id){
                ?>
                    
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?= $result['order_date'] ?></td>
                        <td><?= $result['invoice_number'] ?></td>
                        <td><?= $result['amount'] ?></td>
                        <td><?= $result['order_status'] ?></td>
                    </tr>
                    <?php
                                }
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
<!-- include footer -->
