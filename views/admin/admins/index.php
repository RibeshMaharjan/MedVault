<div class="container-fluid bg-white">
    <!-- Add Modal -->
    <div class="modal fade" id="adminAddModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add Admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/admins" method="POST" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="mv-form-grid">
                            <div class="mb-3">
                                <label for="add_name" class="form-label">Name</label>
                                <input class="form-control" type="text" id="add_name" placeholder="Name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_email" class="form-label">Email</label>
                                <input class="form-control" type="email" id="add_email" placeholder="Email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_password" class="form-label">Password</label>
                                <input class="form-control" type="password" id="add_password" placeholder="Password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_gender" class="form-label">Gender</label>
                                <select class="form-select" id="add_gender" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="add_phone" class="form-label">Phone</label>
                                <input class="form-control" type="text" id="add_phone" placeholder="Phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="add_birth" class="form-label">Date of Birth</label>
                                <input class="form-control" type="date" id="add_birth" name="birth" required>
                            </div>
                            <div class="mb-3 full">
                                <label for="add_address" class="form-label">Address</label>
                                <input class="form-control" type="text" id="add_address" placeholder="Address" name="address" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="add-admin">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="pt-3 ps-2 d-flex justify-content-between align-items-center">
        <h1 class="fw-normal mb-3">Admin Table</h1>
        <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#adminAddModal">Add Admin</button>
    </div>
    <div class="table-responsive px-2 pt-3 mb-5">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr><th>#</th><th>NAME</th><th>EMAIL</th><th>GENDER</th><th>PHONE</th><th>D.O.B</th><th>ADDRESS</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($admins)): ?>
                    <?php foreach ($admins as $a): ?>
                    <tr>
                        <td><?= $a['admin_id'] ?></td>
                        <td><?= htmlspecialchars($a['name']) ?></td>
                        <td><?= htmlspecialchars($a['email']) ?></td>
                        <td><?= htmlspecialchars($a['gender'] ?? '') ?></td>
                        <td><?= htmlspecialchars($a['phone'] ?? '') ?></td>
                        <td><?= $a['dob'] ?? '' ?></td>
                        <td><?= htmlspecialchars($a['address'] ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No Data Found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
