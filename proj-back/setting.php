<?php include './includes/header.php'; ?>
        <div class="dashboard-content px-3 pt-4 ">
            <div class="container-fluid bg-white">
                <div class="row px-3 p-4">
                    <?= alertmessage(); ?>
                    <div class="col"><h1 class="fw-normal mb-3">WebSite Settings</h1></div>
                </div>
                <div class="row px-3 pb-4">
                    <form action="code.php" class="form" method="POST" id="form">
                        <?php
                            // $paraResult = checkParamId('id');

                            $setting = getById('settings','id', 1);
                
                            if($setting['status'] == 200){
                        ?>
                        <input type="hidden" name="settingId" value="1">
                        <div class="mb-3">
                            <label for="title" class="form-label">Heading</label>
                            <input class="form-control" type="text" aria-label="default input example"  value="<?= $setting['data']['title']?>" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="small_description" class="form-label">Small Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='small-description' id=""><?= $setting['data']['small_description']?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sub-title" class="form-label">Sub-Heading</label>
                            <input type="text" class="form-control"  value="<?= $setting['data']['sub_title']?>" name="sub-title">
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">Sub-Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='sub-description' id=""><?= $setting['data']['sub_description']?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control"  value="<?= $setting['data']['phone']?>" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= $setting['data']['email']?>" name="email">
                        </div>
                        <input type="submit" value="Save Setting" class="btn btn-danger" name="saveSetting">
                        <?php
                            }
                            else
                            {
                                echo "<h5>".$setting['status'].'</h5>';   
                            }
                            ?>
                    </form>
                </div>
            </div>
        </div>
<?php include './includes/footer.php'; ?>

