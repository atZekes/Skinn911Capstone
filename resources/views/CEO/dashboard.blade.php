@extends('layouts.ceoapp')

@section('dashboard')
<div class="container-fluid px-3 px-md-4">
    <!-- Top statistics cards -->
    <div class="mb-4 row g-3">
        <!-- Total Users Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon icon-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number" id="totalUsers">{{ $totalUsers ?? '0' }}</div>
                <div class="stats-label">Total Users</div>
                <div class="mt-3" style="font-size: 0.85rem;">
                    <div class="mb-1 d-flex justify-content-between text-muted">
                        <span><i class="fas fa-user text-info me-1"></i>Clients:</span>
                        <strong class="text-info">{{ $totalClients ?? '0' }}</strong>
                    </div>
                    <div class="mb-1 d-flex justify-content-between text-muted">
                        <span><i class="fas fa-user-tie text-warning me-1"></i>Staff:</span>
                        <strong class="text-warning">{{ $totalStaff ?? '0' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted">
                        <span><i class="fas fa-user-shield text-danger me-1"></i>Admins:</span>
                        <strong class="text-danger">{{ $totalAdmins ?? '0' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Branches Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon icon-branches">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stats-number" id="activeBranches">{{ $activeBranches ?? '0' }}</div>
                <div class="stats-label">Active Branches</div>
            </div>
        </div>

        <!-- Total Bookings Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon icon-bookings">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stats-number" id="totalBookings">{{ $totalBookings ?? '0' }}</div>
                <div class="stats-label">Total Bookings</div>
                @if(isset($bookingGrowth) && $bookingGrowth != 0)
                    <div class="growth-indicator">
                        <i class="fas fa-arrow-{{ $bookingGrowth > 0 ? 'up' : 'down' }} me-1"></i>
                        <span class="{{ $bookingGrowth > 0 ? 'text-success' : 'text-danger' }}">
                            {{ abs($bookingGrowth) }}% from last month
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Monthly Revenue Card -->
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="stats-card">
                <div class="stats-icon icon-revenue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stats-number" id="monthlyRevenue">₱{{ number_format($monthlyRevenue ?? 0, 0) }}</div>
                <div class="stats-label">Monthly Revenue</div>
                @if(isset($revenueGrowthPercent) && $revenueGrowthPercent != 0)
                    <div class="growth-indicator">
                        <i class="fas fa-arrow-{{ $revenueGrowthPercent > 0 ? 'up' : 'down' }} me-1"></i>
                        <span class="{{ $revenueGrowthPercent > 0 ? 'text-success' : 'text-danger' }}">
                            {{ abs($revenueGrowthPercent) }}% from last month
                        </span>
                    </div>
                @endif
            </div>
        </div>
            </div>

    <!-- Client Retention Analytics -->
    <div class="mb-4">
        <div class="chart-container">
            <h4 class="chart-title">
                <i class="fas fa-chart-line me-2"></i>Client Retention Analytics
            </h4>

            <!-- Metrics Cards (Mobile Responsive) -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="card text-center h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <div class="card-body text-white py-3 px-2">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-users mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                    <h6 class="text-white opacity-85 mb-2" style="font-size: 0.75rem; font-weight: 600;">Total Clients</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.8rem;">{{ number_format($retentionSummary['total_clients'] ?? 0) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card text-center h-100" style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(245, 98, 137, 0.3);">
                            <div class="card-body text-white py-3 px-2">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-percentage mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                    <h6 class="text-white opacity-85 mb-2" style="font-size: 0.75rem; font-weight: 600;">Return Rate (30d)</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.8rem;">{{ $retentionSummary['average_return_rate'] ?? 0 }}%</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card text-center h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);">
                            <div class="card-body text-white py-3 px-2">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-clock mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                    <h6 class="text-white opacity-85 mb-2" style="font-size: 0.75rem; font-weight: 600;">Avg Days Between</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.8rem;">{{ $retentionSummary['average_days_between_bookings'] ?? 0 }}<small style="font-size: 0.6rem;">d</small></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card text-center h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);">
                            <div class="card-body text-white py-3 px-2">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-calendar-check mb-2" style="font-size: 1.5rem; opacity: 0.8;"></i>
                                    <h6 class="text-white opacity-85 mb-2" style="font-size: 0.75rem; font-weight: 600;">Total Visits</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.8rem;">{{ number_format($retentionSummary['total_visits'] ?? 0) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <!-- Executive Summary Row -->
    <div class="mb-4 row g-3">
        <!-- Branch Performance Comparison -->
        <div class="mb-4 col-xl-6 col-lg-6">
            <div class="executive-card">
                <h5><i class="fas fa-building me-2"></i>Branch Performance Comparison</h5>
                @if(isset($branchPerformance) && count($branchPerformance) > 0)
                    @foreach($branchPerformance as $branch)
                        <div class="branch-item">
                            <div class="branch-name">{{ $branch['name'] }}</div>
                            <div>
                                <div class="branch-revenue">₱{{ number_format($branch['revenue'], 0) }}</div>
                                <small class="text-muted">{{ $branch['bookings'] }} bookings</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No branch performance data available.</p>
                @endif
            </div>
        </div>

        <!-- Top Performing Services -->
        <div class="mb-4 col-xl-6 col-lg-6">
            <div class="executive-card">
                <h5><i class="fas fa-star me-2"></i>Top Performing Services</h5>
                @if(isset($topServices) && count($topServices) > 0)
                    @foreach($topServices as $service)
                        <div class="service-item">
                            <div class="service-name">{{ $service['name'] }}</div>
                            <div class="service-count">{{ $service['bookings'] }} bookings</div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No service performance data available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Retention Chart Row -->
    <div class="mb-4">
        <div class="chart-container">
                <!-- Retention Analytics Chart -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <h6 class="mb-0 fw-bold" style="color: #333;">
                        <i class="fas fa-chart-area me-2" style="color: #F56289;"></i>Return Rate & Visits Trend
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="filter-dropdown">
                            <select class="form-select form-select-sm" id="retentionPeriodFilter" style="min-width: 100px;">
                                <option value="month" selected>Last 6 Months</option>
                                <option value="quarter">Last Year</option>
                                <option value="year">Last 2 Years</option>
                            </select>
                        </div>
                        <div class="filter-dropdown">
                            <select class="form-select form-select-sm" id="retentionChartTypeFilter" style="min-width: 100px;">
                                <option value="line" selected>Line Chart</option>
                                <option value="bar">Bar Chart</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="chart-wrapper" style="position: relative; height: 350px;">
                    <canvas id="retentionChart"></canvas>
                </div>
        </div>
    </div>

    <!-- Revenue Growth Chart -->
    <div class="mb-4">
        <div class="chart-container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
                    <h4 class="chart-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Revenue Growth Trends
                    </h4>
                    <div class="d-flex gap-2">
                        <div class="filter-dropdown">
                            <select class="form-select form-select-sm branch-filter" data-target="revenue" style="min-width: 140px; max-width: 150px;">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-dropdown">
                            <select class="form-select form-select-sm" id="chartTypeFilter" style="min-width: 140px; max-width: 150px;">
                                <option value="line" selected>Line Chart</option>
                                <option value="bar">Bar Chart</option>
                            </select>
                        </div>
                        <div class="filter-dropdown">
                            <select class="form-select form-select-sm" id="revenueFilter" style="min-width: 120px; max-width: 130px;">
                                <option value="week">Last Week</option>
                                <option value="month" selected>Last Month</option>
                                <option value="quarter">Last Quarter</option>
                                <option value="year">Last Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="chart-wrapper" style="position: relative; height: 320px; max-height: 320px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

    <!-- Peak Booking Hours Chart -->
    <div class="mb-4 row">
        <div class="col-12">
            <div class="chart-container">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="chart-title mb-0">
                            <i class="fas fa-clock me-2"></i>Peak Booking Hours
                        </h4>
                        <div class="d-flex gap-2">
                            <div class="filter-dropdown">
                                <select class="form-select form-select-sm branch-filter" data-target="peak" style="min-width: 140px; max-width: 150px;">
                                    <option value="">All Branches</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-dropdown">
                                <select class="form-select form-select-sm" id="peakHoursFilter" style="min-width: 120px; max-width: 130px;">
                                    <option value="week">Last Week</option>
                                    <option value="month" selected>Last Month</option>
                                    <option value="quarter">Last Quarter</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <div class="chart-wrapper" style="position: relative; height: 400px; max-height: 400px;">
                    <canvas id="peakHoursChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Retention Analytics Section -->
    <div class="mb-4 row">
        <div class="col-12">

                   <!-- Branch Comparison Section -->
    <div class="mb-4 row branch-comparison-section">
        <div class="col-12">
            <div class="chart-container">
                <h4 class="chart-title">
                    <i class="fas fa-balance-scale me-2"></i>Branch Performance Comparison
                </h4>

                <!-- Branch Selection Controls -->
                <div class="mb-4 row">
                    <div class="col-md-5">
                        <label for="branch1" class="form-label"><strong>First Branch</strong></label>
                        <select class="form-select form-select-lg" id="branch1" name="branch1">
                            <option value="">Choose First Branch...</option>
                            @if(isset($branches))
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="text-center col-md-2 d-flex align-items-end">
                        <div class="w-100">
                            <span class="px-3 py-2 badge">VS.</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="branch2" class="form-label"><strong>Second Branch</strong></label>
                        <select class="form-select form-select-lg" id="branch2" name="branch2">
                            <option value="">Choose Second Branch...</option>
                            @if(isset($branches))
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="mb-4 row">
                    <div class="text-center col-12">
                        <button type="button" class="px-5 py-3 btn btn-lg btn-primary" id="compareBtn" disabled>
                            <i class="fas fa-chart-bar me-2"></i>Compare Branch Performance
                        </button>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div class="text-center" id="loadingIndicator" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading comparison data...</p>
                </div>

                <!-- Charts Section -->
                <div id="chartsSection" style="display: none;">
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-dollar-sign text-success me-2"></i>Revenue Comparison</h5>
                                </div>
                                <div class="card-body">
                                    <div style="height: 300px;">
                                        <canvas id="branchRevenueChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-calendar-check text-primary me-2"></i>Bookings Comparison</h5>
                                </div>
                                <div class="card-body">
                                    <div style="height: 300px;">
                                        <canvas id="branchBookingsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="branchCards">
                        <!-- Branch performance cards will be populated here -->
                    </div>

                    <div class="mt-3 row">
                        <div class="text-center col-12">
                            <button type="button" class="btn btn-outline-secondary" id="resetComparisonBtn">
                                <i class="fas fa-refresh me-2"></i>Reset Comparison
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Welcome Message -->
                <div id="welcomeMessage" class="py-4 text-center">
                    <div class="text-muted">
                        <i class="mb-3 fas fa-chart-line fa-3x" style="color: #e75480;"></i>
                        <h5 style="color: #e75480;">Branch Performance Comparison</h5>
                        <p>Select two branches above to compare their performance metrics and view detailed analytics.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/CEO/dashboard.js') }}"></script>
<script>
// Initialize dashboard when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Pass data from Laravel to JavaScript
    const revenueData = @json($revenueGrowth ?? ['months' => [], 'revenues' => []]);
    const clientData = @json($clientRetention ?? []);
    const peakHoursData = @json($peakBookingHours ?? ['hours' => [], 'percentages' => []]);
    const compareUrl = '{{ route("ceo.compare.branches") }}';
    const csrfToken = '{{ csrf_token() }}';

    // Initialize dashboard functionality
    initializeDashboard(revenueData, clientData, peakHoursData, compareUrl, csrfToken);

    // Initialize Retention Chart
    initializeRetentionChart();
});

// Retention Chart Management
let retentionChart = null;

function initializeRetentionChart() {
    loadRetentionChartData();

    // Add event listeners for filters
    document.getElementById('retentionPeriodFilter').addEventListener('change', loadRetentionChartData);
    document.getElementById('retentionChartTypeFilter').addEventListener('change', function() {
        if (retentionChart) {
            loadRetentionChartData();
        }
    });
}

function loadRetentionChartData() {
    const period = document.getElementById('retentionPeriodFilter').value;
    const chartType = document.getElementById('retentionChartTypeFilter').value;

    // Build query parameters
    const params = new URLSearchParams({
        period: period,
        chart_type: chartType
    });    // Fetch data from API
    fetch(`{{ route('ceo.retention-chart-data') }}?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error loading retention chart:', data.error);
                return;
            }
            renderRetentionChart(data, chartType);
        })
        .catch(error => {
            console.error('Error fetching retention chart data:', error);
        });
}

function renderRetentionChart(data, chartType) {
    const ctx = document.getElementById('retentionChart').getContext('2d');

    // Destroy existing chart if it exists
    if (retentionChart) {
        retentionChart.destroy();
    }

    // Create new chart
    retentionChart = new Chart(ctx, {
        type: chartType,
        data: {
            labels: data.labels,
            datasets: data.datasets.map(dataset => ({
                ...dataset,
                fill: chartType === 'line' ? true : false,
                borderWidth: 2,
                pointRadius: chartType === 'line' ? 4 : 0,
                pointHoverRadius: chartType === 'line' ? 6 : 0,
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: window.innerWidth < 768 ? 9 : 11
                        },
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(245, 98, 137, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Return Rate (%)',
                        color: '#F56289',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: function(value) {
                            return Math.round(value);
                        }
                    },
                    title: {
                        display: true,
                        text: 'Total Visits',
                        color: '#667eea',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
}
</script>
@endsection

