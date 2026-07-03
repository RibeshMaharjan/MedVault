<?= pageHeader('Dashboard', 'Platform overview across pharmacies and admins.') ?>

<div class="grid-stats">
    <?= statCard('Pharmacies', (string) $totalPharmacies, 'building-2', 'default') ?>
    <?= statCard('Verified', (string) $verifiedCount, 'shield-check', 'success') ?>
    <?= statCard('Pending', (string) $pendingCount, 'clock', 'warning') ?>
    <?= statCard('Admins', (string) $totalAdmins, 'users', 'info') ?>
</div>

<div class="grid-2col" style="margin-top:1.5rem;">
    <div class="card">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Recent pharmacies</div></div>
        <div class="card__content list-card">
            <?php if (empty($recentPharmacies)): ?>
                <p class="text-sm text-muted">No pharmacies yet.</p>
            <?php else: ?>
                <?php foreach ($recentPharmacies as $ph): ?>
                    <div class="list-row">
                        <p class="list-row__title"><?= htmlspecialchars($ph['pharmacy_name'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?= statusBadge((int) $ph['isverified'] === 1 ? 'verified' : 'unverified') ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Verification queue</div></div>
        <div class="card__content list-card">
            <?php if (empty($verificationQueue)): ?>
                <p class="text-sm text-muted">No pending verification requests.</p>
            <?php else: ?>
                <?php foreach ($verificationQueue as $ph): ?>
                    <div class="list-row">
                        <p class="list-row__title"><?= htmlspecialchars($ph['pharmacy_name'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?= statusBadge('pending') ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
