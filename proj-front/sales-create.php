<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
        <?php include 'includes/dashboard.php'; ?>
                <div class="form-section">
                    <?= alertmessage()?>
                    <h1 style="padding: 20px 0px 50px 0px;">Sales From</h1>
                    <!-- Search box. -->
                    <style>
                        #search{
                            width: 300px;
                            height: auto;
                            font-size: larger;
                            margin: 0;
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
                            background-color: black;
                        }
                    </style>
                        <form action="" id="sales-suggest-form" method="post">
                            <input type="text" id="search" name="medicine_name" placeholder="Search" />
                            <button type="submit" class="add-btn">Add</button>
                            <div id="display"></div>
                        </form>
                    <br>
                    <!-- Suggestions will be displayed in below div. -->
                    
                    <div class="order-table">
                    <form action="php/sales-add.php" method="POST">
                        <table class="order-add-table content-table">
                            <thead>
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
    <?php include 'includes/footer.php'; ?>