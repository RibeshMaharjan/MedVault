<?php include 'includes/header.php'; ?>
    <div class="main-container d-flex">
        <?php include 'includes/dashboard.php'; ?>
        <div class="container-fluid p-2 p-md-3 p-lg-5 max-vh-100 overflow-auto" style="max-height: 100vh; !important;">
            <?php include 'includes/navbar.php'; ?>
            <div class="row pt-4 mb-4">
                <div class="col-md-6">
                    <h1 class="mb-3">Sales Analysis</h1>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-end" role="group">
                        <button type="button" class="btn btn-outline-danger z-0" id="fiveDaysBtn" onclick="updateChartAndButtons('5days')">5 Days</button>
                        <button type="button" class="btn btn-outline-danger z-0" id="twelveDaysBtn" onclick="updateChartAndButtons('12days')">12 Days</button>
                        <button type="button" class="btn btn-outline-danger z-0" id="fifteenDaysBtn" onclick="updateChartAndButtons('15days')">15 Days</button>
                    </div>
                </div>
            </div>

            <!-- Charts Container -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Sales Trend</h5>
                            <div id="chartContainer">
                                <canvas id="salesChart"></canvas>
                            </div>
                            <div class="mt-3 small text-muted">
                                <p><strong>Understanding the Prediction Method:</strong></p>
                                <p>The sales forecast uses a <strong>Weighted Moving Average</strong> algorithm calculated in the backend that works like this:</p>
                                <ol>
                                    <li>Look at the recent sales data (the "window size" varies by forecast period)</li>
                                    <li>Give more weight to recent days (with different weighting patterns for different forecast periods)</li>
                                    <li>Calculate a weighted average of these values to predict the next day</li>
                                    <li>Add this prediction to our data and repeat to forecast further days</li>
                                    <li>Apply variability that increases with prediction distance to simulate real-world uncertainty</li>
                                </ol>
                                <p>Each forecast period uses different parameters:</p>
                                <ul>
                                    <li><strong>5-day forecast:</strong> Uses 3 most recent days with strong recency bias</li>
                                    <li><strong>12-day forecast:</strong> Uses 5 most recent days with moderate recency bias and gradually increasing variability</li>
                                    <li><strong>15-day forecast:</strong> Uses 9 most recent days with more balanced weights and higher variability</li>
                                </ul>
                                <p>This approach provides an effective way to forecast sales trends while reflecting that longer-term predictions naturally have more uncertainty. All calculations are performed in the backend (get_sales_data.php) to ensure consistency and accuracy.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                        <div class="card border-0 shadow mb-4">
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
    </div>

    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Responsive styles for chart container */
        #chartContainer {
            position: relative;
            height: 50vh; /* Use viewport height for better responsiveness */
            min-height: 300px; /* Minimum height to ensure visibility */
            width: 100%;
            margin-bottom: 20px;
        }

        /* Adjust chart container height based on screen size */
        @media (max-width: 768px) {
            #chartContainer {
                height: 60vh; /* Taller on mobile for better visibility */
                min-height: 250px;
            }

            /* Make sure the chart title and labels are visible on small screens */
            #salesChart {
                max-width: 100%;
                overflow-x: auto;
            }
        }
    </style>

    <script>
    let salesChart = null;

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
            '5days': 'fiveDaysBtn',
            '12days': 'twelveDaysBtn',
            '15days': 'fifteenDaysBtn'
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
            const response = await fetch(`php/get_sales_data.php?period=${period}`);

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
        let daysInPast = 5; // default for '5days'
        if (period === '12days') {
            daysInPast = 12;
        } else if (period === '15days') {
            daysInPast = 15;
        }

        // Add past dates with zero values
        for (let i = daysInPast - 1; i >= 0; i--) {
            const date = new Date();
            date.setDate(today.getDate() - i);
            dates.push(formatDate(date));
            amounts.push(0);
        }

        // Generate future predictions based on period
        let daysToPredict = 5; // default for '5days'
        if (period === '12days') {
            daysToPredict = 12;
        } else if (period === '15days') {
            daysToPredict = 15;
        }

        // Create a simple increasing trend for empty predictions
        // to avoid flat zero line and make the forecast visible
        const baseValue = 0; // Start with a small value
        const increment = 0;  // Small increment for each day

        // Add future dates with small increasing values instead-of-zeros
        // Start with i=0 to include today's date in predictions
        for (let i = 0; i <= daysToPredict; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);
            predictedDates.push(formatDate(date));
            // For today (i=0), use the last value from amounts (which is 0)
            // For future days, use the increasing trend
            if (i === 0) {
                predictedAmounts.push(0); // Today's value (matches the last value in amounts)
            } else {
                predictedAmounts.push(baseValue + ((i - 1) * increment));
            }
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
        let daysToForecast = 5; // Default for '5days'
        if (period === '12days') {
            daysToForecast = 12;
        } else if (period === '15days') {
            daysToForecast = 15;
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

            // Use a small base value and increment for predictions
            const baseValue = 0;
            const increment = 0;

            for (let i = predictedDates.length; i < daysToForecast; i++) {
                const nextDate = new Date();
                nextDate.setDate(nextDate.getDate() + (i + 1));
                data.predictedDates.push(formatDate(nextDate));
                // Use increasing values instead of zeros
                data.predictedAmounts.push(baseValue + ((i + 1) * increment));
            }
        }

        // Check if all prediction amounts are zero and replace with non-zero values if needed
        let allZeros = true;
        for (let i = 0; i < data.predictedAmounts.length; i++) {
            if (data.predictedAmounts[i] > 0) {
                allZeros = false;
                break;
            }
        }

        if (allZeros && data.predictedAmounts.length > 0) {
            console.log("All prediction amounts are zero, replacing with non-zero values");
            const baseValue = 0;
            const increment = 0;
            for (let i = 0; i < data.predictedAmounts.length; i++) {
                data.predictedAmounts[i] = baseValue + ((i + 1) * increment);
            }
        }

        // Combine actual and predicted data for labels
        const combinedDates = [...data.dates, ...data.predictedDates];

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
                        label: 'Sales Forecast',
                        data: [...Array(data.amounts.length - 1).fill(null), data.amounts[data.amounts.length - 1], ...data.predictedAmounts],
                        borderColor: 'rgb(54, 162, 235)',
                        borderDash: [5, 5],
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: function() {
                        // Dynamically adjust aspect ratio based on screen width
                        return window.innerWidth < 768 ? 1 : 2;
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Sales History and Future Forecast',
                            font: {
                                size: function() {
                                    return window.innerWidth < 768 ? 14 : 16;
                                }
                            }
                        },
                        legend: {
                            labels: {
                                // Adjust legend font size for small screens
                                font: {
                                    size: function() {
                                        return window.innerWidth < 768 ? 11 : 12;
                                    }
                                },
                                boxWidth: function() {
                                    return window.innerWidth < 768 ? 30 : 40;
                                }
                            }
                        },
                        tooltip: {
                            titleFont: {
                                size: function() {
                                    return window.innerWidth < 768 ? 12 : 14;
                                }
                            },
                            bodyFont: {
                                size: function() {
                                    return window.innerWidth < 768 ? 11 : 13;
                                }
                            },
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
                                text: 'Sales Amount (Rs.)',
                                font: {
                                    size: function() {
                                        return window.innerWidth < 768 ? 11 : 13;
                                    }
                                }
                            },
                            ticks: {
                                font: {
                                    size: function() {
                                        return window.innerWidth < 768 ? 10 : 12;
                                    }
                                },
                                // Limit the number of ticks on small screens
                                maxTicksLimit: function() {
                                    return window.innerWidth < 768 ? 5 : 10;
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                                font: {
                                    size: function() {
                                        return window.innerWidth < 768 ? 11 : 13;
                                    }
                                }
                            },
                            ticks: {
                                font: {
                                    size: function() {
                                        return window.innerWidth < 768 ? 9 : 11;
                                    }
                                },
                                // Show fewer labels on small screens
                                maxRotation: 45,
                                autoSkip: true,
                                maxTicksLimit: function() {
                                    return window.innerWidth < 768 ? 
                                        (window.innerWidth < 480 ? 5 : 8) : 15;
                                }
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


    // Initialize with 5 days data
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded");

        // Set initial active state for '5days' button
        const fiveDaysBtn = document.getElementById('fiveDaysBtn');
        if (fiveDaysBtn) {
            fiveDaysBtn.classList.add('active');
        }

        // Initialize chart with 5 days data
        updateChartAndButtons('5days');
    });
    </script>
<?php include 'includes/footer.php'; ?>
