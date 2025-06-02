<?php include './includes/header.php'; ?>

    <div class="dashboard-content bg-white py-3">
    <?php
        $admin = getAll('tbl_admin');
        if(mysqli_num_rows($admin) > 0)
        {
            $i = 1;
            
    ?>

    <div class="container-fluid bg-white">
        <div class="pt-3 ps-2">
            <h1 class="fw-normal mb-3">Admin Table</h1>
        </div>
        <?php
            $user_id = $_SESSION['loggedInUser']['user_id'];
        ?>
        <div class="table-responsive px-2 pt-3 mb-5">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">GENDER</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">D.O.B</th>
                    <th scope="col">ADDRESS</th>
                    <!-- <th scope="col">ACTION</th> -->
                </tr>
            </thead>
            <tbody>
            <?php 
                    while($result = mysqli_fetch_assoc($admin)){
                        ?>
                        <tr>
                            <td scope="row"><?php echo $result['admin_id'] ?></td>
                                    <td><?= $result['name'] ?></td>
                                    <td><?= $result['email'] ?></td>
                                    <td><?= $result['phone'] ?></td>
                                    <td><?= $result['gender'] ?></td>
                                    
                                    <td><?= $result['dob'] ?></td>
                                    <td><?= $result['address'] ?></td>
                                </tr>
                                <?php
                        }
                    }
                    else{
                        ?>
                        </tbody>
                        <tr>
                            <td colspan='7'>No Data Found</td>
                        </tr>
                    <?php
                        }
                    
                ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>
    
    </div>
    
<?php include './includes/footer.php'; ?>