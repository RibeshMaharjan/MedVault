<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-5 bg-body-tertiary">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2>Sales Analysis</h2>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-end" role="group">
                        <button type="button" class="btn btn-outline-danger" onclick="updateChart('week')">Last Week</button>
                        <button type="button" class="btn btn-outline-danger" onclick="updateChart('month')">Last Month</button>
                        <button type="button" class="btn btn-outline-danger" onclick="updateChart('6months')">Last 6 Months</button>
                    </div>
                </div>
            </div>

            <!-- Charts Container -->
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sales Trend</h5>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Statistics</h5>
                            <div id="statsContainer">
                                <!-- Stats will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Recommendations -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stock Recommendations</h5>
                            <div id="stockRecommendations">
                                <!-- Stock recommendations will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Anomaly Detection Results -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sales Anomalies</h5>
                            <div id="anomalyContainer">
                                <!-- Anomalies will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
    let salesChart = null;

    // Function to calculate moving average
    function calculateMovingAverage(data, windowSize) {
        let result = [];
        for (let i = 0; i < data.length; i++) {
            let start = Math.max(0, i - windowSize + 1);
            let sum = 0;
            for (let j = start; j <= i; j++) {
                sum += data[j];
            }
            result.push(sum / (i - start + 1));
        }
        return result;
    }

    // Function to detect anomalies (using standard deviation method)
    function detectAnomalies(data, threshold = 2) {
        const mean = data.reduce((a, b) => a + b, 0) / data.length;
        const squareDiffs = data.map(value => Math.pow(value - mean, 2));
        const stdDev = Math.sqrt(squareDiffs.reduce((a, b) => a + b, 0) / data.length);
        
        return data.map((value, index) => {
            const zScore = Math.abs(value - mean) / stdDev;
            return zScore > threshold ? index : null;
        }).filter(index => index !== null);
    }

    // Function to fetch sales data
    async function fetchSalesData(period) {
        const response = await fetch(`php/get_sales_data.php?period=${period}`);
        return await response.json();
    }

    // Function to calculate stock recommendations
    function calculateStockRecommendations(data) {
        const averageDailySales = data.amounts.reduce((a, b) => a + b, 0) / data.amounts.length;
        const maxDailySale = Math.max(...data.amounts);
        const minDailySale = Math.min(...data.amounts);
        const salesTrend = data.amounts[data.amounts.length - 1] > averageDailySales ? 'increasing' : 'decreasing';
        
        // Calculate recommended stock levels
        const safetyStock = Math.ceil(maxDailySale * 1.5); // 150% of max daily sale
        const reorderPoint = Math.ceil(averageDailySales * 7); // 7 days of average sales
        const maxStock = Math.ceil(reorderPoint * 2); // 2x reorder point

        return {
            safetyStock,
            reorderPoint,
            maxStock,
            averageDailySales: Math.ceil(averageDailySales),
            salesTrend
        };
    }

    // Function to update stock recommendations
    function updateStockRecommendations(data) {
        const recommendations = calculateStockRecommendations(data);
        const container = document.getElementById('stockRecommendations');
        
        // Fetch current inventory levels
        fetch('php/get_inventory_levels.php')
            .then(response => response.json())
            .then(inventory => {
                container.innerHTML = `
                    <div class="alert ${recommendations.salesTrend === 'increasing' ? 'alert-success' : 'alert-warning'} mb-3">
                        Sales Trend: <strong>${recommendations.salesTrend === 'increasing' ? 'Increasing ↑' : 'Decreasing ↓'}</strong>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Current Inventory Status:</h6>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Units in Stock
                                    <span class="badge bg-primary rounded-pill">${inventory.totalStock} units</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Low Stock Items
                                    <span class="badge bg-warning rounded-pill">${inventory.lowStockCount} items</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Out of Stock Items
                                    <span class="badge bg-danger rounded-pill">${inventory.outOfStockCount} items</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6>Recommended Stock Levels:</h6>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Safety Stock Level
                                    <span class="badge bg-primary rounded-pill">${recommendations.safetyStock} units</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Reorder Point
                                    <span class="badge bg-warning rounded-pill">${recommendations.reorderPoint} units</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Maximum Stock Level
                                    <span class="badge bg-info rounded-pill">${recommendations.maxStock} units</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6>Sales Metrics:</h6>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Average Daily Sales
                                    <span class="badge bg-secondary rounded-pill">${recommendations.averageDailySales} units</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Stock Coverage
                                    <span class="badge ${inventory.totalStock >= recommendations.safetyStock ? 'bg-success' : 'bg-danger'} rounded-pill">
                                        ${Math.round(inventory.totalStock / recommendations.averageDailySales)} days
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <small class="text-muted">
                                        * Safety stock helps prevent stockouts<br>
                                        * Reorder when stock reaches reorder point<br>
                                        * Stock coverage shows days of inventory left
                                    </small>
                                </li>
                            </ul>
                        </div>
                    </div>
                    ${inventory.lowStockItems.length > 0 ? `
                        <div class="mt-4">
                            <h6>Items Requiring Attention:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Medicine Name</th>
                                            <th>Current Stock</th>
                                            <th>Status</th>
                                            <th>Recommended Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${inventory.lowStockItems.map(item => `
                                            <tr>
                                                <td>${item.medicine_name}</td>
                                                <td>${item.in_stock}</td>
                                                <td>
                                                    <span class="badge ${item.in_stock === 0 ? 'bg-danger' : 'bg-warning'}">
                                                        ${item.in_stock === 0 ? 'Out of Stock' : 'Low Stock'}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-danger">
                                                        Order ${Math.max(recommendations.safetyStock - item.in_stock, 0)} units
                                                    </span>
                                                </td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    ` : ''}
                `;
            });
    }

    // Function to update chart
    async function updateChart(period) {
        // Update button states
        const buttons = document.querySelectorAll('.btn-group .btn');
        buttons.forEach(btn => {
            btn.classList.remove('active');
            // Get the period from onclick attribute using regex to extract exact match
            const btnPeriod = btn.getAttribute('onclick').match(/updateChart\('(\w+)'\)/)[1];
            if (btnPeriod === period) {
                btn.classList.add('active');
            }
        });

        const data = await fetchSalesData(period);
        const movingAverage = calculateMovingAverage(data.amounts, 3);
        const anomalies = detectAnomalies(data.amounts);

        // Update chart
        if (salesChart) {
            salesChart.destroy();
        }

        const ctx = document.getElementById('salesChart').getContext('2d');
        salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.dates,
                datasets: [{
                    label: 'Daily Sales',
                    data: data.amounts,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }, {
                    label: 'Moving Average (3-day)',
                    data: movingAverage,
                    borderColor: 'rgb(255, 99, 132)',
                    borderDash: [5, 5],
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales Amount'
                        }
                    }
                }
            }
        });

        // Update statistics
        const stats = calculateStats(data.amounts);
        updateStats(stats);

        // Update stock recommendations
        updateStockRecommendations(data);

        // Update anomalies
        updateAnomalies(anomalies, data);
    }

    function calculateStats(amounts) {
        const sum = amounts.reduce((a, b) => a + b, 0);
        const avg = sum / amounts.length;
        const max = Math.max(...amounts);
        const min = Math.min(...amounts);
        
        return {
            total: sum,
            average: avg.toFixed(2),
            max: max,
            min: min
        };
    }

    function updateStats(stats) {
        document.getElementById('statsContainer').innerHTML = `
            <p><strong>Total Sales:</strong> Rs. ${stats.total}</p>
            <p><strong>Average Daily Sales:</strong> Rs. ${stats.average}</p>
            <p><strong>Highest Sale:</strong> Rs. ${stats.max}</p>
            <p><strong>Lowest Sale:</strong> Rs. ${stats.min}</p>
        `;
    }

    function updateAnomalies(anomalies, data) {
        const container = document.getElementById('anomalyContainer');
        if (anomalies.length === 0) {
            container.innerHTML = '<p>No sales anomalies detected in this period.</p>';
            return;
        }

        let html = '<ul class="list-group">';
        anomalies.forEach(index => {
            html += `
                <li class="list-group-item ${data.amounts[index] > data.averageSale ? 'list-group-item-success' : 'list-group-item-danger'}">
                    ${data.dates[index]}: Rs. ${data.amounts[index]} 
                    (${data.amounts[index] > data.averageSale ? 'Unusually high' : 'Unusually low'} sales)
                </li>
            `;
        });
        html += '</ul>';
        container.innerHTML = html;
    }

    // Initialize with last week's data
    document.addEventListener('DOMContentLoaded', () => {
        // Set initial active state for 'week' button
        const weekButton = document.querySelector('button[onclick="updateChart(\'week\')"]');
        weekButton.classList.add('active');
        updateChart('week');
    });
    </script>

<?php include 'includes/footer.php'; ?>