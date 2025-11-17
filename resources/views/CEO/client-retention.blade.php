@extends('layouts.ceoapp')

@section('dashboard')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: 2px solid #F56289; border-radius: 15px; box-shadow: 0 8px 25px rgba(245,98,137,0.15);">
                <div class="card-header" style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); border-radius: 13px 13px 0 0; padding: 20px;">
                    <h3 class="mb-1 text-white" style="font-size: 1.5rem;">
                        <i class="fas fa-users-cog me-2"></i>Client Retention Overview
                    </h3>
                    <p class="mb-0 text-white opacity-75" style="font-size: 0.9rem;">Track client visit patterns and retention metrics</p>
                </div>

                <div class="card-body p-3 p-md-4">
                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px;">
                                <div class="card-body text-white py-3 px-2">
                                    <h6 class="text-white opacity-75 mb-1" style="font-size: 0.75rem;">Total Clients</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.5rem;">{{ $totalClients }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border: none; border-radius: 10px;">
                                <div class="card-body text-white py-3 px-2">
                                    <h6 class="text-white opacity-75 mb-1" style="font-size: 0.75rem;">Active Clients</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.5rem;">{{ $activeClients }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border: none; border-radius: 10px;">
                                <div class="card-body text-white py-3 px-2">
                                    <h6 class="text-white opacity-75 mb-1" style="font-size: 0.75rem;">Inactive Clients</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.5rem;">{{ $inactiveClients }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); border: none; border-radius: 10px;">
                                <div class="card-body text-white py-3 px-2">
                                    <h6 class="text-white opacity-75 mb-1" style="font-size: 0.75rem;">Avg Return Rate</h6>
                                    <h2 class="mb-0 fw-bold" style="font-size: 1.25rem;">
                                        @if($averageReturnInterval)
                                            {{ round($averageReturnInterval) }}d
                                        @else
                                            N/A
                                        @endif
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <form method="GET" action="{{ route('ceo.client-retention') }}" class="mb-4">
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label fw-bold" style="color: #F56289; font-size: 0.85rem;">
                                    <i class="fas fa-building me-1"></i>Branch
                                </label>
                                <select name="branch_id" class="form-select form-select-sm" style="border: 2px solid #ffe4ec; border-radius: 8px;">
                                    <option value="">All Branches</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $branchFilter == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label fw-bold" style="color: #F56289; font-size: 0.85rem;">
                                    <i class="fas fa-calendar me-1"></i>Date Range
                                </label>
                                <select name="date_range" class="form-select form-select-sm" style="border: 2px solid #ffe4ec; border-radius: 8px;">
                                    <option value="all" {{ $dateRange == 'all' ? 'selected' : '' }}>All Time</option>
                                    <option value="3months" {{ $dateRange == '3months' ? 'selected' : '' }}>Last 3 Months</option>
                                    <option value="6months" {{ $dateRange == '6months' ? 'selected' : '' }}>Last 6 Months</option>
                                    <option value="12months" {{ $dateRange == '12months' ? 'selected' : '' }}>Last 12 Months</option>
                                </select>
                            </div>

                            <div class="col-6 col-md-4 col-lg-2">
                                <label class="form-label fw-bold" style="color: #F56289; font-size: 0.85rem;">
                                    <i class="fas fa-clock me-1"></i>Inactive After
                                </label>
                                <select name="inactive_days" class="form-select form-select-sm" style="border: 2px solid #ffe4ec; border-radius: 8px;">
                                    <option value="30" {{ $inactiveDays == 30 ? 'selected' : '' }}>30 Days</option>
                                    <option value="60" {{ $inactiveDays == 60 ? 'selected' : '' }}>60 Days</option>
                                    <option value="90" {{ $inactiveDays == 90 ? 'selected' : '' }}>90 Days</option>
                                    <option value="180" {{ $inactiveDays == 180 ? 'selected' : '' }}>180 Days</option>
                                </select>
                            </div>

                            <div class="col-6 col-md-4 col-lg-2">
                                <label class="form-label fw-bold" style="color: #F56289; font-size: 0.85rem;">
                                    <i class="fas fa-filter me-1"></i>Show
                                </label>
                                <select name="show_inactive" class="form-select form-select-sm" style="border: 2px solid #ffe4ec; border-radius: 8px;">
                                    <option value="0" {{ !$showInactiveOnly ? 'selected' : '' }}>All Clients</option>
                                    <option value="1" {{ $showInactiveOnly ? 'selected' : '' }}>Inactive Only</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-4 col-lg-2 d-flex align-items-end">
                                <button type="submit" class="btn w-100 btn-sm" style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); color: white; border-radius: 8px; font-weight: 600; padding: 8px;">
                                    <i class="fas fa-search me-1"></i><span class="d-none d-md-inline">Apply </span>Filters
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Additional Stats -->
                    <div class="alert" style="background: #f8f9fa; border: 2px solid #e9ecef; border-radius: 10px;">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <i class="fas fa-chart-line" style="color: #F56289; font-size: 2rem;"></i>
                                <h5 class="mt-2 mb-1" style="color: #F56289;">Average Visits</h5>
                                <h3 class="mb-0 fw-bold">{{ $averageVisits ? round($averageVisits, 1) : 'N/A' }}</h3>
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-percentage" style="color: #F56289; font-size: 2rem;"></i>
                                <h5 class="mt-2 mb-1" style="color: #F56289;">Active Rate</h5>
                                <h3 class="mb-0 fw-bold">
                                    @if($totalClients > 0)
                                        {{ round(($activeClients / $totalClients) * 100, 1) }}%
                                    @else
                                        N/A
                                    @endif
                                </h3>
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-user-clock" style="color: #F56289; font-size: 2rem;"></i>
                                <h5 class="mt-2 mb-1" style="color: #F56289;">Avg Return Days</h5>
                                <h3 class="mb-0 fw-bold">
                                    @if($averageReturnInterval)
                                        {{ round($averageReturnInterval) }}
                                    @else
                                        N/A
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Client Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-hover" id="retentionTable">
                            <thead style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); color: white;">
                                <tr>
                                    <th><i class="fas fa-user me-1"></i>Client Name</th>
                                    <th><i class="fas fa-envelope me-1"></i>Email</th>
                                    <th><i class="fas fa-phone me-1"></i>Phone</th>
                                    <th class="text-center"><i class="fas fa-calendar-check me-1"></i>Total Visits</th>
                                    <th class="text-center"><i class="fas fa-calendar me-1"></i>Last Visit</th>
                                    <th class="text-center"><i class="fas fa-clock me-1"></i>Days Since</th>
                                    <th class="text-center"><i class="fas fa-sync-alt me-1"></i>Return Interval</th>
                                    <th class="text-center"><i class="fas fa-info-circle me-1"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($retentionData as $client)
                                    <tr>
                                        <td class="fw-bold">{{ $client['name'] }}</td>
                                        <td>{{ $client['email'] }}</td>
                                        <td>{{ $client['mobile_phone'] ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span class="badge" style="background: #667eea; font-size: 0.9rem;">
                                                {{ $client['total_visits'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($client['last_visit_date'])
                                                {{ \Carbon\Carbon::parse($client['last_visit_date'])->format('M d, Y') }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($client['days_since_last_visit'] !== null)
                                                @php
                                                    $days = $client['days_since_last_visit'];
                                                    $hours = $days * 24;
                                                    if ($hours < 24) {
                                                        $timeAgo = $hours < 1 ? 'Just now' : round($hours) . ' hours ago';
                                                    } elseif ($days == 1) {
                                                        $timeAgo = '1 day ago';
                                                    } else {
                                                        $timeAgo = $days . ' days ago';
                                                    }
                                                @endphp
                                                <span class="badge {{ $client['days_since_last_visit'] > $inactiveDays ? 'bg-danger' : 'bg-success' }}">
                                                    {{ $timeAgo }}
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($client['return_interval'] !== null)
                                                <span class="badge" style="background: #43e97b;">
                                                    {{ $client['return_interval'] }} days
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($client['is_inactive'])
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Inactive
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No client data available</h5>
                                            <p class="text-muted">Try adjusting your filters or add more bookings</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Export Button -->
                    <div class="mt-3">
                        <button onclick="exportTableToCSV('client-retention-data.csv')" class="btn btn-success">
                            <i class="fas fa-file-export me-2"></i>Export to CSV
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Export table to CSV
function exportTableToCSV(filename) {
    const table = document.getElementById('retentionTable');
    const rows = table.querySelectorAll('tr');
    const csv = [];

    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];

        cols.forEach(col => {
            let text = col.innerText.replace(/\n/g, ' ').trim();
            // Remove icon text
            text = text.replace(/[\uD800-\uDFFF]./g, '');
            rowData.push('"' + text + '"');
        });

        if (rowData.length > 0) {
            csv.push(rowData.join(','));
        }
    });

    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');

    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
</script>

<style>
.table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    border: none;
    white-space: nowrap;
    padding: 12px 8px;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background: #fff5f8;
    box-shadow: 0 2px 8px rgba(245,98,137,0.1);
}

.table tbody td {
    padding: 10px 8px;
    vertical-align: middle;
    font-size: 0.85rem;
}

.card {
    transition: all 0.3s ease;
}

/* Mobile responsive table */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.75rem;
    }

    .table thead th {
        font-size: 0.65rem;
        padding: 8px 4px;
    }

    .table tbody td {
        padding: 8px 4px;
        font-size: 0.75rem;
    }

    .table thead th i,
    .table tbody td i {
        display: none;
    }

    .badge {
        font-size: 0.65rem !important;
        padding: 3px 6px;
    }

    .alert {
        padding: 15px !important;
    }

    .alert .row > div {
        margin-bottom: 15px;
    }

    .alert h5 {
        font-size: 0.9rem;
    }

    .alert h3 {
        font-size: 1.2rem;
    }

    .alert i {
        font-size: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .table {
        font-size: 0.7rem;
    }

    .table thead th {
        font-size: 0.6rem;
        padding: 6px 3px;
    }

    .table tbody td {
        padding: 6px 3px;
        font-size: 0.7rem;
    }
}
</style>
@endsection
