<?php include './includes/header.php'; ?>
        <div class="dashboard-content px-3 pt-4 ">
            <?php include 'includes/dashboard.php'; ?>

            <div class="container-fluid bg-white">
                <div class="row px-3 p-4">
                <div class="row px-3">
                    </div>
                    <div class="col"><h1 class="fw-normal mb-3">Append Medicine From</h1></div>
                </div>
                <div class="row px-3 pb-4">
                    <form action="php/medicine-add.php" class="form" method="POST" id="form" autocomplete="off" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Medicine Name</label>
                            <input class="form-control" type="text" placeholder="Medicine Name" aria-label="default input example" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Medicine description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">Select Category</option>
                                <?php
                                //                                    $categories = getAll('user_category_tbl');
                                                                    $user_id = $_SESSION['loggedInUser']['user_id'];

                                                                    $query = "SELECT * FROM user_category_tbl WHERE pharmacy_id = $user_id";
                                                                    $result = mysqli_query($conn,$query);
                                                                    while($cat = mysqli_fetch_assoc($result)){
                                                                        echo '<option value="'.$cat['c_id'].'">'.$cat['category_name'].'</option>';
                                                                    }
                                                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Buy Price</label>
                            <input type="text" class="form-control" placeholder="Buy Price" name="buy_price">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Sell Price</label>
                            <input type="text" class="form-control" placeholder="Sell Price" name="sell_price">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" placeholder="Quantity" name="quantity">
                        </div>
                        <div class="mb-3">
                            <label for="exp_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" name="exp_date">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image</label>
                            <input class="form-control" type="file" name="images" id="inputTag">
                        </div>
                        <input type="submit" value="Add" class="btn btn-danger" name="add-medicine">
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>