<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-5">
            <div class="row pt-4 mb-4">
                <div class="col-md-6">
                    <h1 class="mb-3">Order Analysis</h1>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-end" role="group">
                        <button type="button" class="btn btn-outline-danger active" id="weekBtn" onclick="updateChartAndButtons('week')">Last Week</button>
                        <button type="button" class="btn btn-outline-danger" id="monthBtn" onclick="updateChartAndButtons('month')">Last Month</button>
                        <button type="button" class="btn btn-outline-danger" id="sixMonthsBtn" onclick="updateChartAndButtons('6months')">Last 6 Months</button>
                    </div>
                </div>
            </div>

            <!-- Charts Container -->
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Order Trend</h5>
                            <canvas id="orderChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Statistics</h5>
                            <div id="statsContainer">
                                <!-- Stats will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Performance -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Order Status Distribution</h5>
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Top Ordered Medicines</h5>
                            <div id="topOrders">
                                <!-- Top orders will be populated by JavaScript -->
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
    let orderChart = null;
    let orderStatusChart = null;

    // Function to update active button state
    function updateActiveButton(period) {
        // Remove active class from all buttons
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to selected button
        const buttonMap = {
            'week': 'weekBtn',
            'month': 'monthBtn',
            '6months': 'sixMonthsBtn'
        };
        document.getElementById(buttonMap[period]).classList.add('active');
    }

    // Combined function to update chart and buttons
    async function updateChartAndButtons(period) {
        await updateChart(period);
        updateActiveButton(period);
    }

    // Function to fetch order data
    async function fetchOrderData(period) {
        const response = await fetch(`php/get_order_data.php?period=${period}`);
        return await response.json();
    }

    // Function to update charts
    async function updateChart(period) {
        const data = await fetchOrderData(period);
        
        // Update main order trend chart
        if (orderChart) {
            orderChart.destroy();
        }

        const ctx = document.getElementById('orderChart').getContext('2d');
        orderChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.dates,
                datasets: [{
                    label: 'Daily Orders',
                    data: data.orders,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    }
                }
            }
        });

        // Update order status chart
        if (orderStatusChart) {
            orderStatusChart.destroy();
        }

        const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
        orderStatusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        data.statusDistribution.completed,
                        data.statusDistribution.pending,
                        data.statusDistribution.cancelled
                    ],
                    backgroundColor: [
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });

        // Update statistics
        updateStats(data.stats);

        // Update top orders
        updateTopOrders(data.topOrders);

    }

    function updateStats(stats) {
        document.getElementById('statsContainer').innerHTML = `
            <p><strong>Total Orders:</strong> ${stats.total}</p>
            <p><strong>Average Daily Orders:</strong> ${stats.average}</p>
            <p><strong>Completion Rate:</strong> ${stats.completionRate}%</p>
            <p><strong>Average Order Value:</strong> Rs. ${stats.avgOrderValue}</p>
        `;
    }

    function updateTopOrders(topOrders) {
        let html = '<div class="table-responsive"><table class="table">';
        html += '<thead><tr><th>Medicine</th><th>Orders</th><th>Total Quantity</th></tr></thead><tbody>';
        
        topOrders.forEach(order => {
            html += `
                <tr>
                    <td>${order.medicine_name}</td>
                    <td>${order.order_count}</td>
                    <td>${order.total_quantity}</td>
                </tr>
            `;
        });
        
        html += '</tbody></table></div>';
        document.getElementById('topOrders').innerHTML = html;
    }

    // Initialize with last week's data
    document.addEventListener('DOMContentLoaded', () => {
        updateChart('week');
    });
    </script>
<?php include 'includes/footer.php'; ?>
