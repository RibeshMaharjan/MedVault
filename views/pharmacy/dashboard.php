<!-- Medicine Statistics -->
<div class="row pt-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Total Medicine Types</h5>
                <p class="card-text text-danger h3"><?= $totalMedicines ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Total Categories</h5>
                <p class="card-text text-danger h3"><?= $totalCategories ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Low Stock Items</h5>
                <p class="card-text text-warning h3"><?= $lowStockCount ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Out of Stock</h5>
                <p class="card-text text-danger h3"><?= $outOfStockCount ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Category-wise Medicine Distribution -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Medicine by Category</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Category</th><th>Medicine Count</th><th>Total Stock</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categoryDistribution as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['category_name']) ?></td>
                                <td><?= $row['med_count'] ?></td>
                                <td><?= $row['total_stock'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Low Stock Alert</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Medicine Name</th><th>Current Stock</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lowStockItems as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                                <td><?= $row['in_stock'] ?></td>
                                <td>
                                    <?php if ($row['in_stock'] == 0): ?>
                                        <span class="badge bg-danger">Out of Stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Low Stock</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Recent Activities</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Date</th><th>Type</th><th>Medicine</th><th>Quantity</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentActivities as $row): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                <td><?= $row['type'] ?></td>
                                <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td>
                                    <span class="badge <?= $row['status'] == 'completed' ? 'bg-success' : 'bg-warning' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
