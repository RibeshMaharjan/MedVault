<?php $p = $pagination; $f = $filters ?? []; ?>

<!-- Edit Modal -->
<div class="modal fade" id="salesEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h1 class="modal-title fs-5">Sales Edit</h1><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="" method="POST" id="salesEditForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <input type="hidden" name="m_id" id="m_id">
                    <div class="mb-3"><label class="form-label">Medicine Name</label><input class="form-control" type="text" id="name" name="name"></div>
                    <div class="mb-3"><label class="form-label">Price</label><input type="text" class="form-control" id="price" name="price" required></div>
                    <div class="mb-3"><label class="form-label">Quantity</label><input type="text" class="form-control" id="quantity" name="quantity" required></div>
                    <div class="mb-3"><label class="form-label">Total</label><input type="text" class="form-control" id="total" name="total" required></div>
                    <div class="mb-3"><label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status"><option value="pending">Pending</option><option value="completed">Completed</option><option value="cancelled">Cancelled</option></select>
                    </div>
                    <div class="mb-3"><label class="form-label">Sales Date</label><input type="date" class="form-control" id="sales_date" name="sales_date"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-sales">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="salesDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white"><h1 class="modal-title fs-5">Confirm Delete</h1><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="" method="POST" id="salesDeleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="delete_sales_id" id="delete_sales_id">
                    <p>Are you sure you want to delete this sale?</p>
                    <div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone.</div>
                    <p><strong>Sale ID:</strong> <span id="delete_sales_display_id"></span></p>
                    <p><strong>Quantity:</strong> <span id="delete_sales_quantity"></span></p>
                    <p><strong>Total:</strong> <span id="delete_sales_total"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete-sales">Delete Sale</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Sales</h1>
            <p class="mv-page-subtitle">Review sale transactions and status changes.</p>
        </div>
        <a href="/pharmacy/sales/create" class="btn btn-danger">Add Sale</a>
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
                <a href="/pharmacy/sales" class="btn btn-secondary">Reset</a>
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
                <?php if (!empty($sales)): ?>
                    <?php foreach ($sales as $s): ?>
                    <tr>
                        <td data-label="ID"><?= $s['s_id'] ?></td>
                        <td data-label="Medicine ID"><?= $s['m_id'] ?></td>
                        <td data-label="Medicine"><?= htmlspecialchars($s['medicine_name'] ?? $s['m_id']) ?></td>
                        <td data-label="Price"><?= $s['price'] ?></td>
                        <td data-label="Quantity"><?= $s['quantity'] ?></td>
                        <td data-label="Total"><?= $s['total_amount'] ?></td>
                        <td data-label="Status"><span class="badge <?= $s['status'] == 'completed' ? 'bg-success' : ($s['status'] == 'cancelled' ? 'bg-danger' : 'bg-warning') ?>"><?= $s['status'] ?></span></td>
                        <td data-label="Date"><?= $s['sales_date'] ?></td>
                        <td class="mv-actions-cell" data-label="Action">
                            <div class="mv-icon-actions">
                                <button class="btn btn-success mv-icon-btn salesEditBtn"
                                    data-id="<?= $s['s_id'] ?>" data-mid="<?= $s['m_id'] ?>"
                                    data-price="<?= $s['price'] ?>" data-quantity="<?= $s['quantity'] ?>"
                                    data-total="<?= $s['total_amount'] ?>" data-status="<?= $s['status'] ?>"
                                    data-date="<?= $s['sales_date'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-danger mv-icon-btn salesDeleteBtn"
                                    data-id="<?= $s['s_id'] ?>" data-quantity="<?= $s['quantity'] ?>"
                                    data-total="<?= $s['total_amount'] ?>">
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
            echo generatePaginationLinks($p['currentPage'], $p['totalPages'], '/pharmacy/sales?page={page}' . ($fp ? "&{$fp}" : ''));
        ?>
    </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.salesEditBtn').on('click', function() {
        var id = $(this).data('id');
        $('#salesEditForm').attr('action', '/pharmacy/sales/' + id);
        $('#update_id').val(id);
        $('#m_id').val($(this).data('mid'));
        $('#price').val($(this).data('price'));
        $('#quantity').val($(this).data('quantity'));
        $('#total').val($(this).data('total'));
        $('#status').val($(this).data('status'));
        $('#sales_date').val($(this).data('date'));
        $('#salesEditModal').modal('show');
    });
    $('.salesDeleteBtn').on('click', function() {
        var id = $(this).data('id');
        $('#salesDeleteForm').attr('action', '/pharmacy/sales/' + id + '/delete');
        $('#delete_sales_id').val(id);
        $('#delete_sales_display_id').text(id);
        $('#delete_sales_quantity').text($(this).data('quantity'));
        $('#delete_sales_total').text($(this).data('total'));
        $('#salesDeleteModal').modal('show');
    });
});
</script>
