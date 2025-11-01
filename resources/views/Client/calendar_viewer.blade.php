@extends('layouts.clientapp')
@section('content')

    <div class="container-fluid">
        <a class="navbar-brand" href="#" style="color:#F56289;font-weight:bold;">Skin911 Real time Calendar</a>
    </div>

@php
    $currentBranchId = request('branch_id');
    $defaultSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
    $maxSlots = 5;
    $branchOperatingDays = [];

    if ($currentBranchId) {
        $branch = \App\Models\Branch::find($currentBranchId);
        if ($branch) {
            $maxSlots = $branch->slot_capacity ?? 5;

            // Get operating days (e.g., ["Monday", "Tuesday", "Wednesday", ...])
            if ($branch->operating_days && !empty($branch->operating_days)) {
                $branchOperatingDays = array_filter(array_map('trim', explode(',', $branch->operating_days)));
            }

            if ($branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
                $parts = explode(' - ', $branch->time_slot, 2);
                if (count($parts) === 2) {
                    [$s,$e] = $parts;
                    try {
                        $start = \Carbon\Carbon::createFromFormat('H:i', trim($s));
                        $end = \Carbon\Carbon::createFromFormat('H:i', trim($e));
                        $slots = [];
                        for ($t = $start->copy(); $t->lt($end); $t->addHour()) {
                            $slotStart = $t->format('H:i');
                            $slotEnd = $t->copy()->addHour()->format('H:i');
                            if (\Carbon\Carbon::createFromFormat('H:i', $slotEnd)->lte($end)) {
                                $slots[] = $slotStart . '-' . $slotEnd;
                            }
                        }
                    } catch (\Exception $e) {
                        $slots = $defaultSlots;
                    }
                } else {
                    $slots = $defaultSlots;
                }
            } else {
                $slots = $defaultSlots;
            }
        } else {
            $slots = $defaultSlots;
        }
    } else {
        $slots = $defaultSlots;
    }    // Preload bookings for the 7-day window so we can compute multi-slot coverage and occupancy
    $dates = [];
    for ($i = 0; $i < 7; $i++) { $dates[] = \Carbon\Carbon::now()->addDays($i)->format('Y-m-d'); }
    $bookingQuery = \App\Models\Booking::whereIn('date', $dates)->where('status', 'active');
    if ($currentBranchId) $bookingQuery->where('branch_id', $currentBranchId);
    $bookings = $bookingQuery->with(['service','package.services'])->get();

    // Get only the current user's bookings for display purposes
    $userBookings = $bookings->where('user_id', Auth::id());

    // build branch-specific duration map (service_id => pivot.duration) when a branch is selected
    $branchDurations = [];
    if ($currentBranchId) {
        try {
            $branchForDur = \App\Models\Branch::with('services')->find($currentBranchId);
            if ($branchForDur) {
                foreach ($branchForDur->services as $s) {
                    $branchDurations[$s->id] = $s->pivot->duration ?? null;
                }
            }
        } catch (\Exception $e) { /* ignore */ }
    }

    // Maps: occupyingCount[date][slot] = integer number of bookings occupying that slot
    // startBookings[date][slot] = array of ALL bookings that START at that slot (for availability)
    // userStartBookings[date][slot] = array of current USER'S bookings only (for display)
    $occupyingCount = [];
    $startBookings = [];
    $userStartBookings = [];
    foreach ($bookings as $b) {
        $dur = 1;
        if ($b->service) {
            // prefer branch-specific pivot duration when present
            $dur = $b->service->duration ?? 1;
            if (isset($branchDurations[$b->service->id]) && $branchDurations[$b->service->id]) {
                $dur = $branchDurations[$b->service->id];
            }
        } elseif ($b->package) {
            $dur = 0;
            foreach ($b->package->services as $ps) {
                $pd = $ps->duration ?? 1;
                if (isset($branchDurations[$ps->id]) && $branchDurations[$ps->id]) $pd = $branchDurations[$ps->id];
                $dur += $pd;
            }
            if ($dur <= 0) $dur = 1;
        }
        try {
            [$ss,$se] = explode('-', $b->time_slot, 2);
            $startT = \Carbon\Carbon::createFromFormat('H:i', trim($ss));
            for ($k = 0; $k < $dur; $k++) {
                $s = $startT->copy()->addHours($k);
                $e = $s->copy()->addHour();
                $slotLabel = $s->format('H:i') . '-' . $e->format('H:i');
                if (! isset($occupyingCount[$b->date])) $occupyingCount[$b->date] = [];
                if (! isset($occupyingCount[$b->date][$slotLabel])) $occupyingCount[$b->date][$slotLabel] = 0;
                $occupyingCount[$b->date][$slotLabel]++;
                if ($k === 0) {
                    if (! isset($startBookings[$b->date])) $startBookings[$b->date] = [];
                    if (! isset($startBookings[$b->date][$slotLabel])) $startBookings[$b->date][$slotLabel] = [];
                    $startBookings[$b->date][$slotLabel][] = $b;

                    // Only add to userStartBookings if it's the current user's booking
                    if ($b->user_id == Auth::id()) {
                        if (! isset($userStartBookings[$b->date])) $userStartBookings[$b->date] = [];
                        if (! isset($userStartBookings[$b->date][$slotLabel])) $userStartBookings[$b->date][$slotLabel] = [];
                        $userStartBookings[$b->date][$slotLabel][] = $b;
                    }
                }
            }
        } catch (\Exception $e) {
            // ignore
        }
    }
    // now $occupyingCount, $startBookings (all bookings), and $userStartBookings (user's only) are available
@endphp
<div class="py-5 container-fluid" style="background:#fff;">
    <h2 class="mb-4" style="color:#F56289;">Real-Time Calendar Viewer</h2>
    <form method="GET" id="branchFilterForm" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 col-sm-12">
                <label for="branch_id" class="form-label" style="color:#F56289;font-weight:600;">Select Branch:</label>
                <select name="branch_id" id="branch_id" class="form-select" style="border-radius:8px;">
                    <option value="">All Branches</option>
                    @foreach(\App\Models\Branch::all() as $branch)
                        <option value="{{ $branch->id }}" @if($currentBranchId == $branch->id) selected @endif>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    @if(!$currentBranchId)
        <div class="mb-4 text-center alert alert-info" style="color:#F56289;background:#ffe6f0;border:none;font-size:1.1rem;">
            Please select a branch first to view and book available time slots.
        </div>
    @endif
    {{-- Mobile zoom calendar (shown on screens < 768px) --}}
    <div id="mobile-zoom-calendar" class="mobile-zoom-calendar d-none">
        <div id="zoom-header" class="zoom-header">
            <button id="zoom-back-btn" class="zoom-back-btn" style="display:none;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
                <span id="zoom-back-text">Back</span>
            </button>
            <h3 id="zoom-title" class="zoom-title">Select a Week</h3>
        </div>
        <div id="zoom-content" class="zoom-content"></div>
    </div>

    {{-- Desktop/Tablet calendar (shown on screens >= 768px) --}}
    <div id="calendar-viewer" class="calendar-responsive" style="background:#fff;border-radius:18px;padding:32px;min-height:600px;box-shadow:0 4px 24px rgba(0,0,0,0.10);font-size:1.25rem;width:100%;max-width:none;margin:auto;overflow-x:auto;">
        <div class="mb-3 row flex-nowrap">
            <div class="col-2" style="min-width:140px;"></div>
            @for($i = 0; $i < 7; $i++)
                @php $dateObj = \Carbon\Carbon::now()->addDays($i); $date = $dateObj->format('Y-m-d'); @endphp
                <div class="text-center col" style="font-size:1.2rem;min-width:140px;">
                    <div class="calendar-day" style="font-weight:bold;color:#F56289;">{{ $dateObj->format('D') }}</div>
                    <div class="calendar-date" style="color:#F56289;">{{ $date }}</div>
                </div>
            @endfor
        </div>
    @foreach($slots as $slot)
            @php
                $fmt = $slot;
                if (strpos($slot, '-') !== false) {
                    try {
                        [$sstart, $send] = explode('-', $slot, 2);
                        $fmt = \Carbon\Carbon::createFromFormat('H:i', trim($sstart))->format('g:ia') . ' - ' . \Carbon\Carbon::createFromFormat('H:i', trim($send))->format('g:ia');
                    } catch (\Exception $e) {
                        $fmt = $slot;
                    }
                }
            @endphp
            <div class="mb-3 row flex-nowrap" style="height:56px;">
                <div class="col-2 d-flex align-items-center calendar-timeslot-label">{{ $fmt }}</div>
                @for($i = 0; $i < 7; $i++)
                    @php
                        $dateObj = \Carbon\Carbon::now()->addDays($i);
                        $date = $dateObj->format('Y-m-d');
                        $dayLabel = $dateObj->format('D, M j'); // e.g., "Mon, Oct 25"
                    @endphp
                    <div class="text-center col d-flex align-items-center justify-content-center" style="min-width:140px;" data-mobile-date="{{ $dayLabel }}">
                        @php
                            $occ = $occupyingCount[$date][$slot] ?? 0;
                            $available = ($maxSlots ?? 5) - $occ;
                            $starts = $startBookings[$date][$slot] ?? [];
                        @endphp
                        @if($occ >= ($maxSlots ?? 5))
                            <span class="badge bg-danger booked-link" style="font-size:1.05rem;padding:8px 12px;text-decoration:none;cursor:not-allowed;opacity:0.85;">Full</span>
                        @else
                            {{-- Always show remaining slots only --}}
                            @if($currentBranchId)
                                <a href="{{ route('client.booking', ['branch_id' => $currentBranchId, 'date' => $date, 'time_slot' => $slot]) }}" class="badge bg-pink available-link" style="font-size:1.05rem;padding:8px 12px;text-decoration:none;cursor:pointer;background:#F56289;color:#fff;">
                                    {{ $available }} left
                                </a>
                            @else
                                <span class="badge bg-pink" style="font-size:1.05rem;padding:8px 12px;opacity:0.6;cursor:not-allowed;background:#F56289;color:#fff;">
                                    {{ $available }} left
                                </span>
                            @endif
                        @endif
                    </div>
                @endfor
            </div>
        @endforeach
    </div>
</div>
<script>
document.getElementById('branch_id').addEventListener('change', function() {
    document.getElementById('branchFilterForm').submit();
});
// Prevent clicking available links if no branch is selected
setTimeout(function() {
    document.querySelectorAll('.available-link, .booked-link').forEach(function(link) {
        if (!document.getElementById('branch_id').value) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Please select a branch first.');
            });
        }
    });
    document.querySelectorAll('.booked-link.bg-danger').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            alert('This slot is already full and cannot be booked.');
        });
    });
}, 100);
</script>
<script>
// Refresh client calendar viewer when a booking is rescheduled
window.addEventListener('booking:rescheduled', function(e){
    try {
        var bid = e.detail && e.detail.branch_id ? String(e.detail.branch_id) : null;
        var current = document.getElementById('branch_id').value;
        if (!bid || !current || bid === current) {
            location.reload();
        }
    } catch(e) { console.warn('booking:rescheduled handler error', e); }
});
// Refresh client calendar when a booking is created elsewhere
window.addEventListener('booking:created', function(e){
    try {
        var bid = e.detail && e.detail.branch_id ? String(e.detail.branch_id) : null;
        var current = document.getElementById('branch_id').value;
        if (!bid || !current || bid === current) {
            location.reload();
        }
    } catch(err) { console.warn('booking:created handler error', err); }
});
</script>
<!-- Pass booking data to JavaScript for mobile zoom calendar -->
<script>
window.calendarData = {
    currentBranchId: {{ $currentBranchId ? $currentBranchId : 'null' }},
    maxSlots: {{ $maxSlots ?? 5 }},
    slots: @json($slots),
    occupyingCount: @json($occupyingCount),
    startBookings: @json($startBookings),
    userStartBookings: @json($userStartBookings),
    operatingDays: @json($branchOperatingDays),
    bookingRoute: '{{ route('client.booking', ['branch_id' => '__BRANCH__', 'date' => '__DATE__', 'time_slot' => '__SLOT__']) }}'
};
</script>
<!-- Externalized calendar viewer styles and scripts -->
<link rel="stylesheet" href="{{ asset('css/client/calendar_viewer.css') }}">
<script src="{{ asset('js/client/calendar_viewer.js') }}" defer></script>
@endsection

