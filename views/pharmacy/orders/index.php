<?php $p = $pagination; $f = $filters ?? []; ?>

<?= pageHeader('Purchase orders', 'Track medicine restocking orders.', '<button type="button" class="btn btn--primary" data-dialog-open="#order-create">' . lucide('plus', 'icon-4') . ' New order</button>') ?>

<div class="card" style="padding:0.75rem;margin-bottom:0.75rem;">
    <form method="GET" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(9rem,1fr));gap:0.5rem;">
        <select class="select" name="status">
            <option value="">All statuses</option>
            <option value="pending" <?= (($f['status'] ?? '') === 'pending') ? 'selected' : '' ?>>Pending</option>
            <option value="completed" <?= (($f['status'] ?? '') === 'completed') ? 'selected' : '' ?>>Completed</option>
            <option value="cancelled" <?= (($f['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <input type="date" class="input" name="date_from" placeholder="Date from" value="<?= htmlspecialchars($f['date_from'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="date" class="input" name="date_to" placeholder="Date to" value="<?= htmlspecialchars($f['date_to'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div style="display:flex;gap:0.5rem;">
            <button type="submit" class="btn btn--primary" style="flex:1;">Filter</button>
            <a href="/pharmacy/orders" class="btn btn--outline" style="flex:1;text-align:center;">Reset</a>
        </div>
    </form>
</div>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <?= sortableTh('Medicine') ?>
                <?= sortableTh('Price', 'text-right') ?>
                <?= sortableTh('Qty', 'text-right') ?>
                <?= sortableTh('Total', 'text-right') ?>
                <th>Status</th>
                <?= sortableTh('Date') ?>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $ord): ?>
                    <?php $fields = json_encode([
                        'update_id' => $ord['o_id'],
                        'quantity' => $ord['quantity'],
                        'status' => $ord['status'],
                        'order_date' => $ord['order_date'],
                    ]); ?>
                    <tr>
                        <td style="font-weight:500;"><?= htmlspecialchars($ord['medicine_name'] ?? ('#' . $ord['m_id']), ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="text-right tabular-nums">$<?= number_format((float) $ord['price'], 2) ?></td>
                        <td class="text-right tabular-nums"><?= $ord['quantity'] ?></td>
                        <td class="text-right tabular-nums">$<?= number_format((float) $ord['total_amount'], 2) ?></td>
                        <td><?= statusBadge($ord['status']) ?></td>
                        <td><?= date('M d, Y', strtotime($ord['order_date'])) ?></td>
                        <td class="text-right">
                            <button type="button" class="btn btn--ghost btn--icon"
                                data-dialog-open="#order-edit"
                                data-fields='<?= htmlspecialchars($fields, ENT_QUOTES, 'UTF-8') ?>'
                                data-form-action="/pharmacy/orders/<?= $ord['o_id'] ?>"
                                aria-label="Edit">
                                <?= lucide('pencil', 'icon-4') ?>
                            </button>
                            <form action="/pharmacy/orders/<?= $ord['o_id'] ?>/delete" method="POST" style="display:inline;" data-confirm="Delete this order? This action cannot be undone.">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn--ghost btn--icon text-destructive" aria-label="Delete"><?= lucide('trash-2', 'icon-4') ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="7">No orders to display.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
    $fp = http_build_query(array_filter($f, fn($v) => $v !== '' && $v !== null));
    echo generateTableFooter($p['currentPage'], 10, $p['totalRecords'], '/pharmacy/orders?page={page}' . ($fp ? "&{$fp}" : ''));
?>

<!-- New order dialog -->
<dialog id="order-create" class="dialog dialog--lg" <?= ($_GET['open'] ?? '') === 'create' ? 'data-auto-open' : '' ?>>
    <form action="/pharmacy/orders" method="POST" id="order-create-form">
        <?= csrf_field() ?>
        <input type="hidden" name="m_id" value="">
        <div class="dialog__header">
            <h2 class="dialog__title">New order</h2>
            <p class="dialog__description">Search a medicine to add it to this order.</p>
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
                    <label class="label">Order date</label>
                    <input type="date" class="input" name="order_date" data-txn-date>
                    <p class="text-xs text-destructive" data-txn-date-warning></p>
                </div>
            </div>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary" data-txn-submit disabled>New order</button>
        </div>
    </form>
</dialog>

<!-- Edit order dialog -->
<dialog id="order-edit" class="dialog">
    <form action="" method="POST">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">Edit order</h2>
        </div>
        <div class="field">
            <label class="label" for="edit-order-quantity">Quantity</label>
            <input type="number" class="input" id="edit-order-quantity" name="quantity" min="1">
        </div>
        <div class="field">
            <label class="label" for="edit-order-status">Status</label>
            <select class="select" id="edit-order-status" name="status">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="field">
            <label class="label" for="edit-order-date">Order date</label>
            <input type="date" class="input" id="edit-order-date" name="order_date">
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Save changes</button>
        </div>
    </form>
</dialog>

<script src="/assets/js/transactions.js" defer></script>
