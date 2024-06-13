<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <!-- Modal -->
        <div class="modal fade" id="medicineeditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
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
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-4 bg-body-tertiary">
                    <?php
                        // $medicine = getAll('user_medicine_tbl');
                        $medicine = getAllById('user_medicine_tbl', 'pharmacy_id', $user_id);
                        // $query = "SELECT * FROM user_medicine_tbl";
                        // $query ="SELECT * FROM user_medicine_tbl WHERE pharmacy_id='$user_id'";
                        // $row = mysqli_query($conn, $query);


                        if($medicine['status'] == 200)
                        {
                    ?>
                            <div class="row p-4 bg-white">
                                <div class="row px-3">
                                    <?php
                                        alertmessage();
                                    ?>
                                </div>
                                <div class="col"><h1 class="fw-normal mb-3">Medicine Table</h1></div>
                            <div class="bg-white table-responsive pt-4 mb-5">
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
                        while($result = mysqli_fetch_array( $medicine['data'] , MYSQLI_ASSOC)){
                            ?> <tr>
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
                                        <a class="text-white text-decoration-none " href="php/medicine-delete.php?m_id=<?=$result['m_id']?>"  onclick="return confirm('You want to delete the data?')"><button class="btn btn-danger btn-md px-3 py-2 my-2 btn-md"><i class="fa-regular fa-trash-can"></i></button></a>
                                        </div>
                                    </td>
                                    </tr>
                            <?php
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
