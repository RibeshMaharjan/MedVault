<div class="mv-overview">
    <div class="mv-overview-header">
        <h1 class="mv-overview-title">Platform overview</h1>
        <p class="mv-overview-subtitle">How MedVault is doing across all pharmacies.</p>
    </div>

    <div class="mv-overview-stats">
        <div class="mv-overview-stat">
            <div class="mv-overview-stat-icon is-blue"><i class="fa-solid fa-building"></i></div>
            <div>
                <p class="mv-overview-stat-label">Pharmacies</p>
                <p class="mv-overview-stat-value"><?= $totalPharmacies ?></p>
            </div>
        </div>
        <div class="mv-overview-stat">
            <div class="mv-overview-stat-icon is-green"><i class="fa-solid fa-shield-halved"></i></div>
            <div>
                <p class="mv-overview-stat-label">Verified</p>
                <p class="mv-overview-stat-value"><?= $verifiedCount ?></p>
            </div>
        </div>
        <div class="mv-overview-stat">
            <div class="mv-overview-stat-icon is-amber"><i class="fa-solid fa-clock"></i></div>
            <div>
                <p class="mv-overview-stat-label">Pending Verification</p>
                <p class="mv-overview-stat-value"><?= $pendingCount ?></p>
            </div>
        </div>
        <div class="mv-overview-stat">
            <div class="mv-overview-stat-icon is-blue"><i class="fa-solid fa-users"></i></div>
            <div>
                <p class="mv-overview-stat-label">Admins</p>
                <p class="mv-overview-stat-value"><?= $totalAdmins ?></p>
            </div>
        </div>
    </div>

    <div class="mv-overview-panels">
        <div class="mv-overview-panel">
            <h2 class="mv-overview-panel-title">Recent pharmacies</h2>
            <?php if (!empty($recentPharmacies)): ?>
                <?php foreach ($recentPharmacies as $p): ?>
                    <div class="mv-overview-list-item">
                        <div>
                            <p class="mv-overview-item-name"><?= htmlspecialchars($p['pharmacy_name'] ?: $p['name']) ?></p>
                            <p class="mv-overview-item-meta"><?= htmlspecialchars($p['email'] ?: $p['user_email']) ?></p>
                        </div>
                        <?php if ((int) $p['isverified'] === 1): ?>
                            <span class="mv-pill mv-pill-verified">Verified</span>
                        <?php else: ?>
                            <span class="mv-pill mv-pill-pending">Pending</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="mv-empty">No pharmacies found</p>
            <?php endif; ?>
        </div>

        <div class="mv-overview-panel">
            <h2 class="mv-overview-panel-title">Verification queue</h2>
            <?php if (!empty($verificationQueue)): ?>
                <?php foreach ($verificationQueue as $p): ?>
                    <div class="mv-overview-list-item">
                        <div>
                            <p class="mv-overview-item-name"><?= htmlspecialchars($p['pharmacy_name'] ?: $p['name']) ?></p>
                            <p class="mv-overview-item-meta">Requested <?= date('Y-m-d', strtotime($p['verification_request_date'])) ?></p>
                        </div>
                        <span class="mv-pill mv-pill-pending">Pending</span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="mv-empty">No pending requests</p>
            <?php endif; ?>
        </div>
    </div>
</div>
