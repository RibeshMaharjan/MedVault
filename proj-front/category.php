<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
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
        <div class="inventory-container">
            <div class="category-form">
                <div class="heading">
                    <h3>Add Category</h3>
                </div>
                <div class="form">
                    <form action="php/category-add.php" method="post">
                        <input type="text" name="category-name" placeholder="Category Name">
                        <button type="submit" name="submit-category">Add</button>
                    </form>
                </div>
            </div>
            <div class="display-category">
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
                                <a class="text-white text-decoration-none "><button class="btn w-75 btn-success btn-md px-5 my-buy-button categoryEditBtn">Edit</button></a>
                                <div class="button" style="background-color: red;" id="button">
                                <a href="php/category-delete.php?c_id=<?=$result["c_id"]?>" id="button"
                                    onclick="return confirm('You want to delete the data?')"
                                    >Delete</a>
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
<?php include 'includes/footer.php'; ?>