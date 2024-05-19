<?php include './includes/header.php'; ?>

    <div class="dashboard-content px-3 pt-4 ">
    <?php
        alertmessage();
    ?>
        <div class="row px-3 pt-4 mb-5">
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title ">Total Admins</h5>
                        <p class="card-text text-danger float-end h3 fs-3 "><?= getTotal("tbl_admin"); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title ">Total Users</h5>
                        <p class="card-text text-danger float-end h3 fs-3 "><?= getTotal("tbl_pharmacy"); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title ">Total Order Pendings</h5>
                        <p class="card-text text-danger float-end h3 fs-3 "><?= getTotal("order_pending"); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title ">Total Order Completed</h5>
                        <p class="card-text text-danger float-end h3 fs-3 "><?= getTotal("order_completed"); ?></p>
                    </div>
                </div>
            </div>
            <div class="row py-5">
                <div class="col-3">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title ">Total Order</h5>
                            <p class="card-text text-danger float-end h3 fs-3 "><?= getTotal("user_orders"); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
<?php include './includes/footer.php'; ?>