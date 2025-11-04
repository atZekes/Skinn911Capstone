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
                                <th style="border: none; padding: 15px;">Service</th>
                                <th style="border: none; padding: 15px;">Price</th>
                                <th style="border: none; padding: 15px;">Date Purchased</th>
                                <th style="border: none; padding: 15px;">Location</th>
                                <th style="border: none; padding: 15px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use Carbon\Carbon;
                                $purchasedServices = \App\Models\PurchasedService::where('user_id', Auth::id())
                                    ->with(['service', 'booking.branch', 'booking.package.services'])
                                    ->get();
                            @endphp
                            @forelse($purchasedServices as $service)
                                @php
                                    $booking = $service->booking;
                                    $status = 'completed';
                                    if ($service->status === 'cancelled') {
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
                                @endphp
                                <tr>
                                    <td data-label="Service">
                                        @php
                                            // Determine if this purchased service is actually part of a multi-service package
                                            $pkgToShow = $service->booking->package ?? null;
                                            if (!$pkgToShow && $service->booking) {
                                                $bId = $service->booking->id;
                                                $purchasedIds = \App\Models\PurchasedService::where('booking_id', $bId)->pluck('service_id')->toArray();
                                                // only infer a package when more than one purchased service exists for the booking
                                                if (count($purchasedIds) > 1) {
                                                    $candidates = \App\Models\Package::where(function($q) use ($service) {
                                                        $branchId = $service->booking->branch->id ?? null;
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
                                            @if($service->service)
                                                {{ $service->service->name }}
                                            @else
                                                <span class="text-danger">Service ID: {{ $service->service_id }}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td data-label="Price">{{ $service->price ?? '' }}</td>
                                    <td data-label="Date Purchased">{{ $service->created_at }}</td>
                                    <td data-label="Location">
                                        @if($booking && $booking->branch)
                                            {{ $booking->branch->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            // Determine duration in hours for this purchased service
                                            $durationHours = 1;
                                            if ($service->service) {
                                                // prefer pivot/branch duration if available on the purchased service's booking
                                                $svc = $service->service;
                                                $durationHours = $svc->duration ?? 1;
                                                // if branch-specific pivot stored somewhere, prefer it (best-effort)
                                                if (isset($service->booking) && $service->booking) {
                                                    try {
                                                        $branchIdForThisBooking = $service->booking->branch->id ?? null;
                                                        if ($branchIdForThisBooking) {
                                                            $branch = \App\Models\Branch::with('services')->find($branchIdForThisBooking);
                                                            if ($branch) {
                                                                foreach ($branch->services as $bsvc) {
                                                                    if ($bsvc->id == $svc->id && isset($bsvc->pivot->duration) && $bsvc->pivot->duration) {
                                                                        $durationHours = $bsvc->pivot->duration;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } catch (\Exception $e) {
                                                        // ignore and keep default duration
                                                    }
                                                }
                                            } elseif ($service->booking && $service->booking->package) {
                                                // if purchased service is part of a package, prefer package->duration when available
                                                $pkg = $service->booking->package;
                                                if (isset($pkg->duration) && $pkg->duration && $pkg->duration > 0) {
                                                    $durationHours = $pkg->duration;
                                                } else {
                                                    // otherwise sum durations of services inside the package
                                                    $sumDur = 0;
                                                    foreach ($pkg->services as $ps) {
                                                        $sumDur += $ps->duration ?? 1;
                                                    }
                                                    if ($sumDur > 0) $durationHours = $sumDur;
                                                }
                                            }
                                            // compute end time by parsing booking's time_slot end and adding (duration-1) hours if needed
                                            $displaySlot = $service->booking->time_slot ?? $service->time_slot ?? '';
                                            if ($displaySlot && strpos($displaySlot, '-') !== false) {
                                                try {
                                                    [$startStr, $endStr] = explode('-', $displaySlot, 2);
                                                    $start = \Carbon\Carbon::createFromFormat('H:i', trim($startStr));
                                                    // final end = start + durationHours hours
                                                    $end = $start->copy()->addHours($durationHours);
                                                    $displaySlot = $start->format('g:ia') . ' - ' . $end->format('g:ia');
                                                } catch (\Exception $e) {
                                                    // fallback to original
                                                }
                                            }
                                        @endphp
                                        {{ $displaySlot }}
                                    </td>
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
                                    <td colspan="5" class="text-center py-5">
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

                    <div id="clientBookingQueue" class="booking-queue-wrapper" style="max-height:400px;overflow-y:auto;padding-right:6px;">
                    <table class="table table-hover" style="border-radius:10px;overflow:hidden;">
                        <thead style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color:#fff;">
                            <tr>
                                <th style="border: none; padding: 15px;">Booking ID</th>
                                <th style="border: none; padding: 15px;">Branch</th>
                                <th style="border: none; padding: 15px;">Service</th>
                                <th style="border: none; padding: 15px;">Date</th>
                                <th style="border: none; padding: 15px;">Time Slot</th>
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
                                                $purchasedIds = \App\Models\PurchasedService::where('booking_id', $booking->id)->pluck('service_id')->toArray();
                                                // only infer a package when more than one purchased service exists for this booking
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
                                        @if($pkgToShow)
                                            <div><strong>{{ $pkgToShow->name }}</strong></div>
                                            <div class="text-muted small">{{ $pkgToShow->services->pluck('name')->implode(', ') }}</div>
                                        @else
                                            @if($booking->service)
                                                {{ $booking->service->name }}
                                            @else
                                                -
                                            @endif
                                        @endif
                                    </td>
                                    <td data-label="Date">{{ $booking->date }}</td>
                                    <td data-label="Time Slot">
                                        @php
                                            // Compute duration for this booking (service or package)
                                            $bookingDuration = 1;
                                            if ($booking->service) {
                                                $bookingDuration = $booking->service->duration ?? 1;
                                                // try branch-specific pivot duration if present
                                                try {
                                                    $bid = $booking->branch->id ?? null;
                                                    if ($bid) {
                                                        $branchObj = \App\Models\Branch::with('services')->find($bid);
                                                        if ($branchObj) {
                                                            foreach ($branchObj->services as $bsvc) {
                                                                if ($bsvc->id == $booking->service->id && isset($bsvc->pivot->duration) && $bsvc->pivot->duration) {
                                                                    $bookingDuration = $bsvc->pivot->duration;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                } catch (\Exception $e) { /* ignore */ }
                                            } elseif ($booking->package) {
                                                // prefer package->duration when present, otherwise sum service durations
                                                $pkgObj = $booking->package;
                                                if (isset($pkgObj->duration) && $pkgObj->duration && $pkgObj->duration > 0) {
                                                    $bookingDuration = $pkgObj->duration;
                                                } else {
                                                    $sumD = 0;
                                                    foreach ($pkgObj->services as $ps) {
                                                        $sumD += $ps->duration ?? 1;
                                                    }
                                                    if ($sumD > 0) $bookingDuration = $sumD;
                                                }
                                            }
                                            // format display slot: take booking->time_slot start and add bookingDuration hours
                                            $displaySlot = $booking->time_slot;
                                            if ($displaySlot && strpos($displaySlot, '-') !== false) {
                                                try {
                                                    [$sstr, $estr] = explode('-', $displaySlot, 2);
                                                    $sTime = \Carbon\Carbon::createFromFormat('H:i', trim($sstr));
                                                    $endTime = $sTime->copy()->addHours($bookingDuration);
                                                    $displaySlot = $sTime->format('g:ia') . ' - ' . $endTime->format('g:ia');
                                                } catch (\Exception $e) { /* ignore */ }
                                            }
                                        @endphp
                                        {{ $displaySlot }}
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
                                                <button type="button" class="btn btn-sm btn-info reschedule-booking-btn"
                                                    data-booking-id="{{ $booking->id }}"
                                                    data-booking-date="{{ $booking->date }}"
                                                    data-branch-id="{{ $booking->branch->id ?? '' }}"
                                                    data-service-name="{{ $pkgToShow ? $pkgToShow->name : ($booking->service ? $booking->service->name : '-') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rescheduleModal{{ $booking->id }}"
                                                    style="border-radius: 8px;">
                                                    <i class="fas fa-calendar-alt me-1"></i>Reschedule
                                                </button>
                                                @if($booking->payment_status === 'paid' && $booking->status !== 'pending_refund')
                                                    <button type="button" class="btn btn-sm btn-success request-refund-btn"
                                                        data-action="{{ route('client.booking.requestRefund', $booking->id) }}"
                                                        data-booking-id="{{ $booking->id }}"
                                                        style="border-radius: 8px;">
                                                        <i class="fas fa-undo-alt me-1"></i>Request Refund
                                                    </button>
                                                @elseif($booking->payment_status !== 'paid')
                                                    <button type="button" class="btn btn-sm btn-danger cancel-booking-btn"
                                                        data-action="{{ route('client.booking.cancel', $booking->id) }}"
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
                                    <td colspan="7" class="text-center py-5">
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

<!-- Reschedule Booking Modals -->
@foreach($activeBookings as $booking)
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
                            required>
                        <small class="text-muted">You can only reschedule to a date at least 3 days from your current booking date.</small>
                    </div>
                    <div class="mb-3">
                        <label for="new_time_{{ $booking->id }}" class="form-label"><strong>New Time Slot:</strong></label>
                        <select class="form-select" id="new_time_{{ $booking->id }}" name="new_time_slot" required>
                            <option value="">Select a time slot</option>
                            @php
                                $branch = $booking->branch;
                                if ($branch && $branch->time_slot) {
                                    [$start, $end] = explode(' - ', $branch->time_slot);
                                    $startTime = \Carbon\Carbon::createFromFormat('H:i', trim($start));
                                    $endTime = \Carbon\Carbon::createFromFormat('H:i', trim($end));

                                    while ($startTime->lt($endTime)) {
                                        $slotStart = $startTime->format('H:i');
                                        $slotEnd = $startTime->copy()->addHour()->format('H:i');
                                        $displaySlot = $startTime->format('g:i A') . ' - ' . $startTime->copy()->addHour()->format('g:i A');
                                        echo '<option value="' . $slotStart . ' - ' . $slotEnd . '">' . $displaySlot . '</option>';
                                        $startTime->addHour();
                                    }
                                }
                            @endphp
                        </select>
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
@endforeach

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
                bookingTableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading bookings...</td></tr>';

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
                            // Reattach event listeners to new buttons
                            attachCancelButtonListeners();
                        } else {
                            bookingTableBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger py-4">Invalid response format</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading bookings:', error);
                        bookingTableBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger py-4"><i class="fas fa-exclamation-circle"></i> Error loading bookings. Please refresh the page.</td></tr>';
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
                // Attach cancel button listeners
                document.querySelectorAll('.cancel-booking-btn').forEach(btn => {
                    btn.addEventListener('click', handleCancelBooking);
                });

                // Attach request refund button listeners
                document.querySelectorAll('.request-refund-btn').forEach(btn => {
                    btn.addEventListener('click', handleRequestRefund);
                });

                // Attach reschedule button listeners
                document.querySelectorAll('.reschedule-booking-btn').forEach(btn => {
                    const bookingId = btn.getAttribute('data-booking-id');
                    if (bookingId) {
                        // Add modal trigger attributes if not present
                        if (!btn.hasAttribute('data-bs-toggle')) {
                            btn.setAttribute('data-bs-toggle', 'modal');
                            btn.setAttribute('data-bs-target', '#rescheduleModal' + bookingId);
                        }
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
            }

            // Handle cancel booking
            function handleCancelBooking() {
                const action = this.getAttribute('data-action');

                Swal.fire({
                    title: 'Cancel Booking?',
                    html: `
                        <div style="text-align: left; padding: 10px 20px;">
                            <p style="margin-bottom: 15px; color: #555;">
                                <strong>Are you sure you want to cancel this booking?</strong>
                            </p>
                            <div style="background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 10px;">
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
            }

            // Initial load and attach listeners
            attachCancelButtonListeners();
        });
        </script>
@endsection
