<div class="mv-page">
    <!-- Add Modal -->
    <div class="modal fade" id="pharmacyAddModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add Pharmacy</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/pharmacies" method="POST" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="mv-form-grid">
                            <div class="mb-3">
                                <label for="add_pan" class="form-label">PAN Number</label>
                                <input class="form-control" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="9" id="add_pan" placeholder="PAN Number" name="pan" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_pharmacy_name" class="form-label">Pharmacy Name</label>
                                <input class="form-control" type="text" id="add_pharmacy_name" placeholder="Pharmacy Name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_pharmacy_email" class="form-label">Email</label>
                                <input class="form-control" type="email" id="add_pharmacy_email" placeholder="Email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_pharmacy_password" class="form-label">Password</label>
                                <input class="form-control" type="password" id="add_pharmacy_password" placeholder="Password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_pharmacy_phone" class="form-label">Phone</label>
                                <input class="form-control" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="10" id="add_pharmacy_phone" placeholder="Phone" name="phone" required>
                            </div>
                            <div class="mb-3 full">
                                <label for="add_pharmacy_address" class="form-label">Address</label>
                                <input class="form-control" type="text" id="add_pharmacy_address" placeholder="Address" name="address" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="add-pharmacy">Add Pharmacy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Pharmacies</h1>
            <p class="mv-page-subtitle">Manage registered pharmacies and their verification status.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="/admin/pharmacies/verify" class="btn btn-outline-danger">Verify Pharmacies</a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#pharmacyAddModal">Add Pharmacy</button>
        </div>
    </div>
    <div class="mv-table-wrap mb-5">
        <div class="table-responsive">
            <table class="table table-striped mv-responsive-table">
                <thead class="table-danger">
                    <tr><th>ID</th><th>PAN</th><th>NAME</th><th>EMAIL</th><th>PHONE</th><th>ADDRESS</th><th>VERIFIED</th><th>ACTION</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($pharmacies)): ?>
                        <?php foreach ($pharmacies as $p): ?>
                        <tr>
                            <td data-label="ID"><?= $p['pharmacy_id'] ?></td>
                            <td data-label="PAN"><?= htmlspecialchars($p['pan'] ?? '') ?></td>
                            <td data-label="Name"><?= htmlspecialchars($p['pharmacy_name']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($p['email']) ?></td>
                            <td data-label="Phone"><?= htmlspecialchars($p['phone'] ?? '') ?></td>
                            <td data-label="Address"><?= htmlspecialchars($p['address'] ?? '') ?></td>
                            <td data-label="Verified"><span class="badge <?= ($p['isverified'] ?? 0) ? 'bg-success' : 'bg-warning' ?>"><?= ($p['isverified'] ?? 0) ? 'Yes' : 'No' ?></span></td>
                            <td class="mv-actions-cell" data-label="Action">
                                <div class="mv-icon-actions">
                                    <a href="/admin/pharmacies/<?= $p['pharmacy_id'] ?>" class="btn btn-secondary mv-icon-btn" title="View details" aria-label="View <?= htmlspecialchars($p['pharmacy_name']) ?> details"><i class="fa-regular fa-eye"></i></a>
                                    <form action="/admin/pharmacies/<?= $p['pharmacy_id'] ?>/delete" method="POST" onsubmit="return confirm('Delete this pharmacy?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger mv-icon-btn" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No Data Found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
