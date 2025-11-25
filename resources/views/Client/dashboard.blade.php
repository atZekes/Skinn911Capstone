@extends('layouts.clientapp')

@section('content')
<style>
.stat-card {
    border-radius: 20px;
    padding: 25px;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
    background: white;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(231, 84, 128, 0.2) !important;
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 120px;
    height: 120px;
    background: rgba(231, 84, 128, 0.05);
    border-radius: 50%;
    transform: translate(30%, -30%);
}
.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
    color: white;
    box-shadow: 0 8px 16px rgba(231, 84, 128, 0.3);
}
.stat-number {
    font-size: 2.8rem;
    font-weight: 700;
    margin: 0;
    line-height: 1;
    background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.stat-label {
    font-size: 1rem;
    color: #666;
    margin-top: 8px;
    font-weight: 600;
}

/* Table Styling */
.table tbody tr {
    transition: all 0.2s ease;
    background: white;
}
.table tbody tr:hover {
    background: linear-gradient(90deg, #fff0f5 0%, #ffffff 100%);
    transform: scale(1.005);
}
.table td {
    vertical-align: middle;
    padding: 15px;
    border-color: #ffe4ec !important;
}

/* Badge Styling */
.badge {
    padding: 8px 16px;
    font-weight: 600;
    border-radius: 20px;
    font-size: 0.85rem;
}
.badge.bg-success {
    background: linear-gradient(135deg, #51cf66 0%, #37b24d 100%) !important;
}
.badge.bg-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #fa5252 100%) !important;
}
.badge.bg-info {
    background: linear-gradient(135deg, #4dabf7 0%, #228be6 100%) !important;
}
.badge.bg-warning {
    background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%) !important;
}
.badge.bg-secondary {
    background: linear-gradient(135deg, #868e96 0%, #495057 100%) !important;
}

/* Button Styling */
.btn-sm {
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}
.btn-info {
    background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%) !important;
    color: white !important;
    border: none !important;
}
.btn-success {
    background: linear-gradient(135deg, #51cf66 0%, #37b24d 100%) !important;
    color: white !important;
    border: none !important;
}
.btn-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #fa5252 100%) !important;
    color: white !important;
    border: none !important;
}
.btn-primary {
    background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%) !important;
    color: white !important;
    border: none !important;
}
.btn-sm:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(231, 84, 128, 0.4);
}

/* Scrollbar Styling */
.booking-queue-wrapper::-webkit-scrollbar {
    width: 8px;
}
.booking-queue-wrapper::-webkit-scrollbar-track {
    background: #ffe4ec;
    border-radius: 10px;
}
.booking-queue-wrapper::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
    border-radius: 10px;
}
.booking-queue-wrapper::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #ff8fab 0%, #e75480 100%);
}

/* Quick Action Cards */
.quick-action-card {
    border-radius: 20px;
    transition: all 0.3s ease;
    border: 2px solid #ffe4ec;
    background: white;
}
.quick-action-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(231, 84, 128, 0.2);
    border-color: #ffb3c6;
}

/* SweetAlert2 Toast Customization */
.colored-toast.swal2-popup {
    border-radius: 15px !important;
    border: 2px solid rgba(231, 84, 128, 0.3) !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    font-family: 'Montserrat', sans-serif !important;
    font-size: 15px !important;
    padding: 15px 20px !important;
}

.colored-toast .swal2-title {
    font-size: 15px !important;
    font-weight: 600 !important;
}

.colored-toast .swal2-icon {
    width: 35px !important;
    height: 35px !important;
    margin: 0 10px 0 0 !important;
}

.swal2-timer-progress-bar {
    background: rgba(231, 84, 128, 0.8) !important;
}

/* Booking ID Badge Styling */
#clientBookingQueue .badge[style*="gradient"] {
    transition: all 0.3s ease;
}

#clientBookingQueue .badge[style*="gradient"]:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(231, 84, 128, 0.4);
}
</style>

<div class="container py-4" style="margin-top:120px;">
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    },
                    customClass: {
                        popup: 'colored-toast'
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    background: '#d4edda',
                    color: '#155724'
                });
            });
        </script>
    @endif

    @if(session('error') || $errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    },
                    customClass: {
                        popup: 'colored-toast'
                    }
                });

                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') ?? $errors->first() }}',
                    background: '#f8d7da',
                    color: '#721c24'
                });
            });
        </script>
    @endif

    <!-- Welcome Section -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card shadow" style="border-radius: 25px; border: none; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);">
                <div class="text-center card-body py-5">
                    <h1 class="mb-2 text-white" style="font-family:Montserrat,sans-serif; font-weight: 700; font-size: 2.5rem;">
                        <i class="fas fa-spa me-2"></i>Welcome Back, {{ Auth::user()->name }}!
                    </h1>
                    <p class="mb-0 text-white" style="font-size: 1.2rem; opacity: 0.95;">
                        Your trusted partner for premier skin care and wellness
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="row g-4">
                <!-- Total Bookings -->
                <div class="col-md-4">
                    <div class="card stat-card shadow-lg">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h2 class="stat-number">
                            {{ $totalBookings ?? 0 }}
                        </h2>
                        <p class="stat-label mb-0">Total Bookings</p>
                    </div>
                </div>

                <!-- Active Bookings -->
                <div class="col-md-4">
                    <div class="card stat-card shadow-lg">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h2 class="stat-number">
                            {{ $activeBookings ?? 0 }}
                        </h2>
                        <p class="stat-label mb-0">Active Bookings</p>
                    </div>
                </div>

                <!-- Completed Bookings -->
                <div class="col-md-4">
                    <div class="card stat-card shadow-lg">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="stat-number">
                            {{ $completedBookings ?? 0 }}
                        </h2>
                        <p class="stat-label mb-0">Completed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row of Statistics -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="row g-4">
                <!-- Cancelled Bookings -->
                <div class="col-md-6">
                    <div class="card stat-card shadow-lg">
                        <div class="stat-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h2 class="stat-number">
                            {{ $cancelledBookings ?? 0 }}
                        </h2>
                        <p class="stat-label mb-0">Cancelled Bookings</p>
                    </div>
                </div>

                <!-- Refunded Bookings -->
                <div class="col-md-6">
                    <div class="card stat-card shadow-lg">
                        <div class="stat-icon">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <h2 class="stat-number">
                            {{ $refundedBookings ?? 0 }}
                        </h2>
                        <p class="stat-label mb-0">Refunded / Pending Refund</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Purchased Services Section -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-4 card shadow-lg" style="border-radius: 25px; border: none;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(231, 84, 128, 0.3);">
                            <i class="fas fa-shopping-bag text-white" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <h2 class="mb-0" style="color: #e75480; font-weight: 700;">Your Purchased Services</h2>
                            <small class="text-muted">All your service purchases in one place</small>
                        </div>
                    </div>
                    <div style="max-height:400px; overflow-y:auto;">
                    <table class="table table-hover" style="border-radius:15px;overflow:hidden;">
                        <thead style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color:#fff;">
                            <tr>
                                <th style="border: none; padding: 15px;">Services</th>
                                <th style="border: none; padding: 15px;">Total Price</th>
                                <th style="border: none; padding: 15px;">Date</th>
                                <th style="border: none; padding: 15px;">Time</th>
                                <th style="border: none; padding: 15px;">Location</th>
                                <th style="border: none; padding: 15px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use Carbon\Carbon;
                                // Group purchased services by booking
                                $bookingsWithServices = \App\Models\PurchasedService::where('user_id', Auth::id())
                                    ->with(['service', 'booking.branch', 'booking.package.services', 'booking.transactions'])
                                    ->get()
                                    ->groupBy('booking_id');
                            @endphp
                            @forelse($bookingsWithServices as $bookingId => $services)
                                @php
                                    $booking = $services->first()->booking;
                                    $totalPrice = $services->sum('price');

                                    // Determine if this is a package booking
                                    $pkgToShow = $booking->package ?? null;
                                    if (!$pkgToShow && count($services) > 1) {
                                        $purchasedIds = $services->pluck('service_id')->toArray();
                                        $candidates = \App\Models\Package::where(function($q) use ($booking) {
                                            $branchId = $booking->branch->id ?? null;
                                            if ($branchId) {
                                                $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
                                            }
                                        })->get();
                                        foreach ($candidates as $c) {
                                            $pkgServiceIds = $c->services->pluck('id')->toArray();
                                            if (!array_diff($purchasedIds, $pkgServiceIds)) {
                                                $pkgToShow = $c;
                                                break;
                                            }
                                        }
                                    }

                                    // Determine status
                                    $status = 'completed';
                                    if ($services->contains('status', 'cancelled')) {
                                        $status = 'cancelled';
                                    } elseif ($booking) {
                                        if ($booking->status === 'active') {
                                            $bookingEnd = \Carbon\Carbon::parse($booking->date . ' ' . trim(explode('-', $booking->time_slot)[1]));
                                            if (now()->lt($bookingEnd)) {
                                                $status = 'active';
                                            } else {
                                                $status = 'completed';
                                            }
                                        } elseif ($booking->status === 'cancelled') {
                                            $status = 'cancelled';
                                        }
                                    }

                                    // Calculate total duration and time slot using current active duration
                                    $totalDuration = 0;
                                    if ($booking) {
                                        $totalDuration = $booking->getCurrentActiveDuration();
                                    } else {
                                        // Fallback for purchased services without booking
                                        foreach ($services as $service) {
                                            if ($service->service) {
                                                $totalDuration += $service->service->duration ?? 1;
                                            }
                                        }
                                    }

                                    $displaySlot = $booking->time_slot ?? '';
                                    if ($displaySlot && strpos($displaySlot, '-') !== false && $totalDuration > 0) {
                                        try {
                                            [$startStr, $endStr] = explode('-', $displaySlot, 2);
                                            $start = \Carbon\Carbon::createFromFormat('H:i', trim($startStr));
                                            $end = $start->copy()->addHours($totalDuration);
                                            $displaySlot = $start->format('g') . ' to ' . $end->format('g A');
                                        } catch (\Exception $e) {
                                            // fallback to original
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td data-label="Services">
                                        @if($pkgToShow)
                                            <div><strong>{{ $pkgToShow->name }}</strong></div>
                                            <div class="text-muted small">{{ $pkgToShow->services->pluck('name')->implode(', ') }}</div>
                                        @else
                                            @if(count($services) > 1)
                                                <div><strong>Multiple Services</strong></div>
                                                <div class="text-muted small">{{ $services->pluck('service.name')->implode(', ') }}</div>
                                            @else
                                                {{ $services->first()->service->name ?? 'Service ID: ' . $services->first()->service_id }}
                                            @endif
                                        @endif
                                    </td>
                                    <td data-label="Total Price">₱{{ number_format($booking->transactions->first()->amount ?? $totalPrice, 2) }}</td>
                                    <td data-label="Date">{{ $booking->date }}</td>
                                    <td data-label="Time">{{ $displaySlot }}</td>
                                    <td data-label="Location">
                                        @if($booking && $booking->branch)
                                            {{ $booking->branch->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Status">
                                        @if($status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($status === 'completed')
                                            <span class="badge bg-secondary">Completed</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #ddd;"></i>
                                            <h4 class="mt-3 text-muted">No Purchased Services</h4>
                                            <p class="text-muted">You haven't purchased any services yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Your Bookings Section -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-4 card shadow-lg" style="border-radius: 25px; border: none;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(231, 84, 128, 0.3);">
                            <i class="fas fa-calendar-alt text-white" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <h2 class="mb-0" style="color: #e75480; font-weight: 700;">Your Bookings</h2>
                            <small class="text-muted">Manage all your appointments</small>
                        </div>
                    </div>

                    @php
                        // eager-load package and its services to ensure package info shows up
                        // Show ALL bookings for the current user (active, cancelled, completed, refunded, etc.)
                        $activeBookings = \App\Models\Booking::with(['service','package.services','branch'])
                            ->where('user_id', Auth::id())
                            ->orderByDesc('created_at')
                            ->get();

                        // Count unpaid active bookings (cash payments only) - only from truly active bookings
                        $unpaidActiveBookings = $activeBookings->where('status', 'active')->where('payment_status', '!=', 'paid');
                    @endphp

                    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            @if($unpaidActiveBookings->count() > 0)
                                <button type="button" class="btn btn-danger btn-sm" id="cancelAllBookingsBtn" data-bs-toggle="modal" data-bs-target="#cancelAllModal" style="border-radius: 10px;">
                                    <i class="fas fa-times-circle me-1"></i>Cancel All Unpaid ({{ $unpaidActiveBookings->count() }})
                                </button>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <input id="clientBookingSearch" class="form-control form-control-sm" type="search" placeholder="🔍 Search by ID, branch, service..." style="width: 250px; border-radius: 10px;">
                            <select id="clientStatusFilter" class="form-select form-select-sm" style="width: 150px; border-radius: 10px;">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                                <option value="refunded">Refunded</option>
                                <option value="pending_refund">Pending Refund</option>
                            </select>
                            <input type="date" id="clientDateFilter" class="form-control form-control-sm" style="width: 150px; border-radius: 10px;">
                        </div>
                    </div>

                    <div id="clientBookingQueue" class="booking-queue-wrapper" style="max-height:600px;overflow-y:auto;padding-right:6px;">
                    <table class="table table-hover" style="border-radius:10px;overflow:hidden;width:100%;">
                        <thead style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color:#fff;">
                            <tr>
                                <th style="border: none; padding: 15px;">Booking ID</th>
                                <th style="border: none; padding: 15px;">Branch</th>
                                <th style="border: none; padding: 15px;">Service</th>
                                <th style="border: none; padding: 15px;">Date</th>
                                <th style="border: none; padding: 15px;">Time Slot</th>
                                <th style="border: none; padding: 15px;">Sessions Left</th>
                                <th style="border: none; padding: 15px;">Expiry Date</th>
                                <th style="border: none; padding: 15px;">Status</th>
                                <th style="border: none; padding: 15px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeBookings as $booking)
                                <tr data-booking-id="{{ $booking->id }}" data-status="{{ $booking->status }}" data-payment-status="{{ $booking->payment_status }}" data-date="{{ $booking->date }}">
                                    <td data-label="Booking ID"><span class="badge" style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color: white; cursor: pointer;" title="Click to search">#{{ $booking->id }}</span></td>
                                    <td data-label="Branch">{{ $booking->branch->name ?? '' }}</td>
                                    <td data-label="Service">
                                        @php
                                            $pkgToShow = $booking->package ?? null;
                                            if (!$pkgToShow) {
                                                $purchasedServices = \App\Models\PurchasedService::where('booking_id', $booking->id)->with('service')->get();
                                                // only infer a package when more than one purchased service exists for this booking
                                                if ($purchasedServices->count() > 1) {
                                                    $purchasedIds = $purchasedServices->pluck('service_id')->toArray();
                                                    $candidates = \App\Models\Package::where(function($q) use ($booking) {
                                                        $branchId = $booking->branch->id ?? null;
                                                        if ($branchId) {
                                                            $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
                                                        }
                                                    })->get();
                                                    foreach ($candidates as $c) {
                                                        $pkgServiceIds = $c->services->pluck('id')->toArray();
                                                        if (!array_diff($purchasedIds, $pkgServiceIds)) {
                                                            $pkgToShow = $c;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($pkgToShow)
                                            <div><strong>{{ $pkgToShow->name }}</strong></div>
                                            <div class="text-muted small">{{ $pkgToShow->services->pluck('name')->implode(', ') }}</div>
                                        @else
                                            @php
                                                $purchasedServices = \App\Models\PurchasedService::where('booking_id', $booking->id)->with('service')->get();
                                            @endphp
                                            @if($purchasedServices->count() > 1)
                                                <div><strong>Multiple Services</strong></div>
                                                <div class="text-muted small">
                                                    @foreach($purchasedServices as $ps)
                                                        <div>• {{ $ps->service->name ?? 'Unknown Service' }} ({{ $ps->sessions_remaining ?? 0 }} sessions left)</div>
                                                    @endforeach
                                                </div>
                                            @else
                                                @if($booking->service)
                                                    {{ $booking->service->name }}
                                                @else
                                                    -
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td data-label="Date">{{ $booking->date }}</td>
                                    <td data-label="Time Slot">
                                        @php
                                            // Use current active duration for consistency
                                            $bookingDuration = $booking->getCurrentActiveDuration();
                                            // format display slot: take booking->time_slot start and add bookingDuration hours
                                            $displaySlot = $booking->time_slot;
                                            if ($displaySlot && strpos($displaySlot, '-') !== false && $bookingDuration > 0) {
                                                try {
                                                    [$sstr, $estr] = explode('-', $displaySlot, 2);
                                                    $sTime = \Carbon\Carbon::createFromFormat('H:i', trim($sstr));
                                                    $endTime = $sTime->copy()->addHours($bookingDuration);
                                                    $displaySlot = $sTime->format('g') . ' to ' . $endTime->format('g A');
                                                } catch (\Exception $e) { /* ignore */ }
                                            }
                                        @endphp
                                        {{ $displaySlot }}
                                    </td>
                                    <td data-label="Sessions Left">
                                        @php
                                                $sessionsLeft = '-';
                                                try {
                                                    if ($booking->payment_status === 'paid') {
                                                        // Prefer package sessions bound to this booking
                                                        $sum = \App\Models\ClientPackageSession::where('booking_id', $booking->id)
                                                            ->sum('sessions_remaining');
                                                        if ($sum) {
                                                            $sessionsLeft = $sum;
                                                        } elseif ($booking->package_id) {
                                                            // fallback to package ID match if booking lacks session record
                                                            $sum = \App\Models\ClientPackageSession::where('user_id', $booking->user_id)
                                                                ->where('branch_id', $booking->branch_id)
                                                                ->where('package_id', $booking->package_id)
                                                                ->where('status', 'active')
                                                                ->sum('sessions_remaining');
                                                            if ($sum) $sessionsLeft = $sum;
                                                        }
                                                    }
                                                } catch (\Exception $e) {
                                                    $sessionsLeft = '-';
                                                }
                                        @endphp
                                        @if($sessionsLeft > 0)
                                            <span class="badge bg-pink">{{ $sessionsLeft }} left</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Expiry Date">
                                        @php
                                            $expiryDate = null;
                                            $isExpired = false;
                                            try {
                                                if ($booking->payment_status === 'paid') {
                                                    $session = \App\Models\ClientPackageSession::where('booking_id', $booking->id)
                                                        ->whereNotNull('expiry_date')
                                                        ->first();
                                                    if ($session && $session->expiry_date) {
                                                        $expiryDate = $session->expiry_date;
                                                    } elseif ($booking->package_id) {
                                                        $session = \App\Models\ClientPackageSession::where('user_id', $booking->user_id)
                                                            ->where('branch_id', $booking->branch_id)
                                                            ->where('package_id', $booking->package_id)
                                                            ->whereNotNull('expiry_date')
                                                            ->orderBy('expiry_date', 'asc')
                                                            ->first();
                                                        if ($session && $session->expiry_date) $expiryDate = $session->expiry_date;
                                                    }
                                                }
                                                if ($expiryDate) {
                                                    $isExpired = \Carbon\Carbon::parse($expiryDate)->isPast();
                                                }
                                            } catch (\Exception $e) { /* ignore */ }
                                        @endphp
                                        @if($expiryDate)
                                            <span class="badge {{ $isExpired ? 'bg-danger' : 'bg-info' }}">{{ \Carbon\Carbon::parse($expiryDate)->format('M d, Y') }}{{ $isExpired ? ' (EXPIRED)' : '' }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Status">
                                        @if($booking->status === 'pending_refund')
                                            <span class="badge bg-warning">Pending Refund</span>
                                        @elseif($booking->payment_status === 'refunded')
                                            <span class="badge bg-secondary">Cancelled & Refunded</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($booking->status === 'active')
                                            @if($booking->payment_status === 'paid')
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif($booking->payment_status === 'pending')
                                                <span class="badge bg-warning">Payment Pending</span>
                                            @else
                                                <span class="badge bg-info">Active</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td data-label="Actions">
                                        @if(strtolower($booking->status) === 'active')
                                            <div class="d-flex gap-1 flex-wrap">
                                                @if($sessionsLeft > 0 && $booking->payment_status === 'paid')
                                                    <button type="button" class="btn btn-sm btn-primary book-next-session-btn"
                                                        data-booking-id="{{ $booking->id }}"
                                                        data-branch-id="{{ $booking->branch->id ?? '' }}"
                                                        data-service-name="{{ $pkgToShow ? $pkgToShow->name : ($booking->service ? $booking->service->name : '-') }}"
                                                        style="border-radius: 8px;">
                                                        <i class="fas fa-calendar-plus me-1"></i>Book Next Session
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-info reschedule-booking-btn"
                                                    data-booking-id="{{ $booking->id }}"
                                                    data-booking-date="{{ $booking->date }}"
                                                    data-branch-id="{{ $booking->branch->id ?? '' }}"
                                                    data-service-name="{{ $pkgToShow ? $pkgToShow->name : ($booking->service ? $booking->service->name : '-') }}"
                                                    style="border-radius: 8px;">
                                                    <i class="fas fa-calendar-alt me-1"></i>Reschedule
                                                </button>

                                                @if($booking->payment_status === 'paid' && $booking->status !== 'pending_refund')
                                                    @php
                                                        // Check if any sessions have been used
                                                        $sessionsUsed = 0;
                                                        $canRefund = true;
                                                        try {
                                                            $packageSession = \App\Models\ClientPackageSession::where('booking_id', $booking->id)->first();
                                                            if ($packageSession && $packageSession->sessions_used > 0) {
                                                                $sessionsUsed = $packageSession->sessions_used;
                                                                $canRefund = false;
                                                            }
                                                        } catch (\Exception $e) { /* ignore */ }
                                                    @endphp
                                                    @if($canRefund)
                                                        <button type="button" class="btn btn-sm btn-success request-refund-btn"
                                                            data-action="{{ route('client.booking.requestRefund', $booking->id) }}"
                                                            data-booking-id="{{ $booking->id }}"
                                                            style="border-radius: 8px;">
                                                            <i class="fas fa-undo-alt me-1"></i>Request Refund
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-secondary" disabled
                                                            title="Cannot request refund - {{ $sessionsUsed }} session(s) already used"
                                                            style="border-radius: 8px;">
                                                            <i class="fas fa-ban me-1"></i>Refund Not Available
                                                        </button>
                                                    @endif
                                                @elseif($booking->payment_status !== 'paid')
                                                    <!-- Provide data-booking-id so JS can directly use it instead of parsing the route URL -->
                                                    <button type="button" class="btn btn-sm btn-danger cancel-booking-btn"
                                                        data-action="{{ route('client.booking.cancel', $booking->id) }}"
                                                        data-booking-id="{{ $booking->id }}"
                                                        style="border-radius: 8px;">
                                                        <i class="fas fa-times me-1"></i>Cancel
                                                    </button>
                                                @endif
                                            </div>
                                            @if($booking->status === 'pending_refund')
                                                <span class="badge bg-warning text-dark mt-1">Refund Requested</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-calendar-times" style="font-size: 4rem; color: #ddd;"></i>
                                            <h4 class="mt-3 text-muted">No Bookings Found</h4>
                                            <p class="text-muted">You don't have any bookings yet. Start booking your favorite services!</p>
                                            <a href="{{ route('client.booking') }}" class="btn btn-primary mt-2" style="border-radius: 10px;">
                                                <i class="fas fa-plus-circle me-2"></i>Book a Service
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reschedule Booking Modals for Initial Page Load -->
    @foreach($activeBookings as $booking)
        @if(strtolower($booking->status) === 'active')
        <div class="modal fade" id="rescheduleModal{{ $booking->id }}" tabindex="-1" aria-labelledby="rescheduleModalLabel{{ $booking->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title text-white" id="rescheduleModalLabel{{ $booking->id }}">
                            <i class="fas fa-calendar-alt me-2"></i>Reschedule Booking
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('client.booking.reschedule', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label"><strong>Service:</strong></label>
                                <p class="text-muted">
                                    @php
                                        $pkgToShow = $booking->package ?? null;
                                        if (!$pkgToShow) {
                                            $purchasedIds = \App\Models\PurchasedService::where('booking_id', $booking->id)->pluck('service_id')->toArray();
                                            if (count($purchasedIds) > 1) {
                                                $candidates = \App\Models\Package::where(function($q) use ($booking) {
                                                    $branchId = $booking->branch->id ?? null;
                                                    if ($branchId) {
                                                        $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
                                                    }
                                                })->get();
                                                foreach ($candidates as $c) {
                                                    $pkgServiceIds = $c->services->pluck('id')->toArray();
                                                    if (!array_diff($purchasedIds, $pkgServiceIds)) {
                                                        $pkgToShow = $c;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    {{ $pkgToShow ? $pkgToShow->name : ($booking->service ? $booking->service->name : '-') }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Current Date:</strong></label>
                                <p class="text-muted">{{ \Carbon\Carbon::parse($booking->date)->format('F d, Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="new_date_{{ $booking->id }}" class="form-label"><strong>New Date:</strong></label>
                                <input type="date"
                                    class="form-control"
                                    id="new_date_{{ $booking->id }}"
                                    name="new_date"
                                    min="{{ \Carbon\Carbon::parse($booking->date)->addDays(3)->format('Y-m-d') }}"
                                    value="{{ session('reschedule_booking_id') == $booking->id ? old('new_date') : '' }}"
                                    required>
                                <small class="text-muted">You can only reschedule to a date at least 3 days from your current booking date.</small>
                            </div>
                            <div class="mb-3">
                                <label for="new_time_{{ $booking->id }}" class="form-label"><strong>New Time Slot:</strong></label>
                                <select class="form-select" id="new_time_{{ $booking->id }}" name="new_time_slot" required>
                                    <option value="">Select a time slot</option>
                                    @php
                                        $branch = $booking->branch;

                                        // Calculate service duration for multiple services
                                        $serviceDuration = 1; // default
                                        $purchasedServices = $booking->purchasedServices()->with('service')->get();
                                        if ($purchasedServices->count() > 0) {
                                            $serviceDuration = 0;
                                            foreach ($purchasedServices as $ps) {
                                                $serviceDuration += $ps->service->duration ?? 1;
                                            }
                                        } elseif ($booking->package_id) {
                                            $pkg = \App\Models\Package::find($booking->package_id);
                                            if ($pkg) {
                                                $serviceDuration = $pkg->duration ?? 1;
                                            }
                                        } elseif ($booking->service_id) {
                                            $svc = \App\Models\Service::find($booking->service_id);
                                            if ($svc) $serviceDuration = $svc->duration ?? 1;
                                        }

                                        if ($branch && $branch->time_slot) {
                                            [$start, $end] = explode(' - ', $branch->time_slot);
                                            $startTime = \Carbon\Carbon::createFromFormat('H:i', trim($start));
                                            $endTime = \Carbon\Carbon::createFromFormat('H:i', trim($end));

                                            // Generate slots that can accommodate the full service duration
                                            $currentTime = $startTime->copy();
                                            while ($currentTime->copy()->addHours($serviceDuration)->lte($endTime)) {
                                                $slotStart = $currentTime->format('H:i');
                                                $slotEnd = $currentTime->copy()->addHours($serviceDuration)->format('H:i');
                                                $displaySlot = $currentTime->format('g') . ' to ' . $currentTime->copy()->addHours($serviceDuration)->format('g A');

                                                // Add duration info for multi-hour services
                                                if ($serviceDuration > 1) {
                                                    $displaySlot .= " ({$serviceDuration} hour" . ($serviceDuration > 1 ? 's' : '') . ")";
                                                }

                                                $optionValue = $slotStart . ' - ' . $slotEnd;
                                                $isSelected = (session('reschedule_booking_id') == $booking->id && old('new_time_slot') == $optionValue) ? ' selected' : '';
                                                echo '<option value="' . $optionValue . '"' . $isSelected . '>' . $displaySlot . '</option>';
                                                $currentTime->addHours($serviceDuration);
                                            }
                                        }
                                    @endphp
                                </select>
                                @if(session('reschedule_booking_id') == $booking->id)
                                    @error('new_time_slot')
                                    <div class="text-danger mt-1">
                                        <small>{{ $message }}</small>
                                    </div>
                                    @enderror
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn" style="background:#F56289;color:#fff;">
                                <i class="fas fa-check me-2"></i>Confirm Reschedule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    <!-- Quick Links Section -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card shadow-lg" style="border-radius: 25px; border: none;">
                <div class="card-body p-4">
                    <h4 class="mb-4" style="color: #e75480; font-weight: 700;">
                        <i class="fas fa-bolt me-2" style="color: #e75480;"></i>Quick Actions
                    </h4>
                    <div class="row g-4">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('client.booking') }}" class="text-decoration-none">
                                <div class="card text-center h-100 shadow-sm" style="border-radius: 20px; border: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(231, 84, 128, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                                    <div class="card-body p-4">
                                        <div class="mb-3" style="width: 60px; height: 60px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(231, 84, 128, 0.3);">
                                            <i class="fas fa-calendar-plus text-white" style="font-size: 28px;"></i>
                                        </div>
                                        <h5 style="color: #e75480; font-weight: 600;">Book Service</h5>
                                        <p class="text-muted small mb-0">Schedule a new appointment</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('client.services') }}" class="text-decoration-none">
                                <div class="card text-center h-100 shadow-sm" style="border-radius: 20px; border: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(255, 143, 171, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                                    <div class="card-body p-4">
                                        <div class="mb-3" style="width: 60px; height: 60px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, #ff8fab 0%, #ffb3c6 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(255, 143, 171, 0.3);">
                                            <i class="fas fa-spa text-white" style="font-size: 28px;"></i>
                                        </div>
                                        <h5 style="color: #ff8fab; font-weight: 600;">View Services</h5>
                                        <p class="text-muted small mb-0">Explore our services</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('client.dashboard') }}" class="text-decoration-none">
                                <div class="card text-center h-100 shadow-sm" style="border-radius: 20px; border: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(255, 179, 198, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                                    <div class="card-body p-4">
                                        <div class="mb-3" style="width: 60px; height: 60px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, #ffb3c6 0%, #ffc8d8 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(255, 179, 198, 0.3);">
                                            <i class="fas fa-history text-white" style="font-size: 28px;"></i>
                                        </div>
                                        <h5 style="color: #ffb3c6; font-weight: 600;">View History</h5>
                                        <p class="text-muted small mb-0">Check your booking history</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('client.messages') }}" class="text-decoration-none">
                                <div class="card text-center h-100 shadow-sm" style="border-radius: 20px; border: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(255, 200, 216, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                                    <div class="card-body p-4">
                                        <div class="mb-3" style="width: 60px; height: 60px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, #ffc8d8 0%, #ffe0ea 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(255, 200, 216, 0.3);">
                                            <i class="fas fa-comments text-white" style="font-size: 28px;"></i>
                                        </div>
                                        <h5 style="color: #ffc8d8; font-weight: 600;">Messages</h5>
                                        <p class="text-muted small mb-0">Contact our team</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Cancel All Bookings Modal -->
<div class="modal fade" id="cancelAllModal" tabindex="-1" aria-labelledby="cancelAllModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:16px;">
      <div class="modal-header" style="border-bottom:none; background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%); border-radius: 16px 16px 0 0;">
        <h5 class="modal-title text-white" id="cancelAllModalLabel">
            <i class="fas fa-exclamation-triangle me-2"></i>Cancel All Unpaid Bookings
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="text-center modal-body" style="padding: 2rem;">
        <i class="fas fa-times-circle" style="font-size:3rem;color:#dc3545;margin-bottom:1rem;"></i>
        <p style="font-size:1.1rem;margin-bottom:1rem;">Are you sure you want to cancel <strong>all unpaid bookings</strong>?</p>
        <p class="text-muted">This will cancel all your active bookings that haven't been paid yet (cash payments). This action cannot be undone.</p>
        <p class="text-danger"><strong>Note:</strong> Paid bookings (Card/GCash) cannot be cancelled and will remain active.</p>
      </div>
      <div class="modal-footer" style="border-top:none;justify-content:center;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Them</button>
        <form action="{{ route('client.booking.cancelAll') }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check me-2"></i>Yes, Cancel All
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

        {{-- per-view CSS and JS for client dashboard --}}
        <link rel="stylesheet" href="{{ asset('css/client/dashboard.css') }}">

        <script>
            // Mark that this page uses AJAX-based bookings filtering so public JS won't attach duplicate filters
            window.ajaxBookingsFilter = true;
        </script>
        <script src="{{ asset('js/client/dashboard.js') }}" defer></script>
        {{-- Ensure bootstrap bundle is present (modal support). If your layout already includes it, this can be removed. --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        // Double-submit prevention for all forms on client dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent double-submit on all forms
            const forms = document.querySelectorAll('form[method="POST"]');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && submitBtn.disabled) {
                        e.preventDefault();
                        return false;
                    }
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                        // Re-enable after 3 seconds as fallback
                        setTimeout(function() {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }, 3000);
                    }
                });
            });

            // Handle refund request with confirmation
            const refundBtns = document.querySelectorAll('.request-refund-btn');
            refundBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const actionUrl = this.getAttribute('data-action');

                    // Show SweetAlert confirmation
                    Swal.fire({
                        title: 'Request Refund?',
                        html: '<p><strong>Important Notice:</strong></p>' +
                              '<p>To receive your refund, you must visit the branch physically.</p>' +
                              '<p>Once approved by staff, you can collect your refund at the branch location.</p>' +
                              '<p>Do you want to proceed with the refund request?</p>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, Request Refund',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form and submit
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = actionUrl;

                            // Add CSRF token
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Handle book next session - open reschedule modal
            document.addEventListener('click', function(e) {
                if (e.target.closest('.book-next-session-btn')) {
                    e.preventDefault();
                    const btn = e.target.closest('.book-next-session-btn');
                    const bookingId = btn.getAttribute('data-booking-id');
                    const branchId = btn.getAttribute('data-branch-id');

                    // Show info message
                    Swal.fire({
                        title: 'Book Next Session',
                        html: '<p>Select a new date and time for your next session.</p>' +
                              '<p class="text-muted"><small>You can only book slots that are available.</small></p>',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#e75480',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Continue',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Trigger the reschedule modal for this booking
                            const rescheduleModal = document.getElementById('rescheduleModal' + bookingId);
                            if (rescheduleModal) {
                                $(rescheduleModal).modal('show');
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Unable to open booking form. Please refresh the page and try again.',
                                    icon: 'error',
                                    confirmButtonColor: '#e75480'
                                });
                            }
                        }
                    });
                }
            });

            // Debounce function to improve performance
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Client Booking Filter Functionality with AJAX
            const clientBookingSearch = document.getElementById('clientBookingSearch');
            const clientStatusFilter = document.getElementById('clientStatusFilter');
            const clientDateFilter = document.getElementById('clientDateFilter');
            const bookingTableBody = document.querySelector('#clientBookingQueue table tbody');

            // Load bookings via AJAX with filters
            function loadFilteredBookings() {
                if (!bookingTableBody) return;

                const searchVal = clientBookingSearch ? clientBookingSearch.value.trim() : '';
                const statusVal = clientStatusFilter ? clientStatusFilter.value : '';
                const dateVal = clientDateFilter ? clientDateFilter.value : '';

                // Show loading state
                bookingTableBody.innerHTML = '<tr><td colspan="9" class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading bookings...</td></tr>';

                // Build query parameters
                const params = new URLSearchParams();
                if (searchVal) params.append('search', searchVal);
                if (statusVal) params.append('status', statusVal);
                if (dateVal) params.append('date', dateVal);

                // Fetch filtered bookings
                fetch(`{{ route("api.client.dashboard.bookings") }}?${params.toString()}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                            if (data.html) {
                            bookingTableBody.innerHTML = data.html;

                            // Handle modals if present in response
                            if (data.modals) {
                                // Remove existing reschedule modals
                                document.querySelectorAll('[id^="rescheduleModal"]').forEach(modal => modal.remove());
                                // Add new modals directly to the body
                                document.body.insertAdjacentHTML('beforeend', data.modals);
                            }

                            // Reattach event listeners to new buttons
                            attachCancelButtonListeners();

                            // Mark that AJAX filtering is active (disable client-side JS filter)
                            window.ajaxBookingsFilter = true;

                            // Add responsive data-labels to columns for mobile view
                            if (typeof window.addLabels === 'function') {
                                const tableEl = document.querySelector('#clientBookingQueue table');
                                if (tableEl) {
                                    window.addLabels(tableEl, ['Booking ID','Branch','Service','Date','Time Slot','Sessions Left','Expiry Date','Status','Action']);
                                }
                            }
                        } else {
                            bookingTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger py-4">Invalid response format</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading bookings:', error);
                        bookingTableBody.innerHTML = '<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-circle"></i> Error loading bookings. Please refresh the page.</td></tr>';
                    });
            }

            // Debounced filter (300ms delay for search input)
            const debouncedLoadBookings = debounce(loadFilteredBookings, 300);

            // Attach filter event listeners
            if (clientBookingSearch) {
                clientBookingSearch.addEventListener('input', debouncedLoadBookings);
            }
            if (clientStatusFilter) {
                clientStatusFilter.addEventListener('change', loadFilteredBookings);
            }
            if (clientDateFilter) {
                clientDateFilter.addEventListener('change', loadFilteredBookings);
            }

            // Function to attach all button listeners
            function attachCancelButtonListeners() {
                // Attach cancel button listeners safely (avoid duplicate bindings)
                document.querySelectorAll('.cancel-booking-btn').forEach(btn => {
                    try {
                        btn.removeEventListener('click', handleCancelBooking);
                    } catch (e) { /* ignore */ }
                    btn.addEventListener('click', handleCancelBooking);
                });

                // Attach request refund button listeners
                document.querySelectorAll('.request-refund-btn').forEach(btn => {
                    try { btn.removeEventListener('click', handleRequestRefund); } catch (e) { /* ignore */ }
                    btn.addEventListener('click', handleRequestRefund);
                });

                // Attach reschedule button listeners
                document.querySelectorAll('.reschedule-booking-btn').forEach(btn => {
                    const bookingId = btn.getAttribute('data-booking-id');
                    if (bookingId) {
                        // Always set modal trigger attributes to ensure they point to the correct dynamic modal
                        btn.setAttribute('data-bs-toggle', 'modal');
                        btn.setAttribute('data-bs-target', '#rescheduleModal' + bookingId);
                    }
                });

                // Attach click-to-search for booking ID badges
                document.querySelectorAll('#clientBookingQueue .badge').forEach(badge => {
                    if (badge.textContent.includes('#')) {
                        badge.addEventListener('click', function() {
                            const bookingId = this.textContent.trim();
                            if (clientBookingSearch) {
                                clientBookingSearch.value = bookingId;
                                debouncedLoadBookings();
                                clientBookingSearch.focus();

                                // Highlight the search box briefly
                                clientBookingSearch.style.backgroundColor = '#fff3cd';
                                setTimeout(function() {
                                    clientBookingSearch.style.backgroundColor = '';
                                }, 1000);
                            }
                        });
                    }
                });
            }

            // Handle request refund
            function handleRequestRefund() {
                const action = this.getAttribute('data-action');
                const bookingId = this.getAttribute('data-booking-id');

                // Fetch booking details to check session usage
                fetch(`/api/booking/${bookingId}/session-info`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const sessionsUsed = data.sessions_used || 0;
                    const hasDeductedSessions = sessionsUsed > 0;

                    let warningHtml = '<p><strong>Important Notice:</strong></p>' +
                          '<p>To receive your refund, you must visit the branch physically.</p>' +
                          '<p>Once approved by staff, you can collect your refund at the branch location.</p>';

                    if (hasDeductedSessions) {
                        warningHtml += `
                            <div style="background: #f8d7da; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin: 15px 0;">
                                <p style="margin: 0; color: #721c24; font-weight: 600;">
                                    <i class="fas fa-ban" style="color: #dc3545; margin-right: 5px;"></i>
                                    <strong>WARNING:</strong> ${sessionsUsed} session(s) have been used.
                                </p>
                                <p style="margin: 5px 0 0 0; color: #721c24;">
                                    Your refund request may be <strong>DENIED</strong> because sessions have been deducted.
                                </p>
                            </div>
                        `;
                    }

                    warningHtml += '<p>Do you want to proceed with the refund request?</p>';

                    Swal.fire({
                        title: 'Request Refund?',
                        html: warningHtml,
                        icon: hasDeductedSessions ? 'warning' : 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, Request Refund',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form and submit
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = action;

                            // Add CSRF token
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching session info:', error);
                    // Fallback to simple refund request
                    Swal.fire({
                        title: 'Request Refund?',
                        html: '<p><strong>Important Notice:</strong></p>' +
                              '<p>To receive your refund, you must visit the branch physically.</p>' +
                              '<p>Once approved by staff, you can collect your refund at the branch location.</p>' +
                              '<p>Do you want to proceed with the refund request?</p>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, Request Refund',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = action;

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            // Handle cancel booking
            function handleCancelBooking() {
                const action = this.getAttribute('data-action');
                // Prefer explicit data attribute; fallback to regex to extract the ID from URL
                let bookingId = this.getAttribute('data-booking-id');
                if (!bookingId && action) {
                    // match /booking/{id}/ in the URL
                    const m = action.match(/\/booking\/(\d+)\//);
                    bookingId = (m && m[1]) ? m[1] : null;
                }
                if (!bookingId) {
                    console.error('Could not determine booking ID for cancel action:', action);
                    return;
                }

                // Fetch booking details to check session usage
                fetch(`/api/booking/${bookingId}/session-info`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const sessionsUsed = data.sessions_used || 0;
                    const hasDeductedSessions = sessionsUsed > 0;

                    let warningHtml = '';
                    if (hasDeductedSessions) {
                        warningHtml = `
                            <div style="background: #f8d7da; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                                <p style="margin: 0; color: #721c24; font-size: 14px; font-weight: 600;">
                                    <i class="fas fa-ban" style="color: #dc3545; margin-right: 5px;"></i>
                                    <strong>Warning:</strong> ${sessionsUsed} session(s) have been used.
                                </p>
                                <p style="margin: 5px 0 0 0; color: #721c24; font-size: 13px;">
                                    You <strong>CANNOT request a refund</strong> for this booking.
                                </p>
                            </div>
                        `;
                    } else {
                        warningHtml = `
                            <div style="background: #d1ecf1; padding: 15px; border-radius: 8px; border-left: 4px solid #17a2b8; margin-bottom: 15px;">
                                <p style="margin: 0; color: #0c5460; font-size: 14px;">
                                    <i class="fas fa-info-circle" style="color: #17a2b8; margin-right: 5px;"></i>
                                    No sessions have been used yet. You may request a refund from staff after cancelling.
                                </p>
                            </div>
                        `;
                    }

                    Swal.fire({
                        title: 'Cancel Booking?',
                        html: `
                            <div style="text-align: left; padding: 10px 20px;">
                                <p style="margin-bottom: 15px; color: #555;">
                                    <strong>Are you sure you want to cancel this booking?</strong>
                                </p>
                                ${warningHtml}
                                <div style="background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107;">
                                    <p style="margin: 0; color: #856404; font-size: 14px;">
                                        <i class="fas fa-exclamation-triangle" style="color: #ffc107; margin-right: 5px;"></i>
                                        This action cannot be undone
                                    </p>
                                </div>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e75480',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-check"></i> Yes, Cancel Booking',
                        cancelButtonText: '<i class="fas fa-times"></i> Keep Booking',
                        customClass: {
                            popup: 'swal-wide',
                            title: 'swal-title-custom',
                            confirmButton: 'btn-lg',
                            cancelButton: 'btn-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create and submit form
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = action;

                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken;
                            form.appendChild(csrfInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching session info:', error);
                    // Fallback to simple confirmation if API fails
                    Swal.fire({
                        title: 'Cancel Booking?',
                        html: `
                            <div style="text-align: left; padding: 10px 20px;">
                                <p style="margin-bottom: 15px; color: #555;">
                                    <strong>Are you sure you want to cancel this booking?</strong>
                                </p>
                                <div style="background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107;">
                                    <p style="margin: 0; color: #856404; font-size: 14px;">
                                        <i class="fas fa-exclamation-triangle" style="color: #ffc107; margin-right: 5px;"></i>
                                        This action cannot be undone
                                    </p>
                                </div>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e75480',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-check"></i> Yes, Cancel Booking',
                        cancelButtonText: '<i class="fas fa-times"></i> Keep Booking'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = action;

                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken;
                            form.appendChild(csrfInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            // Initial load and attach listeners
            attachCancelButtonListeners();

            // Handle notification highlight parameter
            function highlightBooking() {
                const urlParams = new URLSearchParams(window.location.search);
                const highlightBookingId = urlParams.get('highlight');

                if (highlightBookingId) {
                    // Find the booking row with the matching ID
                    const bookingRow = document.querySelector(`tr[data-booking-id="${highlightBookingId}"]`);

                    if (bookingRow) {
                        // Scroll to the booking
                        bookingRow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        // Add highlight effect
                        bookingRow.style.background = 'linear-gradient(90deg, #fff0f5 0%, #ffe4ec 100%)';
                        bookingRow.style.transform = 'scale(1.02)';
                        bookingRow.style.boxShadow = '0 4px 12px rgba(245, 98, 137, 0.2)';
                        bookingRow.style.borderLeft = '4px solid #F56289';

                        // Remove highlight after 3 seconds
                        setTimeout(() => {
                            bookingRow.style.background = '';
                            bookingRow.style.transform = '';
                            bookingRow.style.boxShadow = '';
                            bookingRow.style.borderLeft = '';
                        }, 3000);

                        // Clean up URL parameter
                        const newUrl = window.location.pathname + window.location.hash;
                        window.history.replaceState({}, document.title, newUrl);
                    }
                }
            }

            // Call highlight function on page load
            highlightBooking();
            // If server returned a reschedule modal error (validation error), open the reschedule modal automatically
            try {
                @if(session('reschedule_booking_id'))
                    (function() {
                        const id = '{{ session('reschedule_booking_id') }}';
                        const modalEl = document.getElementById('rescheduleModal' + id);
                        if (modalEl) {
                            // Use jQuery/Bootstrap modal show for compatibility across pages
                            $(modalEl).modal('show');
                        } else {
                            console.warn('Reschedule modal element not found for booking', id);
                        }
                    })();
                @endif
            } catch (e) { /* ignore */ }

            // AJAX validation for reschedule time slots
            @foreach($activeBookings as $booking)
                @if(strtolower($booking->status) === 'active')
                    (function() {
                        const bookingId = '{{ $booking->id }}';
                        const branchId = '{{ $booking->branch_id }}';
                        const timeSelect = document.getElementById('new_time_' + bookingId);
                        const dateInput = document.getElementById('new_date_' + bookingId);
                        const submitBtn = document.querySelector('#rescheduleModal' + bookingId + ' button[type="submit"]');
                        const validationMsg = document.createElement('div');
                        validationMsg.className = 'text-danger mt-1 small';
                        validationMsg.style.display = 'none';
                        timeSelect.parentNode.appendChild(validationMsg);

                        function validateTimeSlot() {
                            const selectedTime = timeSelect.value;
                            const selectedDate = dateInput.value;

                            if (!selectedTime || !selectedDate) {
                                validationMsg.style.display = 'none';
                                submitBtn.disabled = false;
                                return;
                            }

                            // Show loading state
                            validationMsg.textContent = 'Validating...';
                            validationMsg.className = 'text-info mt-1 small';
                            validationMsg.style.display = 'block';
                            submitBtn.disabled = true;

                            fetch('{{ route('client.booking.validate-time-slot') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    date: selectedDate,
                                    time_slot: selectedTime,
                                    branch_id: branchId,
                                    booking_id: bookingId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.valid) {
                                    validationMsg.textContent = '✓ Time slot is available';
                                    validationMsg.className = 'text-success mt-1 small';
                                    submitBtn.disabled = false;
                                } else {
                                    validationMsg.textContent = data.message;
                                    validationMsg.className = 'text-danger mt-1 small';
                                    submitBtn.disabled = true;
                                }
                            })
                            .catch(error => {
                                console.error('Validation error:', error);
                                validationMsg.textContent = 'Validation failed. Please try again.';
                                validationMsg.className = 'text-warning mt-1 small';
                                submitBtn.disabled = false;
                            });
                        }

                        // Validate on time slot change
                        timeSelect.addEventListener('change', validateTimeSlot);
                        // Validate on date change
                        dateInput.addEventListener('change', function() {
                            if (timeSelect.value) {
                                validateTimeSlot();
                            }
                        });
                    })();
                @endif
            @endforeach
        });
        </script>
@endsection
