<?= pageHeader('Sales analytics', "Understand what's moving and how revenue is trending.") ?>

<div class="grid-2col">
    <div class="card grid-2col--span2">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Revenue · last 14 days</div></div>
        <div class="card__content">
            <div style="height:16rem;"><canvas id="revenue-trend-chart"></canvas></div>
        </div>
    </div>

    <div class="card">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Top-selling medicines</div></div>
        <div class="card__content list-card" id="top-selling-list">
            <p class="text-sm text-muted">Loading…</p>
        </div>
    </div>

    <div class="card">
        <div class="card__header"><div class="card__title" style="font-size:1rem;">Current inventory levels</div></div>
        <div class="card__content">
            <div style="height:16rem;"><canvas id="inventory-levels-chart"></canvas></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script src="/assets/js/chart-theme.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/pharmacy/revenue-trend?days=14')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            new Chart(document.getElementById('revenue-trend-chart'), window.chartTheme.line(data.labels, data.amounts));
        });

    fetch('/api/pharmacy/top-selling')
        .then(function (r) { return r.json(); })
        .then(function (rows) {
            var el = document.getElementById('top-selling-list');
            if (!rows.length) {
                el.innerHTML = '<p class="text-sm text-muted">No completed sales yet.</p>';
                return;
            }
            el.innerHTML = rows.map(function (row, i) {
                return '<div class="list-row">' +
                    '<div style="display:flex;align-items:center;gap:0.75rem;">' +
                    '<span class="rank-tile">' + (i + 1) + '</span>' +
                    '<span class="text-sm font-medium">' + row.medicine_name + '</span>' +
                    '</div>' +
                    '<span class="text-sm tabular-nums text-muted">' + row.total_quantity + ' sold</span>' +
                    '</div>';
            }).join('');
        });

    fetch('/api/pharmacy/stock-levels')
        .then(function (r) { return r.json(); })
        .then(function (rows) {
            var labels = rows.map(function (row) { return row.medicine_name.split(' ')[0]; });
            var data = rows.map(function (row) { return parseInt(row.in_stock, 10); });
            new Chart(document.getElementById('inventory-levels-chart'), window.chartTheme.bar(labels, data, { color: window.chartTheme.COLORS.success }));
        });
});
</script>
