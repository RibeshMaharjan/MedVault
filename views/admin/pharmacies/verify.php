<div class="container-fluid p-4">
    <h1 class="mb-4">Pharmacy Verification</h1>

    <div class="row mb-4">
        <div class="col-md-4"><div class="card border-0 shadow"><div class="card-body"><h5>Total Pharmacies</h5><p class="h3 text-danger"><?= $totalCount ?></p></div></div></div>
        <div class="col-md-4"><div class="card border-0 shadow"><div class="card-body"><h5>Pending</h5><p class="h3 text-warning"><?= $pendingCount ?></p></div></div></div>
        <div class="col-md-4"><div class="card border-0 shadow"><div class="card-body"><h5>Verified</h5><p class="h3 text-success"><?= $verifiedCount ?></p></div></div></div>
    </div>

    <h3 class="mb-3">Pending Verification</h3>
    <?php if (!empty($pending)): ?>
        <?php foreach ($pending as $p): ?>
        <div class="card border-0 shadow mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5><?= htmlspecialchars($p['pharmacy_name']) ?></h5>
                        <p><strong>Email:</strong> <?= htmlspecialchars($p['email']) ?></p>
                        <p><strong>License:</strong> <?= htmlspecialchars($p['license_number'] ?? 'N/A') ?></p>
                        <p><strong>Requested:</strong> <?= date('F j, Y', strtotime($p['verification_request_date'])) ?></p>
                        <?php if (!empty($p['reg_document'])): ?>
                            <a href="/uploads/documents/<?= htmlspecialchars(basename($p['reg_document'])) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View Document</a>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <form action="/admin/pharmacies/<?= $p['pharmacy_id'] ?>/approve" method="POST" class="mb-2">
                            <?= csrf_field() ?>
                            <textarea name="verification_notes" class="form-control mb-2" placeholder="Notes (optional)"></textarea>
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="/admin/pharmacies/<?= $p['pharmacy_id'] ?>/reject" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="verification_notes" value="">
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No pending verification requests.</p>
    <?php endif; ?>

    <h3 class="mb-3 mt-4">Verified Pharmacies</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-success"><tr><th>Name</th><th>Email</th><th>License</th><th>Verified Date</th></tr></thead>
            <tbody>
                <?php if (!empty($verified)): ?>
                    <?php foreach ($verified as $v): ?>
                    <tr>
                        <td><?= htmlspecialchars($v['pharmacy_name']) ?></td>
                        <td><?= htmlspecialchars($v['email']) ?></td>
                        <td><?= htmlspecialchars($v['license_number'] ?? '') ?></td>
                        <td><?= date('F j, Y', strtotime($v['verification_date'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No verified pharmacies yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
