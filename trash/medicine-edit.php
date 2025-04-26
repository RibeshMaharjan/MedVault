<?php include './includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include './includes/dashboard.php'; ?>
            <div class="container-fluid p-4">
                <form action="code.php" method="POST" enctype="multipart/form-data">
                    <?php
                        $paraResult = checkParamId("medicine_id");
                        if (!is_numeric($paraResult)) {
                            echo '<h5>'.$paraReult.'<br /></h5>';
                            return;
                        }
                        $medicine = getById('tbl_medicine','medicine_id',checkParamId("medicine_id"));
                        if($medicine['status'] == 200)
                        {
                    ?>
                    <h1>Append Medicine From</h1>
                    <input type="hidden" name="medicine_id" value="<?=$medicine['data']['medicine_id']?>">
                    <div class="input_field">
                        <label for="name">Medicine Name</label>
                        <input type="text" class="input" value="<?= $medicine['data']['medicine_name']?>" name="name" required>
                    </div>
                    <div class="input_field">
                        <label for="manufacturername">Manufacturere</label>
                        <input type="text" class="input" value="<?= $medicine['data']['manufacturer']?>" name="manufacturername" >
                    </div>
                    <div class="input_field">
                        <label for="price">Price</label>
                        <input type="number" class="input" value="<?= $medicine['data']['price']?>" name="price" required>
                    </div>
                    <div class="input_field">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="input" value="<?= $medicine['data']['quantity']?>" name="quantity" required>
                    </div>
                    <div class="input_field">
                        <label for="exp_date">Expiration Date</label>
                        <input type="date" class="email" value="<?= $medicine['data']['expiration_date']?>" name="exp_date" id="exp_date">
                    </div>
                    <div class="input_field">
                        <label for="dosage">Dosage</label>
                        <select class="selectbox" name="dosage">
                                <option value="tablet" value="<?= $medicine['data']['dosage'] == 'Tablet' ? 'selected' : '' ?>" >Tablet</option>
                                <option value="capsule" value="<?= $medicine['data']['dosage'] == 'Capsule' ? 'selected' : ''?>" >Capsule</option>
                            </select>
                    </div>
                    
                    <div class="input_field">
                        <input type="submit" value="Add" class="btn" name="update-medicine">
                    </div>
                    <?php
                    }
                    else
                    {
                        echo "<h5>" . $medicine['message'] . "</h5>";
                    }
                    ?>
                </form>
            </div>
    </div>
<?php include './includes/footer.php'; ?>