<?php include './includes/header.php' ;
    $result = getById('tbl_medicine', 'medicine_id', checkParamId('medicine_id'));
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
    ?>
    <div class="container my-3 py-3 ">
        <h1 class="payment-heading">Payment Option</h1>
        <div class="row py-5">
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        <img class="img-fluid" src="<?=$result['data']['images']?>" alt="" id="prodImg"/>
                    </div>
                    <div class="col ms-4">
                        <p class="fs-3 fw-bolder">Product Name : <?=$result['data']['medicine_name']?></p>
                        <p class="fs-5 fw-bolder">Price : Rs. <span class="text-danger" id="price"><?=$result['data']['price']?></span></span></p>
                    </div>
                </div>
            </div>
            <div class="col-2">
                
            </div>
        </div>
        <div class="form mb-5">
            <form action="php/user-order-add.php?medicine_id=<?= $result['data']['medicine_id']?>" method="post" class="payment-form">
                <!-- <div class="payment-inputfield">
                    <label for="email">Email:</label>
                    <input type="email"class="input" id="email" name="email" required>
                </div>
                <div class="payment-inputfield">
                    <label for="phone">Phone:</label>
                    <input type="tel" class="input" id="phone" name="phone" required>
                </div> -->
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="quantity">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="<?= $quantity ?>" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="delivery">Delivery Method:</label>
                            <select class="form-select" id="payment" name="payment" required>
                                <option value="">Select a delivery method</option>
                                <!-- <option value="standard">Standard Delivery (5-7 business days)</option>
                                <option value="express">Express Delivery (1-2 business days)</option> -->
                                <option value="cashinhand">Cash-In-Hand</option>
                                <option value="esewa">E-Sewa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="city">City:</label>
                            <input type="text" class="form-control" id="city" name="city" value="ktm" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="province">Province:</label>
                            <input type="text" class="form-control" id="state" name="state" value="bagmati" required>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="street-address">Street Address:</label>
                            <input type="text" class="form-control" id="street-address" name="street-address" value="samakhusi" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="postal-code">Postal Code:</label>
                            <input type="text" class="form-control" id="postal-code" name="postal-code" value="845" required>
                        </div>
                    </div>
                </div>
                <div class="row my-2 ">
                    <div class="col-6">
                        <input type="hidden" id="subtotal" name="subtotal" value="0">
                        <p class="fw-bolder fs-5" >Subtotal: &emsp; <span class="text-danger" id="sub-total">0</span></p>
                    </div>
                </div>
                <input type="submit" class="btn btn-danger btn-md px-3 py-2 my-2 btn-md text float-end" value="Submit Order" name="order-purchase">
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>