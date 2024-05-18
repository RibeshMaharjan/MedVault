<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
            <div class="container-fluid p-4 bg-body-tertiary">
                <div class="row p-4 bg-white">
                    <?= alertmessage()?>
                    <div class="col"><h1 class="fw-normal mb-3">Order Table</h1></div>
                    <!-- Search box. -->
                    <style>
                        #search{
                            width: 300px;
                            height: auto;
                            font-size: larger;
                            margin: 0;
                            border-bottom-right-radius: 0px;
                            border-bottom-left-radius: 0px;
                        }
                        .add-btn{
                            background-color: #0d6efd;
                            width: 100px;
                            height: auto;
                            color: white;
                            padding: 10px 10px;
                            border-radius: 5px;
                            box-sizing: border-box;
                            text-align: center;
                            cursor: pointer;
                            transition: transform .2s;
                        }

                        .add-btn:hover{
                            transform: scale(1.1);
                        }
                        .submit-btn{
                            margin-top: 50px;
                        }
                    </style>
                        <form action="" id="order-suggest-form" method="post" class="d-flex">
                            <input class="form-control me-4 " type="text" id="search" name="medicine_name" placeholder="Search">
                            <button type="submit" class="btn btn-outline-danger">Add</button>
                            
                        </form>
                        <div id="display"></div>
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