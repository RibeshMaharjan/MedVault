<?php include './includes/header.php' ;?>
<div class="container-fluid bg-body-secondary py-5">
    <div class="container mt-5">
        <div class="row bg-white py-4 px-3 gy-4 rounded">
            <div class="row px-3">
                <?php
                    alertmessage();
                ?>
            </div>
                <h1 class="h3 m-0 fw-bold">Products</h1>
                <?php
                    $result = getAllProducts('tbl_medicine');
                    while ($row=mysqli_fetch_assoc($result)){
                        $product_id= $row['medicine_id'];
                        $product_name=$row['medicine_name'];
                        $product_description=$row['medicine_description'];
                        $product_image=$row['images'];
                        $product_price=$row [ 'price'];
                ?>
            <div class="col">
                <div class="card" style="width: 15rem;">
                    <img src="<?=$product_image?>" class="card-img-top" style="height: 250px;" alt="<?=$product_name?>">
                    <div class="card-body h-100 ">
                    <div class="product-card " role="button" data-href="product.php?medicine_id=<?= $product_id ?>">
                            <a href="product.php?medicine_id=<?= $product_id ?>"><h5 class="card-title h6"><?=$product_name?></h5></a>
                            <p class="card-text h5 text-danger fw-semibold mb-4 ">Rs. <?=$product_price?>.00</p>
                        </div>
                        <a href="php/add-to-cart.php?add_to_cart=<?=$product_id?>" class="btn btn-danger w-100 py-2">Add to cart</a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>
    <!-- include footer -->
<?php include 'includes/footer.php' ?>