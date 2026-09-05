<div class="mv-page mv-verify">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Pharmacy verification</h1>
            <p class="mv-page-subtitle">Review submitted documents and approve or reject.</p>
        </div>
    </div>

    <ul class="nav mv-verify-tabs" id="verifyTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-pane" type="button" role="tab" aria-selected="true">Pending (<?= $pendingCount ?>)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="verified-tab" data-bs-toggle="tab" data-bs-target="#verified-pane" type="button" role="tab" aria-selected="false">Verified (<?= $verifiedCount ?>)</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="pending-pane" role="tabpanel">
            <?php if (!empty($pending)): ?>
                <div class="mv-verify-grid">
                    <?php foreach ($pending as $p): ?>
                        <div class="mv-verify-card">
                            <div class="mv-verify-card-head">
                                <div>
                                    <h2 class="mv-verify-name"><?= htmlspecialchars($p['pharmacy_name']) ?></h2>
                                    <p class="mv-verify-email"><?= htmlspecialchars($p['email']) ?></p>
                                </div>
                                <span class="mv-pill mv-pill-pending">Pending</span>
                            </div>
                            <p class="mv-verify-meta">License: <strong><?= htmlspecialchars($p['license_number'] ?? 'N/A') ?></strong></p>
                            <p class="mv-verify-meta">Requested: <strong><?= date('Y-m-d', strtotime($p['verification_request_date'])) ?></strong></p>
                            <?php if (!empty($p['reg_document'])): ?>
                                <div class="mv-verify-doc">
                                    <span><i class="fa-regular fa-file-lines"></i><?= htmlspecialchars(basename($p['reg_document'])) ?></span>
                                    <a href="/admin/pharmacies/<?= (int) $p['pharmacy_id'] ?>/document" target="_blank" rel="noopener">View</a>
                                </div>
                            <?php endif; ?>
                            <div class="mv-verify-actions">
                                <a href="/admin/pharmacies/<?= $p['pharmacy_id'] ?>" class="mv-verify-btn mv-verify-btn-approve"><i class="fa-regular fa-eye"></i> Review details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mv-empty">No pending verification requests.</p>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade" id="verified-pane" role="tabpanel">
            <?php if (!empty($verified)): ?>
                <div class="mv-verify-grid">
                    <?php foreach ($verified as $v): ?>
                        <div class="mv-verify-card">
                            <div class="mv-verify-card-head">
                                <div>
                                    <h2 class="mv-verify-name"><?= htmlspecialchars($v['pharmacy_name']) ?></h2>
                                    <p class="mv-verify-meta">Verified <?= date('Y-m-d', strtotime($v['verification_date'])) ?></p>
                                </div>
                                <span class="mv-pill mv-pill-verified">Verified</span>
                            </div>
                            <div class="mv-verify-actions">
                                <a href="/admin/pharmacies/<?= $v['pharmacy_id'] ?>" class="mv-verify-btn mv-verify-btn-approve"><i class="fa-regular fa-eye"></i> View details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mv-empty">No verified pharmacies yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
