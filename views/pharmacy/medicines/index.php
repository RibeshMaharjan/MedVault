<?php $p = $pagination; $f = $filters ?? []; ?>

<?= pageHeader('Medicines', 'Manage your pharmacy\'s medicine catalogue.', '<button type="button" class="btn btn--primary" data-dialog-open="#medicine-create">' . lucide('plus', 'icon-4') . ' Add medicine</button>') ?>

<div class="card" style="padding:0.75rem;margin-bottom:0.75rem;">
    <form method="GET" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(9rem,1fr));gap:0.5rem;">
        <input type="text" class="input" name="search" placeholder="Search by name…" value="<?= htmlspecialchars($f['search'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <select class="select" name="category">
            <option value="">All categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['c_id'] ?>" <?= (($f['category'] ?? '') == $cat['c_id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" class="input" name="exp_date_from" placeholder="Expiry from" value="<?= htmlspecialchars($f['exp_date_from'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="date" class="input" name="exp_date_to" placeholder="Expiry to" value="<?= htmlspecialchars($f['exp_date_to'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="number" min="0" class="input" name="stock_min" placeholder="Min stock" value="<?= htmlspecialchars($f['stock_min'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="number" min="0" class="input" name="stock_max" placeholder="Max stock" value="<?= htmlspecialchars($f['stock_max'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div style="display:flex;gap:0.5rem;">
            <button type="submit" class="btn btn--primary" style="flex:1;">Filter</button>
            <a href="/pharmacy/medicines" class="btn btn--outline" style="flex:1;text-align:center;">Reset</a>
        </div>
    </form>
</div>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <?= sortableTh('Medicine') ?>
                <th>Category</th>
                <?= sortableTh('Stock', 'text-right') ?>
                <?= sortableTh('Buy', 'text-right') ?>
                <?= sortableTh('Sell', 'text-right') ?>
                <?= sortableTh('Expiry') ?>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($medicines)): ?>
                <?php foreach ($medicines as $med): ?>
                    <?php
                        $expDate = new DateTime($med['exp_date']);
                        $today = new DateTime();
                        $daysDiff = (int) $today->diff($expDate)->format('%a');
                        $expiring = $expDate < $today ? true : $daysDiff < 90;
                        $lowStock = (int) $med['in_stock'] < 20;

                        $catName = 'Unknown';
                        foreach ($categories as $cat) {
                            if ($cat['c_id'] == $med['c_id']) { $catName = $cat['category_name']; break; }
                        }

                        $fields = json_encode([
                            'update_id' => $med['m_id'],
                            'name' => $med['medicine_name'],
                            'description' => $med['medicine_desc'],
                            'category' => $med['c_id'],
                            'in_stock' => $med['in_stock'],
                            'buy_price' => $med['buy_price'],
                            'sell_price' => $med['sell_price'],
                            'exp_date' => $med['exp_date'],
                        ]);
                    ?>
                    <tr>
                        <td>
                            <div style="font-weight:500;"><?= htmlspecialchars($med['medicine_name'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-xs text-muted"><?= htmlspecialchars($med['medicine_desc'], ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td><span class="badge badge--secondary"><?= htmlspecialchars($catName, ENT_QUOTES, 'UTF-8') ?></span></td>
                        <td class="text-right tabular-nums<?= $lowStock ? ' text-warning' : '' ?>" style="<?= $lowStock ? 'font-weight:500;' : '' ?>"><?= $med['in_stock'] ?></td>
                        <td class="text-right tabular-nums">$<?= number_format((float) $med['buy_price'], 2) ?></td>
                        <td class="text-right tabular-nums">$<?= number_format((float) $med['sell_price'], 2) ?></td>
                        <td class="<?= $expiring ? 'text-destructive' : '' ?>"><?= $med['exp_date'] ?></td>
                        <td class="text-right">
                            <button type="button" class="btn btn--ghost btn--icon" data-dialog-open="#medicine-edit" data-fields='<?= htmlspecialchars($fields, ENT_QUOTES, 'UTF-8') ?>' data-form-action="/pharmacy/medicines/<?= $med['m_id'] ?>" aria-label="Edit">
                                <?= lucide('pencil', 'icon-4') ?>
                            </button>
                            <form action="/pharmacy/medicines/<?= $med['m_id'] ?>/delete" method="POST" style="display:inline;" data-confirm="Delete <?= htmlspecialchars($med['medicine_name'], ENT_QUOTES, 'UTF-8') ?>? This action cannot be undone.">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn--ghost btn--icon text-destructive" aria-label="Delete"><?= lucide('trash-2', 'icon-4') ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="7">No medicines to display.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
    $filter_params = http_build_query(array_filter($f, fn($v) => $v !== '' && $v !== null));
    $pagination_url = '/pharmacy/medicines?page={page}' . ($filter_params ? '&' . $filter_params : '');
    echo generateTableFooter($p['currentPage'], 10, $p['totalRecords'], $pagination_url);
?>

<!-- Add medicine dialog -->
<dialog id="medicine-create" class="dialog" <?= ($_GET['open'] ?? '') === 'create' ? 'data-auto-open' : '' ?>>
    <form action="/pharmacy/medicines" method="POST" autocomplete="off">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">Add medicine</h2>
            <p class="dialog__description">Add a new medicine to your catalogue.</p>
        </div>
        <div class="field-group field-group--2col">
            <div class="field" style="grid-column:1 / -1;">
                <label class="label" for="name">Medicine name</label>
                <input class="input" type="text" id="name" name="name" required>
            </div>
            <div class="field" style="grid-column:1 / -1;">
                <label class="label" for="description">Description</label>
                <textarea class="textarea" id="description" name="description"></textarea>
            </div>
            <div class="field">
                <label class="label" for="category">Category</label>
                <select class="select" id="category" name="category" required>
                    <option value="">Select category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['c_id'] ?>"><?= htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label class="label" for="quantity">Stock</label>
                <input type="number" class="input" id="quantity" name="quantity" required>
            </div>
            <div class="field">
                <label class="label" for="buy_price">Buy price</label>
                <input type="number" step="0.01" class="input" id="buy_price" name="buy_price" required>
            </div>
            <div class="field">
                <label class="label" for="sell_price">Sell price</label>
                <input type="number" step="0.01" class="input" id="sell_price" name="sell_price" required>
            </div>
            <div class="field" style="grid-column:1 / -1;">
                <label class="label" for="exp_date">Expiration date</label>
                <input type="date" class="input" id="exp_date" name="exp_date" required>
            </div>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Add medicine</button>
        </div>
    </form>
</dialog>

<!-- Edit medicine dialog -->
<dialog id="medicine-edit" class="dialog">
    <form action="" method="POST" autocomplete="off">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">Edit medicine</h2>
        </div>
        <div class="field-group field-group--2col">
            <div class="field" style="grid-column:1 / -1;">
                <label class="label" for="edit-name">Medicine name</label>
                <input class="input" type="text" id="edit-name" name="name">
            </div>
            <div class="field" style="grid-column:1 / -1;">
                <label class="label" for="edit-description">Description</label>
                <textarea class="textarea" id="edit-description" name="description"></textarea>
            </div>
            <div class="field">
                <label class="label" for="edit-category">Category</label>
                <select class="select" id="edit-category" name="category">
                    <option value="">Select category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['c_id'] ?>"><?= htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label class="label" for="edit-in_stock">Stock</label>
                <input type="number" class="input" id="edit-in_stock" name="in_stock">
            </div>
            <div class="field">
                <label class="label" for="edit-buy_price">Buy price</label>
                <input type="number" step="0.01" class="input" id="edit-buy_price" name="buy_price">
            </div>
            <div class="field">
                <label class="label" for="edit-sell_price">Sell price</label>
                <input type="number" step="0.01" class="input" id="edit-sell_price" name="sell_price">
            </div>
            <div class="field" style="grid-column:1 / -1;">
                <label class="label" for="edit-exp_date">Expiration date</label>
                <input type="date" class="input" id="edit-exp_date" name="exp_date">
            </div>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Save changes</button>
        </div>
    </form>
</dialog>
