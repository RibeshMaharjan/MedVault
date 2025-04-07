<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <!-- Modal -->
        <div class="modal fade" id="salesEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sales Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="php/sales-edit.php" class="form" method="POST" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <input type="hidden" name="m_id" id="m_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Medicine Name</label>
                        <input class="form-control" type="text" placeholder="Full Name" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sales_date" class="form-label">Sales Date</label>
                        <input type="date" class="form-control" id="sales_date" name="sales_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-sales">Save changes</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-4 bg-body-tertiary">
                    <?php
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $itemsPerPage = 10;

                        // Filter parameters
                        $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
                        $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
                        $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $amount_min = isset($_GET['amount_min']) ? $_GET['amount_min'] : '';
                        $amount_max = isset($_GET['amount_max']) ? $_GET['amount_max'] : '';

                        // Build conditions
                        $conditions = ["pharmacy_id = '$user_id'"];
                        if ($status_filter) {
                            $conditions[] = "status = '$status_filter'";
                        }
                        if ($date_from && $date_to) {
                            $conditions[] = "sales_date BETWEEN '$date_from' AND '$date_to'";
                        }
                        if ($search) {
                            $conditions[] = "(m_id IN (SELECT m_id FROM user_medicine_tbl WHERE medicine_name LIKE '%$search%'))";
                        }
                        if ($amount_min !== '') {
                            $conditions[] = "total_amount >= '$amount_min'";
                        }
                        if ($amount_max !== '') {
                            $conditions[] = "total_amount <= '$amount_max'";
                        }

                        $where_clause = implode(' AND ', $conditions);
                        $paginatedResults = getPaginatedResults('user_sales_tbl', $where_clause, $page, $itemsPerPage);
                        $sales = $paginatedResults['data'];
                    ?>
                            <div class="row px-4 pt-4 bg-white">
                                <div class="col">
                                    <h1 class="fw-normal mb-3">Sales Table</h1>
                                </div>

                                <!-- Filter Form -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <form method="GET" class="row g-3">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="search" placeholder="Search medicine..." value="<?= htmlspecialchars($search) ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-select" name="status">
                                                    <option value="">All Status</option>
                                                    <option value="pending" <?= $status_filter == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="completed" <?= $status_filter == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="date" class="form-control" name="date_from" value="<?= htmlspecialchars($date_from) ?>" placeholder="From Date">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="date" class="form-control" name="date_to" value="<?= htmlspecialchars($date_to) ?>" placeholder="To Date">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="amount_min" placeholder="Min Amount" value="<?= htmlspecialchars($amount_min) ?>">
                                                    <input type="number" class="form-control" name="amount_max" placeholder="Max Amount" value="<?= htmlspecialchars($amount_max) ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-danger">Filter</button>
                                                <a href="sales-display.php" class="btn btn-secondary">Reset</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <p class="text-muted">Showing <?= ($page-1)*$itemsPerPage + 1 ?> to <?= min($page*$itemsPerPage, $paginatedResults['totalRecords']) ?> of <?= $paginatedResults['totalRecords'] ?> entries</p>
                            </div>

                            <div class="row table-responsive px-4 pt-4 mb-5 bg-white ">
                            <table class="table table-striped">
                            <thead class="table-danger">
                                <tr>
                                    <th scope="col">SALES ID</th>
                                    <th scope="col">MEDICINE NAME</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col">TOTAL</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">SALES DATE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php 
                        if(mysqli_num_rows($sales) > 0)
                        {
                            while($result = mysqli_fetch_assoc($sales)){
                    ?> 
                                <tr>
                                    <td><?= $result['s_id'] ?></td>
                                    <td style="display: none;"><?= $result['m_id'] ?></td>
                                    <?php
                                        $medicineAll = getAll('user_medicine_tbl');
                                        while($medicine = mysqli_fetch_assoc($medicineAll)){
                                            if($medicine['m_id'] == $result['m_id']){
                                                echo '<td>'.$medicine['medicine_name'].'</td>';
                                            }
                                        }
                                    ?>
                                    <td><?= $result['price'] ?></td>
                                    <td><?= $result['quantity'] ?></td>
                                    <td><?= $result['total_amount'] ?></td>
                                    <td><span class="badge <?= $result['status'] == 'completed' ? 'bg-success' : 'bg-warning' ?>"><?= $result['status'] ?></span></td>
                                    <td><?= $result['sales_date'] ?></td>
                                    <td class="row g-0">
                                        <div class="col">
                                            <button class="btn btn-success btn-md px-3 py-2 my-2 salesEditBtn"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </div>
                                        <div class="col">
                                            <a class="text-white text-decoration-none" href="php/sales-delete.php?s_id=<?=$result['s_id']?>" onclick="return confirm('You want to delete the data?')">
                                                <button class="btn btn-danger btn-md px-3 py-2 my-2"><i class="fa-regular fa-trash-can"></i></button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        else {
                            echo "<tr><td colspan='8' class='text-center'>No Data Found!</td></tr>";
                        }
                    ?>
                            </tbody>
                            </table>
                            <?php 
                                // Add filter parameters to pagination links
                                $filter_params = http_build_query([
                                    'status' => $status_filter,
                                    'date_from' => $date_from,
                                    'date_to' => $date_to,
                                    'search' => $search,
                                    'amount_min' => $amount_min,
                                    'amount_max' => $amount_max
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
        </div>
<?php include 'includes/footer.php'; ?>