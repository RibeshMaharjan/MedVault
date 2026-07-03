<?= pageHeader('Admins', 'Platform administrator accounts.', '<button type="button" class="btn btn--primary" data-dialog-open="#admin-create">' . lucide('plus', 'icon-4') . ' New admin</button>') ?>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>D.O.B</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($admins)): ?>
                <?php foreach ($admins as $a): ?>
                    <tr>
                        <td style="font-weight:500;"><?= htmlspecialchars($a['name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($a['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($a['phone'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="text-transform:capitalize;"><?= htmlspecialchars($a['gender'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= !empty($a['dob']) ? date('M d, Y', strtotime($a['dob'])) : '—' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="5">No admins to display.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- New admin dialog -->
<dialog id="admin-create" class="dialog" <?= ($_GET['open'] ?? '') === 'create' ? 'data-auto-open' : '' ?>>
    <form action="/admin/admins" method="POST" autocomplete="off">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">New admin</h2>
        </div>
        <div class="field-group field-group--2col">
            <div class="field">
                <label class="label" for="name">Name</label>
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
                <label class="label" for="gender">Gender</label>
                <select class="select" id="gender" name="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="field">
                <label class="label" for="phone">Phone</label>
                <input class="input" type="text" id="phone" name="phone" required>
            </div>
            <div class="field">
                <label class="label" for="birth">Date of birth</label>
                <input class="input" type="date" id="birth" name="birth" required>
            </div>
            <div class="field" style="grid-column:1 / -1;">
                <label class="label" for="address">Address</label>
                <input class="input" type="text" id="address" name="address" required>
            </div>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Create admin</button>
        </div>
    </form>
</dialog>
