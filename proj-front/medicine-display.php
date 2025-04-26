<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <!-- Edit Modal -->
        <div class="modal fade" id="medicineeditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medicine Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="php/medicine-edit.php" class="form" method="POST" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Medicine Name</label>
                        <input class="form-control" type="text" placeholder="Full Name" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" rows="3" name='description' id="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="Not Selected">Category</option>
                            <?php
                                $categoryresult = getAll('user_category_tbl');
                                while($categoryoption = mysqli_fetch_assoc($categoryresult)){
                                    echo '<option value="'.$categoryoption['c_id'].'" >'.$categoryoption['category_name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="instock" class="form-label">In Stock</label>
                        <input type="number" class="form-control" id="instock" name="instock">
                    </div>
                    <div class="mb-3">
                            <label for="buy_price" class="form-label">Buying Price</label>
                            <input type="number" class="form-control" id="buy_price" name="buy_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="sell_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control" id="sell_price" name="sell_price" required>
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
                        <i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone and will remove this medicine from your inventory.
                    </div>
                    <div class="medicine-details mt-3">
                        <p><strong>Medicine ID:</strong> <span id="delete_medicine_display_id"></span></p>
                        <p><strong>Medicine Name:</strong> <span id="delete_medicine_name"></span></p>
                        <p><strong>Category:</strong> <span id="delete_medicine_category"></span></p>
                        <p><strong>Current Stock:</strong> <span id="delete_medicine_stock"></span></p>
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
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-5 ">
            <div class="row pt-4 bg-white">
                <h1 class="fw-normal mb-3">Medicine Table</h1>
                <div class="table-responsiv pt-4 mb-5">
                    <?php
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $itemsPerPage = 10;
                        $conditions = "pharmacy_id = '$user_id'";
                        $paginatedResults = getPaginatedResults('user_medicine_tbl', $conditions, $page, $itemsPerPage);
                        $medicine = $paginatedResults['data'];
                    ?>
                            <div class="row bg-white">
                                <div class="col">
                                    <p class="text-muted">Showing <?= ($page-1)*$itemsPerPage + 1 ?> to <?= min($page*$itemsPerPage, $paginatedResults['totalRecords']) ?> of <?= $paginatedResults['totalRecords'] ?> entries</p>
                                </div>
                            <div class="bg-white table-responsive pt-4">
                            <table class="table table-striped">
                            <thead class="table-danger">
                                <tr>
                                    <th scope="col">MEDICINE ID</th>
                                    <th scope="col">MEDICINE NAME</th>
                                    <th scope="col">DESCRIPTION</th>
                                    <th scope="col">CATEGORY</th>
                                    <th scope="col">IN STOCK</th>
                                    <th scope="col">BUY PRICE</th>
                                    <th scope="col">SELL PRICE</th>
                                    <th scope="col">ADDED DATE</th>
                                    <th scope="col">EXPIRATION DATE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php 
                        if(mysqli_num_rows($medicine) > 0)
                        {
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
                                    <td style="display: none;"><?= $result['c_id'] ?></td>
                                    <?php
                                    $categoryall = getAll('user_category_tbl');
                                    while($category = mysqli_fetch_assoc($categoryall)){
                                        if($category['c_id'] == $result['c_id']){
                                        echo '<td>'.$category['category_name'].'</td>';
                                    }
                                    }
                                ?>
                                    <td><?= $result['in_stock'] ?></td>
                                    <td><?= $result['buy_price'] ?></td>
                                    <td><?= $result['sell_price'] ?></td>
                                    <td><?= $result['added_date'] ?></td>
                                    <td><?= $result['exp_date'] ?></td>
                                    <td class="row g-0 ">
                                        <div class="col">
                                        <a class="text-white text-decoration-none "><button class="btn btn-success btn-md px-3 py-2 my-2 medicineeditbtn"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                        </div>
                                        <div class="col">
                                        <button class="btn btn-danger btn-md px-3 py-2 my-2 medicineDeleteBtn"
                                            data-id="<?=$result['m_id']?>"
                                            data-name="<?=$result['medicine_name']?>"
                                            data-category="<?php
                                                $cat_name = '';
                                                $categoryall = getAll('user_category_tbl');
                                                while($category = mysqli_fetch_assoc($categoryall)){
                                                    if($category['c_id'] == $result['c_id']){
                                                        $cat_name = $category['category_name'];
                                                        break;
                                                    }
                                                }
                                                echo $cat_name;
                                            ?>"
                                            data-stock="<?=$result['in_stock']?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        </div>
                                    </td>
                                    </tr>
                            <?php
                            }
                        }
                        else {
                            echo "<tr><td colspan='9' class='text-center'>No Data Found!</td></tr>";
                        }
                    ?>
                        </tbody>
                        </table>
                        <?php 
                            echo generatePaginationLinks(
                                $paginatedResults['currentPage'],
                                $paginatedResults['totalPages'],
                                '?page={page}'
                            );
                        ?>
                </div>
                </div>
    </div>
    </div>
<?php include 'includes/footer.php'; ?>

