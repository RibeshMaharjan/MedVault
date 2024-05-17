



<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
        <?php include 'includes/dashboard.php'; ?>
            <div class="container-fluid bg-white">
                <?= alertmessage()?>    
                <div class="row px-3 p-4">
                    <div class="col"><h1 class="fw-normal mb-3">Append Medicine From</h1></div>
                </div>
                <div class="row px-3 pb-4">
                    <form action="php/medicine-add.php" class="form" method="POST" id="form" autocomplete="off">
                        <div class="mb-3">
                            <label for="name" class="form-label">Medicine Name</label>
                            <input class="form-control" type="text" aria-label="default input example" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" rows="3" name='description' id=""></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control"  name="quantity">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="category">
                                <option selected value="Not Selected">Category</option>
                                <?php
                                $result = getAll('user_category_tbl');
                                while($category = mysqli_fetch_assoc($result)){
                                    echo '<option value="'.$category['c_id'].'" >'.$category['category_name'].'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="buy_price" class="form-label">Buying Price</label>
                            <input type="number" class="form-control" name="buy_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="sell_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control" name="sell_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="exp_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" name="exp_date">
                        </div>
                        <input type="submit" value="Add" class="btn btn-danger" name="add-medicine">
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>

