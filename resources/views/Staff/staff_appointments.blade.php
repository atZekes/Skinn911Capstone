@extends('layouts.staffapp')
@section('tab-content')
<div class="container py-5">
  <h2 class="mb-4" style="color:#e75480;">Appointment Management</h2>

  <div class="mb-3 d-flex justify-content-between align-items-center gap-2">
    <div><small class="text-muted">Appointments</small></div>
    <div class="d-flex gap-2">
      <input id="appointmentSearch" class="form-control form-control-sm" type="search" placeholder="Search by name or booking ID..." style="width: 250px;">
      <select id="statusFilter" class="form-select form-select-sm" style="width: 150px;">
        <option value="">All Status</option>
        <option value="active">Active</option>
        <option value="pending_refund">Pending Refund</option>
        <option value="refunded">Refunded</option>
        <option value="cancelled">Cancelled</option>
        <option value="completed">Completed</option>
      </select>
      <input type="date" id="dateFilter" class="form-control form-control-sm" style="width: 150px;" placeholder="Filter by date">
    </div>
  </div>
  <div class="appointment-queue-wrapper" style="max-height:420px;overflow-y:auto;padding-right:6px;">
  <table class="table mb-0 bg-white table-bordered table-hover table-sm">
    <thead class="thead-light">
      <tr>
        <th>#</th>
        <th>Booking ID</th>
        <th>Client Name</th>
        <th>Service</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
  @forelse($appointments as $appointment)
  <tr data-id="{{ $appointment->id }}" data-booking-id="{{ $appointment->id }}" data-client-name="{{ $appointment->user->name ?? 'Walk-in' }}" data-status="{{ $appointment->status }}" data-payment-status="{{ $appointment->payment_status }}">
        <td>{{ $loop->iteration }}</td>
        <td><span class="badge bg-primary">#{{ $appointment->id }}</span></td>
        <td>{{ $appointment->user->name ?? 'Walk-in' }}</td>
    <td>
      @php $pkg = $appointment->package ?? null; @endphp
      @if($pkg)
      <div><strong>{{ $pkg->name }}</strong></div>
      <div class="text-muted small">{{ $pkg->services->pluck('name')->implode(', ') }}</div>
      @else
      {{ $appointment->service->name ?? '-' }}
      @endif
    </td>
        <td>{{ $appointment->date }}</td>
        <td>
            @php
                // Calculate full time range based on service duration
                $startTime = $appointment->time_slot;
                $duration = 1; // default 1 hour

                // Debug: Log what we're working with
                $debugInfo = [];
                $debugInfo['appointment_id'] = $appointment->id;
                $debugInfo['has_service'] = !is_null($appointment->service);
                $debugInfo['has_package'] = !is_null($appointment->package);

                // Get duration from service or package
                if ($appointment->package && $appointment->package->services->count() > 0) {
                    // Use the package's duration attribute which considers admin-configured durations
                    $duration = $appointment->package->duration ?: 1;
                    $debugInfo['package_duration'] = $duration;
                    $debugInfo['package_services'] = $appointment->package->services->pluck('name', 'duration')->toArray();
                } elseif ($appointment->service) {
                    $duration = $appointment->service->duration ?: 1;
                    $debugInfo['service_duration'] = $duration;
                    $debugInfo['service_name'] = $appointment->service->name;
                }

                $debugInfo['final_duration'] = $duration;

                // Calculate end time
                try {
                    if (strpos($startTime, '-') !== false) {
                        [$start, $end] = explode('-', $startTime, 2);
                        $startCarbon = \Carbon\Carbon::createFromFormat('H:i', trim($start));
                        $endCarbon = $startCarbon->copy()->addHours($duration);

                        $displayTime = $startCarbon->format('g:i A') . ' - ' . $endCarbon->format('g:i A');
                        if ($duration > 1) {
                            $displayTime .= ' <small class="text-muted">(' . $duration . 'h)</small>';
                        }
                        $debugInfo['display_time'] = $displayTime;
                    } else {
                        $displayTime = $startTime;
                        $debugInfo['display_time'] = 'no_dash_found';
                    }
                } catch (\Exception $e) {
                    $displayTime = $startTime;
                    $debugInfo['error'] = $e->getMessage();
                }

                // Temporary debug output (remove this after testing)
                if ($duration > 1) {
                    \Log::info('Multi-hour appointment found', $debugInfo);
                }
            @endphp
            {!! $displayTime !!}
        </td>
        <td>
            @if($appointment->status === 'pending_refund')
                <span class="badge bg-warning">Pending Refund</span>
            @elseif($appointment->payment_status === 'refunded')
                <span class="badge bg-secondary">Cancelled & Refunded</span>
            @elseif($appointment->status === 'cancelled')
                <span class="badge bg-danger">Cancelled</span>
            @elseif($appointment->status === 'completed')
                <span class="badge bg-success">Completed</span>
            @elseif($appointment->status === 'active')
                @if($appointment->payment_status === 'paid')
                    <span class="badge bg-success">Confirmed</span>
                @elseif($appointment->payment_status === 'pending')
                    <span class="badge bg-warning">Payment Pending</span>
                @else
                    <span class="badge bg-info">Active</span>
                @endif
            @else
                <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
            @endif
        </td>
        <td>
          @if($appointment->status === 'pending_refund')
            <span class="badge bg-warning text-dark mb-1 d-block">⚠️ Refund Requested by Client</span>
            <form action="{{ route('staff.processRefund', $appointment->id) }}" method="POST" style="display:inline-block;" class="process-refund-form">
              @csrf
              <button type="submit" class="mb-1 btn btn-success btn-sm" title="Confirm refund was given to client physically">
                <i class="fas fa-check-circle"></i> Confirm Refund Given
              </button>
            </form>
          @elseif($appointment->status === 'refunded')
            <span class="badge bg-secondary">Refunded</span>
          @elseif($appointment->status === 'completed')
            <span class="badge bg-success">✓ Completed</span>
          @elseif($appointment->status !== 'Cancelled' && $appointment->status !== 'cancelled')
          @if($appointment->payment_status === 'pending' && in_array($appointment->payment_method, ['card', 'gcash']))
          <button type="button" class="mb-1 btn btn-success btn-sm" data-toggle="modal" data-target="#confirmPaymentModal{{ $appointment->id }}">
            <i class="fas fa-check-circle"></i> Confirm Payment
          </button>
          @endif
          @if(($appointment->payment_status === 'paid' || $appointment->payment_method === 'cash') && $appointment->status === 'active')
          <form action="{{ route('staff.completeAppointment', $appointment->id) }}" method="POST" style="display:inline-block;" class="complete-appointment-form">
            @csrf
            @method('PATCH')
            <button type="submit" class="mb-1 btn btn-success btn-sm" title="Mark this appointment as completed">
              <i class="fas fa-check-double"></i> Mark Complete
            </button>
          </form>
          @endif
          <form action="{{ route('staff.sendReminder', $appointment->id) }}" method="POST" style="display:inline-block;" class="send-reminder-form">
            @csrf
            <button type="submit" class="mb-1 btn btn-info btn-sm" title="Send reminder email to client">
              <i class="fa fa-envelope"></i> Send Reminder
            </button>
          </form>
          <form action="{{ route('staff.cancelAppointment', $appointment->id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
          </form>
          <button type="button" class="btn btn-pink btn-sm" style="background:#e75480;color:#fff;" data-toggle="modal" data-target="#rescheduleModal{{ $appointment->id }}">Reschedule</button>
          @else
            <span class="text-muted">Cancelled</span>
          @endif
        </td>
      </tr>
      @empty
      <tr class="text-center no-results" style="display:none;">
        <td colspan="7" class="text-center">No matching appointments.</td>
      </tr>
      <tr>
        <td colspan="7" class="text-center">No appointments found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  </div>

    <!-- Add Booking Modal Trigger -->
    <div class="mb-3">
        <button class="btn btn-pink" style="background:#e75480;color:#fff;border:none;" data-toggle="modal" data-target="#addBookingModal">Add Walk-In Booking</button>
    </div>

    <!-- Add Booking Modal -->
    <div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="addBookingModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:#fff;border-radius:16px;">
          <div class="modal-header" style="background:#e75480;color:#fff;border-top-left-radius:16px;border-top-right-radius:16px;">
            <h5 class="modal-title" id="addBookingModalLabel">Add Walk-In Booking</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="{{ route('staff.addBooking') }}">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="walkin_name" style="color:#e75480;">Client Name</label>
                <input type="text" id="walkin_name_input" name="walkin_name" class="form-control" required placeholder="Enter walk-in client name">
                <div id="walkinNameError" class="mt-1 text-danger small" style="display:none;">Please enter a client name.</div>
              </div>
              <div class="form-group">
                <label for="walkin_email" style="color:#e75480;">Client Email (optional)</label>
                <input type="email" name="walkin_email" class="form-control" placeholder="Enter walk-in client email">
              </div>
              <div class="form-group">
                <label for="branch" style="color:#e75480;">Branch</label>
                @php $staffBranchId = optional(auth('staff')->user())->branch_id; @endphp
                @if($staffBranchId)
                  @php
                    $onlyBranch = \App\Models\Branch::find($staffBranchId);
                    try {
                      $svcQuery = $onlyBranch ? $onlyBranch->services()->get() : collect();
                      $servicesForBranch = $svcQuery->filter(function($s){
                        $globActive = (\Illuminate\Support\Facades\Schema::hasColumn('services', 'active')) ? (bool)($s->active ?? 1) : true;
                        $pivotActive = isset($s->pivot) && isset($s->pivot->active) ? (bool)$s->pivot->active : true;
                        return $globActive && $pivotActive;
                      })->map(function($s){ return ['id'=>$s->id,'name'=>$s->name,'price'=> $s->pivot->price ?? $s->price ?? null, 'duration' => $s->pivot->duration ?? $s->duration ?? 1]; })->values();
                    } catch (\Exception $e) { $servicesForBranch = collect(); }
                  @endphp
                  <select name="branch_id" class="form-control" required disabled>
                    <option value="{{ $onlyBranch->id ?? '' }}" data-services='@json($servicesForBranch)' selected>{{ $onlyBranch->name ?? 'Assigned Branch' }}</option>
                  </select>
                  <input type="hidden" name="branch_id" value="{{ $onlyBranch->id ?? '' }}">
                @else
                  <select name="branch_id" class="form-control" required>
                    @foreach(App\Models\Branch::all() as $branch)
                      @php
                        // compute services allowed for this branch (respect global active column if present, and pivot active if present)
                        try {
                          $svcQuery = $branch->services()->get();
                          $servicesForBranch = $svcQuery->filter(function($s){
                            $globActive = (\Illuminate\Support\Facades\Schema::hasColumn('services', 'active')) ? (bool)($s->active ?? 1) : true;
                            $pivotActive = isset($s->pivot) && isset($s->pivot->active) ? (bool)$s->pivot->active : true;
                            return $globActive && $pivotActive;
                          })->map(function($s){ return ['id'=>$s->id,'name'=>$s->name,'price'=> $s->pivot->price ?? $s->price ?? null, 'duration' => $s->pivot->duration ?? $s->duration ?? 1]; })->values();
                        } catch (\Exception $e) {
                          $servicesForBranch = collect();
                        }
                      @endphp
                      <option value="{{ $branch->id }}" data-services='@json($servicesForBranch)' @if(optional(auth('staff')->user())->branch_id == $branch->id) selected @endif>{{ $branch->name }}</option>
                    @endforeach
                  </select>
                @endif
              </div>
              <div class="form-group">
                <label for="service" style="color:#e75480;">Service</label>
                <select name="service_id" class="form-control" required>
                  @php
                    $availableServices = collect();
                    $staffBranchId = optional(auth('staff')->user())->branch_id;

                    if ($staffBranchId) {
                        // Staff has assigned branch - show only services active for their branch
                        $branch = \App\Models\Branch::find($staffBranchId);
                        if ($branch) {
                            try {
                                $availableServices = $branch->services()->get()->filter(function($s) {
                                    // Check global active status (if column exists)
                                    $globActive = (\Illuminate\Support\Facades\Schema::hasColumn('services', 'active')) ? (bool)($s->active ?? 1) : true;
                                    // Check branch-specific active status (pivot table)
                                    $pivotActive = isset($s->pivot) && isset($s->pivot->active) ? (bool)$s->pivot->active : true;
                                    return $globActive && $pivotActive;
                                });
                            } catch (\Exception $e) {
                                $availableServices = collect();
                            }
                        }
                    } else {
                        // Staff has no assigned branch - show all globally active services
                        $svcQuery = \App\Models\Service::query();
                        if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'active')) {
                            $svcQuery->where('active', 1);
                        }
                        $availableServices = $svcQuery->get();
                    }
                  @endphp
                  @if($availableServices->count() > 0)
                    @foreach($availableServices as $service)
                      @php
                        // Get the correct duration (admin-configured, including branch-specific overrides)
                        $serviceDuration = 1; // default
                        $servicePrice = $service->price ?? 0;

                        if ($staffBranchId) {
                            // For staff with assigned branch, get branch-specific overrides
                            // The $availableServices already come from branch relationship, so check pivot
                            if (isset($service->pivot)) {
                                // Duration: use branch override if available, otherwise service default
                                $serviceDuration = $service->pivot->duration ?? $service->duration ?? 1;
                                // Price: use branch override if available, otherwise service default
                                $servicePrice = $service->pivot->price ?? $service->price ?? 0;
                            } else {
                                $serviceDuration = $service->duration ?: 1;
                            }
                        } else {
                            // Staff with no assigned branch - use service defaults
                            $serviceDuration = $service->duration ?: 1;
                        }
                      @endphp
                      <option value="{{ $service->id }}" data-duration="{{ $serviceDuration }}" data-price="{{ $servicePrice }}">
                        {{ $service->name }} - ₱{{ number_format($servicePrice, 2) }} ({{ $serviceDuration }}h)
                      </option>
                    @endforeach
                  @else
                    <option value="" disabled>No services available for this branch</option>
                  @endif
                </select>
              </div>
              <div class="form-group">
                <label for="package" style="color:#e75480;">Package (Optional)</label>
                <select name="package_id" class="form-control">
                  <option value="">Select Package (Optional)</option>
                  @php
                    $availablePackages = collect();
                    $staffBranchId = optional(auth('staff')->user())->branch_id;

                    if ($staffBranchId) {
                        // Staff has assigned branch - show packages for their branch
                        $availablePackages = \App\Models\Package::where(function($query) use ($staffBranchId) {
                            $query->where('branch_id', $staffBranchId)
                                  ->orWhereNull('branch_id'); // Global packages
                        })->get();
                    } else {
                        // Staff has no assigned branch - show all packages
                        $availablePackages = \App\Models\Package::all();
                    }
                  @endphp
                  @if($availablePackages->count() > 0)
                    @foreach($availablePackages as $package)
                      @php
                        // Use the package's duration attribute which considers admin-configured durations
                        $packageDuration = $package->duration ?: 1;
                      @endphp
                      <option value="{{ $package->id }}" data-duration="{{ $packageDuration }}" data-price="{{ $package->price }}">{{ $package->name }} - ₱{{ number_format($package->price, 2) }} ({{ $packageDuration }}h)</option>
                    @endforeach
                  @endif
                </select>
                <small class="text-muted">Note: Select either a service OR a package, not both.</small>
              </div>
              <div class="form-group">
                <label for="date" style="color:#e75480;">Date</label>
                <input type="date" name="date" class="form-control" required min="{{ date('Y-m-d') }}">
              </div>
              <div class="form-group">
                <label for="time_slot" style="color:#e75480;">Time Slot</label>
                <select name="time_slot" class="form-control" required>
                  <option value="">Select Time Slot</option>
                </select>
              </div>

            </div>
            <div class="modal-footer" style="background:#fff;border-bottom-left-radius:16px;border-bottom-right-radius:16px;">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-pink" style="background:#e75480;color:#fff;">Add Booking</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<script>
// AJAX submit for Add Walk-In Booking
document.addEventListener('DOMContentLoaded', function() {
  var addForm = document.querySelector('#addBookingModal form');
  if (!addForm) return;
  addForm.addEventListener('submit', function(e) {
    e.preventDefault();
    var walkinNameEl = document.getElementById('walkin_name_input');
    if (walkinNameEl) {
      var val = walkinNameEl.value || '';
      if (val.trim().length === 0) {
        document.getElementById('walkinNameError').style.display = 'block';
        return;
      } else {
        document.getElementById('walkinNameError').style.display = 'none';
      }
    }
    var formData = new FormData(addForm);
    var action = addForm.getAttribute('action');
    fetch(action, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '' },
      body: formData
    }).then(function(resp){
      return resp.json().then(function(json){ return { ok: resp.ok, status: resp.status, body: json }; });
    }).then(function(result){
      var respOk = result.ok;
      var data = result.body;
      if (!respOk) {
        var msg = (data && data.message) ? data.message : 'Failed to book the slot.';
        var toast = document.getElementById('bookingSuccessToast');
        if (toast) { toast.style.background = '#dc3545'; toast.firstElementChild.textContent = msg; toast.style.display = 'block'; setTimeout(function(){ toast.style.display = 'none'; toast.style.background=''; toast.firstElementChild.textContent='Booking added'; }, 3000); }
        return;
      }
      if (data && data.booking) {
          var b = data.booking;
        // append to booking queue table
        var btbody = document.querySelector('.booking-queue-wrapper table tbody');
        if (btbody) {
          var tr = document.createElement('tr');
          tr.className = 'new-booking';
          tr.innerHTML = '<td>--</td>' +
            '<td>'+ (b.user_name || 'Walk-in') +'</td>' +
            '<td>'+ (b.service_name || '-') +'</td>' +
            '<td>'+ (b.date || '') +'</td>' +
            '<td>'+ (b.status || '') +'</td>' +
            '<td><form action="'+ (b.cancel_url || '#') +'" method="POST" onsubmit="return confirm(\'Cancel this booking?\');">' + (b.csrf || '') + '<button class="btn btn-danger btn-sm" type="submit">Cancel</button></form></td>';
          btbody.insertBefore(tr, btbody.firstChild);
          // highlight and scroll into view
          tr.classList.add('new-booking-highlight');
          var wrapper = document.querySelector('.booking-queue-wrapper'); if (wrapper) wrapper.scrollTop = 0;
        }
        // if walk-in, append to walk-in table
        if (!formData.get('user_id')) {
          var wtbody = document.querySelector('.walkin-queue-wrapper table tbody');
          if (wtbody) {
            var wtr = document.createElement('tr');
            wtr.className = 'new-booking';
            // Calculate display time with duration
            var displayTime = b.time_slot || '';
            if (b.duration && b.duration > 1 && b.time_slot && b.time_slot.includes('-')) {
                try {
                    var parts = b.time_slot.split('-');
                    var startTime = parts[0].trim();
                    var startDate = new Date('2000-01-01 ' + startTime);
                    var endDate = new Date(startDate.getTime() + (b.duration * 60 * 60 * 1000));

                    var startFormatted = startDate.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                    var endFormatted = endDate.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });

                    displayTime = startFormatted + ' - ' + endFormatted;
                    if (b.duration > 1) {
                        displayTime += ' <small class="text-muted">(' + b.duration + 'h)</small>';
                    }
                } catch (e) {
                    displayTime = b.time_slot || '';
                }
            }

            wtr.innerHTML = '<td>--</td>' +
              '<td>'+ (b.user_name || 'Walk-in') +'</td>' +
              '<td>'+ (b.service_name || '-') +'</td>' +
              '<td>'+ (b.date || '') +'</td>' +
              '<td>'+ displayTime +'</td>' +
              '<td>'+ (b.status || '') +'</td>' +
              '<td><form action="'+ (b.cancel_url || '#') +'" method="POST" onsubmit="return confirm(\'Cancel this booking?\');">' + (b.csrf || '') + '<button class="btn btn-danger btn-sm" type="submit">Cancel</button></form></td>';
            wtbody.insertBefore(wtr, wtbody.firstChild);
            wtr.classList.add('new-booking-highlight');
            var wwrap = document.querySelector('.walkin-queue-wrapper'); if (wwrap) wwrap.scrollTop = 0;
          }
        }
        // Update calendar slot badges' data-names and availability for the start + continuation slots
        try {
          var slotDate = b.date;
          var slot = b.time_slot; // this is the first hourly subslot (e.g., "12:00-13:00")
          var displayName = (b.walkin_name && b.walkin_name.trim().length) ? (b.walkin_name + ' (Walk-in)') : (b.user_name || 'Walk-in');

          // prefer authoritative required_slots from server response
          var required = [];
          if (data && data.required_slots && Array.isArray(data.required_slots) && data.required_slots.length) {
            required = data.required_slots;
          } else {
            // fallback: compute based on modal branch data-services
            var modal = document.getElementById('addBookingModal');
            var branchSel = modal ? modal.querySelector('select[name="branch_id"]') : document.querySelector('select[name="branch_id"]');
            var svcSel = modal ? modal.querySelector('select[name="service_id"]') : document.querySelector('select[name="service_id"]');
            var duration = 1;
            try {
              if (branchSel && svcSel) {
                var bOpt = branchSel.options[branchSel.selectedIndex];
                var list = [];
                try { list = JSON.parse(bOpt.getAttribute('data-services') || '[]'); } catch(e) { list = []; }
                var sObj = list.find(function(x){ return String(x.id) === String(svcSel.value); });
                if (sObj && sObj.duration) duration = Number(sObj.duration) || 1;
              }
            } catch(e) { duration = 1; }

            // helper functions
            function hhmmToMins(hhmm) { var p = hhmm.split(':'); return (parseInt(p[0],10)||0)*60 + (parseInt(p[1],10)||0); }
            function minsToHHMM(m) { var h = Math.floor(m/60); var mm = m%60; return String(h).padStart(2,'0') + ':' + String(mm).padStart(2,'0'); }
            try {
              var startHHMM = slot.split('-')[0].trim();
              var startMin = hhmmToMins(startHHMM);
              for (var k = 0; k < duration; k++) {
                var sMin = startMin + k*60;
                var eMin = sMin + 60;
                required.push(minsToHHMM(sMin) + '-' + minsToHHMM(eMin));
              }
            } catch (ex) { required = [slot]; }
          }

          // update calendar badges for each required subslot
          document.querySelectorAll('.slot-badge').forEach(function(el){
            try {
              if (el.getAttribute('data-date') === slotDate && required.indexOf(el.getAttribute('data-slot')) !== -1) {
                // update names
                var existing = el.getAttribute('data-names') || '';
                var newNames = displayName + (existing ? ', ' + existing : '');
                el.setAttribute('data-names', newNames);
                // update displayed availability: try parse "X left" and decrement
                var txt = el.textContent || '';
                var m = txt.match(/(\d+)\s*left/);
                if (m && m[1]) {
                  var left = parseInt(m[1],10) - 1;
                  if (left <= 0) {
                    el.textContent = 'Full';
                    el.classList.remove('bg-pink'); el.classList.add('bg-danger');
                    el.style.background = '#ffb6c1'; el.style.color = '#e75480';
                  } else {
                    el.textContent = left + ' left';
                  }
                }
              }
            } catch(e) { /* ignore per-element errors */ }
          });

          // disable matching select options across the page for each required subslot
          required.forEach(function(rs){
            document.querySelectorAll('select[name="time_slot"] option').forEach(function(opt){
              if (opt.value === rs) { opt.disabled = true; if (!/Booked|Full/.test(opt.textContent)) opt.textContent = opt.textContent + ' (Booked)'; }
            });
          });

        } catch (e) { console.warn('Failed to update calendar badge names', e); }
                // close modal
                var modalEl = document.getElementById('addBookingModal');
                if (modalEl) $(modalEl).modal('hide');
                addForm.reset();
                // show toast
                var toast = document.getElementById('bookingSuccessToast');
                if (toast) { toast.style.display = 'block'; setTimeout(function(){ toast.style.display = 'none'; }, 2200); }
                // notify other parts of the app (calendars, dashboards) about the new booking
                try { window.dispatchEvent(new CustomEvent('booking:created', { detail: b })); } catch (e) { console.warn('booking:created dispatch failed', e); }
      }
    }).catch(function(err){
      console.error('Booking failed', err);
      var toast = document.getElementById('bookingSuccessToast');
      if (toast) { toast.style.background = '#dc3545'; toast.firstElementChild.textContent = 'Booking failed (network)'; toast.style.display = 'block'; setTimeout(function(){ toast.style.display = 'none'; toast.style.background=''; toast.firstElementChild.textContent='Booking added'; }, 3000); }
    });
  });
});
</script>

<script>
// AJAX reschedule: submit reschedule forms via fetch, show an in-modal floating notification for errors
document.addEventListener('DOMContentLoaded', function() {
  function showRescheduleFloat(modal, message, level) {
    try {
      if (!modal) return;
      var content = modal.querySelector('.modal-content') || modal;
      if (!content) content = modal;
      content.style.position = content.style.position || 'relative';
      // remove existing
      var existing = content.querySelector('.reschedule-float-notice');
      if (existing) existing.remove();
      var div = document.createElement('div');
      div.className = 'reschedule-float-notice alert ' + (level === 'success' ? 'alert-success' : 'alert-danger') + ' p-2';
      div.style.position = 'absolute';
      div.style.left = '50%';
      div.style.transform = 'translateX(-50%)';
      div.style.top = '72px';
      div.style.zIndex = 2050;
      div.style.width = 'calc(100% - 48px)';
      div.style.textAlign = 'center';
      div.style.borderRadius = '8px';
      div.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
      div.innerHTML = message;
      content.appendChild(div);
      // auto-hide after 4 seconds
      setTimeout(function(){ if (div && div.parentNode) div.parentNode.removeChild(div); }, 4000);
    } catch (e) { console.warn('showRescheduleFloat failed', e); }
  }

  // delegate submit for any reschedule form
  document.querySelectorAll('form[action*="/reschedule"]').forEach(function(form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      var modal = form.closest('.modal');

      // client-side guard: if selected time is disabled or marked as (Break), show float and stop
      try {
        var timeSelect = form.querySelector('select[name="time_slot"]');
        if (timeSelect) {
          var sel = timeSelect.options[timeSelect.selectedIndex];
          if (sel && (sel.disabled || /\(Break\)/i.test(sel.textContent))) {
            showRescheduleFloat(modal || document.body, 'Selected time falls within branch break time. Please choose another slot.', 'danger');
            return;
          }
        }
      } catch (e) { /* ignore and continue */ }

      var action = form.getAttribute('action');
      var fd = new FormData(form);
      // Use fetch with same-origin credentials
      fetch(action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(function(resp){
        return resp.json().then(function(json){ return { ok: resp.ok, status: resp.status, body: json }; });
      }).then(function(result){
        if (!result.ok) {
          var msg = (result.body && result.body.message) ? result.body.message : 'Failed to reschedule.';
          showRescheduleFloat(modal || document.body, msg, 'danger');
          return;
        }
        var data = result.body && result.body.booking ? result.body.booking : null;
        // extract id from action url (assumes /staff/appointments/{id}/reschedule)
        var m = action.match(/appointments\/(\d+)\/reschedule/);
        var id = m ? m[1] : null;
        if (id) {
          var row = document.querySelector('tr[data-id="' + id + '"]');
          if (row) {
            // Date column is 4th cell (0-based index 3), Time is 5th (index 4)
            try { row.cells[3].textContent = data.date || fd.get('date'); } catch(e){}
            try { row.cells[4].textContent = data.time_slot || fd.get('time_slot'); } catch(e){}
          }
        }
        // update booking queue / walkin tables where time shown
        try {
          document.querySelectorAll('.walkin-queue-wrapper table tbody tr').forEach(function(r){ var tcell = r.cells[4]; if (tcell) { /* leave as-is; can't reliably map id here */ } });
        } catch(e){}

        // close modal
        try { if (modal) { if (window.jQuery) $(modal).modal('hide'); else modal.style.display='none'; } } catch(e){}

        // show success toast
        try { var toast = document.getElementById('bookingSuccessToast'); if (toast) { toast.style.display='block'; setTimeout(function(){ toast.style.display='none'; }, 2200); } } catch(e){}

        // Dispatch event so any calendar on the page can update if it's listening
        try { window.dispatchEvent(new CustomEvent('booking:rescheduled', { detail: data })); } catch(e){}
      }).catch(function(err){ console.error('Reschedule failed', err); showRescheduleFloat(modal || document.body, 'Reschedule failed (network)', 'danger'); });
    });
  });
});
</script>

<script>
// Populate Add Walk-In modal time slots from branch.time_slot and server-side full slots
document.addEventListener('DOMContentLoaded', function() {
  function parseHHMMToMinutes(hhmm) { var parts = hhmm.split(':'); var h = parseInt(parts[0],10)||0; var m = parseInt(parts[1],10)||0; return h*60 + m; }
  function minutesToHHMM(mins) { var h = Math.floor(mins/60); var m = mins % 60; return String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0'); }
  function buildHourlySlotsFromRange(rangeStr) {
    if (!rangeStr) return [];
    // accept "09:00 - 21:00" or "09:00-21:00"
    var sep = rangeStr.indexOf('-')>-1 ? '-' : null;
    if (!sep) return [];
    var parts = rangeStr.split('-');
    var start = parts[0].trim();
    var end = parts[1].trim();
    var sMin = parseHHMMToMinutes(start);
    var eMin = parseHHMMToMinutes(end);
    var slots = [];
    for (var cur = sMin; cur + 60 <= eMin; cur += 60) {
      slots.push(minutesToHHMM(cur) + '-' + minutesToHHMM(cur+60));
    }
    return slots;
  }
  function toAmPmLabel(hhmm) {
    var parts = hhmm.split(':'); var h = parseInt(parts[0],10); var m = parts[1]||'00'; var am = h < 12 ? 'am' : 'pm'; var hh = h % 12 === 0 ? 12 : h % 12; return hh + ':' + m + am; }
  function formatSlotLabel(slot) { if (!slot) return slot; var p = slot.split('-'); return toAmPmLabel(p[0]) + ' - ' + toAmPmLabel(p[1]); }

  // Fetch branch time_slot and break times via server-side Branch data snapshot embedded in page if available
  var branchMap = {};
  @foreach(App\Models\Branch::all() as $branch)
    branchMap['{{ $branch->id }}'] = {
      time_slot: @json($branch->time_slot),
      slot_capacity: {{ $branch->slot_capacity ?? 5 }},
      break_start: @json($branch->break_start),
      break_end: @json($branch->break_end)
    };
  @endforeach

  function refreshSlotsInModal() {
  var modal = document.getElementById('addBookingModal'); if (!modal) return;
    var branchSelect = modal.querySelector('select[name="branch_id"]');
    var dateInput = modal.querySelector('input[name="date"]');
    var timeSelect = modal.querySelector('select[name="time_slot"]');
    if (!branchSelect || !timeSelect) return;
    var bid = branchSelect.value;
    var dateVal = dateInput ? dateInput.value : '';
    timeSelect.innerHTML = '';
    var slots = [];
    if (bid && branchMap[bid] && branchMap[bid].time_slot) {
      slots = buildHourlySlotsFromRange(branchMap[bid].time_slot);
    }
    if (!slots.length) {
      // fallback
      slots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
    }
    // placeholder
    var ph = document.createElement('option'); ph.value=''; ph.textContent='Select Time Slot'; timeSelect.appendChild(ph);

    // determine selected service or package duration for modal before building options
    var modalSvcSel = modal ? modal.querySelector('select[name="service_id"]') : null;
    var modalPkgSel = modal ? modal.querySelector('select[name="package_id"]') : null;
    var selectedSvcDur = 1;
    try {
      // allow force-duration override when service select triggers a rebuild
      if (modal && modal.getAttribute('data-force-duration')) {
        selectedSvcDur = parseInt(modal.getAttribute('data-force-duration') || '1', 10) || 1;
      } else if (modalPkgSel && modalPkgSel.value) {
        // Package selected - calculate duration from package services
        selectedSvcDur = 2; // Default package duration, will be updated by server if needed
        // Try to get package duration from data attribute if available
        try {
          var pkgOption = modalPkgSel.options[modalPkgSel.selectedIndex];
          var pkgDuration = pkgOption ? pkgOption.getAttribute('data-duration') : null;
          if (pkgDuration) {
            selectedSvcDur = parseInt(pkgDuration, 10) || 2;
          }
        } catch(e) { /* ignore */ }
      } else if (modalSvcSel && modalSvcSel.value) {
        // Service selected
        var bOpt = branchSelect.options[branchSelect.selectedIndex];
        var list = [];
        try { list = JSON.parse(bOpt.getAttribute('data-services') || '[]'); } catch(e) { list = []; }
        var sObj = list.find(function(x){ return String(x.id) === String(modalSvcSel.value); });
        if (sObj && sObj.duration) selectedSvcDur = Number(sObj.duration) || 1;
      }
    } catch (e) { selectedSvcDur = 1; }

    // build duration-sized starts stepping by duration (value remains first hourly subslot)
  function buildDurationStarts(hourly, durationHours) {
      var starts = [];
      if (!hourly || hourly.length === 0) return starts;
      try {
        var firstStart = hourly[0].split('-')[0];
        var lastEnd = hourly[hourly.length - 1].split('-')[1];
        var sMin = parseHHMMToMinutes(firstStart);
        var eMin = parseHHMMToMinutes(lastEnd);
    // use 1-hour sliding window start (step = 60) so a multi-hour service can start at each hour boundary
    var step = 60;
    for (var cur = sMin; cur + (durationHours*60) <= eMin; cur += step) {
          var start = minutesToHHMM(cur);
          var end = minutesToHHMM(cur + (durationHours*60));
          var required = [];
          var fits = true;
          for (var k = 0; k < durationHours; k++) {
            var ss = minutesToHHMM(cur + k*60) + '-' + minutesToHHMM(cur + (k+1)*60);
            if (hourly.indexOf(ss) === -1) { fits = false; break; }
            required.push(ss);
          }
          if (fits) starts.push({ value: required[0], labelStart: start, labelEnd: end, required: required });
        }
      } catch (e) { /* ignore */ }
      return starts;
    }

    var durationStarts = buildDurationStarts(slots, selectedSvcDur);
    // render duration-sized options
    durationStarts.forEach(function(ds){
      var o = document.createElement('option');
      o.value = ds.value; // first hourly slot
      o.textContent = formatSlotLabel(ds.labelStart + '-' + ds.labelEnd);
      // check breaks across required subslots
      try {
        if (branchMap[bid] && branchMap[bid].break_start && branchMap[bid].break_end) {
          for (var ii = 0; ii < ds.required.length; ii++) {
            var sslot = ds.required[ii];
            var p = sslot.split('-');
            var sMin = parseHHMMToMinutes(p[0]);
            var eMin = parseHHMMToMinutes(p[1]);
            var bsMin = parseHHMMToMinutes(branchMap[bid].break_start);
            var beMin = parseHHMMToMinutes(branchMap[bid].break_end);
            if (sMin < beMin && eMin > bsMin) { o.disabled = true; o.textContent = o.textContent + ' (Break)'; break; }
          }
        }
      } catch (ex) { /* ignore */ }
      timeSelect.appendChild(o);
    });

    // then ask server which are full for this branch/date and disable them
    if (bid && dateVal) {
      // determine selected service duration for add-walk-in modal
      var modalSvc = document.querySelector('#addBookingModal select[name="service_id"]');
      var selectedDur = 1;
      try {
        if (modalSvc && modalSvc.value) {
          var bOpt = document.querySelector('select[name="branch_id"]').options[document.querySelector('select[name="branch_id"]').selectedIndex];
          var list = [];
          try { list = JSON.parse(bOpt.getAttribute('data-services') || '[]'); } catch(e) { list = []; }
          var sObj = list.find(function(x){ return String(x.id) === String(modalSvc.value); });
          if (sObj && sObj.duration) selectedDur = Number(sObj.duration) || 1;
        }
      } catch (e) { selectedDur = 1; }

      var url = '{{ url('/api/booking/slots') }}' + '?branch_id=' + encodeURIComponent(bid) + '&date=' + encodeURIComponent(dateVal) + '&duration=' + encodeURIComponent(selectedDur);
      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(function(r){ return r.json(); }).then(function(json){
        var full = (json && json.fullSlots) ? json.fullSlots : [];
        var unavailable = (json && json.unavailableStarts) ? json.unavailableStarts : [];

        Array.from(timeSelect.options).forEach(function(opt){
          if (!opt.value) return;

          // Remove full slots entirely for cleaner UX
          if (full.indexOf(opt.value) !== -1) {
            opt.remove();
            return;
          }

          // Disable unavailable slots
          if (unavailable.indexOf(opt.value) !== -1) {
            opt.disabled = true;
            opt.textContent = opt.textContent + ' (Unavailable)';
          }
        });
      }).catch(function(){ /* ignore */ });
    }

    // disable past slots if booking date is today
    if (dateVal) {
      var today = new Date().toISOString().slice(0,10);
      if (dateVal === today) {
        var now = new Date(); var curMins = now.getHours()*60 + now.getMinutes();
        Array.from(timeSelect.options).forEach(function(opt){ if (!opt.value) return; var start = opt.value.split('-')[0]; if (parseHHMMToMinutes(start) + 60 <= curMins) { opt.disabled = true; opt.textContent = opt.textContent + ' (Past)'; } });
      }
    }
  }

  // Bind modal open via data-target click to be resilient and also on branch/date changes
  var trigger = document.querySelector('button[data-target="#addBookingModal"]'); if (trigger) trigger.addEventListener('click', function(){ setTimeout(refreshSlotsInModal, 50); });
  document.addEventListener('change', function(e){ if (!e.target) return; if (e.target.name === 'branch_id' || e.target.name === 'date') { refreshSlotsInModal(); } });

  // populate service select in Add Walk-In modal based on branch's data-services
  function populateAddModalServices() {
    var modal = document.getElementById('addBookingModal'); if (!modal) return;
    var branchSelect = modal.querySelector('select[name="branch_id"]');
    var serviceSelect = modal.querySelector('select[name="service_id"]');
    if (!branchSelect || !serviceSelect) return;
    var opt = branchSelect.options[branchSelect.selectedIndex];
    var list = [];
    try { list = JSON.parse(opt.getAttribute('data-services') || '[]'); } catch(e) { list = []; }
    serviceSelect.innerHTML = '';
    if (list && list.length) {
      list.forEach(function(s){
        var o = document.createElement('option');
        o.value = s.id;
        o.textContent = s.name + (s.price ? (' - ₱' + s.price) : '');
        if (s.price !== undefined && s.price !== null) o.setAttribute('data-price', s.price);
        if (s.duration !== undefined && s.duration !== null) o.setAttribute('data-duration', s.duration);
        serviceSelect.appendChild(o);
      });
  // ensure price + duration fields exist and populate initial values
  ensureModalPriceField(modal, serviceSelect);
  // trigger change to set price + duration for current selection
  serviceSelect.dispatchEvent(new Event('change'));
    } else {
      // fallback: keep existing behavior but avoid disabled services where possible
      serviceSelect.innerHTML = '<option value="">Select Service</option>';
    }
  }

  // ensure the readonly Price field exists inside the Add Walk-In modal and return it
  function ensureModalPriceField(modal, $serviceSelect) {
    if (!modal) return null;
    var container = modal.querySelector('.form-group') || modal.querySelector('.modal-body') || modal;
    // try to place price below the service select
    var svcEl = modal.querySelector('select[name="service_id"]');
    if (!svcEl) svcEl = $serviceSelect || null;
    // check existing
    var existing = modal.querySelector('#walkin_service_price');
    if (existing) return existing;
    // create label + readonly input
  var lbl = document.createElement('label'); lbl.setAttribute('for','walkin_service_price'); lbl.className = 'form-label'; lbl.style.color = '#e75480'; lbl.style.fontWeight = '600'; lbl.style.marginTop = '8px'; lbl.textContent = 'Price';
  var inp = document.createElement('input'); inp.type = 'text'; inp.id = 'walkin_service_price'; inp.name = 'service_price_display'; inp.readOnly = true; inp.className = 'form-control'; inp.style.marginTop = '6px';
  // duration label+input
  var durLbl = document.createElement('label'); durLbl.setAttribute('for','walkin_service_duration'); durLbl.className = 'form-label'; durLbl.style.color = '#e75480'; durLbl.style.fontWeight = '600'; durLbl.style.marginTop = '8px'; durLbl.style.marginLeft = '12px'; durLbl.textContent = 'Duration (hrs)';
  var durInp = document.createElement('input'); durInp.type = 'text'; durInp.id = 'walkin_service_duration'; durInp.name = 'service_duration_display'; durInp.readOnly = true; durInp.className = 'form-control'; durInp.style.display = 'inline-block'; durInp.style.width = '120px'; durInp.style.marginTop = '6px'; durInp.style.marginLeft = '12px';
    if (svcEl && svcEl.parentNode) {
      svcEl.parentNode.insertBefore(lbl, svcEl.nextSibling);
      svcEl.parentNode.insertBefore(inp, lbl.nextSibling);
      // insert duration next to price
      svcEl.parentNode.insertBefore(durLbl, inp.nextSibling);
      svcEl.parentNode.insertBefore(durInp, durLbl.nextSibling);
    } else if (container) {
      container.appendChild(lbl);
      container.appendChild(inp);
      container.appendChild(durLbl);
      container.appendChild(durInp);
    }
    return inp;
  }

  // Listen to branch changes inside modal specifically
  document.addEventListener('change', function(e){
    if (!e.target) return;
    if (e.target.name === 'branch_id' && e.target.closest && e.target.closest('#addBookingModal')) {
      populateAddModalServices();
    }
  });

  // when service changes inside Add Walk-In modal, rebuild the time slots using that service duration
  (function(){
    var timer = null;
    document.addEventListener('change', function(e){
      try {
        var el = e.target;
        if (!el) return;
        if (el.name === 'service_id' && el.closest && el.closest('#addBookingModal')) {
          // debounce small delay in case branch/service selects update together
          if (timer) clearTimeout(timer);
          timer = setTimeout(function(){
            try {
              var modal = document.getElementById('addBookingModal');
              var branchSelect = modal.querySelector('select[name="branch_id"]');
              var dateInput = modal.querySelector('input[name="date"]');
              // Ask server for authoritative service duration/price
              var svcId = el.value;
              var bid = (branchSelect && branchSelect.value) ? branchSelect.value : '';
              if (!svcId) {
                // no selection -> clear force-duration and rebuild
                if (modal) { modal.removeAttribute('data-force-duration'); }
                refreshSlotsInModal();
                return;
              }
              var url = '/api/service/' + encodeURIComponent(svcId) + (bid ? ('?branch_id=' + encodeURIComponent(bid)) : '');
              fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(function(r){ return r.json(); }).then(function(json){
                try {
                  var duration = parseInt(json.duration || 1, 10) || 1;
                  var price = json.price !== undefined && json.price !== null ? json.price : null;
                  // set display inputs
                  var priceInput = modal.querySelector('#walkin_service_price');
                  var durInput = modal.querySelector('#walkin_service_duration');
                  if (!priceInput) priceInput = ensureModalPriceField(modal);
                  if (!durInput) { ensureModalPriceField(modal); durInput = modal.querySelector('#walkin_service_duration'); }
                  if (priceInput) {
                    if (price === null) {
                      priceInput.value = '₱0.00';
                    } else {
                      var n = parseFloat(String(price).replace(/[^0-9.\-]/g,'')); if (isNaN(n)) n = 0; priceInput.value = '₱' + n.toFixed(2);
                    }
                  }
                  if (durInput) durInput.value = String(duration || 1);
                  // force rebuild with authoritative duration
                  if (modal) modal.setAttribute('data-force-duration', String(duration));
                  refreshSlotsInModal();
                  if (modal) modal.removeAttribute('data-force-duration');
                } catch(ex) { console.warn('service detail parse failed', ex); refreshSlotsInModal(); }
              }).catch(function(err){ console.warn('service detail fetch failed', err); refreshSlotsInModal(); });
            } catch(err) { console.warn('rebuild slots error', err); }
          }, 120);
        }
      } catch(ex) { /* ignore */ }
    });
  })();

  // update price and duration display when service select changes inside the modal
  document.addEventListener('change', function(e){
    try {
      var el = e.target;
      if (!el) return;
      if (el.name === 'service_id' && el.closest && el.closest('#addBookingModal')) {
        var modal = el.closest('#addBookingModal');
        var selected = el.options[el.selectedIndex];
        var price = selected ? selected.getAttribute('data-price') : null;
        var duration = selected ? selected.getAttribute('data-duration') : null;
        var priceInput = modal.querySelector('#walkin_service_price');
        var durInput = modal.querySelector('#walkin_service_duration');
        if (!priceInput) priceInput = ensureModalPriceField(modal, el);
        if (!durInput) { ensureModalPriceField(modal, el); durInput = modal.querySelector('#walkin_service_duration'); }
        if (priceInput) {
          if (price === null || price === undefined || price === '') {
            priceInput.value = '₱0.00';
          } else {
            var num = parseFloat(String(price).replace(/[^0-9.\-]/g,''));
            if (isNaN(num)) num = 0;
            priceInput.value = '₱' + num.toFixed(2);
          }
        }
        if (durInput) {
          if (duration === null || duration === undefined || duration === '') {
            durInput.value = '1';
          } else {
            var dn = parseInt(String(duration).replace(/[^0-9\-]/g,''), 10);
            if (isNaN(dn) || dn < 1) dn = 1;
            durInput.value = String(dn);
          }
        }
      }
    } catch (ex) { console.warn('price update error', ex); }
  });

  // Handle mutual exclusivity between service and package selection
  document.addEventListener('change', function(e) {
    try {
      var el = e.target;
      if (!el || !el.closest) return;

      var modal = el.closest('#addBookingModal');
      if (!modal) return;

      var serviceSelect = modal.querySelector('select[name="service_id"]');
      var packageSelect = modal.querySelector('select[name="package_id"]');

      if (!serviceSelect || !packageSelect) return;

      if (el.name === 'service_id' && el.value) {
        // Service selected, clear package
        packageSelect.value = '';
        // Update required attribute
        serviceSelect.setAttribute('required', 'required');
        packageSelect.removeAttribute('required');
      } else if (el.name === 'package_id' && el.value) {
        // Package selected, clear service
        serviceSelect.value = '';
        // Update required attribute
        packageSelect.setAttribute('required', 'required');
        serviceSelect.removeAttribute('required');

        // Trigger time slot refresh for package duration
        var branchSelect = modal.querySelector('select[name="branch_id"]');
        var dateInput = modal.querySelector('input[name="date"]');
        if (branchSelect && dateInput && branchSelect.value && dateInput.value) {
          setTimeout(function() {
            refreshSlotsInModal();
          }, 100);
        }
      } else if ((el.name === 'service_id' && !el.value) || (el.name === 'package_id' && !el.value)) {
        // Nothing selected, make service required by default
        serviceSelect.setAttribute('required', 'required');
        packageSelect.removeAttribute('required');
      }
    } catch (ex) { console.warn('service/package mutual exclusivity error', ex); }
  });

  // initial call in case modal is already on page
  refreshSlotsInModal();
});
</script>

  <hr>
  <div class="container py-4">
    <h2 class="mb-4" style="color:#e75480;">Booking Queue</h2>

    <div class="mb-2 d-flex justify-content-between align-items-center">
      <div><small class="text-muted">Live queue (most recent first)</small></div>
      <div class="d-flex gap-2">
        <input id="bookingSearch" class="form-control form-control-sm" type="search" placeholder="Search by name..." style="width: 200px;">
        <select id="queueStatusFilter" class="form-select form-select-sm" style="width: 150px;">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="cancelled">Cancelled</option>
          <option value="completed">Completed</option>
        </select>
        <input type="date" id="queueDateFilter" class="form-control form-control-sm" style="width: 150px;">
      </div>
    </div>
    <div class="booking-queue-wrapper" style="max-height:380px;overflow-y:auto;padding-right:6px;">
    <table class="table mb-0 table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr data-status="{{ $booking->status }}" data-payment-status="{{ $booking->payment_status }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->user->name ?? 'Walk-in' }}</td>
          <td>
            @php $bpkg = $booking->package ?? null; @endphp
            @if($bpkg)
              <div><strong>{{ $bpkg->name }}</strong></div>
              <div class="text-muted small">{{ $bpkg->services->pluck('name')->implode(', ') }}</div>
            @else
              {{ $booking->service->name ?? '-' }}
            @endif
          </td>
                    <td>{{ $booking->date }}</td>
                    <td>
                        @if($booking->payment_method === 'cash')
                            <span class="badge bg-success"><i class="fas fa-money-bill-wave"></i> Cash</span>
                        @elseif($booking->payment_method === 'card')
                            <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Card</span>
                        @elseif($booking->payment_method === 'gcash')
                            <span class="badge bg-info"><i class="fas fa-mobile-alt"></i> GCash</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
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
                    <td>
                        @if($booking->status !== 'Cancelled' && $booking->status !== 'cancelled' && $booking->status !== 'completed')
                        <div class="d-flex gap-1">
                            @if($booking->status === 'active' && ($booking->payment_status === 'paid' || $booking->payment_method === 'cash'))
                            <form action="{{ route('staff.completeAppointment', $booking->id) }}" method="POST" class="complete-booking-form d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Complete
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('staff.cancelAppointment', $booking->id) }}" method="POST" class="cancel-booking-form d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </form>
                        </div>
                        @elseif($booking->status === 'completed')
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="text-muted">Cancelled</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No bookings found.</td>
                </tr>
                @endforelse

        <tr class="text-center no-results" style="display:none;">
          <td colspan="7" class="text-center">No matching bookings.</td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>

  <!-- Walk-In Clients (scrollable, searchable) -->
  <div class="container py-4">
    <h2 class="mb-4" style="color:#e75480;">Walk-In Clients</h2>

    <div class="mb-2 d-flex justify-content-between align-items-center">
      <div><small class="text-muted">Current walk-in clients</small></div>
      <div class="d-flex gap-2">
        <input id="walkinSearch" class="form-control form-control-sm" type="search" placeholder="Search by name or booking ID..." style="width: 250px;">
        <select id="walkinStatusFilter" class="form-select form-select-sm" style="width: 150px;">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="cancelled">Cancelled</option>
          <option value="completed">Completed</option>
        </select>
        <input type="date" id="walkinDateFilter" class="form-control form-control-sm" style="width: 150px;">
      </div>
    </div>
    <div class="walkin-queue-wrapper" style="max-height:300px;overflow-y:auto;padding-right:6px;">
      <table class="table mb-0 table-sm table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Booking ID</th>
            <th>Client Name</th>
            <th>Service</th>
            <th>Date</th>
            <th>Time</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($walkins as $w)
            <tr data-id="walkin-{{ $w->id }}" data-booking-id="{{ $w->id }}">
              <td>{{ $loop->iteration }}</td>
              <td><span class="badge bg-success">#{{ $w->id }}</span></td>
              <td>{{ $w->user->name ?? ($w->walkin_name ?? 'Walk-in') }}</td>
              <td>
                @php $bpkg = $w->package ?? null; @endphp
                @if($bpkg)
                  <div><strong>{{ $bpkg->name }}</strong></div>
                  <div class="text-muted small">{{ $bpkg->services->pluck('name')->implode(', ') }}</div>
                @else
                  {{ $w->service->name ?? '-' }}
                @endif
              </td>
              <td>{{ $w->date }}</td>
              <td>
                  @php
                      // Calculate full time range based on service duration for walk-in
                      $startTime = $w->time_slot;
                      $duration = 1; // default 1 hour

                      // Get duration from service or package
                      if ($w->package) {
                          // Use the package's duration attribute which considers admin-configured durations
                          $duration = $w->package->duration ?: 1;
                      } elseif ($w->service) {
                          $duration = $w->service->duration ?: 1;
                      }

                      // Calculate end time
                      try {
                          if (strpos($startTime, '-') !== false) {
                              [$start, $end] = explode('-', $startTime, 2);
                              $startCarbon = \Carbon\Carbon::createFromFormat('H:i', trim($start));
                              $endCarbon = $startCarbon->copy()->addHours($duration);

                              $displayTime = $startCarbon->format('g:i A') . ' - ' . $endCarbon->format('g:i A');
                              if ($duration > 1) {
                                  $displayTime .= ' <small class="text-muted">(' . $duration . 'h)</small>';
                              }
                          } else {
                              $displayTime = $startTime;
                          }
                      } catch (\Exception $e) {
                          $displayTime = $startTime;
                      }
                  @endphp
                  {!! $displayTime !!}
              </td>
              <td>
                @if($w->payment_method === 'cash')
                    <span class="badge bg-success"><i class="fas fa-money-bill-wave"></i> Cash</span>
                @elseif($w->payment_method === 'card')
                    <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Card</span>
                @elseif($w->payment_method === 'gcash')
                    <span class="badge bg-info"><i class="fas fa-mobile-alt"></i> GCash</span>
                @else
                    <span class="text-muted">-</span>
                @endif
              </td>
              <td>{{ ucfirst($w->status) }}</td>
              <td>
                @if($w->status !== 'Cancelled' && $w->status !== 'cancelled' && $w->status !== 'completed')
                <div class="d-flex gap-1">
                  @if($w->status === 'active' && ($w->payment_status === 'paid' || $w->payment_method === 'cash'))
                  <form action="{{ route('staff.completeAppointment', $w->id) }}" method="POST" class="complete-walkin-form d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm">
                      <i class="fas fa-check"></i> Complete
                    </button>
                  </form>
                  @endif
                  <form action="{{ route('staff.cancelAppointment', $w->id) }}" method="POST" class="cancel-walkin-form d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                      <i class="fas fa-times"></i> Cancel
                    </button>
                  </form>
                  <!-- Reschedule walk-in (open a modal similar to rescheduleModal for registered users) -->
                  <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#rescheduleModalWalkin{{ $w->id }}">Reschedule</button>
                </div>
                @elseif($w->status === 'completed')
                  <span class="badge bg-success">Completed</span>
                @else
                  <span class="text-muted">Cancelled</span>
                @endif
              </td>
            </tr>
            <!-- Reschedule modal for walk-in -->
            <div class="modal fade" id="rescheduleModalWalkin{{ $w->id }}" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalWalkinLabel{{ $w->id }}" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="background:#fff;border-radius:16px;">
                  <div class="modal-header" style="background:#e75480;color:#fff;border-top-left-radius:16px;border-top-right-radius:16px;">
                    <h5 class="modal-title" id="rescheduleModalWalkinLabel{{ $w->id }}">Reschedule Walk-In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <form method="POST" action="{{ route('staff.rescheduleBooking', $w->id) }}">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group"><label for="date" style="color:#e75480;">New Date</label><input type="date" name="date" class="form-control" value="{{ $w->date }}" required></div>
                      <div class="form-group"><label for="time_slot" style="color:#e75480;">New Time Slot</label>
                        @php
                          $branch = \App\Models\Branch::find($w->branch_id);
                          $defaultSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
                          $slots = $defaultSlots;
                          if ($branch && $branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
                            try {
                              [$s,$e] = explode(' - ', $branch->time_slot, 2);
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
                            } catch (\Exception $e) { $slots = $defaultSlots; }
                          }
                        @endphp
                        <select name="time_slot" class="form-control" required>
                          @foreach($slots as $s)
                            @php
                              $label = $s;
                              $disabled = false;
                              if (strpos($s,'-') !== false) {
                                try { [$ss,$se] = explode('-', $s, 2); $label = \Carbon\Carbon::createFromFormat('H:i', trim($ss))->format('g:ia') . ' - ' . \Carbon\Carbon::createFromFormat('H:i', trim($se))->format('g:ia'); } catch (\Exception $e) { $label = $s; }
                              }
                              // server-side check for branch break overlap
                              if ($branch && $branch->break_start && $branch->break_end && strpos($s,'-') !== false) {
                                try {
                                  [$ss,$se] = explode('-', $s, 2);
                                  $slotStart = \Carbon\Carbon::createFromFormat('H:i', trim($ss));
                                  $slotEnd = \Carbon\Carbon::createFromFormat('H:i', trim($se));
                                  $bs = \Carbon\Carbon::createFromFormat('H:i', trim($branch->break_start));
                                  $be = \Carbon\Carbon::createFromFormat('H:i', trim($branch->break_end));
                                  if ($slotStart->lt($be) && $slotEnd->gt($bs)) { $disabled = true; $label = $label . ' (Break)'; }
                                } catch (\Exception $e) { /* ignore */ }
                              }
                            @endphp
                            <option value="{{ $s }}" @if($w->time_slot == $s) selected @endif @if($disabled) disabled @endif>{{ $label }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer" style="background:#fff;border-bottom-left-radius:16px;border-bottom-right-radius:16px;">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-pink" style="background:#e75480;color:#fff;">Reschedule</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @empty
            <tr>
              <td colspan="8" class="text-center">No walk-ins found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

<!-- Success toast -->
<div id="bookingSuccessToast" style="position:fixed;top:18px;right:18px;z-index:2000;display:none;">
  <div style="background:#28a745;color:#fff;padding:12px 18px;border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,0.12);">Booking added</div>
</div>

<style>
.new-booking-highlight { animation: flash-bg 2s ease-in-out; }
@keyframes flash-bg { 0%{background:#e8f8ef;} 50%{background:#fff;} 100%{background:transparent;} }

/* Booking ID Badge Styling */
.badge.bg-primary, .badge.bg-success {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
    padding: 6px 10px;
    cursor: pointer;
}

.badge.bg-primary:hover {
    background-color: #0056b3 !important;
    transform: scale(1.05);
    transition: all 0.2s ease;
}

.badge.bg-success:hover {
    background-color: #0f7b3c !important;
    transform: scale(1.05);
    transition: all 0.2s ease;
}

/* Custom Toast Styling */
.colored-toast.swal2-popup {
    border-radius: 12px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
    padding: 16px 20px !important;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    border-left: 5px solid !important;
}

.colored-toast.swal2-popup.swal2-icon-success {
    border-left-color: #28a745 !important;
}

.colored-toast.swal2-popup.swal2-icon-error {
    border-left-color: #dc3545 !important;
}

.colored-toast .swal2-title {
    font-size: 16px !important;
    font-weight: 600 !important;
    margin: 0 !important;
}

.colored-toast .swal2-icon {
    width: 32px !important;
    height: 32px !important;
    margin: 0 12px 0 0 !important;
}

.colored-toast .swal2-timer-progress-bar {
    background: rgba(0, 0, 0, 0.2) !important;
}

.colored-toast:hover .swal2-timer-progress-bar {
    background: rgba(0, 0, 0, 0.3) !important;
}
</style>

    <!-- Confirm Payment Modal (one per appointment) -->
    @foreach($appointments as $appointment)
    @if($appointment->payment_status === 'pending' && in_array($appointment->payment_method, ['card', 'gcash']))
    <div class="modal fade" id="confirmPaymentModal{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmPaymentModalLabel{{ $appointment->id }}" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:#fff;border-radius:16px;">
          <div class="modal-header" style="background:linear-gradient(135deg, #e91e63 0%, #f06292 100%);color:#fff;border-top-left-radius:16px;border-top-right-radius:16px;">
            <h5 class="modal-title" id="confirmPaymentModalLabel{{ $appointment->id }}">
                <i class="fas fa-check-circle me-2"></i>Confirm Payment Received
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="mb-3 text-center">
                <i class="fas fa-money-check-alt" style="font-size:3rem;color:#e91e63;"></i>
            </div>
            <p class="text-center"><strong>Client:</strong> {{ $appointment->user->name ?? 'Walk-in' }}</p>
            <p class="text-center"><strong>Payment Method:</strong>
                @if($appointment->payment_method === 'card')
                    Credit/Debit Card
                @elseif($appointment->payment_method === 'gcash')
                    GCash
                @endif
            </p>
            <p class="text-center text-muted">Are you sure you want to confirm that payment has been received for this booking?</p>
          </div>
          <form method="POST" action="{{ route('staff.confirmPayment', $appointment->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success" style="background:#28a745;border-color:#28a745;">
                  <i class="fas fa-check me-2"></i>Confirm Payment Received
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endif
    @endforeach

    <!-- Reschedule Modal (one per appointment) -->
    @foreach($appointments as $appointment)
    <div class="modal fade" id="rescheduleModal{{ $appointment->id }}" tabindex="-1" role="dialog" aria-labelledby="rescheduleModalLabel{{ $appointment->id }}" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:#fff;border-radius:16px;">
          <div class="modal-header" style="background:#e75480;color:#fff;border-top-left-radius:16px;border-top-right-radius:16px;">
            <h5 class="modal-title" id="rescheduleModalLabel{{ $appointment->id }}">Reschedule Booking</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="{{ route('staff.rescheduleBooking', $appointment->id) }}">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="date" style="color:#e75480;">New Date</label>
                <input type="date" name="date" class="form-control" value="{{ $appointment->date }}" required>
              </div>
              <div class="form-group">
                <label for="time_slot" style="color:#e75480;">New Time Slot</label>
                  <select name="time_slot" class="form-control" required>
                  @php
                    $defaultSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
                    $slots = $defaultSlots;
                    $branch = null;
                    if (!empty($appointment->branch_id)) {
                      $branch = \App\Models\Branch::find($appointment->branch_id);
                    }
                    if ($branch && $branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
                      [$s,$e] = explode(' - ', $branch->time_slot, 2);
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
                    }
                  @endphp
                  @foreach($slots as $s)
                    @php
                      $label = $s;
                      $disabled = false;
                      if (strpos($s,'-') !== false) {
                        try {
                          [$ss,$se] = explode('-', $s, 2);
                          $label = \Carbon\Carbon::createFromFormat('H:i', trim($ss))->format('g:ia') . ' - ' . \Carbon\Carbon::createFromFormat('H:i', trim($se))->format('g:ia');
                        } catch (\Exception $e) { $label = $s; }
                      }
                      // server-side break overlap check
                      if ($branch && $branch->break_start && $branch->break_end && strpos($s,'-') !== false) {
                        try {
                          [$ss,$se] = explode('-', $s, 2);
                          $slotStart = \Carbon\Carbon::createFromFormat('H:i', trim($ss));
                          $slotEnd = \Carbon\Carbon::createFromFormat('H:i', trim($se));
                          $bs = \Carbon\Carbon::createFromFormat('H:i', trim($branch->break_start));
                          $be = \Carbon\Carbon::createFromFormat('H:i', trim($branch->break_end));
                          if ($slotStart->lt($be) && $slotEnd->gt($bs)) { $disabled = true; $label = $label . ' (Break)'; }
                        } catch (\Exception $e) { /* ignore */ }
                      }
                    @endphp
                    <option value="{{ $s }}" @if($appointment->time_slot == $s) selected @endif @if($disabled) disabled @endif>{{ $label }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="modal-footer" style="background:#fff;border-bottom-left-radius:16px;border-bottom-right-radius:16px;">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-pink" style="background:#e75480;color:#fff;">Reschedule</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach

</div>

<!-- Cancel Confirmation Modal -->
<div class="modal fade" id="cancelConfirmModal" tabindex="-1" role="dialog" aria-labelledby="cancelConfirmLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius:16px;">
      <div class="modal-header" style="background:#e75480;color:#fff;border-top-left-radius:16px;border-top-right-radius:16px;">
        <h5 class="modal-title" id="cancelConfirmLabel">Cancel Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="color:#e75480;">Are you sure you want to cancel this appointment?</div>
      <div class="modal-footer" style="background:#fff;border-bottom-left-radius:16px;border-bottom-right-radius:16px;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-pink" id="confirmCancelBtn" style="background:#e75480;color:#fff;">Yes, Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
    function filterTimeSlots() {
        var selectedDate = $('input[name="date"]').val();
        var now = new Date();
        var today = now.toISOString().slice(0,10);
        var currentHour = now.getHours();
        var currentMinute = now.getMinutes();
        var currentTime = currentHour * 60 + currentMinute;
        var slotMap = {
            '09:00-10:00': 9 * 60,
            '10:00-11:00': 10 * 60,
            '11:00-12:00': 11 * 60,
            '12:00-13:00': 12 * 60,
            '13:00-14:00': 13 * 60,
            '14:00-15:00': 14 * 60,
            '15:00-16:00': 15 * 60,
            '16:00-17:00': 16 * 60,
            '17:00-18:00': 17 * 60
        };
        var select = $('select[name="time_slot"]');
        select.find('option').each(function() {
            var slot = $(this).val();
            if(selectedDate === today && slotMap[slot] < currentTime) {
                $(this).prop('disabled', true).text(slot + ' (Past)');
            } else {
                $(this).prop('disabled', false).text(slot);
            }
        });
    }
    $('input[name="date"]').on('change', filterTimeSlots);
    $(document).ready(filterTimeSlots);
});
</script>

<script>
$(function() {
    var cancelForm = null;
    $(document).on('click', 'form[action*="cancelAppointment"] button[type="submit"]', function(e) {
        e.preventDefault();
        cancelForm = $(this).closest('form');
        $('#cancelConfirmModal').modal('show');
    });
    $(document).on('click', '#confirmCancelBtn', function() {
        if(cancelForm) {
            // Submit the form normally (no AJAX)
            cancelForm.off('submit'); // Remove previous event handler
            cancelForm.submit();
        }
    });
});
</script>
<!-- package modal removed: package services are shown inline now -->
<script>
// Booking queue search/filter
document.addEventListener('DOMContentLoaded', function() {
  var search = document.getElementById('bookingSearch');
  var queueStatusFilter = document.getElementById('queueStatusFilter');
  var queueDateFilter = document.getElementById('queueDateFilter');

  if (!search) return;
  var tbody = document.querySelectorAll('.booking-queue-wrapper table tbody')[0];
  var rows = tbody ? Array.from(tbody.querySelectorAll('tr')) : [];

  function filterRows() {
    var q = (search.value || '').trim().toLowerCase();
    var statusVal = queueStatusFilter ? queueStatusFilter.value.toLowerCase() : '';
    var dateVal = queueDateFilter ? queueDateFilter.value : '';

    rows.forEach(function(r) {
      if (r.classList && r.classList.contains('no-results')) return;
      if (r.cells.length < 5) return;

      // Name filter (column 1)
      var nameCell = r.cells[1];
      var name = nameCell ? (nameCell.textContent || nameCell.innerText || '').toLowerCase() : '';
      var nameMatch = q === '' || name.indexOf(q) !== -1;

      // Status filter using data attributes
      var status = r.getAttribute('data-status') || '';
      var paymentStatus = r.getAttribute('data-payment-status') || '';
      var statusMatch = true;

      if (statusVal !== '') {
        switch(statusVal) {
          case 'active':
            // Active filter: Show all active bookings
            statusMatch = status === 'active';
            break;
          case 'completed':
            // Completed filter: Show only completed bookings
            statusMatch = status === 'completed';
            break;
          case 'cancelled':
            // Cancelled filter: Show all cancelled bookings (including refunded)
            statusMatch = status === 'cancelled';
            break;
          default:
            statusMatch = true;
        }
      }

      // Date filter (column 3)
      var dateCell = r.cells[3];
      var dateText = dateCell ? (dateCell.textContent || dateCell.innerText || '').trim() : '';
      var dateMatch = true;

      if (dateVal) {
        try {
          var rowDate = new Date(dateText);
          var filterDate = new Date(dateVal);
          dateMatch = rowDate.toDateString() === filterDate.toDateString();
        } catch (e) {
          dateMatch = false;
        }
      }

      var match = nameMatch && statusMatch && dateMatch;
      r.style.display = match ? '' : 'none';
    });
  }

  search.addEventListener('input', filterRows);
  if (queueStatusFilter) queueStatusFilter.addEventListener('change', filterRows);
  if (queueDateFilter) queueDateFilter.addEventListener('change', filterRows);
});
</script>
<script>
// Appointment management search/filter
document.addEventListener('DOMContentLoaded', function() {
  var search = document.getElementById('appointmentSearch');
  var statusFilter = document.getElementById('statusFilter');
  var dateFilter = document.getElementById('dateFilter');

  if (!search) return;
  var tbody = document.querySelector('.appointment-queue-wrapper table tbody');
  if (!tbody) return;
  var rows = Array.from(tbody.querySelectorAll('tr'));

  function filterAppointments() {
    var q = (search.value || '').trim().toLowerCase();
    var statusVal = statusFilter ? statusFilter.value.toLowerCase() : '';
    var dateVal = dateFilter ? dateFilter.value : '';

    rows.forEach(function(r) {
      if (r.classList && r.classList.contains('no-results')) return;

      // Booking ID filter (column 1 - Booking ID)
      var bookingIdCell = r.cells[1];
      var bookingId = bookingIdCell ? (bookingIdCell.textContent || bookingIdCell.innerText || '').toLowerCase() : '';
      var bookingIdMatch = q === '' || bookingId.indexOf(q) !== -1;

      // Name filter (column 2 - Client Name)
      var nameCell = r.cells[2];
      var name = nameCell ? (nameCell.textContent || nameCell.innerText || '').toLowerCase() : '';
      var nameMatch = q === '' || name.indexOf(q) !== -1;

      // Combined search match (search in either booking ID or name)
      var searchMatch = q === '' || bookingIdMatch || nameMatch;

      // Status filter using data attributes
      var status = r.getAttribute('data-status') || '';
      var paymentStatus = r.getAttribute('data-payment-status') || '';
      var statusMatch = true;

      if (statusVal !== '') {
        switch(statusVal) {
          case 'active':
            // Active filter: Show all active bookings (both confirmed paid and payment pending)
            statusMatch = status === 'active';
            break;
          case 'refunded':
            // Refunded filter: Show only refunded bookings (payment_status='refunded')
            statusMatch = paymentStatus === 'refunded';
            break;
          case 'completed':
            // Completed filter: Show only completed bookings
            statusMatch = status === 'completed';
            break;
          case 'cancelled':
            // Cancelled filter: Show cancelled bookings (including refunded: payment_status='refunded')
            statusMatch = status === 'cancelled';
            break;
          case 'pending_refund':
            // Pending Refund filter: Show pending refund bookings
            statusMatch = status === 'pending_refund';
            break;
          default:
            statusMatch = true;
        }
      }

      // Date filter (column 4)
      var dateCell = r.cells[4];
      var dateText = dateCell ? (dateCell.textContent || dateCell.innerText || '').trim() : '';
      var dateMatch = true;

      if (dateVal) {
        try {
          var rowDate = new Date(dateText);
          var filterDate = new Date(dateVal);
          dateMatch = rowDate.toDateString() === filterDate.toDateString();
        } catch (e) {
          dateMatch = false;
        }
      }

      var match = searchMatch && statusMatch && dateMatch;
      r.style.display = match ? '' : 'none';
    });
  }

  search.addEventListener('input', filterAppointments);
  if (statusFilter) statusFilter.addEventListener('change', filterAppointments);
  if (dateFilter) dateFilter.addEventListener('change', filterAppointments);

  // Add click handler for booking ID badges to auto-fill search
  var bookingIdBadges = tbody.querySelectorAll('td:nth-child(2) .badge');
  bookingIdBadges.forEach(function(badge) {
    badge.style.cursor = 'pointer';
    badge.title = 'Click to search for this booking ID';
    badge.addEventListener('click', function() {
      var bookingId = this.textContent.trim();
      search.value = bookingId;
      filterAppointments();
      search.focus();
      
      // Highlight the search box briefly
      search.style.backgroundColor = '#fff3cd';
      setTimeout(function() {
        search.style.backgroundColor = '';
      }, 1000);
    });
  });
});
</script>
<script>
// Walk-in clients search
document.addEventListener('DOMContentLoaded', function() {
  var search = document.getElementById('walkinSearch');
  var walkinStatusFilter = document.getElementById('walkinStatusFilter');
  var walkinDateFilter = document.getElementById('walkinDateFilter');

  if (!search) return;
  var tbody = document.querySelector('.walkin-queue-wrapper table tbody');
  if (!tbody) return;
  var rows = Array.from(tbody.querySelectorAll('tr'));

  function filterWalkins() {
    var q = (search.value || '').trim().toLowerCase();
    var statusVal = walkinStatusFilter ? walkinStatusFilter.value.toLowerCase() : '';
    var dateVal = walkinDateFilter ? walkinDateFilter.value : '';

    rows.forEach(function(r) {
      if (r.cells.length < 7) return;

      // Booking ID filter (column 1)
      var bookingIdCell = r.cells[1];
      var bookingId = bookingIdCell ? (bookingIdCell.textContent || bookingIdCell.innerText || '').toLowerCase() : '';
      var bookingIdMatch = q === '' || bookingId.indexOf(q) !== -1;

      // Name filter (column 2)
      var nameCell = r.cells[2];
      var name = nameCell ? (nameCell.textContent || nameCell.innerText || '').toLowerCase() : '';
      var nameMatch = q === '' || name.indexOf(q) !== -1;

      // Combined search match (search in either booking ID or name)
      var searchMatch = q === '' || bookingIdMatch || nameMatch;

      // Status filter (column 7)
      var statusCell = r.cells[7];
      var statusText = statusCell ? (statusCell.textContent || statusCell.innerText || '').toLowerCase() : '';
      var statusMatch = statusVal === '' || statusText.indexOf(statusVal) !== -1;

      // Date filter (column 4)
      var dateCell = r.cells[4];
      var dateText = dateCell ? (dateCell.textContent || dateCell.innerText || '').trim() : '';
      var dateMatch = true;

      if (dateVal) {
        try {
          var rowDate = new Date(dateText);
          var filterDate = new Date(dateVal);
          dateMatch = rowDate.toDateString() === filterDate.toDateString();
        } catch (e) {
          dateMatch = false;
        }
      }

      var match = searchMatch && statusMatch && dateMatch;
      r.style.display = match ? '' : 'none';
    });
  }

  search.addEventListener('input', filterWalkins);
  if (walkinStatusFilter) walkinStatusFilter.addEventListener('change', filterWalkins);
  if (walkinDateFilter) walkinDateFilter.addEventListener('change', filterWalkins);

  // Add click handler for booking ID badges to auto-fill search
  var bookingIdBadges = tbody.querySelectorAll('td:nth-child(2) .badge');
  bookingIdBadges.forEach(function(badge) {
    badge.style.cursor = 'pointer';
    badge.title = 'Click to search for this booking ID';
    badge.addEventListener('click', function() {
      var bookingId = this.textContent.trim();
      search.value = bookingId;
      filterWalkins();
      search.focus();
      
      // Highlight the search box briefly
      search.style.backgroundColor = '#fff3cd';
      setTimeout(function() {
        search.style.backgroundColor = '';
      }, 1000);
    });
  });
});
</script>
<script>
// Modal booking snapshot search
document.addEventListener('DOMContentLoaded', function() {
  // modal snapshot removed; nothing to do here
});
</script>

<script>
// Double-submit prevention for all forms on staff appointments page
document.addEventListener('DOMContentLoaded', function() {
    // Show success/error toast notifications
    @if(session('success'))
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
            color: '#155724',
            iconColor: '#28a745'
        });
    @endif

    @if(session('error'))
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
            title: '{{ session('error') }}',
            background: '#f8d7da',
            color: '#721c24',
            iconColor: '#dc3545'
        });
    @endif

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

    // Specific handler for send reminder forms with custom loading message
    const reminderForms = document.querySelectorAll('.send-reminder-form');
    reminderForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            }
        });
    });

    // Specific handler for complete appointment with confirmation
    const completeForms = document.querySelectorAll('.complete-appointment-form');
    completeForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');

            // SweetAlert confirmation
            Swal.fire({
                title: '✅ Mark Appointment as Complete?',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <p style="margin-bottom: 15px; font-size: 1.1em;">Has the service been completed?</p>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                            <p style="margin: 8px 0;"><i class="fas fa-check-circle" style="color: #28a745; margin-right: 8px;"></i> Service has been performed</p>
                            <p style="margin: 8px 0;"><i class="fas fa-check-circle" style="color: #28a745; margin-right: 8px;"></i> Client is satisfied</p>
                            <p style="margin: 8px 0;"><i class="fas fa-check-circle" style="color: #28a745; margin-right: 8px;"></i> Payment confirmed</p>
                        </div>
                        <p style="margin-top: 15px; font-weight: 600; color: #e75480;">Click CONFIRM to mark this appointment as COMPLETED.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check-double"></i> Mark Complete',
                cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                customClass: {
                    popup: 'swal-wide',
                    title: 'swal-title-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Completing...';
                    }
                    form.submit();
                }
            });
        });
    });

    // Specific handler for refund processing with confirmation
    const refundForms = document.querySelectorAll('.process-refund-form');
    refundForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');

            // SweetAlert confirmation
            Swal.fire({
                title: '⚠️ Confirm Refund Completion',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <p style="margin-bottom: 15px; font-size: 1.1em;">Have you physically given the refund to the client at the branch?</p>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                            <p style="margin: 8px 0;"><i class="fas fa-check-circle" style="color: #28a745; margin-right: 8px;"></i> Confirmed that client received the money</p>
                            <p style="margin: 8px 0;"><i class="fas fa-check-circle" style="color: #28a745; margin-right: 8px;"></i> Verified client identity</p>
                            <p style="margin: 8px 0;"><i class="fas fa-check-circle" style="color: #28a745; margin-right: 8px;"></i> Transaction is complete</p>
                        </div>
                        <p style="margin-top: 15px; font-weight: 600; color: #e75480;">Click CONFIRM to mark this refund as COMPLETED.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check"></i> Confirm Refund',
                cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                customClass: {
                    popup: 'swal-wide',
                    title: 'swal-title-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing Refund...';
                    }
                    form.submit();
                }
            });
        });
    });

    // Handle cancel booking confirmation (Booking Queue)
    document.querySelectorAll('.cancel-booking-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');

            Swal.fire({
                title: '⚠️ Cancel Booking?',
                html: `
                    <div style="text-align: left; padding: 10px 20px;">
                        <p style="margin-bottom: 15px; color: #555;">
                            <strong>Are you sure you want to cancel this booking?</strong>
                        </p>
                        <div style="background: #fff3cd; padding: 10px; border-radius: 5px; border-left: 4px solid #ffc107;">
                            <p style="margin: 0; color: #856404;">
                                <i class="fas fa-exclamation-triangle"></i> This action cannot be undone.
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-times"></i> Yes, Cancel Booking',
                cancelButtonText: '<i class="fas fa-arrow-left"></i> No, Keep It',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Cancelling...';
                    }
                    form.submit();
                }
            });
        });
    });

    // Handle cancel walk-in confirmation
    document.querySelectorAll('.cancel-walkin-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');

            Swal.fire({
                title: '⚠️ Cancel Walk-in Booking?',
                html: `
                    <div style="text-align: left; padding: 10px 20px;">
                        <p style="margin-bottom: 15px; color: #555;">
                            <strong>Are you sure you want to cancel this walk-in booking?</strong>
                        </p>
                        <div style="background: #fff3cd; padding: 10px; border-radius: 5px; border-left: 4px solid #ffc107;">
                            <p style="margin: 0; color: #856404;">
                                <i class="fas fa-exclamation-triangle"></i> This action cannot be undone.
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-times"></i> Yes, Cancel Booking',
                cancelButtonText: '<i class="fas fa-arrow-left"></i> No, Keep It',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Cancelling...';
                    }
                    form.submit();
                }
            });
        });
    });

    // Handle complete booking confirmation
    document.querySelectorAll('.complete-booking-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');

            Swal.fire({
                title: '✅ Complete This Booking?',
                html: `
                    <div style="text-align: left; padding: 10px 20px;">
                        <p style="margin-bottom: 15px; color: #555;">
                            <strong>Are you ready to mark this booking as completed?</strong>
                        </p>
                        <div style="background: #d4edda; padding: 10px; border-radius: 5px; border-left: 4px solid #28a745;">
                            <p style="margin: 0; color: #155724;">
                                <i class="fas fa-check-circle"></i> This will mark the appointment as successfully completed.
                            </p>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check"></i> Yes, Mark as Complete',
                cancelButtonText: '<i class="fas fa-arrow-left"></i> Not Yet',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Completing...';
                    }
                    form.submit();
                }
            });
        });
    });

    // Handle complete walk-in confirmation
    document.querySelectorAll('.complete-walkin-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');

            Swal.fire({
                title: '✅ Complete This Walk-in?',
                html: `
                    <div style="text-align: left; padding: 10px 20px;">
                        <p style="margin-bottom: 15px; color: #555;">
                            <strong>Are you ready to mark this walk-in as completed?</strong>
                        </p>
                        <div style="background: #d4edda; padding: 10px; border-radius: 5px; border-left: 4px solid #28a745;">
                            <p style="margin: 0; color: #155724;">
                                <i class="fas fa-check-circle"></i> This will mark the appointment as successfully completed.
                            </p>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check"></i> Yes, Mark as Complete',
                cancelButtonText: '<i class="fas fa-arrow-left"></i> Not Yet',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Completing...';
                    }
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
