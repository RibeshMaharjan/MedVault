<?php include './includes/header.php'; ?>
    <div class="inventorybody">
        <?php include 'includes/dashboard.php'; ?>
        <div class="dashboard-content container pt-4 ">
            <div class="row pt-4 mb-5">
                <div class="col">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title ">Total Medicine</h5>
                            <p class="card-text text-danger float-end h3 fs-3 "><?= getTotalById("user_medicine_tbl","pharmacy_id",$user_id); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title ">Total Category</h5>
                            <p class="card-text text-danger float-end h3 fs-3 "><?= getTotalById("user_category_tbl","pharmacy_id",$user_id); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title">Total Order Pendings</h5>
                            <p class="card-text text-danger float-end h3 fs-3 "><?= getTotalById("user_order_tbl","pharmacy_id",$user_id); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title ">Total Sales</h5>
                            <p class="card-text text-danger float-end h3 fs-3 "><?= getTotalById("user_sales_tbl","pharmacy_id",$user_id); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include './includes/footer.php'; ?>