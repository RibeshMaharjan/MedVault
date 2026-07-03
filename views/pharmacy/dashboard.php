<div class="mv-page">
    <div class="mv-page-header">
        <div>
            <h1 class="mv-page-title">Dashboard</h1>
            <p class="mv-page-subtitle">Inventory health, expiry risk, and recent activity.</p>
        </div>
    </div>

<!-- Medicine Statistics -->
<div class="mv-stat-grid">
    <div class="card mv-stat-card">
            <div class="card-body">
                <h5 class="card-title">Total Medicine Types</h5>
                <p class="card-text text-danger h3"><?= $totalMedicines ?></p>
            </div>
    </div>
    <div class="card mv-stat-card">
            <div class="card-body">
                <h5 class="card-title">Total Categories</h5>
                <p class="card-text text-danger h3"><?= $totalCategories ?></p>
            </div>
    </div>
    <div class="card mv-stat-card">
            <div class="card-body">
                <h5 class="card-title">Low Stock Items</h5>
                <p class="card-text text-warning h3"><?= $lowStockCount ?></p>
            </div>
    </div>
    <div class="card mv-stat-card">
            <div class="card-body">
                <h5 class="card-title">Out of Stock</h5>
                <p class="card-text text-danger h3"><?= $outOfStockCount ?></p>
            </div>
    </div>
    <div class="card mv-stat-card">
            <div class="card-body">
                <h5 class="card-title">Expired</h5>
                <p class="card-text text-danger h3"><?= $expiredCount ?? 0 ?></p>
            </div>
    </div>
    <div class="card mv-stat-card">
            <div class="card-body">
                <h5 class="card-title">Expiring Soon</h5>
                <p class="card-text text-warning h3"><?= $expiringSoonCount ?? 0 ?></p>
            </div>
    </div>
</div>

<!-- Category-wise Medicine Distribution -->
<div class="mv-two-col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Medicine by Category</h5>
                <div class="table-responsive">
                    <table class="table mv-responsive-table">
                        <thead>
                            <tr><th>Category</th><th>Medicine Count</th><th>Total Stock</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categoryDistribution)): ?>
                            <?php foreach ($categoryDistribution as $row): ?>
                            <tr>
                                <td data-label="Category"><?= htmlspecialchars($row['category_name']) ?></td>
                                <td data-label="Medicine Count"><?= $row['med_count'] ?></td>
                                <td data-label="Total Stock"><?= $row['total_stock'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="mv-empty">No category data</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Low Stock Alert</h5>
                <div class="table-responsive">
                    <table class="table mv-responsive-table">
                        <thead>
                            <tr><th>Medicine Name</th><th>Current Stock</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lowStockItems)): ?>
                            <?php foreach ($lowStockItems as $row): ?>
                            <tr>
                                <td data-label="Medicine"><?= htmlspecialchars($row['medicine_name']) ?></td>
                                <td data-label="Current Stock"><?= $row['in_stock'] ?></td>
                                <td data-label="Status">
                                    <?php if ($row['in_stock'] == 0): ?>
                                        <span class="badge bg-danger">Out of Stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Low Stock</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="mv-empty">No low stock items</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

<!-- Expiry Alerts -->
<div class="mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Expiry Alerts</h5>
                <div class="table-responsive">
                    <table class="table mv-responsive-table">
                        <thead>
                            <tr><th>Medicine Name</th><th>Expiration Date</th><th>Stock</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($expiryAlerts)): ?>
                                <?php foreach ($expiryAlerts as $row): ?>
                                <tr>
                                    <td data-label="Medicine"><?= htmlspecialchars($row['medicine_name']) ?></td>
                                    <td data-label="Expiration Date"><?= htmlspecialchars($row['exp_date']) ?></td>
                                    <td data-label="Stock"><?= $row['in_stock'] ?></td>
                                    <td data-label="Status">
                                        <?php if ($row['expiry_status'] === 'expired'): ?>
                                            <span class="badge bg-danger">Expired <?= abs((int) $row['days_to_expiry']) ?> days ago</span>
                                        <?php elseif ((int) $row['days_to_expiry'] === 0): ?>
                                            <span class="badge bg-warning text-dark">Expires today</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Expires in <?= (int) $row['days_to_expiry'] ?> days</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted">No expiry alerts</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mv-filter-actions mt-3">
                    <a href="/pharmacy/medicines?expiry_status=expired" class="btn btn-sm btn-outline-danger">View Expired</a>
                    <a href="/pharmacy/medicines?expiry_status=expiring_soon" class="btn btn-sm btn-outline-warning">View Expiring Soon</a>
                </div>
            </div>
        </div>
</div>

<!-- Recent Activities -->
<div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Activities</h5>
                <div class="table-responsive">
                    <table class="table mv-responsive-table">
                        <thead>
                            <tr><th>Date</th><th>Type</th><th>Medicine</th><th>Quantity</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentActivities)): ?>
                            <?php foreach ($recentActivities as $row): ?>
                            <tr>
                                <td data-label="Date"><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                <td data-label="Type"><?= $row['type'] ?></td>
                                <td data-label="Medicine"><?= htmlspecialchars($row['medicine_name']) ?></td>
                                <td data-label="Quantity"><?= $row['quantity'] ?></td>
                                <td data-label="Status">
                                    <span class="badge <?= $row['status'] == 'completed' ? 'bg-success' : 'bg-warning' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="mv-empty">No recent activity</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
</div>
