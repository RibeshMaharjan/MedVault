<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <!-- Modal -->
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
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-5 bg-body-tertiary ">
            <div class="row g-5 ">
                <div class="col p-5 bg-white">
                    <div class="row px-3 p-4">
                        <div class="col"><h1 class="fw-normal mb-3 fs-3">Add Category</h1></div>
                    </div>
                    <div class="row px-3 pb-4 w-50 ">
                        <form action="php/category-add.php" class="form" method="POST">
                            <div class="mb-3 category-input">
                                <input class="form-control" type="text" placeholder="Category Name" name="category-name">
                            </div>
                            <input type="submit" value="Add" class="btn btn-danger" name="submit-category">
                        </form>
                    </div>
                </div>
                <div class="col-md-6 p-5 bg-white ms-md-auto ">
                    <?php
                        alertmessage();
                        $category = getAll('user_category_tbl');
                        
                        if(mysqli_num_rows($category) > 0)
                        {
                    ?>
                    
                    <table class="table table-striped">
                        <thead class="table-danger">
                            <tr>
                                <th>C.ID</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($result = mysqli_fetch_assoc( $category ) ){
                                    if($result['pharmacy_id'] == $user_id){
                            ?>
                            <tr>
                                <td><?= $result['c_id'] ?></td>
                                <td><?= $result['category_name'] ?></td>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-white text-decoration-none ">
                                                <button class="btn btn-success btn-md px-3 py-2 my-2 categoryEditBtn">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <div class="btn btn-danger btn-md px-3 py-2 my-2 btn-md" style="background-color: red;" id="button">
                                            <a class="text-light " href="php/category-delete.php?c_id=<?=$result["c_id"]?>" id="button"
                                                onclick="return confirm('You want to delete the data?')"
                                                ><i class="fa-regular fa-trash-can"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
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