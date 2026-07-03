<?= pageHeader('Order analytics', 'Status mix and recent activity across your purchase orders.') ?>

<div class="grid-3col">
    <div class="card">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Status distribution</div></div>
        <div class="card__content">
            <div style="height:16rem;"><canvas id="status-distribution-chart"></canvas></div>
        </div>
    </div>

    <div class="card grid-3col--span2">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Recent orders</div></div>
        <div class="card__content list-card" id="recent-orders-list">
            <p class="text-sm text-muted">Loading…</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script src="/assets/js/chart-theme.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/pharmacy/order-data?period=all')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            var dist = data.statusDistribution || {};
            var labels = ['pending', 'completed', 'cancelled'];
            var values = labels.map(function (k) { return dist[k] || 0; });
            var colors = [window.chartTheme.COLORS.warning, window.chartTheme.COLORS.success, window.chartTheme.COLORS.destructive];
            new Chart(document.getElementById('status-distribution-chart'), window.chartTheme.doughnut(labels, values, colors));

            var list = document.getElementById('recent-orders-list');
            var recent = data.recentOrders || [];
            if (!recent.length) {
                list.innerHTML = '<p class="text-sm text-muted">No orders yet.</p>';
                return;
            }
            list.innerHTML = recent.slice(0, 8).map(function (o) {
                return '<div class="list-row">' +
                    '<div class="list-row__main">' +
                    '<p class="list-row__title">' + (o.medicine_name || '#' + o.m_id) + '</p>' +
                    '<p class="list-row__meta">' + o.date + ' · Qty ' + o.quantity + '</p>' +
                    '</div>' +
                    '<div style="display:flex;align-items:center;gap:0.75rem;flex-shrink:0;">' +
                    '<span class="text-sm tabular-nums">$' + parseFloat(o.amount).toFixed(2) + '</span>' +
                    '<span class="status-badge status-badge--' + o.status + '">' + o.status + '</span>' +
                    '</div>' +
                    '</div>';
            }).join('');
        });
});
</script>
