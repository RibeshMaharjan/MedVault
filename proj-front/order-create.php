<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
            <div class="container-fluid p-4 bg-body-tertiary">
                <div class="row p-4 bg-white">
                    <div class="col">
                        <div class="row px-3">
                            <?php
                                alertmessage();
                            ?>
                        </div>
                        <h1 class="fw-normal mb-3">Order Table</h1>
                    </div>
                    <!-- Search box. -->
                        <div class="row">
                            <div class="col-xl-3">
                                <form action="" id="order-suggest-form" method="post" class="d-flex ">
                                    <input class="form-control me-4" type="text" id="search" name="medicine_name" placeholder="Search">
                                    <button type="submit" class="btn btn-outline-danger">Add</button>
                                </form>
                                <div id="display">
                                </div>
                            </div>
                        </div>
                    <br>
                    <!-- Suggestions will be displayed in below div. -->

                    <div class="table-responsive pt-4 mb-5">
                    <form action="php/order-add.php" method="POST">
                        <table class="table table-striped">
                            <thead class="table-danger">
                                <tr>
                                    <th>MEDICINE NAME</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL</th>
                                    <th>DATE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="product-info">
                                    
                            </tbody>
                        </table>
                    </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>