<?php $p = $pagination; $f = $filters ?? []; ?>

<?= pageHeader('Sales', 'Track medicine sales and revenue.', '<button type="button" class="btn btn--primary" data-dialog-open="#sale-create">' . lucide('plus', 'icon-4') . ' New sale</button>') ?>

<div class="card" style="padding:0.75rem;margin-bottom:0.75rem;">
    <form method="GET" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(9rem,1fr));gap:0.75rem;align-items:end;">
        <div>
            <label class="label" style="margin-bottom:0.25rem;">Status</label>
            <select class="select" name="status">
                <option value="">All status</option>
                <option value="pending" <?= (($f['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
                <option value="completed" <?= (($f['status'] ?? '') === 'completed') ? 'selected' : '' ?>>Completed</option>
                <option value="cancelled" <?= (($f['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="label" style="margin-bottom:0.25rem;">Date from</label>
            <input type="date" class="input" name="date_from" value="<?= htmlspecialchars($f['date_from'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div>
            <label class="label" style="margin-bottom:0.25rem;">Date to</label>
            <input type="date" class="input" name="date_to" value="<?= htmlspecialchars($f['date_to'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div style="display:flex;gap:0.5rem;">
            <button type="submit" class="btn btn--primary">Filter</button>
            <a href="/pharmacy/sales" class="btn btn--outline">Reset</a>
        </div>
    </form>
</div>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Medicine</th>
                <th class="text-right">Price</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
                <th>Status</th>
                <th>Date</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sales)): ?>
                <?php foreach ($sales as $sale): ?>
                    <?php $fields = json_encode([
                        'update_id' => $sale['s_id'],
                        'quantity' => $sale['quantity'],
                        'status' => $sale['status'],
                        'sales_date' => $sale['sales_date'],
                    ]); ?>
                    <tr>
                        <td style="font-weight:500;"><?= htmlspecialchars($sale['medicine_name'] ?? ('#' . $sale['m_id']), ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="text-right tabular-nums">$<?= number_format((float) $sale['price'], 2) ?></td>
                        <td class="text-right tabular-nums"><?= $sale['quantity'] ?></td>
                        <td class="text-right tabular-nums">$<?= number_format((float) $sale['total_amount'], 2) ?></td>
                        <td><?= statusBadge($sale['status']) ?></td>
                        <td><?= date('M d, Y', strtotime($sale['sales_date'])) ?></td>
                        <td class="text-right">
                            <button type="button" class="btn btn--ghost btn--icon"
                                data-dialog-open="#sale-edit"
                                data-fields='<?= htmlspecialchars($fields, ENT_QUOTES, 'UTF-8') ?>'
                                data-form-action="/pharmacy/sales/<?= $sale['s_id'] ?>"
                                aria-label="Edit">
                                <?= lucide('pencil', 'icon-4') ?>
                            </button>
                            <form action="/pharmacy/sales/<?= $sale['s_id'] ?>/delete" method="POST" style="display:inline;" data-confirm="Delete this sale? This action cannot be undone.">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn--ghost btn--icon text-destructive" aria-label="Delete"><?= lucide('trash-2', 'icon-4') ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="7">No sales to display.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
    $fp = http_build_query(array_filter($f, fn($v) => $v !== '' && $v !== null));
    echo generateTableFooter($p['currentPage'], 10, $p['totalRecords'], '/pharmacy/sales?page={page}' . ($fp ? "&{$fp}" : ''));
?>

<!-- New sale dialog -->
<dialog id="sale-create" class="dialog dialog--lg" <?= ($_GET['open'] ?? '') === 'create' ? 'data-auto-open' : '' ?>>
    <form action="/pharmacy/sales" method="POST" id="sale-create-form">
        <?= csrf_field() ?>
        <input type="hidden" name="m_id" value="">
        <div class="dialog__header">
            <h2 class="dialog__title">New sale</h2>
            <p class="dialog__description">Search a medicine to record a sale.</p>
        </div>
        <div class="combobox" data-combobox data-src="/api/pharmacy/search-medicine">
            <button type="button" class="btn btn--outline combobox__trigger">
                <span class="combobox__trigger-label"><?= lucide('search', 'icon-4') ?> Search medicine…</span>
                <?= lucide('chevrons-up-down', 'icon-4') ?>
            </button>
            <div class="combobox__panel">
                <div class="combobox__search">
                    <?= lucide('search', 'icon-4') ?>
                    <input type="text" placeholder="Type to search…">
                </div>
                <div class="combobox__list"></div>
            </div>
        </div>
        <div data-txn-panel hidden style="margin-top:1rem;">
            <table class="data-table" style="border:1px solid var(--border);border-radius:var(--radius-md);">
                <thead><tr><th>Medicine</th><th class="text-right">Unit price</th><th class="text-right">Total</th></tr></thead>
                <tbody><tr>
                    <td data-txn-name></td>
                    <td class="text-right" data-txn-price></td>
                    <td class="text-right" data-txn-total></td>
                </tr></tbody>
            </table>
            <div class="field-group field-group--2col" style="margin-top:0.75rem;">
                <div class="field">
                    <label class="label">Quantity</label>
                    <input type="number" class="input" name="quantity" min="1" value="1">
                    <p class="text-xs text-destructive" data-txn-quantity-warning></p>
                </div>
                <div class="field">
                    <label class="label">Sale date</label>
                    <input type="date" class="input" name="sales_date" data-txn-date>
                    <p class="text-xs text-destructive" data-txn-date-warning></p>
                </div>
            </div>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary" data-txn-submit disabled>New sale</button>
        </div>
    </form>
</dialog>

<!-- Edit sale dialog -->
<dialog id="sale-edit" class="dialog">
    <form action="" method="POST">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">Edit sale</h2>
        </div>
        <div class="field">
            <label class="label" for="edit-sale-quantity">Quantity</label>
            <input type="number" class="input" id="edit-sale-quantity" name="quantity" min="1">
        </div>
        <div class="field">
            <label class="label" for="edit-sale-status">Status</label>
            <select class="select" id="edit-sale-status" name="status">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="field">
            <label class="label" for="edit-sale-date">Sale date</label>
            <input type="date" class="input" id="edit-sale-date" name="sales_date">
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Save changes</button>
        </div>
    </form>
</dialog>

<script src="/assets/js/transactions.js" defer></script>
