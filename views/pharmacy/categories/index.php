<?= pageHeader('Categories', 'Organize medicines into categories.', '<button type="button" class="btn btn--primary" data-dialog-open="#category-create">' . lucide('plus', 'icon-4') . ' New category</button>') ?>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Category</th>
                <th class="text-right">Medicines</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <?php $fields = json_encode(['update_id' => $cat['c_id'], 'name' => $cat['category_name']]); ?>
                    <tr>
                        <td style="font-weight:500;"><?= htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="text-right tabular-nums"><?= (int) $cat['medicine_count'] ?></td>
                        <td class="text-right">
                            <button type="button" class="btn btn--ghost btn--icon" data-dialog-open="#category-edit" data-fields='<?= htmlspecialchars($fields, ENT_QUOTES, 'UTF-8') ?>' data-form-action="/pharmacy/categories/<?= $cat['c_id'] ?>" aria-label="Edit">
                                <?= lucide('pencil', 'icon-4') ?>
                            </button>
                            <?php if ((int) $cat['medicine_count'] === 0): ?>
                                <form action="/pharmacy/categories/<?= $cat['c_id'] ?>/delete" method="POST" style="display:inline;" data-confirm="Delete category &quot;<?= htmlspecialchars($cat['category_name'], ENT_QUOTES, 'UTF-8') ?>&quot;? This action cannot be undone.">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn--ghost btn--icon text-destructive" aria-label="Delete"><?= lucide('trash-2', 'icon-4') ?></button>
                                </form>
                            <?php else: ?>
                                <button type="button" class="btn btn--ghost btn--icon text-muted" disabled title="Reassign medicines before deleting"><?= lucide('trash-2', 'icon-4') ?></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="3">No categories to display.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- New category dialog -->
<dialog id="category-create" class="dialog" <?= ($_GET['open'] ?? '') === 'create' ? 'data-auto-open' : '' ?>>
    <form action="/pharmacy/categories" method="POST">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">New category</h2>
        </div>
        <div class="field">
            <label class="label" for="category-name">Category name</label>
            <input class="input" type="text" id="category-name" name="category-name" required>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Create</button>
        </div>
    </form>
</dialog>

<!-- Edit category dialog -->
<dialog id="category-edit" class="dialog">
    <form action="" method="POST">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">Rename category</h2>
        </div>
        <div class="field">
            <label class="label" for="edit-category-name">Category name</label>
            <input class="input" type="text" id="edit-category-name" name="name">
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Save changes</button>
        </div>
    </form>
</dialog>
