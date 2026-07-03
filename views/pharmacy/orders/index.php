<?php $p = $pagination; $f = $filters ?? []; ?>

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
        <a href="/pharmacy/orders/create" class="btn btn-danger">Add Order</a>
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
                <tr><th>ID</th><th>M_ID</th><th>MEDICINE</th><th>PRICE</th><th>QUANTITY</th><th>TOTAL</th><th>STATUS</th><th>DATE</th><th>ACTION</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $ord): ?>
                    <tr>
                        <td data-label="ID"><?= $ord['o_id'] ?></td>
                        <td data-label="Medicine ID"><?= $ord['m_id'] ?></td>
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
                    <tr><td colspan="9" class="text-center">No Data Found</td></tr>
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
</script>
