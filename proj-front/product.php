<?php include './includes/header.php'; ?>
<div class="container py-5">
    <div class="row px-2 pb-3">
        <?php
                alertmessage();
        ?>
    </div>
    
    <?php $result = getById('tbl_medicine', 'medicine_id', checkParamId('medicine_id'));
            ?>
    <div class="row">
        <div class="col-5">
            <img src="<?= $result['data']['images']; ?>" class="img-fluid" alt="product">
        </div>
        <div class="col">
            <div class="row">
                <h1><?= $result['data']['medicine_name']; ?></h1>
            </div>
            <hr>
            <div class="row">
                <h3>Description: <br><p class="fs-5 pt-3 fw-normal "><?= $result['data']['medicine_description']; ?></p></h3>
            </div>
            <div class="row">
                    <h5 class="text-danger fw-bold mt-3">Rs. <?= $result['data']['price']; ?>.00</h5>
            </div>
            <div class="row px-2">
                <button class="btn btn-danger btn-lg w-25 w me-3 mt-3"><a class="text-white text-decoration-none " href="buy.php?medicine_id=<?= $result['data']['medicine_id'] ?>">Buy</a></button>
                <button class="btn btn-danger btn-lg w-25 mt-3"><a class="text-white text-decoration-none " id='cart_btn' href='php/add-to-cart.php?add_to_cart=<?=$result['data']['medicine_id'] ?>'>Add to cart</a></button>
            </div>
        </div>
    </div>
</div>
<!-- include footer -->
<?php include 'includes/footer.php'; ?>