<?php include './includes/header.php'; ?>

    <div class="dashboard-content px-3 pt-4 ">
    <?php
        $medicine = getAll('tbl_medicine');

        if(mysqli_num_rows($medicine) > 0)
        {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="medicineeditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="code.php" class="form" method="POST" id="form" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="hidden" name="update_id" id="update_id">
            <div class="mb-3">
                <label for="name" class="form-label">Medicine Name</label>
                <input class="form-control" type="text" placeholder="Full Name" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="manufacturername" class="form-label">Manufacturere</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" id="manufacturer" name="manufacturername">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity">
            </div>
            <div class="mb-3">
                <label for="dosage" class="form-label">Dosage</label>
                <select class="form-select" id="dosage" name="dosage">
                    <option value="Not Selected">Dosage</option>
                    <option value="tablet">Tablet</option>
                    <option value="capsule">Capsule</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exp_date" class="form-label">Expiration Date</label>
                <input type="date" class="form-control" id="exp_date" name="exp_date">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Image</label>
                <input class="form-control" type="file" name="images" id="images">
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
    <div class="container-fluid bg-white ">
        <div class="row px-3 pt-4">
            <div class="row px-3">
                <?php
                    alertmessage();
                ?>
            </div>
            <div class="col"><h1 class="fw-normal mb-3">Medicine Table</h1></div>
        </div>
        <div class="table-responsive px-3 pt-4 mb-5">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr>
                    <th scope="col">MEDICINE ID</th>
                    <th scope="col">MEDICINE NAME</th>
                    <th scope="col">MANUFACTURERE</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">QUANTITY</th>
                    <th scope="col">EXPIRATION DATE</th>
                    <th scope="col">DOSAGE FORM</th>
                    <th scope="col">IMAGE</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    while($result = mysqli_fetch_assoc($medicine)){
                        ?>
                        <tr>
                            <?php
                            $expirationDate = new DateTime($result['expiration_date']);
                            $today = new DateTime();
    
                            $interval = $today->diff($expirationDate);
                            $daysDifference = $interval->format('%a');
    
                            if ($daysDifference < 30) {
                                // Do something if the expiration date is less than 30 days from today
                                echo "<td class='bg-danger text-light '>{$result['medicine_id']}</td>";
                            } else {
                                // Otherwise, just display the expiration date
                                echo "<td>{$result['medicine_id']}</td>";
                            }
                            ?>
                                
                            <td><?= $result['medicine_name'] ?></td>
                            <td><?= $result['manufacturer'] ?></td>
                            <td><?= $result['price'] ?></td>
                            <td><?= $result['quantity'] ?></td>
                            <td><?= $result['expiration_date'] ?></td>
                            <td><?= $result['dosage'] ?></td>
                            <td><img src="<?= $result['images'] ?>" alt="" style="height: 80px; width: 80px;"></td>
                            <td class="row g-0" style="height: 100px;">
                                <div class="col">
                                    <a class="text-white text-decoration-none ">
                                        <button class="btn btn-success btn-md px-3 py-2 my-2 medicineeditbtn">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="text-white text-decoration-none " href="medicine-delete.php?medicine_id=<?=$result['medicine_id']?>"  onclick="return confirm('You want to delete the data?')">
                                        <button class="btn btn-danger btn-md px-3 py-2 my-2 btn-md">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </a>
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