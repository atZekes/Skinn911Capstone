// CEO Dashboard JavaScript functionality
// Branch comparison variables
let branchRevenueChart = null;
let branchBookingsChart = null;

// Peak hours chart variable
let peakHoursChart = null;

// Client retention chart variable
let clientRetentionChart = null;

// Revenue chart variable
let revenueChart = null;

// Chart configuration for branch comparison
const branchChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                usePointStyle: true,
                padding: 15
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: '#f0f0f0'
            }
        },
        x: {
            grid: {
                display: false
            }
        }
    }
};

// Initialize dashboard functionality
function initializeDashboard(revenueData, clientData, peakHoursData, compareUrl, csrfToken) {
    // Initialize existing charts (revenue and client acquisition)
    initializeMainCharts(revenueData, clientData, peakHoursData);

    // Initialize filter functionality
    initializePeakHoursFilters();
    initializeRetentionFilters();
    initializeRevenueFilters();
    initializeChartTypeFilters();

    // Initialize branch comparison functionality
    initializeBranchComparison(compareUrl, csrfToken);

    // Update dashboard data every 30 seconds
    setInterval(updateDashboardData, 30000);
}

// Initialize main dashboard charts
function initializeMainCharts(revenueData, clientData, peakHoursData) {
    // Revenue Growth Chart
    if (document.getElementById('revenueChart')) {
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        createRevenueChart(revenueCtx, 'line');

        // Set initial data
        if (revenueChart && revenueData) {
            revenueChart.data.labels = revenueData.months || [];
            revenueChart.data.datasets[0].data = revenueData.revenues || [];
            revenueChart.update();
        }
    }

    // Client Retention Chart
    if (document.getElementById('clientChart') && clientData) {
        const clientCtx = document.getElementById('clientChart').getContext('2d');

        // Create a gauge-like chart showing retention rate
        const retentionRate = clientData.retention_rate || 0;

        clientRetentionChart = new Chart(clientCtx, {
            type: 'doughnut',
            data: {
                labels: ['Repeat Customers', 'One-time Customers'],
                datasets: [{
                    data: [clientData.repeat_customers || 0, (clientData.total_customers || 0) - (clientData.repeat_customers || 0)],
                    backgroundColor: [
                        'rgba(231, 84, 128, 0.8)', // Pink for repeat customers
                        'rgba(149, 165, 166, 0.6)'  // Gray for one-time customers
                    ],
                    borderColor: [
                        '#e75480',
                        '#95a5a6'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const percentage = clientData.total_customers > 0 ?
                                    ((value / clientData.total_customers) * 100).toFixed(1) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            },
                            afterLabel: function(context) {
                                if (context.dataIndex === 0) { // Repeat customers
                                    return `Retention Rate: ${clientData.retention_rate}%`;
                                }
                                return `Avg bookings per customer: ${clientData.average_bookings_per_customer}`;
                            }
                        }
                    },
                    // Add center text showing retention rate
                    beforeDraw: function(chart) {
                        const ctx = chart.ctx;
                        const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                        const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

                        ctx.save();
                        ctx.font = 'bold 24px Arial';
                        ctx.fillStyle = '#e75480';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(`${retentionRate}%`, centerX, centerY - 10);

                        ctx.font = '14px Arial';
                        ctx.fillStyle = '#6c757d';
                        ctx.fillText('Retention Rate', centerX, centerY + 15);
                        ctx.restore();
                    }
                },
                cutout: '70%' // Creates the gauge/donut effect
            }
        });
    }

    // Peak Booking Hours Chart
    if (document.getElementById('peakHoursChart') && peakHoursData) {
        const peakHoursCtx = document.getElementById('peakHoursChart').getContext('2d');
        peakHoursChart = new Chart(peakHoursCtx, {
            type: 'bar',
            data: {
                labels: peakHoursData.hours || [],
                datasets: [{
                    label: 'Booking Percentage',
                    data: peakHoursData.percentages || [],
                    backgroundColor: 'rgba(231, 84, 128, 0.7)',
                    borderColor: '#e75480',
                    borderWidth: 2,
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toFixed(1) + '% of total bookings';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        },
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    }

    // Initialize peak hours filter functionality
    initializePeakHoursFilters();
}

// Initialize peak hours filter functionality
function initializePeakHoursFilters() {
    const peakHoursFilter = document.getElementById('peakHoursFilter');

    if (peakHoursFilter) {
        peakHoursFilter.addEventListener('change', function() {
            const period = this.value;
            loadPeakHoursData(period);
        });
    }
}

// Load peak hours data for the specified period
function loadPeakHoursData(period) {
    const url = `/ceo/peak-hours-data?period=${period}`;

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (peakHoursChart && data.hours && data.percentages) {
            peakHoursChart.data.labels = data.hours;
            peakHoursChart.data.datasets[0].data = data.percentages;
            peakHoursChart.update();
        }
    })
    .catch(error => {
        console.error('Error loading peak hours data:', error);
    });
}

// Initialize retention filter functionality
function initializeRetentionFilters() {
    const retentionFilter = document.getElementById('retentionFilter');

    if (retentionFilter) {
        retentionFilter.addEventListener('change', function() {
            const period = this.value;
            loadRetentionData(period);
        });
    }
}

// Load retention data for the specified period
function loadRetentionData(period) {
    const url = `/ceo/retention-data?period=${period}`;

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (clientRetentionChart && data) {
            // Update chart data
            clientRetentionChart.data.datasets[0].data = [
                data.repeat_customers || 0,
                (data.total_customers || 0) - (data.repeat_customers || 0)
            ];

            // Update tooltips data reference
            clientRetentionChart.options.plugins.tooltip.callbacks.afterLabel = function(context) {
                if (context.dataIndex === 0) { // Repeat customers
                    return `Retention Rate: ${data.retention_rate}%`;
                }
                return `Avg bookings per customer: ${data.average_bookings_per_customer}`;
            };

            // Update center text
            clientRetentionChart.options.plugins.beforeDraw = function(chart) {
                const ctx = chart.ctx;
                const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

                ctx.save();
                ctx.font = 'bold 24px Arial';
                ctx.fillStyle = '#e75480';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(`${data.retention_rate || 0}%`, centerX, centerY - 10);

                ctx.font = '14px Arial';
                ctx.fillStyle = '#6c757d';
                ctx.fillText('Retention Rate', centerX, centerY + 15);
                ctx.restore();
            };

            clientRetentionChart.update();
        }
    })
    .catch(error => {
        console.error('Error loading retention data:', error);
    });
}

// Initialize revenue filter functionality
function initializeRevenueFilters() {
    const revenueFilter = document.getElementById('revenueFilter');

    if (revenueFilter) {
        revenueFilter.addEventListener('change', function() {
            const period = this.value;
            loadRevenueData(period);
        });
    }
}

// Load revenue data for the specified period
function loadRevenueData(period) {
    const url = `/ceo/revenue-data?period=${period}`;

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (revenueChart && data.labels && data.revenues) {
            revenueChart.data.labels = data.labels;
            revenueChart.data.datasets[0].data = data.revenues;
            revenueChart.update();
        }
    })
    .catch(error => {
        console.error('Error loading revenue data:', error);
    });
}

// Initialize chart type filter functionality
function initializeChartTypeFilters() {
    const chartTypeFilter = document.getElementById('chartTypeFilter');

    if (chartTypeFilter) {
        chartTypeFilter.addEventListener('change', function() {
            const chartType = this.value;
            changeChartType(chartType);
        });
    }
}

// Change chart type and recreate chart
function changeChartType(chartType) {
    if (revenueChart) {
        revenueChart.destroy();
    }

    const canvas = document.getElementById('revenueChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        createRevenueChart(ctx, chartType);

        // Reload current period data
        const revenueFilter = document.getElementById('revenueFilter');
        if (revenueFilter) {
            const currentPeriod = revenueFilter.value;
            loadRevenueData(currentPeriod);
        }
    }
}

// Create revenue chart with specified type
function createRevenueChart(ctx, chartType = 'line') {
    const currentData = revenueChart ? revenueChart.data : { labels: [], datasets: [{ data: [] }] };

    const chartConfig = {
        type: chartType,
        data: {
            labels: currentData.labels || [],
            datasets: [{
                label: 'Revenue',
                data: currentData.datasets[0]?.data || [],
                backgroundColor: chartType === 'bar' ? '#e75480' : 'rgba(231, 84, 128, 0.1)',
                borderColor: '#e75480',
                borderWidth: 3,
                fill: chartType === 'line' ? true : false,
                tension: chartType === 'line' ? 0.4 : 0,
                pointBackgroundColor: chartType === 'line' ? '#e75480' : 'transparent',
                pointBorderColor: chartType === 'line' ? '#fff' : 'transparent',
                pointBorderWidth: chartType === 'line' ? 2 : 0,
                pointRadius: chartType === 'line' ? 5 : 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    };

    revenueChart = new Chart(ctx, chartConfig);
}

// Initialize branch comparison functionality
function initializeBranchComparison(compareUrl, csrfToken) {
    const branch1Select = document.getElementById('branch1');
    const branch2Select = document.getElementById('branch2');
    const compareBtn = document.getElementById('compareBtn');
    const resetBtn = document.getElementById('resetComparisonBtn');

    if (branch1Select && branch2Select && compareBtn) {
        function updateButtonState() {
            const branch1Value = branch1Select.value;
            const branch2Value = branch2Select.value;

            if (branch1Value && branch2Value && branch1Value !== branch2Value) {
                compareBtn.disabled = false;
                compareBtn.innerHTML = '<i class="fas fa-chart-bar me-2"></i>Compare Branch Performance';
                compareBtn.classList.remove('btn-secondary');
                compareBtn.classList.add('btn-primary');
            } else {
                compareBtn.disabled = true;
                compareBtn.innerHTML = '<i class="fas fa-chart-bar me-2"></i>Select Both Branches First';
                compareBtn.classList.remove('btn-primary');
                compareBtn.classList.add('btn-secondary');
            }
        }

        branch1Select.addEventListener('change', updateButtonState);
        branch2Select.addEventListener('change', updateButtonState);

        updateButtonState();

        compareBtn.addEventListener('click', function() {
            const branch1 = branch1Select.value;
            const branch2 = branch2Select.value;

            if (!branch1 || !branch2) {
                alert('Please select both branches to compare their performance.');
                return;
            }

            if (branch1 === branch2) {
                alert('Please select two different branches for comparison.');
                return;
            }

            document.getElementById('loadingIndicator').style.display = 'block';
            document.getElementById('welcomeMessage').style.display = 'none';
            document.getElementById('chartsSection').style.display = 'none';

            fetch(compareUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    branch1: branch1,
                    branch2: branch2
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                document.getElementById('loadingIndicator').style.display = 'none';
                document.getElementById('chartsSection').style.display = 'block';

                updateBranchCharts(data.branches);
                updateBranchCards(data.branches);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching comparison data');
                document.getElementById('loadingIndicator').style.display = 'none';
            });
        });

        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                document.getElementById('chartsSection').style.display = 'none';
                document.getElementById('welcomeMessage').style.display = 'block';

                branch1Select.value = '';
                branch2Select.value = '';

                updateButtonState();
            });
        }
    }
}

function updateBranchCharts(branches) {
    const branch1 = branches[0];
    const branch2 = branches[1];

    if (branchRevenueChart) branchRevenueChart.destroy();
    if (branchBookingsChart) branchBookingsChart.destroy();

    // Revenue Chart
    const revenueCtx = document.getElementById('branchRevenueChart').getContext('2d');
    branchRevenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: branch1.month_labels,
            datasets: [{
                label: branch1.name,
                data: branch1.monthly_revenue,
                backgroundColor: 'rgba(231, 84, 128, 0.1)',
                borderColor: '#e75480',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                pointBackgroundColor: '#e75480',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }, {
                label: branch2.name,
                data: branch2.monthly_revenue,
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderColor: '#3498db',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            ...branchChartOptions,
            scales: {
                ...branchChartOptions.scales,
                y: {
                    ...branchChartOptions.scales.y,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Bookings Chart
    const bookingsCtx = document.getElementById('branchBookingsChart').getContext('2d');
    branchBookingsChart = new Chart(bookingsCtx, {
        type: 'bar',
        data: {
            labels: branch1.month_labels,
            datasets: [{
                label: branch1.name,
                data: branch1.monthly_bookings,
                backgroundColor: 'rgba(231, 84, 128, 0.8)',
                borderColor: '#e75480',
                borderWidth: 2,
                borderRadius: 5
            }, {
                label: branch2.name,
                data: branch2.monthly_bookings,
                backgroundColor: 'rgba(52, 152, 219, 0.8)',
                borderColor: '#3498db',
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: branchChartOptions
    });
}

function updateBranchCards(branches) {
    const cardsContainer = document.getElementById('branchCards');
    cardsContainer.innerHTML = '';

    branches.forEach((branch, index) => {
        const cardHtml = `
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">${branch.name}</h6>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="text-success">₱${branch.current_revenue.toLocaleString()}</h5>
                                    <small class="text-muted">Current Revenue</small>
                                    <div class="text-${branch.revenue_growth >= 0 ? 'success' : 'danger'} small">
                                        <i class="fas fa-arrow-${branch.revenue_growth >= 0 ? 'up' : 'down'}"></i>
                                        ${Math.abs(branch.revenue_growth)}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="text-primary">${branch.current_bookings}</h5>
                                    <small class="text-muted">Current Bookings</small>
                                    <div class="text-${branch.bookings_growth >= 0 ? 'success' : 'danger'} small">
                                        <i class="fas fa-arrow-${branch.bookings_growth >= 0 ? 'up' : 'down'}"></i>
                                        ${Math.abs(branch.bookings_growth)}%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Current Clients:</small>
                                <div class="fw-bold text-info">${branch.current_clients}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Top Service:</small>
                                <div class="fw-bold text-warning">${branch.top_service} (${branch.top_service_count})</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        cardsContainer.innerHTML += cardHtml;
    });
}

// Update dashboard data (existing functionality)
function updateDashboardData() {
    // This would typically make an AJAX call to refresh dashboard data
    console.log('Updating dashboard data...');
}
