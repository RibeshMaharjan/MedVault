<?= pageHeader('Pharmacies', 'All registered pharmacies on the platform.', '<button type="button" class="btn btn--primary" data-dialog-open="#pharmacy-create">' . lucide('plus', 'icon-4') . ' New pharmacy</button>') ?>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <?= sortableTh('Pharmacy') ?>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pharmacies)): ?>
                <?php foreach ($pharmacies as $p): ?>
                    <tr>
                        <td>
                            <div style="font-weight:500;"><?= htmlspecialchars($p['pharmacy_name'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-xs text-muted">PAN: <?= htmlspecialchars($p['pan'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td><?= htmlspecialchars($p['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($p['phone'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= statusBadge(($p['isverified'] ?? 0) ? 'verified' : 'unverified') ?></td>
                        <td class="text-right">
                            <form action="/admin/pharmacies/<?= $p['pharmacy_id'] ?>/delete" method="POST" style="display:inline;" data-confirm="Delete <?= htmlspecialchars($p['pharmacy_name'], ENT_QUOTES, 'UTF-8') ?>? This action cannot be undone.">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn--ghost btn--icon text-destructive" aria-label="Delete"><?= lucide('trash-2', 'icon-4') ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="5">No pharmacies to display.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- New pharmacy dialog -->
<dialog id="pharmacy-create" class="dialog" <?= ($_GET['open'] ?? '') === 'create' ? 'data-auto-open' : '' ?>>
    <form action="/admin/pharmacies" method="POST" autocomplete="off">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">New pharmacy</h2>
        </div>
        <div class="field-group field-group--2col">
            <div class="field">
                <label class="label" for="pan">PAN number</label>
                <input class="input" type="text" id="pan" name="pan" required>
            </div>
            <div class="field">
                <label class="label" for="name">Pharmacy name</label>
                <input class="input" type="text" id="name" name="name" required>
            </div>
            <div class="field">
                <label class="label" for="email">Email</label>
                <input class="input" type="email" id="email" name="email" required>
            </div>
            <div class="field">
                <label class="label" for="password">Password</label>
                <input class="input" type="password" id="password" name="password" required>
            </div>
            <div class="field">
                <label class="label" for="phone">Phone</label>
                <input class="input" type="text" id="phone" name="phone" required>
            </div>
            <div class="field">
                <label class="label" for="address">Address</label>
                <input class="input" type="text" id="address" name="address" required>
            </div>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Create pharmacy</button>
        </div>
    </form>
</dialog>
