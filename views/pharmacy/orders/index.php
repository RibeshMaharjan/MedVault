<?php $p = $pagination; $f = $filters ?? []; ?>

<!-- Add Modal -->
<div class="modal fade" id="orderAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mv-filter-panel">
                    <form action="" id="order-add-suggest-form" method="post" class="search-form">
                        <?= csrf_field() ?>
                        <div class="input-group">
                            <input class="form-control" type="text" id="order_add_search" name="medicine_name" placeholder="Search medicine by name..." autocomplete="off">
                            <button type="submit" class="btn btn-danger">Add to Order</button>
                        </div>
                    </form>
                    <div id="order_add_display" class="dropdown-menu w-100"></div>
                </div>
                <div class="mv-table-wrap">
                    <div class="table-responsive">
                        <form action="/pharmacy/orders" method="POST">
                            <?= csrf_field() ?>
                            <table class="table table-striped mv-responsive-table">
                                <thead class="table-danger">
                                    <tr><th>MEDICINE NAME</th><th>PRICE</th><th>QUANTITY</th><th>TOTAL</th><th>DATE</th><th>ACTION</th></tr>
                                </thead>
                                <tbody id="order_add_product_info">
                                    <tr><td colspan="6" class="mv-empty">Search and select a medicine to create an order.</td></tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="orderEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h1 class="modal-title fs-5">Order Edit</h1><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="" method="POST" id="orderEditForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <input type="hidden" name="m_id" id="m_id">
                    <div class="mb-3"><label class="form-label">Medicine Name</label><input class="form-control" type="text" id="name" name="name" readonly></div>
                    <div class="mb-3"><label class="form-label">Price</label><input type="text" class="form-control" id="price" name="price" required></div>
                    <div class="mb-3"><label class="form-label">Quantity</label><input type="text" class="form-control" id="quantity" name="quantity" required></div>
                    <div class="mb-3"><label class="form-label">Total</label><input type="text" class="form-control" id="total" name="total" required></div>
                    <div class="mb-3"><label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status"><option value="pending">Pending</option><option value="completed">Completed</option><option value="cancelled">Cancelled</option></select>
                    </div>
                    <div class="mb-3"><label class="form-label">Order Date</label><input type="date" class="form-control" id="order_date" name="order_date"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-order">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="orderDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white"><h1 class="modal-title fs-5">Confirm Delete</h1><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="" method="POST" id="orderDeleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="delete_order_id" id="delete_id">
                    <p>Are you sure you want to delete this order?</p>
                    <div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone.</div>
                    <p><strong>Order ID:</strong> <span id="delete_order_id"></span></p>
                    <p><strong>Medicine:</strong> <span id="delete_medicine"></span></p>
                    <p><strong>Quantity:</strong> <span id="delete_quantity"></span></p>
                    <p><strong>Total:</strong> <span id="delete_total"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete-order">Delete Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Orders</h1>
            <p class="mv-page-subtitle">Track supplier orders and fulfillment status.</p>
        </div>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#orderAddModal">Add Order</button>
    </div>

    <div class="mv-filter-panel">
        <form method="GET" class="mv-filter-grid">
            <div>
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="pending" <?= (($f['status'] ?? '') == 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="completed" <?= (($f['status'] ?? '') == 'completed') ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= (($f['status'] ?? '') == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div><input type="date" class="form-control" name="date_from" value="<?= htmlspecialchars($f['date_from'] ?? '') ?>"></div>
            <div><input type="date" class="form-control" name="date_to" value="<?= htmlspecialchars($f['date_to'] ?? '') ?>"></div>
            <div class="mv-filter-actions">
                <button type="submit" class="btn btn-danger">Filter</button>
                <a href="/pharmacy/orders" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="mv-table-wrap mb-5">
    <div class="table-responsive">
        <table class="table table-striped mv-responsive-table">
            <thead class="table-danger">
                <tr><th>ID</th><th>MEDICINE</th><th>PRICE</th><th>QUANTITY</th><th>TOTAL</th><th>STATUS</th><th>DATE</th><th>ACTION</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $ord): ?>
                    <tr>
                        <td data-label="ID"><?= $ord['o_id'] ?></td>
                        <td data-label="Medicine"><?= htmlspecialchars($ord['medicine_name'] ?? $ord['m_id']) ?></td>
                        <td data-label="Price"><?= $ord['price'] ?></td>
                        <td data-label="Quantity"><?= $ord['quantity'] ?></td>
                        <td data-label="Total"><?= $ord['total_amount'] ?></td>
                        <td data-label="Status"><span class="badge <?= $ord['status'] == 'completed' ? 'bg-success' : ($ord['status'] == 'cancelled' ? 'bg-danger' : 'bg-warning') ?>"><?= $ord['status'] ?></span></td>
                        <td data-label="Date"><?= $ord['order_date'] ?></td>
                        <td class="mv-actions-cell" data-label="Action">
                            <div class="mv-icon-actions">
                                <button class="btn btn-success mv-icon-btn orderEditBtn"
                                    data-id="<?= $ord['o_id'] ?>" data-mid="<?= $ord['m_id'] ?>"
                                    data-price="<?= $ord['price'] ?>" data-quantity="<?= $ord['quantity'] ?>"
                                    data-total="<?= $ord['total_amount'] ?>" data-status="<?= $ord['status'] ?>"
                                    data-date="<?= $ord['order_date'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-danger mv-icon-btn orderDeleteBtn"
                                    data-id="<?= $ord['o_id'] ?>" data-quantity="<?= $ord['quantity'] ?>"
                                    data-total="<?= $ord['total_amount'] ?>">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center">No Data Found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
            $fp = http_build_query(array_filter($f, fn($v) => $v !== '' && $v !== null));
            echo generatePaginationLinks($p['currentPage'], $p['totalPages'], '/pharmacy/orders?page={page}' . ($fp ? "&{$fp}" : ''));
        ?>
    </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#order_add_search').on('keyup', function() {
        var query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: '/api/pharmacy/search-medicine',
                method: 'POST',
                data: { search: query },
                success: function(data) {
                    $('#order_add_display').html(data).addClass('show');
                }
            });
        } else {
            $('#order_add_display').html('').removeClass('show');
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

    $('.orderEditBtn').on('click', function() {
        var id = $(this).data('id');
        $('#orderEditForm').attr('action', '/pharmacy/orders/' + id);
        $('#update_id').val(id);
        $('#m_id').val($(this).data('mid'));
        $('#price').val($(this).data('price'));
        $('#quantity').val($(this).data('quantity'));
        $('#total').val($(this).data('total'));
        $('#status').val($(this).data('status'));
        $('#order_date').val($(this).data('date'));
        $('#orderEditModal').modal('show');
    });
    $('.orderDeleteBtn').on('click', function() {
        var id = $(this).data('id');
        $('#orderDeleteForm').attr('action', '/pharmacy/orders/' + id + '/delete');
        $('#delete_id').val(id);
        $('#delete_order_id').text(id);
        $('#delete_quantity').text($(this).data('quantity'));
        $('#delete_total').text($(this).data('total'));
        $('#orderDeleteModal').modal('show');
    });
});

function fill(name) {
    $('#order_add_search').val(name);
    $('#order_add_display').html('').removeClass('show');
    $.ajax({
        url: '/api/pharmacy/medicine-row',
        method: 'POST',
        data: { m_name: name },
        dataType: 'json',
        success: function(med) {
            var today = new Date().toISOString().split('T')[0];
            var row = '<tr>' +
                '<td data-label="Medicine">' + escapeHtml(med.medicine_name) + '<input type="hidden" name="m_id" value="' + encodeURIComponent(med.m_id) + '"></td>' +
                '<td data-label="Price"><input type="number" step="0.01" class="form-control price-input" name="price" value="' + encodeURIComponent(med.buy_price) + '"></td>' +
                '<td data-label="Quantity"><input type="number" class="form-control quantity-input" name="quantity" value="1" min="1" max="' + encodeURIComponent(med.in_stock) + '">' +
                '<span class="quantity-warning"></span></td>' +
                '<td data-label="Total"><input type="number" step="0.01" class="form-control total-input" name="total" value="' + encodeURIComponent(med.buy_price) + '" readonly></td>' +
                '<td data-label="Date"><input type="date" class="form-control date-input" name="order_date" value="' + today + '">' +
                '<span class="date-warning"></span></td>' +
                '<td class="mv-actions-cell"><button type="submit" name="add-order" class="btn btn-danger submit-order-btn">Submit Order</button></td>' +
                '</tr>';
            $('#order_add_product_info').html(row);
        }
    });
}
</script>
