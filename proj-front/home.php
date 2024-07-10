<?php include 'includes/header.php';?>
<div id="carouselExample" class="carousel slide carousel-fade">
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="image/banner4.jpg" class="d-block w-100" style="height:32rem;object-fit: cover;" alt="...">
        </div>
        <div class="carousel-item">
        <img src="image/banner2.jpg" class="d-block w-100" style="height:32rem;object-fit: cover;" alt="...">
        </div>
        <div class="carousel-item">
        <img src="image/banner5.jpg" class="d-block w-100" style="height:32rem;object-fit: cover;" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
    <div class="container-fluid  bg-body-secondary py-5">
        <!-- <div class="big-slider">
            <div class="slides-display">
                <p>hello</p>
            </div>
            <div class="slides">
                <p>Hi</p>
            </div>
            <div class="slides">
                <p>Bye</p>
            </div>
            <button id="prevbtn">&lt</button>
            <button id="nextbtn">&gt</button>
        </div> -->
        <div class="container ">
            <div class="row pb-3">
                <?php
                        alertmessage();
                ?>
            </div>
            <div class="row bg-white p-4 g-2">
                    <h1 class="h3 fw-bold">Tablets</h1>
                    <?php
                        $result = getRandom('tbl_medicine','tablet');
                        while ($row=mysqli_fetch_assoc($result)){
                            $product_id= $row['medicine_id'];
                            $product_name=$row['medicine_name'];
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
            <div class="row bg-white p-4 g-2 mt-5">
                    <h1 class="h3 fw-bold ">Capsule</h1>
                    <?php
                        $result = getRandom('tbl_medicine','capsule');
                        while ($row=mysqli_fetch_assoc($result)){
                            $product_id= $row['medicine_id'];
                            $product_name=$row['medicine_name'];
                            $product_image=$row['images'];
                            $product_price=$row [ 'price'];
                    ?>
                <div class="col">
                    
                    <div class="card" style="width: 15rem;">
                        <img src="<?=$product_image?>" class="card-img-top" style="height: 250px;" alt="<?=$product_name?>">
                        <div class="card-body h-100">
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
            <section class="pt-5">
            <div class="row g-lg-5">
                <div class="col-sm-6">
                    <img class="img-fluid" src="image/med.png" alt="">
                </div>
                <div class="col-sm-6">
                    <h1 class="mt-4"><?= webSetting('sub_title') ?? ''; ?></h1>
                    <p class="mt-4"><?= webSetting('sub_description') ?? ''; ?></p>

                    <a href="" target="" class="btn btn-danger btn-lg">Learn More</a>
                </div>
            </div>
        </section>
        </div>
    </div>
    <!-- include footer -->
    <?php include 'includes/footer.php' ?>
