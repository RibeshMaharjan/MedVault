<?php
    include_once '../config/function.php';
    ?>
    <form action="code.php" method="POST">
        <?php
            $paraResult = checkParamId('email');

            $pharmacy = getById('tbl_pharmacy','email', checkParamId('email'));

            if($pharmacy['status'] == 200){
        ?>
            <h1>Append Pharmacy From</h1>
                <div class="input_field">
                    <label for="pan">Pan No.</label>
                    <input type="text" class="input" value="<?=$pharmacy['data']['pan']?>" name="pan" required>
                </div>
                <div class="input_field">
                    <label>Pharmacy Name</label>
                    <input type="text" class="input" value="<?=$pharmacy['data']['pharmacy_name']?>" name="pharmacy_name" required>
                </div>
                <div class="input_field">
                    <label for="email">Email</label>
                    <input type="email" class="email" value="<?=$pharmacy['data']['email']?>" name="email" placeholder="">
                </div>
                <div class="input_field">
                    <label for="phone">Phone</label>
                    <input type="text" class="input" value="<?=$pharmacy['data']['phone']?>" maxlength="10" name="phone">
                </div>
                <div class="input_field">
                    <label for="password">Password</label>
                    <input type="password" class="input"  name="password">
                </div>
                <div class="input_field">
                    <label for="address">Address</label>
                    <input type="text" class="input" value="<?=$pharmacy['data']['address']?>" name="address">
                </div>
                <div class="input_field">
                    <input type="submit" value="Add" class="btn" name="update-pharmacy">
                </div>
            <?php
            }
            else
            {
                echo "<h5>".$pharmacy['status'].'</h5>';   
            }
            ?>
        </form>