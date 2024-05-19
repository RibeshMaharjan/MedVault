<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <!-- Modal -->
        <div class="modal fade" id="orderEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Order Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="php/order-edit.php" class="form" method="POST" id="form" enctype="multipart/form-data">
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
                        <label for="order_date" class="form-label">Order Date</label>
                        <input type="date" class="form-control" id="order_date" name="order_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-order">Save changes</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-4 bg-body-tertiary">
                    <?php
                        $order = getAll('user_order_tbl');
                    ?>
                    <div class="row px-4 pt-4 bg-white">
                        <div class="row px-3">
                            <?php
                                alertmessage();
                            ?>
                        </div>
                        <div class="col"><h1 class="fw-normal mb-3">Order Table</h1></div>
                    <div class="row table-responsive px-4 pt-4 mb-5 bg-white">
                    <table class="table table-striped">
                    <thead class="table-danger">
                        <tr>
                            <th scope="col">ORDER ID</th>
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
                        if(mysqli_num_rows($order) > 0)
                        {
                            while($result = mysqli_fetch_assoc($order)){
                                if($result['pharmacy_id'] == $user_id){
                            ?> <tr>
                                        <td><?= $result['o_id'] ?></td>
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
                                        <td><?= $result['order_date'] ?></td>
                                    <td class="row g-0 ">
                                        <div class="col">
                                        <a class="text-white text-decoration-none "><button class="btn btn-success btn-md px-3 py-2 my-2 orderEditBtn"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                        </div>
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="php/order-delete.php?o_id=<?=$result['o_id']?>"  onclick="return confirm('You want to delete the data?')"><button class="btn btn-danger btn-md px-3 py-2 my-2 btn-md"><i class="fa-regular fa-trash-can"></i></button></a>
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