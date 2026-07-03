<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Add Sale</h1>
            <p class="mv-page-subtitle">Search medicine, set quantity, and record a sale.</p>
        </div>
    </div>
    <div class="mv-filter-panel">
            <form action="" id="sales-suggest-form" method="post" class="search-form">
                <?= csrf_field() ?>
                <div class="input-group">
                    <input class="form-control" type="text" id="search" name="medicine_name" placeholder="Search medicine by name..." autocomplete="off">
                    <button type="submit" class="btn btn-danger">Add to Sale</button>
                </div>
            </form>
            <div id="display" class="dropdown-menu w-100"></div>
    </div>
    <div class="mv-table-wrap mb-5">
    <div class="table-responsive">
        <form action="/pharmacy/sales" method="POST">
            <?= csrf_field() ?>
            <table class="table table-striped mv-responsive-table">
                <thead class="table-danger">
                    <tr><th>MEDICINE NAME</th><th>PRICE</th><th>QUANTITY</th><th>TOTAL</th><th>DATE</th><th>ACTION</th></tr>
                </thead>
                <tbody id="product-info"></tbody>
            </table>
        </form>
    </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        var query = $(this).val();
        if (query.length > 1) {
            $.ajax({ url: '/api/pharmacy/search-medicine', method: 'POST', data: { search: query },
                success: function(data) { $('#display').html(data).addClass('show'); }
            });
        } else { $('#display').html('').removeClass('show'); }
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
            warningSpan.html('<span class="text-danger">Exceeds stock!</span>');
            submitBtn.prop('disabled', true);
        } else { warningSpan.html(''); submitBtn.prop('disabled', false); }
    });
});

function fill(name) {
    $('#search').val(name);
    $('#display').html('').removeClass('show');
    $.ajax({
        url: '/api/pharmacy/medicine-row', method: 'POST', data: { m_name: name }, dataType: 'json',
        success: function(med) {
            var today = new Date().toISOString().split('T')[0];
            var row = '<tr>' +
                '<td data-label="Medicine">' + escapeHtml(med.medicine_name) + '<input type="hidden" name="m_id" value="' + encodeURIComponent(med.m_id) + '"></td>' +
                '<td data-label="Price"><input type="number" step="0.01" class="form-control price-input" name="sellprice" value="' + encodeURIComponent(med.sell_price) + '"></td>' +
                '<td data-label="Quantity"><input type="number" class="form-control quantity-input" name="quantity" value="1" min="1" max="' + encodeURIComponent(med.in_stock) + '"><span class="quantity-warning"></span></td>' +
                '<td data-label="Total"><input type="number" step="0.01" class="form-control total-input" name="total" value="' + encodeURIComponent(med.sell_price) + '" readonly></td>' +
                '<td data-label="Date"><input type="date" class="form-control" name="sales_date" value="' + today + '"></td>' +
                '<td class="mv-actions-cell"><button type="submit" name="add-sales" class="btn btn-danger submit-order-btn">Submit Sale</button></td></tr>';
            $('#product-info').html(row);
        }
    });
}
</script>
