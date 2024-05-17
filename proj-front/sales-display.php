<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
        <!-- Modal -->
        <div class="modal fade" id="salesEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sales Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="php/sales-edit.php" class="form" method="POST" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <input type="hidden" name="m_id" id="m_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Medicine Name</label>
                        <input class="form-control" type="text" placeholder="Full Name" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sales_date" class="form-label">Sales Date</label>
                        <input type="date" class="form-control" id="sales_date" name="sales_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-sales">Save changes</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid px-5" id="medicine-medicines"  style="display: block;">
                    <?php
                        alertmessage();
                        $sales = getAll('user_sales_tbl');
                    ?>
                            <div class="row px-3 pt-4">
                                <div class="col"><h1 class="fw-normal mb-3">Sales Table</h1></div>
                            </div>
                            <div class="table-responsive px-3 pt-4 mb-5">
                            <table class="table table-striped">
                            <thead class="table-danger">
                                <tr>
                                    <th scope="col">SALES ID</th>
                                    <th scope="col">MEDICINE NAME</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col">TOTAL</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ORDER DATE</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php 
                        if(mysqli_num_rows($sales) > 0)
                        {
                            while($result = mysqli_fetch_assoc($sales)){
                                if($result['pharmacy_id'] == $user_id){
                            ?> <tr>

                                        <td><?= $result['s_id'] ?></td>
                                        <td style="display: none;"><?= $result['m_id'] ?></td>
                                        <?php
                                            $medicineAll = getAll('user_medicine_tbl');
                                            while($medicine = mysqli_fetch_assoc($medicineAll)){
                                                if($medicine['m_id'] == $result['m_id']){
                                                    echo '<td>'.$medicine['medicine_name'].'</td>';
                                                }
                                            }
                                        ?>
                                        <td><?= $result['price'] ?></td>
                                        <td><?= $result['quantity'] ?></td>
                                        <td><?= $result['total_amount'] ?></td>
                                        <td><?= $result['status'] ?></td>
                                        <td><?= $result['sales_date'] ?></td>
                                    <td class="row g-0 ">
                                        <div class="col">
                                        <a class="text-white text-decoration-none "><button class="btn w-75  btn-success btn-md px-5 my-buy-button salesEditBtn">Edit</button></a>
                                        </div>
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="php/sales-delete.php?s_id=<?=$result['s_id']?>"  onclick="return confirm('You want to delete the data?')"><button class="btn w-75 btn-danger btn-md my-buy-button">REMOVE</button></a>
                                        </div>
                                    </td>

                                    </tr>
                                    <?php
                                }
                            }
                        }
                    ?>
                        </tbody>
                        </table>
                </div>
    </div>
    </div>
                    </div>

<?php include 'includes/footer.php'; ?>