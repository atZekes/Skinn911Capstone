
@extends('layouts.staffapp')
@section('tab-content')
@php
    $currentBranchId = request('branch_id');
    $maxSlots = 5;
    $defaultSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
    if ($currentBranchId) {
        $branch = \App\Models\Branch::find($currentBranchId);
        if ($branch) {
            $maxSlots = $branch->slot_capacity ?? 5;
            if ($branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
                [$s,$e] = explode(' - ', $branch->time_slot, 2);
                try {
                    $start = \Carbon\Carbon::createFromFormat('H:i', $s);
                    $end = \Carbon\Carbon::createFromFormat('H:i', $e);
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

    // Preload bookings for the 30-day window so staff calendar reflects multi-slot coverage
    $dates = [];
    for ($i = 0; $i < 30; $i++) { $dates[] = \Carbon\Carbon::now()->addDays($i)->format('Y-m-d'); }
    $bookingQuery = \App\Models\Booking::whereIn('date', $dates)->where('status', 'active');
    if ($currentBranchId) $bookingQuery->where('branch_id', $currentBranchId);
    $bookings = $bookingQuery->with(['user','service','package.services'])->get();

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
    // occupyingBookings[date][slot] = array of bookings occupying that slot (starts or continuations)
    // startBookings[date][slot] = array of bookings that START at that slot
    $occupyingCount = [];
    $occupyingBookings = [];
    $startBookings = [];
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
                if (! isset($occupyingBookings[$b->date])) $occupyingBookings[$b->date] = [];
                if (! isset($occupyingBookings[$b->date][$slotLabel])) $occupyingBookings[$b->date][$slotLabel] = [];
                $occupyingBookings[$b->date][$slotLabel][] = $b;
                if ($k === 0) {
                    if (! isset($startBookings[$b->date])) $startBookings[$b->date] = [];
                    if (! isset($startBookings[$b->date][$slotLabel])) $startBookings[$b->date][$slotLabel] = [];
                    $startBookings[$b->date][$slotLabel][] = $b;
                }
            }
        } catch (\Exception $e) {
            // ignore
        }
    }
@endphp
<div class="py-5 container-fluid" style="background:#fff;">
    <h2 class="mb-4" style="color:#F56289;">Staff Calendar - Full Month View</h2>
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
            Please select a branch first to view available time slots.
        </div>
    @endif
    <div id="calendar-viewer" class="calendar-responsive" style="background:#fff;border-radius:18px;padding:32px;min-height:600px;box-shadow:0 4px 24px rgba(0,0,0,0.10);font-size:1.1rem;width:100%;max-width:none;margin:auto;overflow-x:auto;">
        <div class="mb-3 row flex-nowrap">
            <div class="col-2" style="min-width:140px;"></div>
            @for($i = 0; $i < 30; $i++)
                @php $dateObj = \Carbon\Carbon::now()->addDays($i); $date = $dateObj->format('Y-m-d'); @endphp
                <div class="text-center col" style="font-size:1.1rem;min-width:140px;">
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
                @for($i = 0; $i < 30; $i++)
                    @php $dateObj = \Carbon\Carbon::now()->addDays($i); $date = $dateObj->format('Y-m-d'); @endphp
                    <div class="text-center col d-flex align-items-center justify-content-center" style="min-width:140px;">
                        @php
                            $occ = $occupyingCount[$date][$slot] ?? 0;
                            $available = ($maxSlots ?? 5) - $occ;
                            $bookedList = $occupyingBookings[$date][$slot] ?? [];
                            $startingBookings = $startBookings[$date][$slot] ?? [];

                            // Build names for occupied slots
                            $namesArr = [];
                            foreach ($bookedList as $b) {
                                if (isset($b->user) && $b->user) {
                                    $namesArr[] = $b->user->name;
                                } elseif (!empty($b->walkin_name)) {
                                    $namesArr[] = $b->walkin_name . ' (Walk-in)';
                                } else {
                                    $namesArr[] = 'Walk-in';
                                }
                            }
                            $names = collect($namesArr)->unique()->implode(', ');

                            // Check if this slot has starting bookings vs continuation only
                            $hasStartingBookings = count($startingBookings) > 0;
                            $continuationOnly = $occ > 0 && !$hasStartingBookings;

                            // Debug info - will be visible in data attributes
                            $debugInfo = "Occ:$occ, StartCount:" . count($startingBookings) . ", TotalBooked:" . count($bookedList);
                        @endphp

                        {{-- All slots show availability count with visual distinction for continuation --}}
                        <span class="badge slot-badge {{ $occ >= $maxSlots ? 'bg-danger' : 'bg-pink' }}"
                              style="font-size:1rem;padding:8px 12px;opacity:{{ $continuationOnly ? '0.7' : '0.8' }};cursor:pointer;
                                     background:{{ $occ >= $maxSlots ? '#ffb6c1' : '#F56289' }};
                                     color:{{ $occ >= $maxSlots ? '#e75480' : '#fff' }};
                                     {{ $continuationOnly ? 'border:2px dashed #fff;' : '' }}"
                              data-names="{{ $names }}" data-date="{{ $date }}" data-slot="{{ $slot }}"
                              data-debug="{{ $debugInfo }}">
                            {{ $occ >= $maxSlots ? 'Full' : ($available . ' left') }}
                        </span>
                    </div>
                @endfor
            </div>
        @endforeach
    </div>
</div>
<!-- Enhanced Booking Details Modal -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1" role="dialog" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingDetailsModalLabel">Booking Details & Actions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bookingDetailsModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('branch_id').addEventListener('change', function() {
        document.getElementById('branchFilterForm').submit();
});

$(document).ready(function(){
    $('.slot-badge').on('click', function(){
        var date = $(this).data('date');
        var slot = $(this).data('slot');
        var debugInfo = $(this).data('debug');
        var names = $(this).data('names');

        console.log('Clicked slot debug info:', debugInfo);
        console.log('Names from PHP:', names);

        // Show loading
        $('#bookingDetailsModalLabel').text('Loading booking details...');
        $('#bookingDetailsModalBody').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        $('#bookingDetailsModal').modal('show');

        // Fetch detailed booking information with contact numbers
        $.ajax({
            url: '/api/staff/booking-details',
            method: 'GET',
            data: {
                date: date,
                slot: slot,
                branch_id: $('#branch_id').val()
            },
            success: function(response) {
                console.log('API Response:', response);
                console.log('Date:', date, 'Slot:', slot, 'Branch ID:', $('#branch_id').val());
                displayBookingDetails(response, date, slot);
            },
            error: function(xhr, status, error) {
                console.error('API Error:', xhr.responseText);
                $('#bookingDetailsModalBody').html('<div class="alert alert-danger">Error loading booking details. Please try again.</div>');
            }
        });
    });

    // Function to display booking details with contact info and actions
    function displayBookingDetails(bookings, date, slot) {
        console.log('Displaying booking details:', {
            bookings: bookings,
            date: date,
            slot: slot,
            bookingCount: bookings ? bookings.length : 0
        });

        var dateObj = new Date(date);
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        var formattedDate = dateObj.toLocaleDateString('en-US', options);

        var slotParts = slot.split('-');
        function formatTime(t) {
            var parts = t.split(':');
            var hour = parseInt(parts[0]);
            var min = parts[1];
            var ampm = hour >= 12 ? 'pm' : 'am';
            hour = hour % 12 || 12;
            return hour + ':' + min + ampm;
        }
        var formattedTime = formatTime(slotParts[0]) + ' to ' + formatTime(slotParts[1]);

        $('#bookingDetailsModalLabel').text('Booking Details - ' + formattedDate + ' at ' + formattedTime);

        var html = `
            <div class="booking-summary mb-4">
                <h6 style="color: #F56289; font-weight: bold;">📅 ${formattedDate} | 🕐 ${formattedTime}</h6>
            </div>
        `;

        if (bookings && bookings.length > 0) {
            html += '<div class="bookings-list">';

            bookings.forEach(function(booking, index) {
                // Status styling
                var statusInfo = getStatusInfo(booking.status);

                html += `
                    <div class="booking-card mb-3" style="border: 2px solid #ffe4ec; border-radius: 12px; padding: 20px; background: #fff;">
                        <div class="row">
                            <div class="col-md-7">
                                <h6 style="color: #F56289; margin-bottom: 15px;">
                                    ${statusInfo.icon} Booking #${booking.id}
                                    <span class="badge" style="background: ${statusInfo.color}; color: ${statusInfo.textColor}; font-size: 0.8em;">
                                        ${statusInfo.label}
                                    </span>
                                </h6>

                                <div class="booking-info">
                                    <p><strong>👤 Customer:</strong> ${booking.customer_name || 'Walk-in Customer'}</p>

                                    <div class="contact-info mb-2">
                                        <p><strong>� Email:</strong>
                                            ${booking.email !== 'Not provided' ?
                                                `<a href="mailto:${booking.email}" style="color: #F56289; text-decoration: none;">${booking.email}</a>` :
                                                '<span class="text-muted">Not provided</span>'
                                            }
                                        </p>
                                        <p><strong>📞 Phone:</strong>
                                            ${booking.phone !== 'Not provided' ?
                                                `<a href="tel:${booking.phone}" style="color: #F56289; text-decoration: none;">${booking.phone}</a>` :
                                                '<span class="text-muted">Not provided</span>'
                                            }
                                        </p>
                                    </div>

                                    <p><strong>💅 Service:</strong> ${booking.service_name}</p>
                                    ${booking.package_services ? `<p><strong>📦 Package includes:</strong> ${booking.package_services}</p>` : ''}
                                    <p><strong>💰 Price:</strong> ₱${booking.price || 'TBD'}</p>
                                    <p><strong>🕐 Booked:</strong> ${booking.created_at}</p>
                                </div>
                            </div>

                            <div class="col-md-5 text-center">
                                ${getActionButtons(booking)}
                            </div>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
        } else {
            html += '<div class="text-center" style="color: #6c757d; padding: 40px;"><i class="fa fa-calendar-o fa-3x mb-3"></i><p>No bookings for this time slot.</p></div>';
        }

        $('#bookingDetailsModalBody').html(html);

        // Attach event handlers for the action buttons
        attachActionHandlers();
    }

    // Helper function to get status information
    function getStatusInfo(status) {
        switch(status.toLowerCase()) {
            case 'pending':
                return {
                    icon: '⏳',
                    label: 'PENDING',
                    color: '#ffc107',
                    textColor: '#000'
                };
            case 'active':
            case 'confirmed':
                return {
                    icon: '✅',
                    label: 'CONFIRMED',
                    color: '#28a745',
                    textColor: '#fff'
                };
            case 'cancelled':
            case 'rejected':
                return {
                    icon: '❌',
                    label: 'CANCELLED',
                    color: '#dc3545',
                    textColor: '#fff'
                };
            case 'completed':
                return {
                    icon: '🎉',
                    label: 'COMPLETED',
                    color: '#6f42c1',
                    textColor: '#fff'
                };
            default:
                return {
                    icon: '❓',
                    label: status.toUpperCase(),
                    color: '#6c757d',
                    textColor: '#fff'
                };
        }
    }

    // Helper function to generate action buttons based on booking status
    function getActionButtons(booking) {
        var contactButtons = `
            <div class="contact-buttons mb-3">
                ${booking.email !== 'Not provided' ?
                    `<button class="btn btn-info btn-sm mb-1 email-customer-btn"
                            data-email="${booking.email}"
                            style="background: #17a2b8; border: none; border-radius: 6px; width: 100%;">
                        📧 Send Email
                    </button>` : ''}

                ${booking.phone !== 'Not provided' ?
                    `<button class="btn btn-warning btn-sm call-customer-btn"
                            data-phone="${booking.phone}"
                            style="background: #ffc107; border: none; border-radius: 6px; color: #000; width: 100%;">
                        📞 Call Customer
                    </button>` : ''}
            </div>
        `;

        switch(booking.status.toLowerCase()) {
            case 'pending':
                return `
                    <div class="action-buttons">
                        <p style="color: #F56289; font-weight: bold; margin-bottom: 15px;">⏳ Awaiting Decision</p>

                        <button class="btn btn-success btn-block mb-2 confirm-booking-btn"
                                data-booking-id="${booking.id}"
                                style="background: #28a745; border: none; border-radius: 8px; font-weight: 600;">
                            ✅ Confirm Booking
                        </button>

                        <button class="btn btn-danger btn-block mb-3 reject-booking-btn"
                                data-booking-id="${booking.id}"
                                style="background: #dc3545; border: none; border-radius: 8px; font-weight: 600;">
                            ❌ Reject Booking
                        </button>

                        ${contactButtons}
                    </div>
                `;

            case 'active':
            case 'confirmed':
                return `
                    <div class="confirmed-status">
                        <p style="color: #28a745; font-weight: bold; margin-bottom: 15px;">✅ Confirmed</p>

                        <button class="btn btn-secondary btn-block mb-3 cancel-booking-btn"
                                data-booking-id="${booking.id}"
                                style="background: #6c757d; border: none; border-radius: 8px; font-weight: 600;">
                            🚫 Cancel Booking
                        </button>

                        ${contactButtons}
                    </div>
                `;

            case 'cancelled':
            case 'rejected':
                return `
                    <div class="cancelled-status">
                        <p style="color: #dc3545; font-weight: bold; margin-bottom: 15px;">❌ Cancelled</p>
                        <small class="text-muted">No actions available</small>
                    </div>
                `;

            case 'completed':
                return `
                    <div class="completed-status">
                        <p style="color: #6f42c1; font-weight: bold; margin-bottom: 15px;">🎉 Completed</p>

                        ${contactButtons}
                    </div>
                `;

            default:
                return `
                    <div class="unknown-status">
                        <p style="color: #6c757d; font-weight: bold;">❓ ${booking.status}</p>

                        ${contactButtons}
                    </div>
                `;
        }
    }

    // Function to handle booking confirmation/rejection actions
    function attachActionHandlers() {
        // Confirm booking
        $('.confirm-booking-btn').on('click', function() {
            var bookingId = $(this).data('booking-id');
            var button = $(this);

            button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Confirming...');

            $.ajax({
                url: '/api/staff/confirm-booking/' + bookingId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        button.closest('.booking-card').find('.action-buttons').html(`
                            <div class="confirmed-status">
                                <p style="color: #28a745; font-weight: bold; margin-bottom: 15px;">✅ Confirmed Successfully!</p>
                                <div class="contact-buttons">
                                    <button class="btn btn-warning btn-sm call-customer-btn"
                                            data-phone="${button.closest('.booking-card').find('[data-phone]').data('phone')}"
                                            style="background: #ffc107; border: none; border-radius: 6px; color: #000; width: 100%;">
                                        📞 Call Customer
                                    </button>
                                </div>
                            </div>
                        `);
                        showSuccessMessage('Booking confirmed successfully!');
                        refreshCalendar();
                    }
                },
                error: function() {
                    button.prop('disabled', false).html('✅ Confirm Booking');
                    showErrorMessage('Error confirming booking. Please try again.');
                }
            });
        });

        // Reject booking
        $('.reject-booking-btn').on('click', function() {
            var bookingId = $(this).data('booking-id');
            var button = $(this);

            if (confirm('Are you sure you want to reject this booking? This action cannot be undone.')) {
                button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Rejecting...');

                $.ajax({
                    url: '/api/staff/reject-booking/' + bookingId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            button.closest('.booking-card').fadeOut(500, function() {
                                $(this).remove();
                            });
                            showSuccessMessage('Booking rejected successfully.');
                            refreshCalendar();
                        }
                    },
                    error: function() {
                        button.prop('disabled', false).html('❌ Reject Booking');
                        showErrorMessage('Error rejecting booking. Please try again.');
                    }
                });
            }
        });

        // Cancel booking (for confirmed bookings)
        $('.cancel-booking-btn').on('click', function() {
            var bookingId = $(this).data('booking-id');
            var button = $(this);

            if (confirm('Are you sure you want to cancel this confirmed booking? The customer will be notified.')) {
                button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Cancelling...');

                $.ajax({
                    url: '/api/staff/reject-booking/' + bookingId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            button.closest('.booking-card').find('.confirmed-status').html(`
                                <div class="cancelled-status">
                                    <p style="color: #dc3545; font-weight: bold;">❌ Cancelled</p>
                                    <small class="text-muted">Booking has been cancelled</small>
                                </div>
                            `);
                            showSuccessMessage('Booking cancelled successfully.');
                            refreshCalendar();
                        }
                    },
                    error: function() {
                        button.prop('disabled', false).html('🚫 Cancel Booking');
                        showErrorMessage('Error cancelling booking. Please try again.');
                    }
                });
            }
        });

        // Call customer
        $('.call-customer-btn').on('click', function() {
            var phone = $(this).data('phone');
            if (phone && phone !== 'Not provided') {
                window.open('tel:' + phone);
            } else {
                alert('No phone number available for this customer.');
            }
        });

        // Email customer
        $('.email-customer-btn').on('click', function() {
            var email = $(this).data('email');
            if (email && email !== 'Not provided') {
                window.open('mailto:' + email + '?subject=Skin911 Appointment Update&body=Dear Customer,%0A%0ARegarding your appointment with Skin911...%0A%0ABest regards,%0ASkin911 Team');
            } else {
                alert('No email address available for this customer.');
            }
        });
    }

    // Helper functions
    function showSuccessMessage(message) {
        var alert = $('<div class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">' + message + '</div>');
        $('body').append(alert);
        setTimeout(function() { alert.fadeOut(); }, 3000);
    }

    function showErrorMessage(message) {
        var alert = $('<div class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">' + message + '</div>');
        $('body').append(alert);
        setTimeout(function() { alert.fadeOut(); }, 3000);
    }

    function refreshCalendar() {
        setTimeout(function() {
            location.reload();
        }, 2000);
    }
});
</script>
<script>
// Refresh staff calendar when a booking is rescheduled elsewhere
window.addEventListener('booking:rescheduled', function(e){
    try {
        var bid = e.detail && e.detail.branch_id ? String(e.detail.branch_id) : null;
        var current = document.getElementById('branch_id').value;
        // if branch matches current filter (or no filter), reload to reflect changes
        if (!bid || !current || bid === current) {
            location.reload();
        }
    } catch(e) { console.warn('booking:rescheduled handler error', e); }
});
// Refresh staff calendar when a booking is created elsewhere
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
<style>
.calendar-responsive { max-width: 100vw; }
.calendar-responsive .row { flex-wrap: nowrap; }
.calendar-responsive .col, .calendar-responsive .col-2 { min-width: 100px !important; }
.calendar-day { font-weight: bold; color: #F56289; }
.calendar-date { color: #F56289; }
.calendar-timeslot-label { background: #fff; color: #F56289; font-weight: 600; border-radius: 8px; }
.badge.bg-pink { background: #F56289; color: #fff; }
.badge.bg-danger { background: #ffb6c1; color: #e75480; }

/* Enhanced Booking Details Modal Styling */
#bookingDetailsModal .modal-content {
    background: linear-gradient(135deg, #fff 60%, #ffe4ec 100%);
    border-radius: 16px;
    border: 2px solid #F56289;
    box-shadow: 0 8px 32px rgba(231,84,128,0.2);
}

#bookingDetailsModal .modal-header {
    background: #F56289;
    color: #fff;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    border-bottom: none;
    padding: 20px 30px;
}

#bookingDetailsModal .modal-title {
    color: #fff;
    font-weight: bold;
    font-size: 1.3rem;
}

#bookingDetailsModal .close {
    color: #fff;
    opacity: 1;
    font-size: 1.8rem;
    font-weight: 300;
}

#bookingDetailsModal .modal-body {
    background: #fff;
    padding: 30px;
    max-height: 70vh;
    overflow-y: auto;
}

#bookingDetailsModal .modal-footer {
    background: #fff;
    border-top: 1px solid #ffe4ec;
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
    padding: 20px 30px;
}

/* Booking Card Styles */
.booking-card {
    transition: all 0.3s ease;
}

.booking-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(231,84,128,0.15);
}

.booking-info p {
    margin-bottom: 8px;
    color: #495057;
}

.booking-info strong {
    color: #F56289;
}

/* Action Button Styles */
.action-buttons button {
    font-weight: 600;
    padding: 10px 15px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.action-buttons button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Success/Error Message Styles */
.alert {
    border-radius: 8px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    #bookingDetailsModal .modal-dialog {
        margin: 10px;
        max-width: calc(100% - 20px);
    }

    .booking-card .row {
        flex-direction: column;
    }

    .booking-card .col-md-4 {
        margin-top: 15px;
    }
}
</style>

@endsection
