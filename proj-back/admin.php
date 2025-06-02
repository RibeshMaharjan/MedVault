<?php include './includes/header.php'; ?>
    <div class="main-container d-flex h-auto">
        <div class="container-fluid p-0 pt-3">
            <div class="dashboard-content bg-white py-3">
                <div class="row px-3 mb-5">
                    <div class="col col-12 mb-3 mb-md-0 col-md-3">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title ">Total Admins</h5>
                                <p class="card-text text-danger float-end h3 fs-3 "><?= getTotal("tbl_admin"); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title ">Total Users</h5>
                                <p class="card-text text-danger float-end h3 fs-3 "><?= getTotal("tbl_pharmacy"); ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title ">Total Order Pendings</h5>
                                <p class="card-text text-danger float-end h3 fs-3 "><?php //  getTotal("order_pending"); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body">
                                <h5 class="card-title ">Total Order Completed</h5>
                                <p class="card-text text-danger float-end h3 fs-3 "><?php // getTotal("order_completed"); ?></p>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="row py-5">
                        <div class="col-3">
                            <div class="card border-0 shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title ">Total Order</h5>
                                    <p class="card-text text-danger float-end h3 fs-3 "><?php // getTotal("user_orders"); ?></p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
<?php include './includes/footer.php'; ?>