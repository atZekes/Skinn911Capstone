// CEO Dashboard JavaScript functionality
// Branch comparison variables
let branchRevenueChart = null;
let branchBookingsChart = null;

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
function initializeDashboard(revenueData, clientData, compareUrl, csrfToken) {
    // Initialize existing charts (revenue and client acquisition)
    initializeMainCharts(revenueData, clientData);

    // Initialize branch comparison functionality
    initializeBranchComparison(compareUrl, csrfToken);

    // Update dashboard data every 30 seconds
    setInterval(updateDashboardData, 30000);
}

// Initialize main dashboard charts
function initializeMainCharts(revenueData, clientData) {
    // Revenue Growth Chart
    if (document.getElementById('revenueChart')) {
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.months || [],
                datasets: [{
                    label: 'Revenue',
                    data: revenueData.revenues || [],
                    backgroundColor: 'rgba(231, 84, 128, 0.1)',
                    borderColor: '#e75480',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#e75480',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
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
        });
    }

    // Client Acquisition Chart
    if (document.getElementById('clientChart')) {
        const clientCtx = document.getElementById('clientChart').getContext('2d');
        new Chart(clientCtx, {
            type: 'doughnut',
            data: {
                labels: clientData.months || [],
                datasets: [{
                    data: clientData.newClients || [],
                    backgroundColor: [
                        '#e75480',
                        '#3498db',
                        '#2ecc71',
                        '#f39c12',
                        '#9b59b6',
                        '#e74c3c'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
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
                            padding: 15
                        }
                    }
                }
            }
        });
    }
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
