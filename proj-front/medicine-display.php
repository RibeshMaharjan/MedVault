<?php include 'includes/header.php'; ?>
    <div class="inventorybody">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid px-5" id="medicine-medicines"  style="display: block;">
                    <?php
                        alertmessage();
                        $medicine = getAll('user_medicine_tbl');

                        if(mysqli_num_rows($medicine) > 0)
                        {
                    ?>
                            <div class="row px-3 pt-4">
                                <div class="col"><h1 class="fw-normal mb-3">Medicine Table</h1></div>
                            </div>
                            <div class="table-responsive px-3 pt-4 mb-5">
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
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php 
                        while($result = mysqli_fetch_assoc($medicine)){
                            ?> <tr>
                                    <td><?= $result['m_id'] ?></td>
                                    <td><?= $result['medicine_name'] ?></td>
                                    <td><?= $result['medicine_desc'] ?></td>
                                    <td><?= $result['c_id'] ?></td>
                                    <td><?= $result['in_stock'] ?></td>
                                    <td><?= $result['buy_price'] ?></td>
                                    <td><?= $result['sell_price'] ?></td>
                                    <td><?= $result['added_date'] ?></td>
                                    <td class="row g-0 ">
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="php/medicine-edit.php?m_id=<?=$result['m_id']?>"><button class="btn w-75  btn-success btn-md px-5 my-buy-button">Edit</button></a>
                                        </div>
                                        <div class="col">
                                        <a class="text-white text-decoration-none " href="php/medicine-delete.php?m_id=<?=$result['m_id']?>"  onclick="return confirm('You want to delete the data?')"><button class="btn w-75 btn-danger btn-md my-buy-button">REMOVE</button></a>
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

<?php include 'includes/footer.php'; ?>

