<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
            <div class="container-fluid p-5">
                <div class="row pt-4 bg-white">
                    <div class="col">
                        <h1 class="fw-normal mb-3">Sales Form</h1>
                    </div>
                    <!-- Enhanced Search box -->
                    <div class="row mb-4">
                        <div class="col-xl-4">
                            <form action="" id="sales-suggest-form" method="post" class="search-form">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="search" name="medicine_name" placeholder="Search medicine by name..." autocomplete="off">
                                    <button type="submit" class="btn btn-danger">Add to Sale</button>
                                </div>
                            </form>
                            <div id="display" class="dropdown-menu w-100"></div>
                        </div>
                    </div>

                    <div class="table-responsive pt-4 mb-5">
                    <form action="php/sales-add.php" method="POST">
                        <table class="table table-striped">
                            <thead class="table-danger">
                                <tr>
                                    <th>MEDICINE NAME</th>
                                    <th>PRICE</th>
                                    <th>QUANTITY</th>
                                    <th>TOTAL</th>
                                    <th>DATE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="product-info">
                                    
                            </tbody>
                        </table>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Real-time validation and total calculation when quantity changes
            $(document).on('change', '.quantity-input', function() {
                let row = $(this).closest('tr');
                let price = parseFloat(row.find('.price-input').val());
                let quantity = parseInt($(this).val());
                let maxStock = parseInt($(this).attr('max'));
                let submitBtn = row.find('.submit-order-btn');
                let warningSpan = row.find('.quantity-warning');
                
                // Validate quantity
                if (quantity < 1 || isNaN(quantity)) {
                    $(this).val(1);
                    quantity = 1;
                }
                
                let total = price * quantity;
                row.find('.total-input').val(total);
                
                // Show warning and disable button if quantity exceeds stock
                if (quantity > maxStock) {
                    warningSpan.html('<span class="text-danger">Quantity exceeds available stock!</span>');
                    submitBtn.prop('disabled', true);
                } else {
                    warningSpan.html('');
                    // Only enable if date is also valid
                    let dateInput = row.find('.date-input');
                    let selectedDate = new Date(dateInput.val());
                    let today = new Date();
                    today.setHours(0, 0, 0, 0);
                    
                    if (selectedDate >= today) {
                        submitBtn.prop('disabled', false);
                    }
                }
            });

            // Validate date on change
            $(document).on('change', '.date-input', function() {
                let row = $(this).closest('tr');
                let submitBtn = row.find('.submit-order-btn');
                let selectedDate = new Date($(this).val());
                let today = new Date();
                today.setHours(0, 0, 0, 0);
                let warningSpan = row.find('.date-warning');

                if (selectedDate < today) {
                    warningSpan.html('<span class="text-danger">Sale date cannot be in the past!</span>');
                    submitBtn.prop('disabled', true);
                } else {
                    warningSpan.html('');
                    // Only enable if quantity is also valid
                    let quantityInput = row.find('.quantity-input');
                    let quantity = parseInt(quantityInput.val());
                    let maxStock = parseInt(quantityInput.attr('max'));
                    
                    if (quantity <= maxStock && quantity > 0) {
                        submitBtn.prop('disabled', false);
                    }
                }
            });
        });
    </script>
<?php include 'includes/footer.php'; ?>