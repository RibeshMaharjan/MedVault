<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-5">
            <div class="row pt-4 mb-4">
                <div class="col-md-6">
                    <h1 class="mb-3">Sales Analysis</h1>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-end" role="group">
                        <button type="button" class="btn btn-outline-danger" id="weekBtn" onclick="updateChartAndButtons('week')">Last Week</button>
                        <button type="button" class="btn btn-outline-danger" id="monthBtn" onclick="updateChartAndButtons('month')">Last Month</button>
                        <button type="button" class="btn btn-outline-danger" id="threeMonthsBtn" onclick="updateChartAndButtons('3months')">Last 3 Months</button>
                    </div>
                </div>
            </div>

            <!-- Charts Container -->
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Sales Trend</h5>
                            <div id="chartContainer">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="row g-3">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Statistics</h5>
                                <div id="statsContainer">
                                    <!-- Stats will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                        <!-- Anomaly Detection Results -->
                        <div class="card border-0 shadow">
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

            <!-- Stock Recommendations -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Stock Recommendations</h5>
                            <div id="stockRecommendations">
                                <!-- Stock recommendations will be populated by JavaScript -->
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

    // Function to calculate weighted moving average
    function calculateWeightedMovingAverage(data, windowSize = 3, weights = [0.5, 0.3, 0.2]) {
        // Adjust weights if they don't match the window size
        if (weights.length !== windowSize) {
            weights = Array(windowSize).fill(1/windowSize);
        }
        
        // Normalize weights to sum to 1
        const weightSum = weights.reduce((a, b) => a + b, 0);
        const normalizedWeights = weights.map(w => w / weightSum);
        
        let result = [];
        for (let i = 0; i < data.length; i++) {
            let weightedSum = 0;
            let usedWeightSum = 0;
            
            for (let j = 0; j < windowSize; j++) {
                const dataIndex = i - (windowSize - 1) + j;
                if (dataIndex >= 0 && dataIndex < data.length) {
                    weightedSum += data[dataIndex] * normalizedWeights[j];
                    usedWeightSum += normalizedWeights[j];
                }
            }
            
            // Renormalize based on available data points
            result.push(usedWeightSum > 0 ? weightedSum / usedWeightSum : data[i]);
        }
        return result;
    }

    // Function to detect anomalies (using standard deviation method)
    function detectAnomalies(data, threshold = 2) {
        if (!data || data.length === 0) {
            return [];
        }
        
        const mean = data.reduce((a, b) => a + b, 0) / data.length;
        const squareDiffs = data.map(value => Math.pow(value - mean, 2));
        const stdDev = Math.sqrt(squareDiffs.reduce((a, b) => a + b, 0) / data.length);
        
        return data.map((value, index) => {
            const zScore = Math.abs(value - mean) / stdDev;
            return zScore > threshold ? index : null;
        }).filter(index => index !== null);
    }

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
            '3months': 'threeMonthsBtn'
        };
        
        const button = document.getElementById(buttonMap[period]);
        if (button) {
            button.classList.add('active');
        }
    }

    // Combined function to update chart and buttons
    async function updateChartAndButtons(period) {
        await updateChart(period);
        updateActiveButton(period);
    }

    // Function to fetch sales data
    async function fetchSalesData(period) {
        try {
            console.log(`Fetching sales data for period: ${period}`);
            // Use the full path to the PHP file
            const response = await fetch(`/MedVault/proj-front/php/get_sales_data.php?period=${period}`);
            
            if (!response.ok) {
                console.error(`Error fetching data: ${response.status} ${response.statusText}`);
                return createEmptyData(period);
            }
            
            const data = await response.json();
            console.log("API Response:", data);
            
            // If data is empty, return structured empty data
            if (!data.dates || data.dates.length === 0) {
                return createEmptyData(period);
            }
            
            return data;
        } catch (error) {
            console.error("Error fetching sales data:", error);
            return createEmptyData(period);
        }
    }
    
    // Function to create empty data structure with proper forecast period
    function createEmptyData(period) {
        const today = new Date();
        const dates = [];
        const amounts = [];
        const predictedDates = [];
        const predictedAmounts = [];
        
        // Generate past dates based on period
        let daysInPast = 7; // default for 'week'
        if (period === 'month') {
            daysInPast = 30;
        } else if (period === '3months') {
            daysInPast = 90;
        }
        
        // Add past dates with zero values
        for (let i = daysInPast - 1; i >= 0; i--) {
            const date = new Date();
            date.setDate(today.getDate() - i);
            dates.push(formatDate(date));
            amounts.push(0);
        }
        
        // Generate future predictions based on period
        let daysToPredict = 7; // default for 'week'
        if (period === 'month') {
            daysToPredict = 30;
        } else if (period === '3months') {
            daysToPredict = 30; // Just show 1 month of predictions for 3 months view
        }
        
        // Add future dates with zero values
        for (let i = 1; i <= daysToPredict; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);
            predictedDates.push(formatDate(date));
            predictedAmounts.push(0);
        }
        
        return {
            dates,
            amounts,
            predictedDates,
            predictedAmounts,
            averageSale: 0
        };
    }
    
    // Helper function to format dates consistently
    function formatDate(date) {
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }
    
    // Function to update chart
    async function updateChart(period) {
        console.log("Updating chart for period:", period);
        
        // Update button states
        updateActiveButton(period);
        
        // Clear any previous alerts
        const chartContainer = document.getElementById('chartContainer');
        if (chartContainer) {
            // Remove any previous alert messages
            const existingAlerts = chartContainer.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
        }

        const data = await fetchSalesData(period);
        console.log("Data received:", data); // Debug: log the data
        
        // Get canvas element
        let canvas = document.getElementById('salesChart');
        if (!canvas) {
            console.warn("Canvas element 'salesChart' not found, creating one");
            if (chartContainer) {
                canvas = document.createElement('canvas');
                canvas.id = 'salesChart';
                chartContainer.appendChild(canvas);
                console.log("Created new canvas:", canvas);
            } else {
                console.error("Chart container not found");
                return;
            }
        }
        
        // Determine prediction period based on selected timeframe
        let daysToForecast = 7; // Default for 'week'
        if (period === 'month') {
            daysToForecast = 30;
        } else if (period === '3months') {
            daysToForecast = 30; // Show 1 month of predictions for 3 months view
        }
        
        // Ensure we have the right number of predicted dates/amounts
        const predictedDates = data.predictedDates || [];
        const predictedAmounts = data.predictedAmounts || [];
        
        // Adjust prediction length if needed
        if (predictedDates.length < daysToForecast) {
            const lastDate = data.dates.length > 0 ? 
                new Date(data.dates[data.dates.length - 1]) : 
                new Date();
                
            const lastAmount = data.amounts.length > 0 ? 
                data.amounts[data.amounts.length - 1] : 0;
            
            for (let i = predictedDates.length; i < daysToForecast; i++) {
                const nextDate = new Date();
                nextDate.setDate(nextDate.getDate() + (i + 1));
                data.predictedDates.push(formatDate(nextDate));
                data.predictedAmounts.push(0);
            }
        }
        
        // Combine actual and predicted data
        const combinedDates = [...data.dates, ...data.predictedDates];
        const combinedAmounts = [...data.amounts, ...data.predictedAmounts];
        
        // Calculate weighted moving average for the entire dataset
        const weightedMA = calculateWeightedMovingAverage(combinedAmounts, 3, [0.5, 0.3, 0.2]);
        
        // Update chart
        if (salesChart) {
            try {
                salesChart.destroy();
            } catch (err) {
                console.error("Error destroying previous chart:", err);
            }
        }

        try {
            const ctx = canvas.getContext('2d');
            
            if (!ctx) {
                console.error("Could not get 2d context from canvas");
                return;
            }
            
            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: combinedDates,
                    datasets: [{
                        label: 'Actual Sales',
                        data: data.amounts.map((val, i) => val),
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }, {
                        label: 'Forecast (Weighted Moving Average)',
                        data: weightedMA,
                        borderColor: 'rgb(255, 99, 132)',
                        borderDash: [5, 5],
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Sales Forecast with Weighted Moving Average'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'Rs. ' + context.parsed.y.toFixed(2);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales Amount (Rs.)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
            console.log("Chart created successfully:", salesChart);
        } catch (error) {
            console.error("Error creating chart:", error);
            // Show error but keep the canvas intact
            if (chartContainer) {
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger mt-3';
                errorAlert.innerHTML = 'Error creating chart: ' + error.message;
                chartContainer.appendChild(errorAlert);
            }
        }

        // Update statistics and other sections
        updateStats(calculateStats(data.amounts));
        updateStockRecommendations(data);
        updateAnomalies(detectAnomalies(data.amounts), data);
    }

    function calculateStats(amounts) {
        if (!amounts || amounts.length === 0) {
            return { total: 0, average: "0.00", max: 0, min: 0 };
        }
        
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
        const container = document.getElementById('statsContainer');
        if (!container) return;
        
        container.innerHTML = `
            <p><strong>Total Sales:</strong> Rs. ${stats.total}</p>
            <p><strong>Average Daily Sales:</strong> Rs. ${stats.average}</p>
            <p><strong>Highest Sale:</strong> Rs. ${stats.max}</p>
            <p><strong>Lowest Sale:</strong> Rs. ${stats.min}</p>
        `;
    }

    function updateAnomalies(anomalies, data) {
        const container = document.getElementById('anomalyContainer');
        if (!container) return;
        
        if (!anomalies || anomalies.length === 0) {
            container.innerHTML = '<p>No sales anomalies detected in this period.</p>';
            return;
        }

        let html = '<ul class="list-group">';
        anomalies.forEach(index => {
            if (data.dates[index] && data.amounts[index] !== undefined) {
                html += `
                    <li class="mb-2 list-group-item ${data.amounts[index] > data.averageSale ? 'list-group-item-success' : 'list-group-item-danger'}">
                        ${data.dates[index]}: Rs. ${data.amounts[index]} 
                        (${data.amounts[index] > data.averageSale ? 'Unusually high' : 'Unusually low'} sales)
                    </li>
                `;
            }
        });
        html += '</ul>';
        container.innerHTML = html;
    }

    function calculateStockRecommendations(data) {
        if (!data.amounts || data.amounts.length === 0) {
            return {
                safetyStock: 0,
                reorderPoint: 0,
                maxStock: 0,
                averageDailySales: 0,
                salesTrend: 'neutral'
            };
        }
        
        const averageDailySales = data.amounts.reduce((a, b) => a + b, 0) / data.amounts.length;
        const maxDailySale = Math.max(...data.amounts);
        const minDailySale = Math.min(...data.amounts);
        const salesTrend = data.amounts.length > 1 && data.amounts[data.amounts.length - 1] > averageDailySales ? 'increasing' : 'decreasing';
        
        // Calculate recommended stock levels
        const safetyStock = averageDailySales > 0 ? Math.ceil(maxDailySale * 1.5) : 0; // 150% of max daily sale
        const reorderPoint = averageDailySales > 0 ? Math.ceil(averageDailySales * 7) : 0; // 7 days of average sales
        const maxStock = reorderPoint > 0 ? Math.ceil(reorderPoint * 2) : 0; // 2x reorder point

        return {
            safetyStock,
            reorderPoint,
            maxStock,
            averageDailySales: Math.ceil(averageDailySales),
            salesTrend
        };
    }

    function updateStockRecommendations(data) {
        const container = document.getElementById('stockRecommendations');
        if (!container) return;
        
        // Calculate recommendations
        const recommendations = calculateStockRecommendations(data);
        
        // Create default inventory object in case fetch fails
        const defaultInventory = {
            totalStock: 0,
            lowStockCount: 0, 
            outOfStockCount: 0,
            lowStockItems: []
        };
        
        // Try to fetch inventory, but handle errors gracefully
        fetch('/MedVault/proj-front/php/get_inventory_levels.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch inventory data');
                }
                return response.json();
            })
            .then(inventory => {
                renderStockRecommendations(container, recommendations, inventory);
            })
            .catch(error => {
                console.error("Error fetching inventory data:", error);
                renderStockRecommendations(container, recommendations, defaultInventory);
            });
    }
    
    function renderStockRecommendations(container, recommendations, inventory) {
        container.innerHTML = `
            <div class="alert ${recommendations.salesTrend === 'increasing' ? 'alert-success' : (recommendations.salesTrend === 'decreasing' ? 'alert-warning' : 'alert-info')} mb-3">
                Sales Trend: <strong>${recommendations.salesTrend === 'increasing' ? 'Increasing ↑' : (recommendations.salesTrend === 'decreasing' ? 'Decreasing ↓' : 'Stable →')}</strong>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h6>Current Inventory Status:</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Units in Stock
                            <span class="badge bg-primary rounded-pill">${inventory.totalStock || 0} units</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Low Stock Items
                            <span class="badge bg-warning rounded-pill">${inventory.lowStockCount || 0} items</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Out of Stock Items
                            <span class="badge bg-danger rounded-pill">${inventory.outOfStockCount || 0} items</span>
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
                            <span class="badge ${(inventory.totalStock || 0) >= recommendations.safetyStock ? 'bg-success' : 'bg-danger'} rounded-pill">
                                ${recommendations.averageDailySales > 0 ? Math.round((inventory.totalStock || 0) / recommendations.averageDailySales) : 0} days
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
            ${inventory.lowStockItems && inventory.lowStockItems.length > 0 ? `
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
    }

    // Initialize with last week's data
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded");
        
        // Set initial active state for 'week' button
        const weekBtn = document.getElementById('weekBtn');
        if (weekBtn) {
            weekBtn.classList.add('active');
        }
        
        // Initialize chart with last week's data
        updateChartAndButtons('week');
    });
    </script>
<?php include 'includes/footer.php'; ?>
