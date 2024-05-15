<?php
    include_once('../config/function.php');
    ?>
    <form action="code.php" method="POST">
    <?php
        $paraResult = checkParamId('email');
        // if(!is_numeric($paraResult)){
        //     echo '<h5>'.$paraResult.'</h5>';
        //     return false;
        // }

        $admin = getById('tbl_admin','email',checkParamId('email'));
        if($admin['status'] == 200)
        {
            ?>                
                <h1>Append Admin From</h1>
                <div class="input_field">
                    <label for="name">Full Name</label>
                    <input type="text" class="input" value="<?= $admin['data']['name'] ;?>" name="name" required>
                </div>
                <div class="input_field">
                    <label for="email">Email</label>
                    <input type="email" class="email" name="email" value="<?= $admin['data']['email'] ;?>" placeholder="@admin.gmail.com" required>
                </div>
                <div class="input_field">
                    <label for="gender">Gender</label>
                    <select class="selectbox" name="gender" required>
                        <option value="Not Selected" >Select</option>
                        <option value="Male" <?= $admin['data']['gender'] == 'Male' ? 'selected':'' ;?>>Male</option>
                        <option value="Female" <?= $admin['data']['gender'] == 'Female' ? 'selected':'' ;?>>Female</option>
                    </select>
                </div>
                <div class="input_field">
                    <label for="phone">Phone</label>
                    <input type="text" class="input" value="<?= $admin['data']['phone'] ;?>" maxlength="10" name="phone" required>
                </div>
                <div class="input_field">
                    <label for="birth">Birth-Date </label>
                    <input type="date" class="aalu" value="<?= $admin['data']['dob'] ;?>" name="birth" required>
                    </div>
                <div class="input_field">
                    <label for="address">Address</label>
                    <input type="text" class="input" value="<?= $admin['data']['address'] ;?>" name="address" required>
                </div>
                <div class="input_field">
                    <input type="submit" value="Add" class="btn" name="update-admin">
                </div>
            <?php
        }
        else
        {
            echo '<h5'.$admin['message'].'</h5>';
        }
    ?>
        
    </form>