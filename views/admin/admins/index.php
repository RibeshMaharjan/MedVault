<div class="container-fluid bg-white">
    <div class="pt-3 ps-2"><h1 class="fw-normal mb-3">Admin Table</h1></div>
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
