<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
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
                                <div class="button" style="background-color: limegreen;">
                                    <a href="php/category-edit.php?c_id=<?=$result["c_id"]?>" id="button">Edit</a>
                                </div>
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