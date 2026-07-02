<?php $p = $pharmacy; ?>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow">
            <div class="card-header bg-danger text-white">
                <p class="fw-semibold fs-4 mb-0">Edit Profile</p>
            </div>
            <div class="card-body">
                <form action="/pharmacy/profile" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="pharmacy_name" class="form-label">Pharmacy Name</label>
                        <input type="text" class="form-control" name="pharmacy_name" value="<?= htmlspecialchars($p['pharmacy_name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($p['email'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pan" class="form-label">PAN Number</label>
                        <input type="text" class="form-control" name="pan" value="<?= htmlspecialchars($p['pan'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($p['phone'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($p['address'] ?? '') ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-danger">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow">
            <div class="card-header bg-danger text-white">
                <h4>Verification Status</h4>
            </div>
            <div class="card-body">
                <?php if (($p['isverified'] ?? 0) == 1): ?>
                    <div class="verification-status verified">
                        <div class="status-icon mb-3"><i class="fas fa-check-circle fa-3x text-success"></i></div>
                        <h5 class="text-success mb-3">Your pharmacy is verified!</h5>
                        <div class="verification-details">
                            <div class="d-flex justify-content-between mb-2"><span class="fw-bold">Status:</span><span class="badge bg-success">Verified</span></div>
                            <div class="d-flex justify-content-between mb-2"><span class="fw-bold">Verification Date:</span><span><?= !empty($p['verification_date']) ? date('F j, Y', strtotime($p['verification_date'])) : 'N/A' ?></span></div>
                            <div class="d-flex justify-content-between mb-2"><span class="fw-bold">License Number:</span><span><?= htmlspecialchars($p['license_number'] ?? '') ?></span></div>
                            <?php if (!empty($p['verification_notes'])): ?>
                            <div class="mb-2"><span class="fw-bold d-block mb-1">Notes:</span><div class="bg-light p-2 rounded"><?= htmlspecialchars($p['verification_notes']) ?></div></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php elseif (!empty($p['verification_request_date'])): ?>
                    <div class="verification-status pending">
                        <div class="status-icon mb-3"><i class="fas fa-clock fa-3x text-warning"></i></div>
                        <h5 class="text-warning mb-3">Verification in progress!</h5>
                        <div class="verification-details">
                            <div class="d-flex justify-content-between mb-2"><span class="fw-bold">Status:</span><span class="badge bg-warning text-dark">Pending</span></div>
                            <div class="d-flex justify-content-between mb-2"><span class="fw-bold">Request Date:</span><span><?= date('F j, Y', strtotime($p['verification_request_date'])) ?></span></div>
                            <div class="d-flex justify-content-between mb-2"><span class="fw-bold">License Number:</span><span><?= htmlspecialchars($p['license_number'] ?? '') ?></span></div>
                            <?php if (!empty($p['reg_document'])): ?>
                            <div class="d-flex justify-content-between mb-2"><span class="fw-bold">Document:</span><a href="/uploads/documents/<?= htmlspecialchars(basename($p['reg_document'])) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a></div>
                            <?php endif; ?>
                        </div>
                        <div class="alert alert-info mt-3"><i class="fas fa-info-circle"></i> Your verification request is under review.</div>
                    </div>
                <?php else: ?>
                    <div class="verification-status not-verified">
                        <div class="status-icon mb-3"><i class="fas fa-exclamation-triangle fa-3x text-danger"></i></div>
                        <h5 class="text-danger mb-3">Not Verified!</h5>
                        <div class="alert alert-warning mb-3"><i class="fas fa-info-circle"></i> Verification is required to access all features.</div>
                        <form action="/pharmacy/profile/verify" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Pharmacy License Number</label>
                                <input type="text" class="form-control" name="license_number" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Registration Document (PDF/Image)</label>
                                <input type="file" class="form-control" name="reg_document" accept=".pdf,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Upload your pharmacy registration certificate or license document.</small>
                            </div>
                            <button type="submit" name="submit_verification" class="btn btn-danger">Submit for Verification</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
