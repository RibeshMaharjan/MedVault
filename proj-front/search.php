<?php include './includes/header.php'; ?>
    <div class="container">
        <?php
            if(isset($_GET['search'])){
                $name = $_GET['medicine_name'];

                $query = "SELECT * FROM tbl_medicine WHERE medicine_name='$name' ";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result) > 0){
                    $data = mysqli_fetch_array( $result , MYSQLI_ASSOC);
                    ?>
            <div class="row bg-white p-4 g-2">
                    <h1 class="h3 fw-bold">Search Result for '<?= $name ?>'</h1>
                    
                <div class="col">
                    <div class="card" style="width: 15rem;">
                        <img src="<?= $data['images']; ?>" class="card-img-top" style="height: 250px;" alt="<?=$product_name?>">
                        <div class="card-body h-100 ">
                        <div class="product-card " role="button" data-href="product.php?medicine_id=<?= $product_id ?>">
                            <a href="product.php?medicine_id=<?= $data['medicine_id']; ?>"><h5 class="card-title h6"><?=$data['medicine_name'];?></h5></a>
                            <p class="card-text h5 text-danger fw-semibold mb-4 ">Rs. <?=$data['price']?>.00</p>
                        </div>
                            <a href="php/add-to-cart.php?add_to_cart=<?=$product_id?>" class="btn btn-danger w-100 py-2">Add to cart</a>
                        </div>
                    </div>
                </div>
                <?php
                    }
                    else{
                    ?>
                    <div class="container py-5">
                        <h1 class="h3 fw-bold">No Result Found</h1>
                    </div>
                <?php
                }
                ?>
            </div>
                <?php
                }
        ?>
    </div>
    

<!-- include footer -->
<?php include 'includes/footer.php'; ?>


