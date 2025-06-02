<?php include './includes/header.php'; ?>
    <div class="dashboard-content">
    <?php include 'includes/dashboard.php'; ?>

    <?php
        // Pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = 10;

        // Filter parameters
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $category_filter = isset($_GET['category']) ? $_GET['category'] : '';
        $exp_date_from = isset($_GET['exp_date_from']) ? $_GET['exp_date_from'] : '';
        $exp_date_to = isset($_GET['exp_date_to']) ? $_GET['exp_date_to'] : '';
        $buy_price_min = isset($_GET['buy_price_min']) ? $_GET['buy_price_min'] : '';
        $buy_price_max = isset($_GET['buy_price_max']) ? $_GET['buy_price_max'] : '';
        $sell_price_min = isset($_GET['sell_price_min']) ? $_GET['sell_price_min'] : '';
        $sell_price_max = isset($_GET['sell_price_max']) ? $_GET['sell_price_max'] : '';
        $stock_min = isset($_GET['stock_min']) ? $_GET['stock_min'] : '';
        $stock_max = isset($_GET['stock_max']) ? $_GET['stock_max'] : '';

        // Build conditions
        $conditions = [];
        // Add condition to only show medicines for the current logged-in user
        if(isset($_SESSION['loggedInUser']['user_id'])) {
            $user_id = $_SESSION['loggedInUser']['user_id'];
            $conditions[] = "pharmacy_id = '$user_id'";
        }
        if ($search) {
            $conditions[] = "medicine_name LIKE '%$search%'";
        }
        if ($category_filter) {
            $conditions[] = "c_id = '$category_filter'";
        }
        if ($exp_date_from && $exp_date_to) {
            $conditions[] = "exp_date BETWEEN '$exp_date_from' AND '$exp_date_to'";
        }
        if ($buy_price_min !== '') {
            $conditions[] = "buy_price >= '$buy_price_min'";
        }
        if ($buy_price_max !== '') {
            $conditions[] = "buy_price <= '$buy_price_max'";
        }
        if ($sell_price_min !== '') {
            $conditions[] = "sell_price >= '$sell_price_min'";
        }
        if ($sell_price_max !== '') {
            $conditions[] = "sell_price <= '$sell_price_max'";
        }
        if ($stock_min !== '') {
            $conditions[] = "in_stock >= '$stock_min'";
        }
        if ($stock_max !== '') {
            $conditions[] = "in_stock <= '$stock_max'";
        }

        $where_clause = !empty($conditions) ? implode(' AND ', $conditions) : "1=1";
        $paginatedResults = getPaginatedResults('user_medicine_tbl', $where_clause, $page, $itemsPerPage);
        $medicine = $paginatedResults['data'];

        if(mysqli_num_rows($medicine) > 0)
        {
    ?>
    <!-- Edit Modal -->
    <div class="modal fade" id="medicineeditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Medicine Edit</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./php/medicine-edit.php" class="form" method="POST" id="form" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="hidden" name="update_id" id="update_id">
            <div class="mb-3">
                <label for="name" class="form-label">Medicine Name</label>
                <input class="form-control" type="text" placeholder="Medicine Name" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Select Category</option>
                    <?php
//                        $categories = getAll('user_category_tbl');
                        $query = "SELECT * FROM user_category_tbl WHERE pharmacy_id = $user_id";
                        $result = mysqli_query($conn,$query);

                        while($cat = mysqli_fetch_assoc($result)){
                            echo '<option value="'.$cat['c_id'].'">'.$cat['category_name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="in_stock" class="form-label">In Stock</label>
                <input type="number" class="form-control" id="in_stock" name="in_stock">
            </div>
            <div class="mb-3">
                <label for="buy_price" class="form-label">Buy Price</label>
                <input type="number" class="form-control" id="buy_price" name="buy_price">
            </div>
            <div class="mb-3">
                <label for="sell_price" class="form-label">Sell Price</label>
                <input type="number" class="form-control" id="sell_price" name="sell_price">
            </div>
            <div class="mb-3">
                <label for="exp_date" class="form-label">Expiration Date</label>
                <input type="date" class="form-control" id="exp_date" name="exp_date">
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="update-medicine">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="medicineDeleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Confirm Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="php/medicine-delete.php" method="POST">
            <div class="modal-body">
                <input type="hidden" name="delete_medicine_id" id="delete_medicine_id">
                <p>Are you sure you want to delete this medicine?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone.
                </div>
                <div class="medicine-details mt-3">
                    <p><strong>Medicine ID:</strong> <span id="delete_medicine_display_id"></span></p>
                    <p><strong>Medicine Name:</strong> <span id="delete_medicine_name"></span></p>
                    <p><strong>Description:</strong> <span id="delete_medicine_desc"></span></p>
                    <p><strong>In Stock:</strong> <span id="delete_medicine_stock"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger" name="delete-medicine">Delete Medicine</button>
            </div>
            </form>
            </div>
        </div>
    </div>
    <?php
        }
    ?>


    <div class="container-fluid max-vh-100 overflow-auto" style="max-height: 100vh; !important;">
          <?php include 'includes/navbar.php'; ?>
        <div class="row mt-2 mt-md-0 p-0 px-md-3 p-md-4">
            <div class="col"><h1 class="fw-normal mb-3">Medicine Table</h1></div>
        </div>

        <!-- Filter Form -->
        <div class="row p-0 px-lg-3 pb-lg-4">
            <div class="col-12">
                <form method="GET" class="row g-3">
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="search" placeholder="Search medicine name..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div class="col-lg-2">
                        <select class="form-select" name="category">
                            <option value="">All Categories</option>
                            <?php
//                                $categories = getAll('user_category_tbl');

                                $query = "SELECT * FROM user_category_tbl WHERE pharmacy_id = $user_id";
                                $result = mysqli_query($conn,$query);

                                while($cat = mysqli_fetch_assoc($result)){
                                    $selected = ($category_filter == $cat['c_id']) ? 'selected' : '';
                                    echo '<option value="'.$cat['c_id'].'" '.$selected.'>'.$cat['category_name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" name="exp_date_from" value="<?= htmlspecialchars($exp_date_from) ?>" placeholder="From Date">
                    </div>
                    <div class="col-lg-2">
                        <input type="date" class="form-control" name="exp_date_to" value="<?= htmlspecialchars($exp_date_to) ?>" placeholder="To Date">
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input type="number" class="form-control" name="buy_price_min" placeholder="Min Buy Price" value="<?= htmlspecialchars($buy_price_min) ?>">
                            <input type="number" class="form-control" name="buy_price_max" placeholder="Max Buy Price" value="<?= htmlspecialchars($buy_price_max) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input type="number" class="form-control" name="sell_price_min" placeholder="Min Sell Price" value="<?= htmlspecialchars($sell_price_min) ?>">
                            <input type="number" class="form-control" name="sell_price_max" placeholder="Max Sell Price" value="<?= htmlspecialchars($sell_price_max) ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input type="number" class="form-control" name="stock_min" placeholder="Min Stock" value="<?= htmlspecialchars($stock_min) ?>">
                            <input type="number" class="form-control" name="stock_max" placeholder="Max Stock" value="<?= htmlspecialchars($stock_max) ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-danger">Filter</button>
                        <a href="medicine-display.php" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-muted mt-2 px-3">Showing <?= ($page-1)*$itemsPerPage + 1 ?> to <?= min($page*$itemsPerPage, $paginatedResults['totalRecords']) ?> of <?= $paginatedResults['totalRecords'] ?> entries</p>

        <div class="table-responsive px-0 pt-0 px-md-3 pt-md-4 mb-5">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">MEDICINE NAME</th>
                    <th scope="col">DESCRIPTION</th>
                    <th scope="col">CATEGORY</th>
                    <th scope="col">IN STOCK</th>
                    <th scope="col">BUY PRICE</th>
                    <th scope="col">SELL PRICE</th>
                    <th scope="col">EXPIRATION DATE</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if(mysqli_num_rows($medicine) > 0) {
                    while($result = mysqli_fetch_assoc($medicine)){
                        ?>
                        <tr>
                            <?php
                            $expirationDate = new DateTime($result['exp_date']);
                            $today = new DateTime();

                            $interval = $today->diff($expirationDate);
                            $daysDifference = $interval->format('%a');

                            if ($daysDifference < 30) {
                                // Do something if the expiration date is less than 30 days from today
                                echo "<td class='bg-danger text-light '>{$result['m_id']}</td>";
                            } else {
                                // Otherwise, just display the expiration date
                                echo "<td>{$result['m_id']}</td>";
                            }
                            ?>

                            <td><?= $result['medicine_name'] ?></td>
                            <td><?= $result['medicine_desc'] ?></td>
                            <td>
                                <?php 
                                    $category = getById('user_category_tbl', 'c_id', $result['c_id']);

                                    echo ($category['status'] == 200) ? $category['data']['category_name'] : 'Unknown';
                                ?>
                            </td>
                            <td><?= $result['in_stock'] ?></td>
                            <td><?= $result['buy_price'] ?></td>
                            <td><?= $result['sell_price'] ?></td>
                            <td><?= $result['exp_date'] ?></td>
                            <td class="row g-0" style="height: 100px;">
                                <div class="col">
                                    <button class="btn btn-success btn-md px-3 py-2 my-2 medicineeditbtn" 
                                           data-id="<?= $result['m_id'] ?>"
                                           data-name="<?= $result['medicine_name'] ?>"
                                           data-description="<?= $result['medicine_desc'] ?>"
                                           data-category="<?= $result['c_id'] ?>"
                                           data-instock="<?= $result['in_stock'] ?>"
                                           data-buyprice="<?= $result['buy_price'] ?>"
                                           data-sellprice="<?= $result['sell_price'] ?>"
                                           data-expdate="<?= $result['exp_date'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-danger btn-md px-3 py-2 my-2 medicineDeleteBtn"
                                           data-id="<?= $result['m_id'] ?>"
                                           data-name="<?= $result['medicine_name'] ?>"
                                           data-description="<?= $result['medicine_desc'] ?>"
                                           data-instock="<?= $result['in_stock'] ?>">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan='9' class="text-center">No Data Found</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php 
            // Add filter parameters to pagination links
            $filter_params = http_build_query([
                'search' => $search,
                'category' => $category_filter,
                'exp_date_from' => $exp_date_from,
                'exp_date_to' => $exp_date_to,
                'buy_price_min' => $buy_price_min,
                'buy_price_max' => $buy_price_max,
                'sell_price_min' => $sell_price_min,
                'sell_price_max' => $sell_price_max,
                'stock_min' => $stock_min,
                'stock_max' => $stock_max
            ]);
            $pagination_url = '?page={page}' . ($filter_params ? '&' . $filter_params : '');

            echo generatePaginationLinks(
                $paginatedResults['currentPage'],
                $paginatedResults['totalPages'],
                $pagination_url
            );
        ?>
        </div>
    </div>

    </div>

<script>
    // Edit Modal Script
    $(document).ready(function () {
        $('.medicineeditbtn').on('click', function () {
            $('#medicineeditmodal').modal('show');

            // Get data from button attributes
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var category = $(this).data('category');
            var instock = $(this).data('instock');
            var buyprice = $(this).data('buyprice');
            var sellprice = $(this).data('sellprice');
            var expdate = $(this).data('expdate');

            // Debug to console
            console.log("Category:", category);
            console.log("Buy Price:", buyprice);
            console.log("Sell Price:", sellprice);

            // Set values in the form - with timeout to ensure modal is fully loaded
            setTimeout(function() {
                $('#update_id').val(id);
                $('#name').val(name);
                $('#description').val(description);
                $('#category').val(category);
                $('#in_stock').val(instock);
                $('#buy_price').val(buyprice);
                $('#sell_price').val(sellprice);

                // Format expiration date properly for date input (YYYY-MM-DD)
                if (expdate) {
                    var dateObj = new Date(expdate);
                    if (!isNaN(dateObj.getTime())) {
                        var year = dateObj.getFullYear();
                        var month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
                        var day = dateObj.getDate().toString().padStart(2, '0');
                        var formattedDate = year + '-' + month + '-' + day;
                        $('#exp_date').val(formattedDate);
                    } else {
                        // If date parsing fails, try direct assignment
                        $('#exp_date').val(expdate);
                    }
                }
            }, 300);
        });
    });

    // Delete Modal Script
    $(document).ready(function () {
        $('.medicineDeleteBtn').on('click', function () {
            $('#medicineDeleteModal').modal('show');

            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var instock = $(this).data('instock');

            $('#delete_medicine_id').val(id);
            $('#delete_medicine_display_id').text(id);
            $('#delete_medicine_name').text(name);
            $('#delete_medicine_desc').text(description);
            $('#delete_medicine_stock').text(instock);
        });
    });
</script>

<?php include './includes/footer.php'; ?>
