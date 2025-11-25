@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Report</h1>

    <form method="GET" action="{{ route('ceo.sales.report') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="from" class="form-label">From</label>
            <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <label for="to" class="form-label">To</label>
            <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-3">
            <label for="branch_id" class="form-label">Branch</label>
            <select name="branch_id" id="branch_id" class="form-select">
                <option value="">All Branches</option>
                @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('ceo.sales.download', request()->query()) }}" class="btn btn-secondary">Download PDF/CSV</a>
        </div>
    </form>

    @if(isset($report))
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Report Summary</h5>
                <p>Total Transactions: <strong>{{ $report['count'] }}</strong></p>
                <p>Total Revenue: <strong>{{ number_format($report['total'],2) }}</strong></p>

                @if(isset($metrics))
                    <div class="mb-3">
                        <h6>Key Metrics</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Total Bookings:</strong> {{ $metrics['total_bookings'] }}</p>
                                <p><strong>Cancelled:</strong> {{ $metrics['cancelled'] }} ({{ $metrics['cancellation_rate'] }}%)</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Promo Transactions:</strong> {{ $metrics['promo']['count'] }}</p>
                                <p><strong>Promo Revenue:</strong> {{ number_format($metrics['promo']['revenue'] ?? 0,2) }} ({{ $metrics['promo']['pct_of_revenue'] ?? 0 }}%)</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Total Revenue (all branches):</strong> {{ number_format($metrics['total_revenue_all'] ?? 0,2) }}</p>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <h6>Revenue by Branch</h6>
                                <ul>
                                    @foreach($metrics['branch_revenues'] as $br)
                                        <li>{{ $br->branch_name ?? 'Unknown' }}: <strong>{{ number_format($br->total,2) }}</strong></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Top Services</h6>
                                <ol>
                                    @foreach($metrics['top_services'] as $ts)
                                        <li>{{ $ts->service_name }} — {{ $ts->tx_count }} tx — {{ number_format($ts->revenue,2) }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <h6>Profit (Purchased Services)</h6>
                                <ol>
                                    @foreach($metrics['profit_per_service'] as $p)
                                        <li>{{ $p->service_name }} — {{ number_format($p->profit,2) }}</li>
                                    @endforeach
                                </ol>
                            </div>
                            <div class="col-md-6">
                                <h6>Peak Hours / Days</h6>
                                <p>Hours: @foreach($metrics['peak_hours'] as $h) {{ $h->hour }}:00 ({{ $h->cnt }}), @endforeach</p>
                                <p>Days: @foreach($metrics['peak_days'] as $d) {{ $d->day }} ({{ $d->cnt }}), @endforeach</p>
                            </div>
                        </div>
                    </div>
                @endif

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Branch</th>
                            <th>Service/Package</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['rows'] as $r)
                            <tr>
                                <td>#{{ $r->booking_id ?? $r->ps_id }}</td>
                                <td>{{ $r->branch_name ?? ($r->branch->name ?? 'N/A') }}</td>
                                <td>{{ $r->service_name ?? ($r->service->name ?? 'N/A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($r->created_at)->format('M d, Y') }}</td>
                                <td>{{ number_format($r->price ?? $r->amount,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
