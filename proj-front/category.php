<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <!-- Edit Modal -->
        <div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Category Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="php/category-edit.php" class="form" method="POST" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input class="form-control" type="text" id="name" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-category">Save changes</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        
        <!-- Delete Modal -->
        <div class="modal fade" id="categoryDeleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Confirm Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="php/category-delete.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="delete_category_id" id="delete_category_id">
                    <p>Are you sure you want to delete this category?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone. All medicines in this category will need to be reassigned.
                    </div>
                    <div class="category-details mt-3">
                        <p><strong>Category ID:</strong> <span id="delete_category_display_id"></span></p>
                        <p><strong>Category Name:</strong> <span id="delete_category_name"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete-category">Delete Category</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-2 p-md-3 p-lg-5 max-vh-100 overflow-auto" style="max-height: 100vh; !important;">
            <?php include 'includes/navbar.php'; ?>
            <div class="row pt-4 g-5">
                <div class="col bg-white">
                    <div class="row">
                        <div class="col"><h1 class="fw-normal mb-3">Add Category</h1></div>
                    </div>
                    <div class="row pt-4 pb-4 w-50 ">
                        <form action="php/category-add.php" class="form" method="POST">
                            <div class="mb-3 category-input">
                                <input class="form-control" type="text" placeholder="Category Name" name="category-name">
                            </div>
                            <input type="submit" value="Add" class="btn btn-danger" name="submit-category">
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 pt-4 bg-white ms-lg-auto ">
                    <?php
                        $category = getAll('user_category_tbl');
                        $user_id = $_SESSION['loggedInUser']['user_id'];

                        $query = "SELECT * FROM user_category_tbl WHERE pharmacy_id = $user_id";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($category) > 0)
                        {
                    ?>
                    
                    <table class="table table-striped">
                        <thead class="table-danger">
                            <tr>
                                <th>S.No</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                while($result = mysqli_fetch_assoc( $category ) ){
                                    if($result['pharmacy_id'] == $user_id){
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $result['category_name'] ?></td>
                                <td class="row g-0">
                                    <div class="col">
                                        <button class="btn btn-success btn-md px-3 py-2 my-2 categoryEditBtn"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-danger btn-md px-3 py-2 my-2 categoryDeleteBtn"
                                            data-id="<?=$result['c_id']?>"
                                            data-name="<?=$result['category_name']?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                    $i++;
                                }
                            }
                        }
                        else{
                            echo "<h4 style='font-size: 26px; text-align: center;'>No Data Found!</h4>";
                        }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>
