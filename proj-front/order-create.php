<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
        <?php include 'includes/dashboard.php'; ?>
                <div class="form-section">
                    <?= alertmessage()?>
                    <h1 style="padding: 20px 0px 50px 0px;">Order From</h1>
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
                        <form action="" id="order-suggest-form" method="post">
                            <input type="text" id="search" name="medicine_name" placeholder="Search">
                            <button type="submit" class="add-btn">Add</button>
                            <div id="display"></div>
                        </form>
                    <br>
                    <!-- Suggestions will be displayed in below div. -->

                    <div class="order-table">
                    <form action="php/order-add.php" method="POST">
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
                    <!-- <form action="code.php" class="form" method="POST" id="user-form">
                        <div class="input_field">
                            <label>Pharmacy Name</label>
                            <input type="text" class="input" name="name" required>
                        </div>
                        <div class="input_field">
                            <label for="email">Email</label>
                            <input type="email" class="input" name="email" placeholder="">
                        </div>
                        <div class="input_field">
                            <label for="password">Password</label>
                            <input type="text" class="input" name="password">
                        </div>
                        <div class="input_field">
                            <label for="phone">Phone</label>
                            <input type="text" class="input" maxlength="10" name="phone">
                        </div>
                        <div class="input_field">
                            <label for="address">Address</label>
                            <input type="text" class="input" name="address">
                        </div>
                            <input type="submit" value="Add" class="btn" name="add-user">
                    </form> -->
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>