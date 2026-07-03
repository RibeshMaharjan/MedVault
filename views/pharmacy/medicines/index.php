<?php $p = $pagination; $f = $filters ?? []; ?>

<!-- Add Modal -->
<div class="modal fade" id="medicineAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Medicine</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/pharmacy/medicines" method="POST" autocomplete="off">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mv-form-grid">
                        <div class="mb-3">
                            <label for="add_name" class="form-label">Medicine Name</label>
                            <input class="form-control" type="text" id="add_name" placeholder="Medicine Name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_category" class="form-label">Category</label>
                            <select class="form-select" id="add_category" name="category" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['c_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3 full">
                            <label for="add_description" class="form-label">Description</label>
                            <textarea class="form-control" id="add_description" placeholder="Description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="add_quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="add_quantity" placeholder="Quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_buy_price" class="form-label">Buy Price</label>
                            <input type="number" step="0.01" class="form-control" id="add_buy_price" placeholder="Buy Price" name="buy_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_sell_price" class="form-label">Sell Price</label>
                            <input type="number" step="0.01" class="form-control" id="add_sell_price" placeholder="Sell Price" name="sell_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_exp_date" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" id="add_exp_date" name="exp_date" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="add-medicine">Add Medicine</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="medicineeditmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Medicine Edit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="medicineEditForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="mb-3">
                        <label class="form-label">Medicine Name</label>
                        <input class="form-control" type="text" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['c_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">In Stock</label>
                        <input type="number" class="form-control" id="in_stock" name="in_stock">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Buy Price</label>
                        <input type="number" step="0.01" class="form-control" id="buy_price" name="buy_price">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sell Price</label>
                        <input type="number" step="0.01" class="form-control" id="sell_price" name="sell_price">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expiration Date</label>
                        <input type="date" class="form-control" id="exp_date" name="exp_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="update-medicine">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="medicineDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5">Confirm Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="medicineDeleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="delete_medicine_id" id="delete_medicine_id">
                    <p>Are you sure you want to delete this medicine?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>This action cannot be undone.
                    </div>
                    <div class="medicine-details mt-3">
                        <p><strong>Medicine ID:</strong> <span id="delete_medicine_display_id"></span></p>
                        <p><strong>Medicine Name:</strong> <span id="delete_medicine_name"></span></p>
                        <p><strong>In Stock:</strong> <span id="delete_medicine_stock"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete-medicine">Delete Medicine</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Medicines</h1>
            <p class="mv-page-subtitle">Search, filter, and manage stocked medicines.</p>
        </div>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#medicineAddModal">Add Medicine</button>
    </div>

    <!-- Filter Form -->
    <div class="mv-filter-panel">
            <form method="GET" class="mv-filter-grid">
                <div>
                    <input type="text" class="form-control" name="search" placeholder="Search medicine name..." value="<?= htmlspecialchars($f['search'] ?? '') ?>">
                </div>
                <div>
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['c_id'] ?>" <?= (($f['category'] ?? '') == $cat['c_id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select class="form-select" name="expiry_status">
                        <option value="">All Expiry</option>
                        <option value="expired" <?= (($f['expiry_status'] ?? '') === 'expired') ? 'selected' : '' ?>>Expired</option>
                        <option value="expiring_soon" <?= (($f['expiry_status'] ?? '') === 'expiring_soon') ? 'selected' : '' ?>>Expiring Soon</option>
                        <option value="valid" <?= (($f['expiry_status'] ?? '') === 'valid') ? 'selected' : '' ?>>Valid</option>
                    </select>
                </div>
                <div>
                    <input type="date" class="form-control" name="exp_date_from" value="<?= htmlspecialchars($f['exp_date_from'] ?? '') ?>">
                </div>
                <div>
                    <input type="date" class="form-control" name="exp_date_to" value="<?= htmlspecialchars($f['exp_date_to'] ?? '') ?>">
                </div>
                <div>
                    <div class="input-group">
                        <input type="number" class="form-control" name="buy_price_min" placeholder="Min Buy" value="<?= htmlspecialchars($f['buy_price_min'] ?? '') ?>">
                        <input type="number" class="form-control" name="buy_price_max" placeholder="Max Buy" value="<?= htmlspecialchars($f['buy_price_max'] ?? '') ?>">
                    </div>
                </div>
                <div>
                    <div class="input-group">
                        <input type="number" class="form-control" name="sell_price_min" placeholder="Min Sell" value="<?= htmlspecialchars($f['sell_price_min'] ?? '') ?>">
                        <input type="number" class="form-control" name="sell_price_max" placeholder="Max Sell" value="<?= htmlspecialchars($f['sell_price_max'] ?? '') ?>">
                    </div>
                </div>
                <div>
                    <div class="input-group">
                        <input type="number" class="form-control" name="stock_min" placeholder="Min Stock" value="<?= htmlspecialchars($f['stock_min'] ?? '') ?>">
                        <input type="number" class="form-control" name="stock_max" placeholder="Max Stock" value="<?= htmlspecialchars($f['stock_max'] ?? '') ?>">
                    </div>
                </div>
                <div class="mv-filter-actions">
                    <button type="submit" class="btn btn-danger">Filter</button>
                    <a href="/pharmacy/medicines" class="btn btn-secondary">Reset</a>
                </div>
            </form>
    </div>

    <p class="mv-count-line">
        Showing <?= ($p['currentPage'] - 1) * 10 + 1 ?> to <?= min($p['currentPage'] * 10, $p['totalRecords']) ?> of <?= $p['totalRecords'] ?> entries
    </p>

    <div class="mv-table-wrap mb-5">
    <div class="table-responsive">
        <table class="table table-striped mv-responsive-table">
            <thead class="table-danger">
                <tr>
                    <th>ID</th><th>MEDICINE NAME</th><th>DESCRIPTION</th><th>CATEGORY</th>
                    <th>IN STOCK</th><th>BUY PRICE</th><th>SELL PRICE</th><th>EXPIRATION DATE</th><th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($medicines)): ?>
                    <?php foreach ($medicines as $med): ?>
                    <?php
                        $expDate = new DateTimeImmutable($med['exp_date']);
                        $today = new DateTimeImmutable('today');
                        $daysDiff = (int) $today->diff($expDate)->format('%r%a');
                        $expired = $daysDiff < 0;
                        $expiring = !$expired && $daysDiff <= 30;

                        // Find category name
                        $catName = 'Unknown';
                        foreach ($categories as $cat) {
                            if ($cat['c_id'] == $med['c_id']) { $catName = $cat['category_name']; break; }
                        }
                    ?>
                    <tr class="<?= $expired ? 'table-danger' : ($expiring ? 'table-warning' : '') ?>">
                        <td data-label="ID"><?= $med['m_id'] ?></td>
                        <td data-label="Medicine"><?= htmlspecialchars($med['medicine_name']) ?></td>
                        <td data-label="Description"><?= htmlspecialchars($med['medicine_desc']) ?></td>
                        <td data-label="Category"><?= htmlspecialchars($catName) ?></td>
                        <td data-label="In Stock"><?= $med['in_stock'] ?></td>
                        <td data-label="Buy Price"><?= $med['buy_price'] ?></td>
                        <td data-label="Sell Price"><?= $med['sell_price'] ?></td>
                        <td data-label="Expiration">
                            <?= $med['exp_date'] ?>
                            <?php if ($expired): ?>
                                <span class="badge bg-danger ms-1">Expired</span>
                            <?php elseif ($daysDiff === 0): ?>
                                <span class="badge bg-warning text-dark ms-1">Expires today</span>
                            <?php elseif ($expiring): ?>
                                <span class="badge bg-warning text-dark ms-1">Expires soon</span>
                            <?php else: ?>
                                <span class="badge bg-success ms-1">Valid</span>
                            <?php endif; ?>
                        </td>
                        <td class="mv-actions-cell" data-label="Action">
                            <div class="mv-icon-actions">
                                <button class="btn btn-success mv-icon-btn medicineeditbtn"
                                    data-id="<?= $med['m_id'] ?>"
                                    data-name="<?= htmlspecialchars($med['medicine_name']) ?>"
                                    data-description="<?= htmlspecialchars($med['medicine_desc']) ?>"
                                    data-category="<?= $med['c_id'] ?>"
                                    data-instock="<?= $med['in_stock'] ?>"
                                    data-buyprice="<?= $med['buy_price'] ?>"
                                    data-sellprice="<?= $med['sell_price'] ?>"
                                    data-expdate="<?= $med['exp_date'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-danger mv-icon-btn medicineDeleteBtn"
                                    data-id="<?= $med['m_id'] ?>"
                                    data-name="<?= htmlspecialchars($med['medicine_name']) ?>"
                                    data-instock="<?= $med['in_stock'] ?>">
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
            $paginationFilters = $f;
            unset($paginationFilters['page']);
            $filter_params = http_build_query(array_filter($paginationFilters, fn($v) => $v !== '' && $v !== null));
            $pagination_url = '/pharmacy/medicines?page={page}' . ($filter_params ? '&' . $filter_params : '');
            echo generatePaginationLinks($p['currentPage'], $p['totalPages'], $pagination_url);
        ?>
    </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Edit modal
    $('.medicineeditbtn').on('click', function () {
        var btn = $(this);
        var id = btn.data('id');
        $('#medicineEditForm').attr('action', '/pharmacy/medicines/' + id);
        $('#medicineeditmodal').modal('show');
        setTimeout(function() {
            $('#update_id').val(id);
            $('#name').val(btn.data('name'));
            $('#description').val(btn.data('description'));
            $('#category').val(btn.data('category'));
            $('#in_stock').val(btn.data('instock'));
            $('#buy_price').val(btn.data('buyprice'));
            $('#sell_price').val(btn.data('sellprice'));
            var expdate = btn.data('expdate');
            if (expdate) {
                var d = new Date(expdate);
                if (!isNaN(d.getTime())) {
                    $('#exp_date').val(d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0'));
                } else {
                    $('#exp_date').val(expdate);
                }
            }
        }, 300);
    });

    // Delete modal
    $('.medicineDeleteBtn').on('click', function () {
        var id = $(this).data('id');
        $('#medicineDeleteForm').attr('action', '/pharmacy/medicines/' + id + '/delete');
        $('#delete_medicine_id').val(id);
        $('#delete_medicine_display_id').text(id);
        $('#delete_medicine_name').text($(this).data('name'));
        $('#delete_medicine_stock').text($(this).data('instock'));
        $('#medicineDeleteModal').modal('show');
    });
});
</script>
