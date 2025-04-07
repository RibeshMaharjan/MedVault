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
                        <button type="button" class="btn btn-outline-primary" onclick="updateChart('week')">Last Week</button>
                        <button type="button" class="btn btn-outline-primary" onclick="updateChart('month')">Last Month</button>
                        <button type="button" class="btn btn-outline-primary" onclick="updateChart('6months')">Last 6 Months</button>
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

            <!-- Anomaly Detection Results -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Anomaly Detection</h5>
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

    // Function to detect anomalies (using simple standard deviation method)
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

    // Function to update chart
    async function updateChart(period) {
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
            <p><strong>Total Sales:</strong> $${stats.total}</p>
            <p><strong>Average Daily Sales:</strong> $${stats.average}</p>
            <p><strong>Highest Sale:</strong> $${stats.max}</p>
            <p><strong>Lowest Sale:</strong> $${stats.min}</p>
        `;
    }

    function updateAnomalies(anomalies, data) {
        const container = document.getElementById('anomalyContainer');
        if (anomalies.length === 0) {
            container.innerHTML = '<p>No anomalies detected in this period.</p>';
            return;
        }

        let html = '<ul class="list-group">';
        anomalies.forEach(index => {
            html += `
                <li class="list-group-item ${data.amounts[index] > data.averageSale ? 'list-group-item-success' : 'list-group-item-danger'}">
                    ${data.dates[index]}: $${data.amounts[index]} 
                    (${data.amounts[index] > data.averageSale ? 'Unusually high' : 'Unusually low'} sales)
                </li>
            `;
        });
        html += '</ul>';
        container.innerHTML = html;
    }

    // Initialize with last week's data
    document.addEventListener('DOMContentLoaded', () => {
        updateChart('week');
    });
    </script>

<?php include 'includes/footer.php'; ?>