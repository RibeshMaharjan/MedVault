<?= pageHeader('Dashboard', "A snapshot of today's inventory and revenue.") ?>

<div class="grid-stats">
    <?= statCard('Total medicines', (string) $totalMedicines, 'package', 'default', 'in your catalogue') ?>
    <?= statCard('Low stock', (string) $lowStockCount, 'alert-triangle', 'warning', 'items at or below 10 units') ?>
    <?= statCard('Pending orders', (string) $pendingOrders, 'clock', 'info', 'awaiting fulfilment') ?>
    <?= statCard('Revenue (30d)', '$' . number_format((float) $revenue30d, 2), 'circle-dollar-sign', 'success', 'completed sales') ?>
</div>

<div class="grid-2col" style="margin-top:1.5rem;">
    <div class="card grid-2col--span2">
        <div class="card__header">
            <div class="card__title" style="font-size:1rem;">Revenue · last 7 days</div>
        </div>
        <div class="card__content">
            <div style="height:16rem;">
                <canvas id="revenue-chart"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card__header">
            <div class="card__title" style="font-size:1rem;">Recent activity</div>
        </div>
        <div class="card__content list-card">
            <?php if (empty($recentActivities)): ?>
                <p class="text-sm text-muted">No recent activity.</p>
            <?php else: ?>
                <?php foreach ($recentActivities as $row): ?>
                    <div class="list-row">
                        <div class="list-row__main">
                            <p class="list-row__title"><?= htmlspecialchars($row['medicine_name'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="list-row__meta"><?= htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8') ?> · <?= date('M d, Y', strtotime($row['date'])) ?></p>
                        </div>
                        <div style="text-align:right;">
                            <p class="list-row__amount">$<?= number_format((float) $row['amount'], 2) ?></p>
                            <?= statusBadge($row['status']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script src="/assets/js/chart-theme.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var labels = <?= json_encode(array_map(function ($row) {
        return date('D', strtotime($row['sale_date']));
    }, $revenueLast7)) ?>;
    var data = <?= json_encode(array_map(function ($row) {
        return round((float) $row['daily_total'], 2);
    }, $revenueLast7)) ?>;

    new Chart(document.getElementById('revenue-chart'), window.chartTheme.bar(labels, data));
});
</script>
