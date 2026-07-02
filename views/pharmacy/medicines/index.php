<?php $p = $pagination; $f = $filters ?? []; ?>

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

<div class="bg-white">
    <div class="row px-3 pt-4">
        <div class="col"><h1 class="fw-normal mb-3">Medicine Table</h1></div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-4 px-3">
        <div class="col-12">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" placeholder="Search medicine name..." value="<?= htmlspecialchars($f['search'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['c_id'] ?>" <?= (($f['category'] ?? '') == $cat['c_id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="exp_date_from" value="<?= htmlspecialchars($f['exp_date_from'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="exp_date_to" value="<?= htmlspecialchars($f['exp_date_to'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="number" class="form-control" name="buy_price_min" placeholder="Min Buy" value="<?= htmlspecialchars($f['buy_price_min'] ?? '') ?>">
                        <input type="number" class="form-control" name="buy_price_max" placeholder="Max Buy" value="<?= htmlspecialchars($f['buy_price_max'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="number" class="form-control" name="sell_price_min" placeholder="Min Sell" value="<?= htmlspecialchars($f['sell_price_min'] ?? '') ?>">
                        <input type="number" class="form-control" name="sell_price_max" placeholder="Max Sell" value="<?= htmlspecialchars($f['sell_price_max'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="number" class="form-control" name="stock_min" placeholder="Min Stock" value="<?= htmlspecialchars($f['stock_min'] ?? '') ?>">
                        <input type="number" class="form-control" name="stock_max" placeholder="Max Stock" value="<?= htmlspecialchars($f['stock_max'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-danger">Filter</button>
                    <a href="/pharmacy/medicines" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <p class="text-muted px-3">
        Showing <?= ($p['currentPage'] - 1) * 10 + 1 ?> to <?= min($p['currentPage'] * 10, $p['totalRecords']) ?> of <?= $p['totalRecords'] ?> entries
    </p>

    <div class="table-responsive px-3 pt-4 mb-5">
        <table class="table table-striped">
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
                        $expDate = new DateTime($med['exp_date']);
                        $today = new DateTime();
                        $daysDiff = (int) $today->diff($expDate)->format('%a');
                        $expiring = $daysDiff < 30;

                        // Find category name
                        $catName = 'Unknown';
                        foreach ($categories as $cat) {
                            if ($cat['c_id'] == $med['c_id']) { $catName = $cat['category_name']; break; }
                        }
                    ?>
                    <tr>
                        <td class="<?= $expiring ? 'bg-danger text-light' : '' ?>"><?= $med['m_id'] ?></td>
                        <td><?= htmlspecialchars($med['medicine_name']) ?></td>
                        <td><?= htmlspecialchars($med['medicine_desc']) ?></td>
                        <td><?= htmlspecialchars($catName) ?></td>
                        <td><?= $med['in_stock'] ?></td>
                        <td><?= $med['buy_price'] ?></td>
                        <td><?= $med['sell_price'] ?></td>
                        <td><?= $med['exp_date'] ?></td>
                        <td class="row g-0" style="height: 100px;">
                            <div class="col">
                                <button class="btn btn-success btn-md px-3 py-2 my-2 medicineeditbtn"
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
                            </div>
                            <div class="col">
                                <button class="btn btn-danger btn-md px-3 py-2 my-2 medicineDeleteBtn"
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
            $filter_params = http_build_query(array_filter($f, fn($v) => $v !== '' && $v !== null));
            $pagination_url = '/pharmacy/medicines?page={page}' . ($filter_params ? '&' . $filter_params : '');
            echo generatePaginationLinks($p['currentPage'], $p['totalPages'], $pagination_url);
        ?>
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
