<div class="container-fluid bg-white">
    <div class="pt-3 ps-2"><h1 class="fw-normal mb-3">Pharmacy Table</h1></div>
    <div class="table-responsive px-2 pt-3 mb-5">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr><th>ID</th><th>PAN</th><th>NAME</th><th>EMAIL</th><th>PHONE</th><th>ADDRESS</th><th>VERIFIED</th></tr>
            </thead>
            <tbody>
                <?php if (!empty($pharmacies)): ?>
                    <?php foreach ($pharmacies as $p): ?>
                    <tr>
                        <td><?= $p['pharmacy_id'] ?></td>
                        <td><?= htmlspecialchars($p['pan'] ?? '') ?></td>
                        <td><?= htmlspecialchars($p['pharmacy_name']) ?></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
                        <td><?= htmlspecialchars($p['phone'] ?? '') ?></td>
                        <td><?= htmlspecialchars($p['address'] ?? '') ?></td>
                        <td><span class="badge <?= ($p['isverified'] ?? 0) ? 'bg-success' : 'bg-warning' ?>"><?= ($p['isverified'] ?? 0) ? 'Yes' : 'No' ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No Data Found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
