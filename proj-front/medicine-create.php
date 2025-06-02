<?php include './includes/header.php'; ?>
        <div class="dashboard-content">
            <?php include 'includes/dashboard.php'; ?>
            <?php
                $formData = [
                    'name' => '',
                    'description' => '',
                    'category' => '',
                    'buy_price' => '',
                    'sell_price' => '',
                    'quantity' => '',
                    'exp_date' => ''
                ];

                // If redirected and form data is stored
                if (isset($_SESSION['form_data'])) {
                    $formData = $_SESSION['form_data'];
                    unset($_SESSION['form_data']); // Clear after use
                }
            ?>
            <div class="container-fluid max-vh-100 overflow-auto" style="max-height: 100vh; !important;">
                <?php include 'includes/navbar.php'; ?>
                <div class="row mt-2 mt-md-0 p-0 px-md-3 p-md-4">
                <div class="row p-0 px-md-3">
                    </div>
                    <div class="col"><h1 class="fw-normal mb-3">Append Medicine From</h1></div>
                </div>
                <div class="row p-0 px-md-3 pb-md-4">
                    <form action="php/medicine-add.php" class="form" method="POST" id="form" autocomplete="off" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Medicine Name</label>
                            <input class="form-control" type="text" placeholder="Medicine Name" aria-label="default input example" name="name" value="<?= htmlspecialchars($formData['name'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Medicine description" name="description"><?= htmlspecialchars($formData['description'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">Select Category</option>
                                <?php
                                    // $categories = getAll('user_category_tbl');
                                    $user_id = $_SESSION['loggedInUser']['user_id'];

                                    $query = "SELECT * FROM user_category_tbl WHERE pharmacy_id = $user_id";
                                    $result = mysqli_query($conn,$query);
                                    while($cat = mysqli_fetch_assoc($result)){
                                        echo '<option value="'.$cat['c_id'].'" '. ($cat['c_id'] == $formData['category'] ? 'selected' : '') .'>'.$cat['category_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Buy Price</label>
                            <input type="text" class="form-control" placeholder="Buy Price" name="buy_price" value="<?= htmlspecialchars($formData['buy_price'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Sell Price</label>
                            <input type="text" class="form-control" placeholder="Sell Price" name="sell_price" value="<?= htmlspecialchars($formData['sell_price'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" placeholder="Quantity" name="quantity" value="<?= htmlspecialchars($formData['quantity'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exp_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" name="exp_date" value="<?= htmlspecialchars($formData['exp_date'] ?? '') ?>">
                        </div>
                        <input type="submit" value="Add" class="btn btn-danger" name="add-medicine">
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>