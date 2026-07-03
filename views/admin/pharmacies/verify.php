<?= pageHeader('Verification', 'Review and approve pharmacy verification requests.') ?>

<div data-tabs>
<div class="tabs-list" style="margin-bottom:1rem;">
    <button type="button" class="tabs-trigger" data-tab="pending" aria-selected="true">Pending (<?= $pendingCount ?>)</button>
    <button type="button" class="tabs-trigger" data-tab="verified" aria-selected="false">Verified (<?= $verifiedCount ?>)</button>
</div>

<div data-tab-panel="pending">
    <?php if (!empty($pending)): ?>
        <div class="grid-2col">
            <?php foreach ($pending as $p): ?>
                <div class="card">
                    <div class="card__content">
                        <h3 style="font-size:1rem;font-weight:600;margin:0 0 0.5rem;"><?= htmlspecialchars($p['pharmacy_name'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="text-sm text-muted" style="margin:0 0 0.25rem;">Email: <?= htmlspecialchars($p['email'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="text-sm text-muted" style="margin:0 0 0.25rem;">License: <?= htmlspecialchars($p['license_number'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="text-sm text-muted" style="margin:0 0 0.75rem;">Requested: <?= date('F j, Y', strtotime($p['verification_request_date'])) ?></p>
                        <?php if (!empty($p['reg_document'])): ?>
                            <a href="/uploads/documents/<?= htmlspecialchars(basename($p['reg_document']), ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn--outline btn--sm" style="border-style:dashed;margin-bottom:0.75rem;">
                                <?= lucide('file-text', 'icon-4') ?> View document
                            </a>
                        <?php endif; ?>
                        <div style="display:flex;gap:0.5rem;">
                            <button type="button" class="btn btn--outline" style="flex:1;" data-dialog-open="#reject-dialog" data-form-action="/admin/pharmacies/<?= $p['pharmacy_id'] ?>/reject">Reject</button>
                            <button type="button" class="btn btn--primary" style="flex:1;" data-dialog-open="#approve-dialog" data-form-action="/admin/pharmacies/<?= $p['pharmacy_id'] ?>/approve">Approve</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-sm text-muted">No pending verification requests.</p>
    <?php endif; ?>
</div>

<div data-tab-panel="verified" hidden>
    <div class="data-table-wrap">
        <table class="data-table">
            <thead><tr><th>Pharmacy</th><th>Email</th><th>License</th><th>Verified date</th></tr></thead>
            <tbody>
                <?php if (!empty($verified)): ?>
                    <?php foreach ($verified as $v): ?>
                        <tr>
                            <td style="font-weight:500;"><?= htmlspecialchars($v['pharmacy_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($v['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($v['license_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= date('F j, Y', strtotime($v['verification_date'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="empty-row"><td colspan="4">No verified pharmacies yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Approve dialog -->
<dialog id="approve-dialog" class="dialog">
    <form action="" method="POST">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">Approve pharmacy</h2>
            <p class="dialog__description">Optionally add a note for this decision.</p>
        </div>
        <div class="field">
            <label class="label" for="approve-notes">Notes</label>
            <textarea class="textarea" id="approve-notes" name="verification_notes" placeholder="Notes (optional)"></textarea>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--primary">Approve</button>
        </div>
    </form>
</dialog>

<!-- Reject dialog -->
<dialog id="reject-dialog" class="dialog">
    <form action="" method="POST">
        <?= csrf_field() ?>
        <div class="dialog__header">
            <h2 class="dialog__title">Reject verification request</h2>
            <p class="dialog__description">This will clear the pharmacy's request so they can resubmit.</p>
        </div>
        <div class="field">
            <label class="label" for="reject-notes">Notes</label>
            <textarea class="textarea" id="reject-notes" name="verification_notes" placeholder="Reason (optional)"></textarea>
        </div>
        <div class="dialog__footer">
            <button type="button" class="btn btn--outline" data-dialog-close>Cancel</button>
            <button type="submit" class="btn btn--destructive">Reject</button>
        </div>
    </form>
</dialog>
