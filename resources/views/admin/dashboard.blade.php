@extends('layouts.adminapp')

@section('styles')
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
@endsection

@push('head')
    <!-- Chart data for JavaScript -->
    <meta name="chart-labels" content="{{ json_encode($labels ?? []) }}">
    <meta name="chart-datasets" content="{{ json_encode($chartDatasets ?? []) }}">
@endpush
<style>
    .dashboard-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(231,84,128,0.10);
    padding: 32px 28px;
    margin-top: 32px;
}

.dashboard-title {
    color: #e75480;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 24px;
    text-align: center;
}

.dashboard-btn {
    background: #e75480;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    margin: 8px 0;
    min-width: 180px;
}

.dashboard-btn:hover {
    background: #d13c6a;
}
.modal-pink-header {
    background: #e75480;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.modal-pink-header .modal-title {
    color: #fff;
    font-weight: 700;
}

.modal-pink-btn {
    background: #e75480;
    color: #fff;
    border: 0;
    border-radius: 8px;
    padding: 8px 14px;
}

.modal-pink-btn:hover {
    background: #d13c6a;
}
.btn-view-pink {
    background: #fff;
    color: #e75480;
    border: 1px solid #e75480;
    border-radius: 8px;
    padding: 4px 8px;
    font-weight: 600;
}

.btn-view-pink:hover {
    background: #e75480;
    color: #fff;
    text-decoration: none;
}

</style>
@section('content')
<div class="container dashboard-card">
    <div class="dashboard-title">Admin Dashboard</div>

    {{-- KPI Row --}}
    <div class="mb-4 row g-3">
        <div class="text-center col-md-3">
            <div style="background:#fff;padding:18px;border-radius:12px;">
                <div style="color:#e75480;font-weight:700;">Today</div>
                <div style="font-size:1.8rem;font-weight:700;">{{ $kpis['today_bookings'] ?? 0 }}</div>
                <small class="text-muted">Bookings</small>
            </div>
        </div>
        <div class="text-center col-md-3">
            <div style="background:#fff;padding:18px;border-radius:12px;">
                <div style="color:#e75480;font-weight:700;">Walk-ins</div>
                <div id="kpi-walkins" style="font-size:1.8rem;font-weight:700;">{{ $kpis['walkins_today'] ?? 0 }}</div>
                <small class="text-muted">Today</small>
            </div>
        </div>
        <div class="text-center col-md-3">
            <div style="background:#fff;padding:18px;border-radius:12px;">
                <div style="color:#e75480;font-weight:700;">Active</div>
                <div style="font-size:1.8rem;font-weight:700;">{{ $kpis['active_bookings'] ?? 0 }}</div>
                <small class="text-muted">Active bookings</small>
            </div>
        </div>
        <div class="text-center col-md-3">
            <div style="background:#fff;padding:18px;border-radius:12px;">
                <div style="color:#e75480;font-weight:700;">Revenue</div>
                <div style="font-size:1.8rem;font-weight:700;">₱{{ number_format($kpis['revenue_today'] ?? 0,2) }}</div>
                <small class="text-muted">Today</small>
            </div>
        </div>
    </div>

    {{-- Branch summary cards --}}
    <div class="mb-4 row" id="branch-summaries">
        @foreach($branchSummaries ?? [] as $bs)
        <div class="mb-2 col-md-3 branch-summary" data-branch-id="{{ $bs['id'] }}">
            <div style="background:#fff;padding:12px;border-radius:10px;min-height:100px;" id="branch-summary-{{ $bs['id'] }}">
                <div style="font-weight:700;color:#333;">{{ $bs['name'] }}</div>
                <div class="branch-count" style="font-size:1.2rem;font-weight:700;">{{ $bs['today_bookings'] }} / {{ $bs['capacity'] }}</div>
                <div class="branch-util text-muted">Utilization: {{ $bs['utilization'] }}%</div>
                @if($bs['utilization'] >= 90)
                    <div class="branch-status" style="color:#c92a2a;font-weight:700;">High (≥90%)</div>
                @elseif($bs['utilization'] >= 70)
                    <div class="branch-status" style="color:#e67700;font-weight:700;">Medium (70–89%)</div>
                @else
                    <div class="branch-status" style="color:#2f9e44;font-weight:700;">Low</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="mb-3 col-lg-8">
            <div style="background:#fff;padding:18px;border-radius:12px;">
                <h5 style="color:#e75480;margin-bottom:12px;">Recent bookings</h5>
                <input type="search" id="booking-search" class="booking-search-input" placeholder="Search bookings by id, client, branch, or date">
                <div class="table-scrollable">
                    <table class="table mb-0 table-sm" id="recent-bookings-table">
                        <thead>
                            <tr><th>#</th><th>Client</th><th>Branch</th><th>Date</th><th>Time</th><th></th></tr>
                        </thead>
                        <tbody>
                            @foreach($recent as $r)
                            <tr data-status="{{ $r->status }}" data-payment-method="{{ $r->payment_method ?? 'N/A' }}" data-payment-status="{{ $r->payment_status ?? 'N/A' }}">
                                <td class="col-id">{{ $r->id }}</td>
                                <td class="col-client">{{ $r->user->name ?? ($r->walkin_name ?? 'Walk-in') }}</td>
                                <td class="col-branch">{{ $r->branch->name ?? '-' }}</td>
                                <td class="col-date">{{ $r->date }}</td>
                                <td class="col-time">
                                    @php
                                        // Calculate full time range based on service duration for admin dashboard
                                        $startTime = $r->time_slot;
                                        $duration = 1; // default 1 hour

                                        // Get duration from service or package
                                        if ($r->package) {
                                            $duration = $r->package->services->sum('duration') ?: 1;
                                        } elseif ($r->service) {
                                            $duration = $r->service->duration ?: 1;
                                        }

                                        // Calculate and display time
                                        try {
                                            if (strpos($startTime, '-') !== false) {
                                                [$start, $end] = explode('-', $startTime, 2);
                                                $startCarbon = \Carbon\Carbon::createFromFormat('H:i', trim($start));
                                                $endCarbon = $startCarbon->copy()->addHours($duration);

                                                if ($duration > 1) {
                                                    $displayTime = $startCarbon->format('g:ia') . ' - ' . $endCarbon->format('g:ia');
                                                } else {
                                                    $displayTime = $startCarbon->format('g:ia');
                                                }
                                            } else {
                                                $displayTime = $startTime;
                                            }
                                        } catch (\Exception $e) {
                                            $displayTime = $startTime;
                                        }
                                    @endphp
                                    {{ $displayTime }}
                                </td>
                                <td><a href="#" class="btn btn-sm btn-view-pink btn-view-booking" data-id="{{ $r->id }}">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mb-3 col-lg-4">
            <div style="background:#fff;padding:18px;border-radius:12px;">
                <h5 style="color:#e75480;margin-bottom:12px;">Branches</h5>
                @foreach($branches as $b)
                    <div style="margin-bottom:10px;"><strong>{{ data_get($b,'name') }}</strong><br><small class="text-muted">Capacity: {{ data_get($b,'slot_capacity', 5) }}</small></div>
                @endforeach
                <div class="mt-3 text-center">
                    <a href="{{ route('admin.promo') }}" class="btn dashboard-btn">Manage Promos</a>
                    <a href="{{ route('admin.booking-settings') }}" class="btn dashboard-btn">
                        <i class="fas fa-cog me-2"></i>Booking Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bookings last 7 days chart --}}
    <div class="mb-4 row">
        <div class="col-12">
            <div style="background:#fff;padding:18px;border-radius:12px;">
                <h5 style="color:#e75480;margin-bottom:12px;">Bookings — last 7 days</h5>
                <canvas id="bookingsChart" height="120"
                        data-labels="{{ json_encode($labels ?? []) }}"
                        data-datasets="{{ json_encode($chartDatasets ?? []) }}"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- External Dashboard JavaScript -->
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
        <!-- Booking details modal -->
        <div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:12px;">
                    <div class="modal-header modal-pink-header">
                        <h5 class="modal-title">Booking details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background:#fff;">
                        <div class="mb-2"><strong>ID:</strong> <span id="md-booking-id"></span></div>
                        <div class="mb-2"><strong>Client:</strong> <span id="md-booking-client"></span></div>
                        <div class="mb-2"><strong>Branch:</strong> <span id="md-booking-branch"></span></div>
                        <div class="mb-2"><strong>Date:</strong> <span id="md-booking-date"></span></div>
                        <div class="mb-2"><strong>Time:</strong> <span id="md-booking-time"></span></div>
                        <div class="mb-2"><strong>Status:</strong> <span id="md-booking-status"></span></div>
                        <div class="mt-3 text-center">
                            <button type="button" class="modal-pink-btn" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
