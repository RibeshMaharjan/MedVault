<?php include './includes/header.php'; ?>

    <div class="dashboard-content px-3 pt-4 ">
    
    <!-- Modal -->
    <div class="modal fade" id="pharmacyeditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Pharmacy Edit</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="code.php" class="form" method="POST" id="form" autocomplete="off">
        <div class="modal-body">
            
            <input type="hidden" name="pan" id="pan">
            <div class="mb-3">
                <label for="name" class="form-label">PHARMACY NAME</label>
                <input type="text" class="form-control"id="name" name="pharmacy_name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">EMAIL</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">PHONE</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">ADDRESS</label>
                <input type="text" class="form-control" id="address" required name="address">
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="update-pharmacy">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>
    <?php
        $pharmacy = getAll('tbl_pharmacy');

        if(mysqli_num_rows($pharmacy) > 0)
        {
    ?>
    <div class="container-fluid bg-white ">
        <div class="row px-3 pt-4">
            <div class="row px-3">
                <?php
                    alertmessage();
                ?>
            </div>
            <div class="col"><h1 class="fw-normal mb-3">Pharmacy Table</h1></div>
        </div>
        <div class="table-responsive px-3 pt-4 mb-5">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr>
                    <th scope="col">PAN</th>
                    <th scope="col">PHARMACY NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    while($result = mysqli_fetch_assoc($pharmacy)){
                        ?>
                        <tr>
                            <td><?=$result['pan']?></td>
                            <td><?=$result['pharmacy_name']?></td>
                            <td><?=$result['email']?></td>
                            <td><?=$result['phone']?></td>
                            <td><?=$result['address']?></td>
                            <td class="row g-0 ">
                                <div class="col">
                                <a class="text-white text-decoration-none "><button class="btn btn-success btn-md px-3 py-2 my-2 pharmacyeditbtn"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                </div>
                                <div class="col">
                                <a class="text-white text-decoration-none " href="pharmacy-delete.php?email=<?=$result["email"]?>"  onclick="return confirm('You want to delete the data?')"><button class="btn btn-danger btn-md px-3 py-2 my-2 btn-md"><i class="fa-regular fa-trash-can"></i></button></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                    }
                    else{
                        ?>
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