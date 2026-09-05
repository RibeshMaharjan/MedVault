<?php
$p = $pharmacy;
$isVerified = (int) ($p['isverified'] ?? 0) === 1;
$isPending = !$isVerified && !empty($p['verification_request_date']);
$statusLabel = $isVerified ? 'Verified' : ($isPending ? 'Pending review' : (!empty($p['verification_notes']) ? 'Rejected / resubmission required' : 'Not submitted'));
$statusClass = $isVerified ? 'bg-success' : ($isPending ? 'bg-warning text-dark' : 'bg-secondary');
$display = static fn($value) => ($value === null || $value === '') ? 'N/A' : htmlspecialchars((string) $value);
$date = static fn($value) => empty($value) ? 'N/A' : date('F j, Y g:i A', strtotime($value));
?>

<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <a href="/admin/pharmacies" class="text-decoration-none text-muted"><i class="fa-solid fa-arrow-left me-1"></i>Pharmacies</a>
            <h1 class="mv-page-title mt-2"><?= $display($p['pharmacy_name'] ?? '') ?></h1>
            <p class="mv-page-subtitle">Complete pharmacy profile and verification record.</p>
        </div>
        <span class="badge <?= $statusClass ?> fs-6"><?= htmlspecialchars($statusLabel) ?></span>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-danger text-white"><h2 class="h5 mb-0">Pharmacy details</h2></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Pharmacy ID</dt><dd class="col-sm-7"><?= $display($p['pharmacy_id'] ?? null) ?></dd>
                        <dt class="col-sm-5">Pharmacy name</dt><dd class="col-sm-7"><?= $display($p['pharmacy_name'] ?? null) ?></dd>
                        <dt class="col-sm-5">PAN number</dt><dd class="col-sm-7"><?= $display($p['pan'] ?? null) ?></dd>
                        <dt class="col-sm-5">Email</dt><dd class="col-sm-7"><?= $display($p['email'] ?? null) ?></dd>
                        <dt class="col-sm-5">Phone</dt><dd class="col-sm-7"><?= $display($p['phone'] ?? null) ?></dd>
                        <dt class="col-sm-5">Address</dt><dd class="col-sm-7"><?= $display($p['address'] ?? null) ?></dd>
                        <dt class="col-sm-5">Account name</dt><dd class="col-sm-7"><?= $display($p['account_name'] ?? null) ?></dd>
                        <dt class="col-sm-5">Account email</dt><dd class="col-sm-7"><?= $display($p['account_email'] ?? null) ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-danger text-white"><h2 class="h5 mb-0">Verification details</h2></div>
                <div class="card-body">
                    <dl class="row mb-3">
                        <dt class="col-sm-5">Status</dt><dd class="col-sm-7"><span class="badge <?= $statusClass ?>"><?= htmlspecialchars($statusLabel) ?></span></dd>
                        <dt class="col-sm-5">License number</dt><dd class="col-sm-7"><?= $display($p['license_number'] ?? null) ?></dd>
                        <dt class="col-sm-5">Requested</dt><dd class="col-sm-7"><?= $date($p['verification_request_date'] ?? null) ?></dd>
                        <dt class="col-sm-5">Verified</dt><dd class="col-sm-7"><?= $date($p['verification_date'] ?? null) ?></dd>
                        <dt class="col-sm-5">Admin notes</dt><dd class="col-sm-7"><?= $display($p['verification_notes'] ?? null) ?></dd>
                    </dl>

                    <?php if (!empty($p['reg_document'])): ?>
                        <a href="/admin/pharmacies/<?= (int) $p['pharmacy_id'] ?>/document" target="_blank" rel="noopener" class="btn btn-outline-danger mb-3"><i class="fa-regular fa-file-lines me-1"></i>View registration document</a>
                    <?php else: ?>
                        <div class="alert alert-secondary">No registration document has been submitted.</div>
                    <?php endif; ?>

                    <?php if ($isPending): ?>
                        <hr>
                        <form action="/admin/pharmacies/<?= (int) $p['pharmacy_id'] ?>/approve" method="POST" class="mb-4">
                            <?= csrf_field() ?>
                            <input type="hidden" name="return_to" value="details">
                            <label for="approval_notes" class="form-label">Approval notes (optional)</label>
                            <textarea id="approval_notes" name="verification_notes" class="form-control mb-2" rows="2"></textarea>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-circle-check me-1"></i>Approve pharmacy</button>
                        </form>
                        <form action="/admin/pharmacies/<?= (int) $p['pharmacy_id'] ?>/reject" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="return_to" value="details">
                            <label for="rejection_notes" class="form-label">Rejection reason</label>
                            <textarea id="rejection_notes" name="verification_notes" class="form-control mb-2" rows="2" required></textarea>
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Reject request</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
