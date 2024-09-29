<?php include './includes/header.php'; ?>

    <div class="dashboard-content px-3 pt-4 ">
    <?php
        $admin = getAll('tbl_admin');
        if(mysqli_num_rows($admin) > 0)
        {
            $i = 1;
    ?>

    <!-- Modal -->
    <div class="modal fade" id="admineditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Admin Edit</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="code.php" class="form" method="POST" id="form" autocomplete="off">
        <div class="modal-body">
            
            <input type="hidden" name="update_id" id="update_id">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input class="form-control" type="text" id="name" placeholder="Full Name" aria-label="default input example" name="name">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Gender</label>
                    <select class="form-select" id="gender" aria-label="Floating label select example" name="gender">
                        <option selected value="Not Selected">Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Birth-Date</label>
                    <input type="date" class="form-control" id="birth" name="birth" required name="birth">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" aria-describedby="emailHelp" name="address">
                </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="update-admin">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>
    <div class="container-fluid bg-white ">
        <div class="row px-3 pt-4">
            <div class="row px-3">
                <?php
                    alertmessage();
                ?>
            </div>
            <div class="col"><h1 class="fw-normal mb-3">Admin Table</h1></div>
        </div>
        <?php
            alertmessage();
            $user_id = $_SESSION['loggedInUser']['user_id'];
            $cartquery = "SELECT * FROM cart WHERE pharmacy_id = '$user_id'" ; 
            $queryresult = mysqli_query($conn, $cartquery);
        ?>
        <div class="table-responsive px-3 pt-4 mb-5">
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
                                    <!-- <td class="row g-0 ">
                                        <div class="col">
                                        <a class="text-white text-decoration-none "><button class="btn btn-success btn-md px-3 py-2 my-2 admineditbtn"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                        </div>
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="admin-delete.php?admin_id=<?=$result['admin_id']?>"  onclick="return confirm('You want to delete the data?')"><button class="btn btn-danger btn-md px-3 py-2 my-2 btn-md"><i class="fa-regular fa-trash-can"></i></button></a>
                                        </div>
                                    </td> -->
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
    
<?php include './includes/footer.php'; ?>