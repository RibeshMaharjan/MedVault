<?php include './includes/header.php' ;
    $result = getById('tbl_medicine', 'medicine_id', checkParamId('medicine_id'));
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
    ?>
    <div class="payment">
        
        <h1 class="payment-heading">Payment Option</h1>
        <div class="about-product">
            <img src="<?=$result['data']['images']?>" alt="" id="prodImg"/>
            <div class="product-detail">
                <p class="price">Product Name : <?=$result['data']['medicine_name']?></p>
                <p class="price">Price : Rs. <span id="price"><?=$result['data']['price']?></span></span></p>
            </div>
        </div>
        <div class="payment-body">
            <form action="php/user-order-add.php?medicine_id=<?= $result['data']['medicine_id']?>" method="post" class="payment-form">
                <!-- <div class="payment-inputfield">
                    <label for="email">Email:</label>
                    <input type="email"class="input" id="email" name="email" required>
                </div>
                <div class="payment-inputfield">
                    <label for="phone">Phone:</label>
                    <input type="tel" class="input" id="phone" name="phone" required>
                </div> -->
                <div class="payment-inputfield">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="input" id="quantity" name="quantity" min="0" value="<?= $quantity ?>" required>
                </div>
                <div class="payment-inputfield">
                    <label for="delivery">Delivery Method:</label>
                    <select id="payment" name="payment" required>
                        <option value="">Select a delivery method</option>
                        <!-- <option value="standard">Standard Delivery (5-7 business days)</option>
                        <option value="express">Express Delivery (1-2 business days)</option> -->
                        <option value="cashinhand">Cash-In-Hand</option>
                        <option value="esewa">E-Sewa</option>
                    </select>
                </div>
                <div class="payment-inputfield">
                    <label for="city">City:</label>
                    <input type="text" class="input" id="city" name="city" value="ktm" required>
                    </select>
                </div>
                <div class="payment-inputfield">
                    <label for="province">Province:</label>
                    <input type="text" class="input" id="state" name="state" value="bagmati" required>
                    </select>
                </div>
                <div class="payment-inputfield address">
                    <label for="street-address">Street Address:</label>
                    <input type="text" class="input" id="street-address" name="street-address" value="samakhusi" required>
                </div>
                <div class="payment-inputfield">
                    <label for="postal-code">Postal Code:</label>
                    <input type="text" class="input" id="postal-code" name="postal-code" value="845" required>
                </div>
                <input type="hidden" id="subtotal" name="subtotal" value="0">
                <p id="sub-total">Subtotal: 0</p>
                <input type="submit" class="btn" value="Submit Order" name="order-purchase">
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>