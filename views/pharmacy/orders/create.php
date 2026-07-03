<div class="row pt-4 bg-white">
    <div class="col"><h1 class="fw-normal mb-3">Order Table</h1></div>
    <div class="row mb-4">
        <div class="col-xl-4">
            <form action="" id="order-suggest-form" method="post" class="search-form">
                <?= csrf_field() ?>
                <div class="input-group">
                    <input class="form-control" type="text" id="search" name="medicine_name" placeholder="Search medicine by name..." autocomplete="off">
                    <button type="submit" class="btn btn-danger">Add to Order</button>
                </div>
            </form>
            <div id="display" class="dropdown-menu w-100"></div>
        </div>
    </div>
    <div class="table-responsive pt-4 mb-5">
        <form action="/pharmacy/orders" method="POST">
            <?= csrf_field() ?>
            <table class="table table-striped">
                <thead class="table-danger">
                    <tr><th>MEDICINE NAME</th><th>PRICE</th><th>QUANTITY</th><th>TOTAL</th><th>DATE</th><th>ACTION</th></tr>
                </thead>
                <tbody id="product-info"></tbody>
            </table>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // AJAX medicine search
    $('#search').on('keyup', function() {
        var query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: '/api/pharmacy/search-medicine',
                method: 'POST',
                data: { search: query },
                success: function(data) {
                    $('#display').html(data).addClass('show');
                }
            });
        } else {
            $('#display').html('').removeClass('show');
        }
    });

    $(document).on('change', '.quantity-input', function() {
        let row = $(this).closest('tr');
        let price = parseFloat(row.find('.price-input').val());
        let quantity = parseInt($(this).val());
        let maxStock = parseInt($(this).attr('max'));
        let submitBtn = row.find('.submit-order-btn');
        let warningSpan = row.find('.quantity-warning');
        if (quantity < 1 || isNaN(quantity)) { $(this).val(1); quantity = 1; }
        row.find('.total-input').val(price * quantity);
        if (quantity > maxStock) {
            warningSpan.html('<span class="text-danger">Quantity exceeds available stock!</span>');
            submitBtn.prop('disabled', true);
        } else {
            warningSpan.html('');
            submitBtn.prop('disabled', false);
        }
    });

    $(document).on('change', '.date-input', function() {
        let row = $(this).closest('tr');
        let submitBtn = row.find('.submit-order-btn');
        let selectedDate = new Date($(this).val());
        let today = new Date(); today.setHours(0,0,0,0);
        let warningSpan = row.find('.date-warning');
        if (selectedDate < today) {
            warningSpan.html('<span class="text-danger">Order date cannot be in the past!</span>');
            submitBtn.prop('disabled', true);
        } else {
            warningSpan.html('');
            submitBtn.prop('disabled', false);
        }
    });
});

function fill(name) {
    $('#search').val(name);
    $('#display').html('').removeClass('show');
    $.ajax({
        url: '/api/pharmacy/medicine-row',
        method: 'POST',
        data: { m_name: name },
        dataType: 'json',
        success: function(med) {
            var today = new Date().toISOString().split('T')[0];
            var row = '<tr>' +
                '<td>' + escapeHtml(med.medicine_name) + '<input type="hidden" name="m_id" value="' + encodeURIComponent(med.m_id) + '"></td>' +
                '<td><input type="number" step="0.01" class="form-control price-input" name="price" value="' + encodeURIComponent(med.buy_price) + '"></td>' +
                '<td><input type="number" class="form-control quantity-input" name="quantity" value="1" min="1" max="' + encodeURIComponent(med.in_stock) + '">' +
                '<span class="quantity-warning"></span></td>' +
                '<td><input type="number" step="0.01" class="form-control total-input" name="total" value="' + encodeURIComponent(med.buy_price) + '" readonly></td>' +
                '<td><input type="date" class="form-control date-input" name="order_date" value="' + today + '">' +
                '<span class="date-warning"></span></td>' +
                '<td><button type="submit" name="add-order" class="btn btn-danger submit-order-btn">Submit</button></td>' +
                '</tr>';
            $('#product-info').html(row);
        }
    });
}
</script>
