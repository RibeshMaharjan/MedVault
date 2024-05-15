<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid px-5">
                    <?php
                        alertmessage();
                        $order = getAll('user_order_tbl');
                        
                    ?>
                    <div class="row px-3 pt-4">
                                <div class="col"><h1 class="fw-normal mb-3">Order Table</h1></div>
                            </div>
                            <div class="table-responsive px-3 pt-4 mb-5">
                            <table class="table table-striped">
                            <thead class="table-danger">
                                <tr>
                                    <th scope="col">ORDER ID</th>
                                    <th scope="col">MEDICINE ID</th>
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">DATE</th>
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
                                        <td><?= $result['m_id'] ?></td>
                                        <td><?= $result['quantity'] ?></td>
                                        <td><?= $result['status'] ?></td>
                                        <td><?= $result['order_date'] ?></td>
                                    <td class="row g-0 ">
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="php/order-edit.php?o_id=<?=$result['o_id']?>"><button class="btn w-75  btn-success btn-md px-5 my-buy-button">Edit</button></a>
                                        </div>
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="php/order-edit.php?o_id=<?=$result['o_id']?>"  onclick="return confirm('You want to delete the data?')"><button class="btn w-75 btn-danger btn-md my-buy-button">REMOVE</button></a>
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

<?php include 'includes/footer.php'; ?>