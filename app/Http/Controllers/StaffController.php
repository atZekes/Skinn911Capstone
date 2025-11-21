<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\ChatMessage;
use \App\Events\MessageSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingReminder;
use App\Mail\BookingRefundConfirmed;
use App\Mail\BookingReschedule;
use Pusher\Pusher;

class StaffController extends Controller
{
    public function submitInteract(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'interaction_type' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        // You can save to database here if needed
        return redirect()->route('staff.interact')->with('success', 'Interaction recorded successfully.');
    }
    public function interact()
    {
        // Get the current staff user's branch
        $staffUser = auth('staff')->user();
        $staffBranchId = $staffUser->branch_id ?? null;

        // Get customers who have sent chat messages to this specific branch
        $customersQuery = User::whereHas('chatMessages', function($query) use ($staffBranchId) {
            $query->where('sender_type', 'client');
            if ($staffBranchId) {
                $query->where('branch_id', $staffBranchId);
            }
        });

        $customers = $customersQuery
            ->withCount(['chatMessages as messages_count' => function($query) use ($staffBranchId) {
                if ($staffBranchId) {
                    $query->where('branch_id', $staffBranchId);
                }
            }])
            ->withCount(['chatMessages as unread_count' => function($query) use ($staffBranchId) {
                $query->where('is_read', false)
                      ->where('sender_type', 'client');
                if ($staffBranchId) {
                    $query->where('branch_id', $staffBranchId);
                }
            }])
            ->with(['chatMessages' => function($query) use ($staffBranchId) {
                $query->latest();
                if ($staffBranchId) {
                    $query->where('branch_id', $staffBranchId);
                }
                $query->limit(1);
            }])
            ->get()
            ->map(function($customer) {
                $customer->last_message_at = $customer->chatMessages->first()?->created_at;
                return $customer;
            })
            ->sortByDesc('last_message_at');

        return view('Staff.staffinteract', compact('customers'));
    }

    public function getCustomerMessages($customerId)
    {
        // Get the current staff user's branch
        $staffUser = auth('staff')->user();
        $staffBranchId = $staffUser->branch_id ?? null;

        // Mark messages as read for this branch only
        $markReadQuery = ChatMessage::where('user_id', $customerId)
                               ->where('sender_type', 'client')
                               ->where('is_read', false);

        if ($staffBranchId) {
            $markReadQuery->where('branch_id', $staffBranchId);
        }

        $markReadQuery->update(['is_read' => true]);

        // Get all chat messages for this customer from this branch
        $messagesQuery = ChatMessage::where('user_id', $customerId);

        if ($staffBranchId) {
            $messagesQuery->where('branch_id', $staffBranchId);
        }

        $messages = $messagesQuery->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    public function sendReply(Request $request)
    {
        // Add debugging
        \Illuminate\Support\Facades\Log::info('SendReply called', [
            'customer_id' => $request->customer_id,
            'message' => $request->message,
            'staff_user' => auth('staff')->user() ? auth('staff')->user()->id : 'not authenticated'
        ]);

        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' // Max 5MB
        ]);

        // Require either message or image
        if (!$request->message && !$request->hasFile('image')) {
            return response()->json([
                'success' => false,
                'message' => 'Either message text or image is required'
            ], 422);
        }

        try {
            $staffUser = auth('staff')->user();
            if (!$staffUser) {
                // Also check regular auth to see if any user is logged in
                $regularUser = auth('web')->user();
                \Illuminate\Support\Facades\Log::error('SendReply: Staff user not authenticated', [
                    'staff_guard_user' => null,
                    'regular_guard_user' => $regularUser ? $regularUser->id . ' (' . $regularUser->role . ')' : null,
                    'session_data' => session()->all()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Not authenticated as staff. Please log in as staff first.',
                    'debug' => [
                        'staff_user' => null,
                        'regular_user' => $regularUser ? $regularUser->role : 'none'
                    ]
                ]);
            }

            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('chat_images', $imageName, 'public');
            }

            // Create message in ChatMessage table (new real-time chat system)
            $chatMessage = ChatMessage::create([
                'user_id' => $request->customer_id,
                'staff_id' => $staffUser->id,
                'sender_type' => 'staff',
                'branch_id' => $staffUser->branch_id ?? null,
                'message' => $request->message,
                'image' => $imagePath,
                'is_read' => true
            ]);

            // Load relationships for broadcasting
            $chatMessage->load(['user', 'staff', 'branch']);

            // Broadcast via Pusher for real-time updates
            broadcast(new MessageSent($chatMessage))->toOthers();

            \Illuminate\Support\Facades\Log::info('SendReply: Message created and broadcasted successfully', [
                'message_id' => $chatMessage->id,
                'branch_id' => $chatMessage->branch_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully',
                'data' => $chatMessage,
                'sent_at' => $chatMessage->created_at->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('SendReply error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to send reply: ' . $e->getMessage()]);
        }
    }

    // Staff add booking
    // NOTE: Staff bookings bypass the advance booking restrictions that apply to client bookings.
    // Staff can create bookings for any date (past, present, or future) as needed.
    public function addBooking(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'walkin_name' => 'required_without:user_id|string|max:255',
            'branch_id' => 'nullable|exists:branches,id',
            'service_id' => 'nullable|exists:services,id|required_without:package_id',
            'package_id' => 'nullable|exists:packages,id|required_without:service_id',
            'date' => 'required|date', // No advance booking restriction for staff
            'time_slot' => 'required|string',
        ]);

            // determine branch to check availability (staff may only book for their assigned branch)
            $staffUser = auth('staff')->user();
            $branchId = $request->branch_id ?? ($staffUser->branch_id ?? null);
            // If the logged-in staff has an assigned branch, enforce it server-side.
            if ($staffUser && !empty($staffUser->branch_id)) {
                // override any provided branch_id and ensure the booking uses staff's branch
                if ($request->filled('branch_id') && $request->branch_id != $staffUser->branch_id) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'You are not permitted to create bookings for other branches.'], 403);
                    }
                    return back()->withErrors(['branch_id' => 'You are not permitted to create bookings for other branches.'])->withInput();
                }
                $branchId = $staffUser->branch_id;
            }

            // ensure we have a branch_id because the bookings.branch_id column is NOT NULL
            if (! $branchId) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Branch is required to create a booking. Please select a branch.'], 422);
                }
                return back()->withErrors(['branch_id' => 'Branch is required to create a booking.'])->withInput();
            }

            // Validate that the service/package is active and available for the selected branch
            $service = null;
            $package = null;

            if ($request->filled('service_id')) {
                $service = \App\Models\Service::find($request->service_id);
                if (!$service) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Selected service not found.'], 422);
                    }
                    return back()->withErrors(['service_id' => 'Selected service not found.'])->withInput();
                }

                // Check if service is globally active (if active column exists)
                if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'active') && !$service->active) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Selected service is not currently available.'], 422);
                    }
                    return back()->withErrors(['service_id' => 'Selected service is not currently available.'])->withInput();
                }

                // Check if service is active for the specific branch
                $branch = \App\Models\Branch::find($branchId);
                if ($branch) {
                    try {
                        $branchService = $branch->services()->where('services.id', $service->id)->first();
                        if (!$branchService) {
                            if ($request->ajax()) {
                                return response()->json(['success' => false, 'message' => 'Selected service is not available for this branch.'], 422);
                            }
                            return back()->withErrors(['service_id' => 'Selected service is not available for this branch.'])->withInput();
                        }

                        // Check branch-specific active status (pivot table)
                        if (isset($branchService->pivot) && isset($branchService->pivot->active) && !$branchService->pivot->active) {
                            if ($request->ajax()) {
                                return response()->json(['success' => false, 'message' => 'Selected service has been disabled for this branch.'], 422);
                            }
                            return back()->withErrors(['service_id' => 'Selected service has been disabled for this branch.'])->withInput();
                        }
                    } catch (\Exception $e) {
                        // If there's an error checking branch services, allow the booking to proceed
                        // This maintains backward compatibility
                    }
                }
            } elseif ($request->filled('package_id')) {
                $package = \App\Models\Package::with('services')->find($request->package_id);
                if (!$package) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Selected package not found.'], 422);
                    }
                    return back()->withErrors(['package_id' => 'Selected package not found.'])->withInput();
                }

                // Ensure package belongs to branch or is global
                if ($package->branch_id && $package->branch_id != $branchId) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Selected package is not available for this branch.'], 422);
                    }
                    return back()->withErrors(['package_id' => 'Selected package is not available for this branch.'])->withInput();
                }
            }

            // server-side availability check to prevent double-booking for the same branch/date/time_slot
            $conflictQuery = \App\Models\Booking::where('date', $request->date)
                ->where('time_slot', $request->time_slot)
                ->where('status', 'active');
            if ($branchId) {
                $conflictQuery->where('branch_id', $branchId);
            }
            // Enforce branch break times: reject when slot overlaps break
            $branch = \App\Models\Branch::find($branchId);

            // Check if branch is active
            if ($branch && !$branch->active) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'The selected branch is currently unavailable for bookings. Please choose another branch.'], 422);
                }
                return back()->withErrors(['branch_id' => 'The selected branch is currently unavailable for bookings.'])->withInput();
            }

            // Check if the booking date falls on an operating day
            if ($branch && !empty($branch->operating_days)) {
                $bookingDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->date);
                $bookingDayOfWeek = $bookingDate->format('l'); // Get full day name (e.g., 'Monday')
                $operatingDays = explode(',', $branch->operating_days);

                if (!in_array($bookingDayOfWeek, $operatingDays)) {
                    $operatingDaysFormatted = implode(', ', $operatingDays);
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => "The selected branch is closed on {$bookingDayOfWeek}s. Operating days: {$operatingDaysFormatted}."], 422);
                    }
                    return back()->withErrors([
                        'date' => "The selected branch is closed on {$bookingDayOfWeek}s. Operating days: {$operatingDaysFormatted}."
                    ])->withInput();
                }
            }

            if ($branch && $branch->break_start && $branch->break_end) {
                try {
                        [$slotStartStr, $slotEndStr] = explode('-', $request->time_slot, 2);
                        // use parse() to accept both H:i and H:i:s stored values
                        $slotStart = \Carbon\Carbon::parse(trim($slotStartStr));
                        $slotEnd = \Carbon\Carbon::parse(trim($slotEndStr));
                        $breakStart = \Carbon\Carbon::parse($branch->break_start);
                        $breakEnd = \Carbon\Carbon::parse($branch->break_end);
                    if ($slotStart->lt($breakEnd) && $slotEnd->gt($breakStart)) {
                        if ($request->ajax()) {
                            return response()->json(['success' => false, 'message' => 'Selected time falls within branch break time. Please choose another slot.'], 422);
                        }
                        return back()->withErrors(['time_slot' => 'Selected time falls within branch break time.'])->withInput();
                    }
                } catch (\Exception $e) {
                    // ignore parsing errors
                }
            }

            // Determine service duration (hours) and compute required consecutive slots
            $totalDuration = 1;
            $svc = null;
            if ($request->filled('service_id')) {
                $svc = \App\Models\Service::find($request->service_id);
                if ($svc) {
                    // prefer branch-specific pivot duration if available
                    try {
                        if ($branch) {
                            $bsvc = $branch->services()->where('services.id', $svc->id)->first();
                            if ($bsvc && isset($bsvc->pivot) && isset($bsvc->pivot->duration) && $bsvc->pivot->duration) {
                                $totalDuration = (int)$bsvc->pivot->duration;
                            } else {
                                $totalDuration = $svc->duration ?? 1;
                            }
                        } else {
                            $totalDuration = $svc->duration ?? 1;
                        }
                    } catch (\Exception $e) {
                        $totalDuration = $svc->duration ?? 1;
                    }
                }
            }
            $requiredSlots = [$request->time_slot];
            if ($totalDuration > 1) {
                try {
                    [$startStr, $endStr] = explode('-', $request->time_slot, 2);
                    $start = \Carbon\Carbon::parse(trim($startStr));
                    for ($i = 1; $i < $totalDuration; $i++) {
                        $s = $start->copy()->addHours($i);
                        $e = $s->copy()->addHour();
                        $requiredSlots[] = $s->format('H:i') . '-' . $e->format('H:i');
                        // also ensure these subsequent slots don't overlap break
                        if ($branch && $branch->break_start && $branch->break_end) {
                            $breakStart = \Carbon\Carbon::parse($branch->break_start);
                            $breakEnd = \Carbon\Carbon::parse($branch->break_end);
                            if ($s->lt($breakEnd) && $e->gt($breakStart)) {
                                if ($request->ajax()) {
                                    return response()->json(['success' => false, 'message' => 'Selected time overlaps branch break. Please choose another slot.'], 422);
                                }
                                return back()->withErrors(['time_slot' => 'Selected time overlaps branch break.'])->withInput();
                            }
                        }
                    }
                } catch (\Exception $e) { /* ignore and fallback to single slot */ }
            }

            // Ensure required slots fit within branch operating slots
            if ($branch) {
                $branchSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
                if ($branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
                    try {
                        [$bs,$be] = explode(' - ', $branch->time_slot, 2);
                        $startRange = \Carbon\Carbon::createFromFormat('H:i', $bs);
                        $endRange = \Carbon\Carbon::createFromFormat('H:i', $be);
                        $branchSlots = [];
                        for ($t = $startRange->copy(); $t->lt($endRange); $t->addHour()) {
                            $slotStart = $t->format('H:i');
                            $slotEnd = $t->copy()->addHour()->format('H:i');
                            if (\Carbon\Carbon::createFromFormat('H:i', $slotEnd)->lte($endRange)) {
                                $branchSlots[] = $slotStart . '-' . $slotEnd;
                            }
                        }
                    } catch (\Exception $e) { }
                }
                foreach ($requiredSlots as $rs) {
                    if (! in_array($rs, $branchSlots)) {
                        if ($request->ajax()) {
                            return response()->json(['success' => false, 'message' => 'Selected start time cannot fit the full service duration within branch operating hours.'], 422);
                        }
                        return back()->withErrors(['time_slot' => 'Selected start time cannot fit the full service duration within branch operating hours.'])->withInput();
                    }
                }
            }

            // Use branch slot_capacity when determining fullness for each required slot
            $max = $branch->slot_capacity ?? null;
            if ($max) {
                foreach ($requiredSlots as $slot) {
                    $count = \App\Models\Booking::where('date', $request->date)
                        ->where('time_slot', $slot)
                        ->where('branch_id', $branchId)
                        ->where('status', 'active')
                        ->count();
                    if ($count >= $max) {
                        // Slot is full - prevent booking
                        if ($request->ajax()) {
                            return response()->json(['success' => false, 'message' => 'The selected time slot is already full. Please choose another time.'], 422);
                        }
                        return back()->withErrors(['time_slot' => 'The selected time slot is already full. Please choose another time.'])->withInput();
                    }
                }
            }

            // Skip conflict validation for walk-in bookings - frontend handles availability

            $isWalkin = $request->user_id ? false : true;
            $booking = \App\Models\Booking::create([
            'user_id' => $request->user_id ?? null,
            'service_id' => $request->service_id ?? null,
            'package_id' => $request->package_id ?? null,
            'branch_id' => $branchId,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'status' => 'active',
            'is_walkin' => $isWalkin,
            'walkin_name' => isset($request->walkin_name) ? trim($request->walkin_name) ?: null : null,
            'walkin_phone' => $request->walkin_phone ?? null,
            'payment_method' => $request->walkin_payment_method ?? null,
        ]);

        // Create PurchasedService records for the booking
        if ($request->filled('package_id')) {
            // Package booking - create PurchasedService for each service in the package
            $pkg = \App\Models\Package::with('services')->find($request->package_id);
            if ($pkg) {
                foreach ($pkg->services as $svc) {
                    \App\Models\PurchasedService::create([
                        'user_id' => $booking->user_id,
                        'service_id' => $svc->id,
                        'booking_id' => $booking->id,
                        'price' => $svc->price ?? 0,
                        'description' => $svc->description ?? '',
                    ]);
                }
            }
        } elseif ($request->filled('service_id')) {
            // Single service booking
            $service = \App\Models\Service::find($request->service_id);
            if ($service) {
                \App\Models\PurchasedService::create([
                    'user_id' => $booking->user_id,
                    'service_id' => $service->id,
                    'booking_id' => $booking->id,
                    'price' => $service->price ?? 0,
                    'description' => $service->description ?? '',
                ]);
            }
        }

        // If booking was created as paid (e.g., staff recorded payment at creation time)
        try {
            if ($booking->payment_status === 'paid') {
                $booking->ensurePackageSessionsExist();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Staff.createBooking ensurePackageSessionsExist failed', ['booking_id' => $booking->id, 'err' => $e->getMessage()]);
        }

        if ($request->ajax()) {
            // Use the same totalDuration that was calculated earlier for the booking logic
            // (already includes branch-specific pivot duration overrides)

            return response()->json([
                'message' => 'Successfully booked!',
                'booking' => [
                    'id' => $booking->id,
                    'user_name' => $booking->user ? $booking->user->name : ($request->walkin_name ?? 'Walk-in'),
                    'service_name' => $booking->service ? $booking->service->name : ($booking->package ? $booking->package->name : '-'),
                    'date' => $booking->date,
                    'time_slot' => $booking->time_slot,
                    'status' => ucfirst($booking->status),
                    'is_walkin' => $booking->is_walkin,
                    'walkin_name' => $booking->walkin_name ?? $request->walkin_name ?? null,
                    'cancel_url' => route('staff.cancelAppointment', $booking->id),
                    'csrf_token' => csrf_token(),
                    'duration' => $totalDuration,
                ],
                // authoritative list of required hourly slots this booking occupies
                'required_slots' => $requiredSlots,
                'branch_id' => $branchId,
            ]);
        }
        return redirect()->route('staff.appointments')->with('success', 'Booking added successfully.');
    }

    // Staff reschedule booking
    public function rescheduleBooking(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time_slot' => 'required|string',
        ]);
        $booking = \App\Models\Booking::findOrFail($id);
        // Debug: log reschedule attempts and branch break values to help diagnose missing DB columns/migrations
        try {
            $branchForLog = null;
            if ($booking->branch_id) {
                $branchForLog = \App\Models\Branch::find($booking->branch_id);
            }
            \Illuminate\Support\Facades\Log::info('reschedule:attempt', [
                'booking_id' => $booking->id,
                'requested_time_slot' => $request->time_slot,
                'branch_id' => $booking->branch_id,
                'branch_break_start' => $branchForLog ? ($branchForLog->break_start ?? null) : null,
                'branch_break_end' => $branchForLog ? ($branchForLog->break_end ?? null) : null,
            ]);
    } catch (\Exception $e) { \Illuminate\Support\Facades\Log::warning('reschedule:log_failed', ['error' => $e->getMessage()]); }
        // ensure branch break and capacity rules are respected when rescheduling
        $branchId = $booking->branch_id;
        $branch = \App\Models\Branch::find($branchId);
        if ($branch && $branch->break_start && $branch->break_end) {
            try {
                [$slotStartStr, $slotEndStr] = explode('-', $request->time_slot, 2);
                $slotStart = \Carbon\Carbon::parse(trim($slotStartStr));
                $slotEnd = \Carbon\Carbon::parse(trim($slotEndStr));
                $breakStart = \Carbon\Carbon::parse($branch->break_start);
                $breakEnd = \Carbon\Carbon::parse($branch->break_end);
                if ($slotStart->lt($breakEnd) && $slotEnd->gt($breakStart)) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Selected time falls within branch break time. Please choose another slot.'], 422);
                    }
                    return back()->withErrors(['time_slot' => 'Selected time falls within branch break time.'])->withInput();
                }
            } catch (\Exception $e) {
                // parsing errors ignored
            }
        }
        // check per-slot capacity
        $max = $branch->slot_capacity ?? null;
        // Determine duration for this booking (service or package) and check required slots
        $totalDuration = 1;
        if ($booking->service_id) {
            $svc = \App\Models\Service::find($booking->service_id);
            if ($svc) {
                try {
                    if ($branch) {
                        $bsvc = $branch->services()->where('services.id', $svc->id)->first();
                        if ($bsvc && isset($bsvc->pivot) && isset($bsvc->pivot->duration) && $bsvc->pivot->duration) {
                            $totalDuration = (int)$bsvc->pivot->duration;
                        } else {
                            $totalDuration = $svc->duration ?? 1;
                        }
                    } else {
                        $totalDuration = $svc->duration ?? 1;
                    }
                } catch (\Exception $e) {
                    $totalDuration = $svc->duration ?? 1;
                }
            }
        } elseif ($booking->package_id) {
            $pkg = \App\Models\Package::with('services')->find($booking->package_id);
            if ($pkg) {
                // Use the package's duration attribute which considers admin-configured durations
                $totalDuration = $pkg->duration ?: 1;
            }
        }
        $requiredSlots = [$request->time_slot];
        if ($totalDuration > 1) {
            try {
                [$startStr, $endStr] = explode('-', $request->time_slot, 2);
                $start = \Carbon\Carbon::parse(trim($startStr));
                for ($i = 1; $i < $totalDuration; $i++) {
                    $s = $start->copy()->addHours($i);
                    $e = $s->copy()->addHour();
                    $requiredSlots[] = $s->format('H:i') . '-' . $e->format('H:i');
                    // check break overlap
                    if ($branch && $branch->break_start && $branch->break_end) {
                        $bs = \Carbon\Carbon::parse($branch->break_start);
                        $be = \Carbon\Carbon::parse($branch->break_end);
                        if ($s->lt($be) && $e->gt($bs)) {
                            if ($request->ajax()) {
                                return response()->json(['success' => false, 'message' => 'Selected time overlaps branch break. Please choose another slot.'], 422);
                            }
                            return back()->withErrors(['time_slot' => 'Selected time overlaps branch break.'])->withInput();
                        }
                    }
                }
            } catch (\Exception $e) { }
        }

        // Ensure rescheduled required slots fit within branch operating slots (no overflow)
        if ($branch) {
            $branchSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
            if ($branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
                try {
                    [$bs,$be] = explode(' - ', $branch->time_slot, 2);
                    $startRange = \Carbon\Carbon::createFromFormat('H:i', $bs);
                    $endRange = \Carbon\Carbon::createFromFormat('H:i', $be);
                    $branchSlots = [];
                    for ($t = $startRange->copy(); $t->lt($endRange); $t->addHour()) {
                        $slotStart = $t->format('H:i');
                        $slotEnd = $t->copy()->addHour()->format('H:i');
                        if (\Carbon\Carbon::createFromFormat('H:i', $slotEnd)->lte($endRange)) {
                            $branchSlots[] = $slotStart . '-' . $slotEnd;
                        }
                    }
                } catch (\Exception $e) { }
            }
            foreach ($requiredSlots as $rs) {
                if (! in_array($rs, $branchSlots)) {
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Selected start time cannot fit the full service duration within branch operating hours.'], 422);
                    }
                    return back()->withErrors(['time_slot' => 'Selected start time cannot fit the full service duration within branch operating hours.'])->withInput();
                }
            }
        }

        if ($max) {
            foreach ($requiredSlots as $slot) {
                $count = \App\Models\Booking::where('branch_id', $branchId)
                    ->where('date', $request->date)
                    ->where('time_slot', $slot)
                    ->where('status', 'active')
                    ->count();
                if ($count >= $max) {
                    // Slot is full - skip validation, frontend should handle this
                    continue;
                }
            }
        }

        $booking->date = $request->date;
        $booking->time_slot = $request->time_slot;
        $booking->save();

        // Send reschedule confirmation email
        try {
            Mail::to($booking->user->email)->send(new BookingReschedule($booking));
        } catch (\Exception $e) {
            Log::error('Failed to send booking reschedule email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            // Don't fail the reschedule if email fails
        }

        // Send notification to client if registered user
        if ($booking->user_id) {
            $this->sendPushNotification(
                $booking->user_id,
                'Booking Rescheduled by Staff',
                'Your booking has been rescheduled by staff to ' . \Carbon\Carbon::parse($booking->date)->format('M d, Y') . ' at ' . $booking->time_slot,
                'info',
                $booking->id
            );
        }

    if ($request->ajax()) {
            $userName = $booking->user ? $booking->user->name : ($booking->walkin_name ?? 'Walk-in');
            $serviceName = null;
            if ($booking->service) {
                $serviceName = $booking->service->name;
            } elseif ($booking->package) {
                $serviceName = $booking->package->name ?? '-';
            } else {
                $serviceName = '-';
            }
        return response()->json([
                'message' => 'Successfully rescheduled!',
                'booking' => [
                    'id' => $booking->id,
                    'user_name' => $userName,
                    'service_name' => $serviceName,
                    'date' => $booking->date,
                    'time_slot' => $booking->time_slot,
                    'branch_id' => $booking->branch_id,
                    'status' => ucfirst($booking->status),
                ],
                'required_slots' => $requiredSlots,
            ]);
        }
        return redirect()->route('staff.appointments')->with('success', 'Booking rescheduled successfully.');
    }

    public function confirmPayment($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);

        // If already marked paid, don't re-confirm. Allow null/empty as unpaid for walk-ins.
        if ($booking->payment_status === 'paid') {
            return redirect()->back()->with('error', 'This booking payment has already been confirmed.');
        }

        // Update payment status to paid (treat null/empty as unpaid)
        $oldStatus = $booking->payment_status;
        $booking->payment_status = 'paid';
        $booking->save();
        \Illuminate\Support\Facades\Log::info('Staff.confirmPayment: payment_status updated', ['booking_id' => $booking->id, 'old_status' => $oldStatus, 'new_status' => $booking->payment_status]);

        // Log the confirmation with staff details
        $staff = auth('staff')->user();
        \Illuminate\Support\Facades\Log::info('Payment confirmed by staff', [
            'staff_id' => $staff->id,
            'staff_name' => $staff->name,
            'booking_id' => $booking->id,
            'payment_method' => $booking->payment_method,
            'customer_id' => $booking->user_id,
        ]);

        // Send notification to client if registered user
        if ($booking->user_id) {
            $sessionsText = '';
            if ($booking->hasSessionCredits()) {
                $totalSessions = $booking->getTotalSessionsCount();
                $sessionsText = " Your package includes {$totalSessions} sessions.";
            }

            $this->sendPushNotification(
                $booking->user_id,
                'Payment Confirmed',
                'Your payment for booking on ' . \Carbon\Carbon::parse($booking->date)->format('M d, Y') . ' has been confirmed by staff.' . $sessionsText,
                'success',
                $booking->id
            );
        }

        // Create client package/session records if this booking is for a package or multi-session service
        try {
            $booking->ensurePackageSessionsExist();
        } catch (\Exception $e) {
            Log::warning('Failed to create package sessions on payment confirmation', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
        }

        return redirect()->route('staff.appointments')->with('success', 'Payment confirmed successfully!');
    }

    public function index()
    {
        // Get the current staff member's branch
        $staffUser = auth()->guard('staff')->user();
        $staffBranchId = $staffUser->branch_id;


        // Get today's transactions for the staff's branch
        $transactions = \App\Models\Transaction::with(['service', 'package'])
            ->where('branch_id', $staffBranchId)
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();

        $staff = User::where('role', 'staff')->get();
        return view('Staff.staffhome', compact('staff', 'transactions'));
    }

    public function show($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        return view('Staff.staffprofile', compact('staff'));
    }

    // Show staff login form
    public function loginForm()
    {
        return view('Staff.stafflogin');
    }

    // Handle staff login
    public function login(Request $request)
    {
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember') && $request->boolean('remember');
    if (auth()->guard('staff')->attempt($credentials, $remember)) {
            $user = auth()->guard('staff')->user();
            if ($user->role !== 'staff') {
                auth()->guard('staff')->logout();
                return back()->withErrors([
                    'email' => 'Only staff accounts can log in here.'
                ]);
            }
            // Prevent deactivated staff from logging in
            if (! $user->active) {
                auth()->guard('staff')->logout();
                return back()->withErrors([
                    'email' => 'Your account is deactivated. Please contact your administrator.'
                ]);
            }
            $request->session()->regenerate();
            return redirect()->route('staff.index');
        }
        return back()->withErrors([
            'email' => 'Invalid staff credentials.'
        ]);
    }

    public function availability(Request $request)
    {
        return view('Staff.staff_calendar');
    }

    // Staff appointments queue
    public function appointments(Request $request)
    {
        // Get the current staff member's branch
        $staffUser = auth()->guard('staff')->user();
        $staffBranchId = $staffUser->branch_id;

    // Appointments: ALL bookings for registered users (include active, pending_refund, refunded, cancelled, completed) in staff's branch
    $appointments = \App\Models\Booking::with(['user', 'service', 'package.services'])
        ->whereNotNull('user_id')
        ->where('branch_id', $staffBranchId)
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

        // Booking queue: all bookings in staff's branch (all statuses)
    $bookings = \App\Models\Booking::with(['user', 'service', 'package.services'])
            ->where('branch_id', $staffBranchId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

    // Walk-ins: bookings without user in staff's branch (all statuses)
    $walkins = $bookings->whereNull('user_id');

    // Get all active client package sessions for this branch (clients with session credits)
    $packageSessions = \App\Models\ClientPackageSession::with(['client', 'service', 'branch'])
        ->forBranch($staffBranchId)
        ->active()
        ->orderBy('expiry_date', 'asc')
        ->orderBy('sessions_remaining', 'asc')
        ->get();

    // Pre-compute session credits for each booking (all bookings collection) to avoid repeated queries in the view
    $sessionCreditsByBooking = [];
    foreach ($bookings as $b) {
        try {
            // Get sessions only for this specific booking_id
            $credits = \App\Models\ClientPackageSession::where('booking_id', $b->id)
                ->sum('sessions_remaining');
        } catch (\Exception $e) {
            $credits = 0;
        }

        $sessionCreditsByBooking[$b->id] = $credits;
    }

    return view('Staff.staff_appointments', compact('appointments', 'bookings', 'walkins', 'packageSessions', 'sessionCreditsByBooking'));
    }

    // Staff cancel appointment
    public function cancelAppointment($id)
    {
        $appointment = \App\Models\Booking::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();

        // Send push notification to client with booking ID
        if ($appointment->user_id) {
            $this->sendPushNotification(
                $appointment->user_id,
                'Booking Cancelled',
                'Your booking has been cancelled by staff.',
                'warning',
                $appointment->id
            );
        }

        return redirect()->route('staff.appointments')->with('success', 'Appointment cancelled successfully.');
    }

    public function completeAppointment($id)
    {
        $appointment = \App\Models\Booking::findOrFail($id);

        // Check if payment is confirmed OR if payment method is cash (allow completion for cash payments)
        if ($appointment->payment_status !== 'paid' && $appointment->payment_method !== 'cash') {
            return redirect()->route('staff.appointments')->with('error', 'Cannot complete appointment: Payment is still pending. Please confirm payment first.');
        }

        // Check if already completed
        if ($appointment->status === 'completed') {
            return redirect()->route('staff.appointments')->with('info', 'This appointment is already marked as completed.');
        }

        // Prevent completion if there are sessions remaining for this booking (service or package)
        try {
            $credits = \App\Models\ClientPackageSession::where('booking_id', $appointment->id)
                ->sum('sessions_remaining');
        } catch (\Exception $e) {
            $credits = 0;
        }
        if ($credits > 0) {
            return redirect()->route('staff.appointments')->with('error', 'Cannot complete appointment: There are still sessions remaining for this booking.');
        }

        // If payment method is cash and not yet paid, mark payment as paid when completing
        if ($appointment->payment_method === 'cash' && $appointment->payment_status !== 'paid') {
            $appointment->payment_status = 'paid';
        }

        // Mark as completed
        $appointment->status = 'completed';
        $appointment->save();

        // Always record both service and package transactions for any completed booking
        $isWalkin = $appointment->is_walkin || is_null($appointment->user_id);

        // Record service transaction if service_id exists
        if ($appointment->service_id) {
            $existingService = \App\Models\Transaction::where('booking_id', $appointment->id)
                ->where('service_id', $appointment->service_id)
                ->first();
            if (! $existingService) {
                \App\Models\Transaction::create([
                    'booking_id' => $appointment->id,
                    'service_id' => $appointment->service_id,
                    'branch_id' => $appointment->branch_id,
                    'amount' => $appointment->service ? $appointment->service->price : 0,
                    'payment_method' => $appointment->payment_method ?? 'cash',
                    'notes' => $isWalkin ? 'Walk-in service transaction' : null,
                ]);
            }
        }

        // Record package transaction if package_id exists
        if ($appointment->package_id) {
            $package = \App\Models\Package::find($appointment->package_id);
            if ($package) {
                $existingPackage = \App\Models\Transaction::where('booking_id', $appointment->id)
                    ->where('package_id', $package->id)
                    ->first();
                if (! $existingPackage) {
                    \App\Models\Transaction::create([
                        'booking_id' => $appointment->id,
                        'package_id' => $package->id,
                        'branch_id' => $appointment->branch_id,
                        'amount' => $package->price ?? 0,
                        'payment_method' => $appointment->payment_method ?? 'cash',
                        'notes' => $isWalkin ? 'Walk-in package transaction' : null,
                    ]);
                }
            }
        }

        // Send push notification to client with booking ID
        if ($appointment->user_id) {
            $this->sendPushNotification(
                $appointment->user_id,
                'Booking Completed',
                'Your booking has been completed successfully.',
                'success',
                $appointment->id
            );
        }

        return redirect()->route('staff.appointments')->with('success', '✅ Appointment marked as completed successfully!');
    }

    public function sendReminder($id)
    {
        try {
            // Find the booking
            $booking = \App\Models\Booking::with(['user', 'branch', 'service', 'package'])->findOrFail($id);

            // Validate that booking has a user with email
            if (!$booking->user || !$booking->user->email) {
                return redirect()->route('staff.appointments')->with('error', 'Cannot send reminder: No email address found for this booking.');
            }

            // Send the reminder email
            Mail::to($booking->user->email)->send(new BookingReminder($booking));

            // Send push notification to client with booking ID
            if ($booking->user_id) {
                $this->sendPushNotification(
                    $booking->user_id,
                    'Appointment Reminder',
                    'You have an upcoming appointment. Please check your email for details.',
                    'info',
                    $booking->id
                );
            }

            return redirect()->route('staff.appointments')->with('success', 'Reminder email sent successfully to ' . $booking->user->email);
        } catch (\Exception $e) {
            Log::error('Failed to send booking reminder: ' . $e->getMessage());
            return redirect()->route('staff.appointments')->with('error', 'Failed to send reminder email. Please try again.');
        }
    }

    public function processRefund($id)
    {
        try {
            // Find the booking
            $booking = \App\Models\Booking::findOrFail($id);

            // Validate that booking is pending refund
            if ($booking->status !== 'pending_refund') {
                return redirect()->route('staff.appointments')->with('error', 'This booking is not pending refund.');
            }

            // Update booking status to cancelled (refunded bookings are automatically cancelled)
            $booking->status = 'cancelled';
            $booking->payment_status = 'refunded';
            $booking->save();

            // Zero out any session credits for this booking
            try {
                \App\Models\ClientPackageSession::where('booking_id', $booking->id)
                    ->update(['sessions_remaining' => 0, 'status' => 'refunded']);
            } catch (\Exception $e) {
                Log::warning('Error zeroing sessions on refund', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

            // Send push notification to client with booking ID
            if ($booking->user_id) {
                $this->sendPushNotification(
                    $booking->user_id,
                    'Refund Processed',
                    'Your refund has been processed successfully.',
                    'info',
                    $booking->id
                );
            }

            // Also mark the related purchased services as refunded
            $purchasedServices = \App\Models\PurchasedService::where('booking_id', $booking->id)->get();
            foreach ($purchasedServices as $ps) {
                $ps->status = 'refunded';
                $ps->save();
            }

            // Restore any session credits associated with this booking
            try {
                // Restore ClientPackageSession rows by booking id
                $clientSessions = \App\Models\ClientPackageSession::where('booking_id', $booking->id)->get();
                foreach ($clientSessions as $cs) {
                    try {
                        // If sessions were used because of this booking, refund them
                        $cs->refundSession();
                    } catch (\Exception $e) {
                        // If refunding fails (e.g., no used session), continue
                    }
                }

                // If this booking linked to a package booking, refund one credit from PackageBooking
                if ($booking->package_booking_id) {
                    $pkg = \App\Models\PackageBooking::find($booking->package_booking_id);
                    if ($pkg) {
                        $pkg->refundCredit();
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Failed to restore sessions during refund processing', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }

            // Send refund confirmed email
            try {
                Mail::to($booking->user->email)->send(new BookingRefundConfirmed($booking));
            } catch (\Exception $e) {
                Log::error('Failed to send booking refund confirmed email', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);
                // Don't fail the refund process if email fails
            }

            return redirect()->route('staff.appointments')->with('success', 'Refund processed successfully for Booking #' . $booking->id);
        } catch (\Exception $e) {
            Log::error('Failed to process refund: ' . $e->getMessage());
            return redirect()->route('staff.appointments')->with('error', 'Failed to process refund. Please try again.');
        }
    }

    public function denyRefund($id)
    {
        try {
            // Find the booking
            $booking = \App\Models\Booking::findOrFail($id);

            // Validate that booking is pending refund
            if ($booking->status !== 'pending_refund') {
                return redirect()->route('staff.appointments')->with('error', 'This booking is not pending refund.');
            }

            // Revert booking status back to active (deny the refund request)
            $booking->status = 'active';
            $booking->save();

            // Send email notification to client about denied refund
            try {
                Mail::to($booking->user->email)->send(new \App\Mail\RefundDenied($booking));
            } catch (\Exception $e) {
                Log::error('Failed to send refund denied email', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);
            }

            // Send push notification to client
            if ($booking->user_id) {
                $this->sendPushNotification(
                    $booking->user_id,
                    'Refund Request Denied',
                    'Your refund request has been denied by staff. Please contact the branch for more information.',
                    'error',
                    $booking->id
                );
            }

            return redirect()->route('staff.appointments')->with('success', 'Refund request denied and client has been notified.');
        } catch (\Exception $e) {
            Log::error('Failed to deny refund: ' . $e->getMessage());
            return redirect()->route('staff.appointments')->with('error', 'Failed to deny refund. Please try again.');
        }
    }

    /**
     * Send push notification to user and save to database
     */
    private function sendPushNotification($userId, $title, $message, $type = 'info', $bookingId = null)
    {
        try {
            // Save notification to database for persistence using custom Notification model
            \App\Models\Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'booking_id' => $bookingId,
                'read' => false,
            ]);

            // Send real-time push notification via Pusher
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                ['cluster' => env('PUSHER_APP_CLUSTER')]
            );

            $pusher->trigger('user-' . $userId, 'notification', [
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'booking_id' => $bookingId,
                'icon' => asset('img/skinlogo.png')
            ]);
        } catch (\Exception $e) {
            Log::error('Push notification failed: ' . $e->getMessage());
        }
    }

    public function recordTransaction(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'booking_id' => 'nullable|integer|exists:bookings,id',
        ]);

        // Prevent double recording for the same booking
        if ($request->booking_id) {
            $existingTransaction = \App\Models\Transaction::where('booking_id', $request->booking_id)->first();
            if ($existingTransaction) {
                $errorMsg = 'Error: Transaction is already recorded for this booking.';
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => $errorMsg], 422);
                }
                return redirect()->back()->withErrors(['booking_id' => $errorMsg]);
            }
        }

        $transaction = \App\Models\Transaction::create([
            'service_id' => $request->service_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'branch_id' => auth('staff')->user()->branch_id ?? null,
            'booking_id' => $request->booking_id,
        ]);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Transaction recorded successfully.']);
        }
        return redirect()->route('staff.index')->with('success', 'Transaction recorded successfully.');
    }

    // ==================== SESSION CREDITS MANAGEMENT ====================

    /**
     * Book a session from client's package credits
     */
    public function bookPackageSession(Request $request, $packageId)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
        ]);

        try {
            $package = \App\Models\ClientPackageSession::findOrFail($packageId);

            // Verify package can book
            if (!$package->canBookSession()) {
                return back()->with('error', 'Cannot book session: Package expired or no credits remaining.');
            }

            // Get staff branch
            $staffBranchId = auth()->guard('staff')->user()->branch_id;

            // Verify package belongs to staff's branch
            if ($package->branch_id != $staffBranchId) {
                return back()->with('error', 'This package belongs to a different branch.');
            }

            // Create the booking
            $booking = \App\Models\Booking::create([
                'user_id' => $package->user_id,
                'service_id' => $package->service_id,
                'branch_id' => $staffBranchId,
                'date' => $request->date,
                'time_slot' => $request->time_slot,
                'status' => 'active',
                'payment_status' => 'paid', // Already paid through package
                'payment_method' => $package->payment_method,
                'notes' => 'Booked from package: ' . $package->booking_id,
            ]);

            // Deduct one credit from the package
            $package->deductSession();

            // Send notification to client
            $this->sendPushNotification(
                $package->user_id,
                'Session Booked',
                'Your next session has been scheduled for ' . $request->date . ' at ' . $request->time_slot,
                'success',
                $booking->id
            );

            return redirect()->route('staff.appointments')->with('success', 'Session booked successfully! Credits remaining: ' . $package->sessions_remaining);

        } catch (\Exception $e) {
            return back()->with('error', 'Error booking session: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a package session and refund credit
     */
    public function cancelPackageSession($bookingId)
    {
        try {
            $booking = \App\Models\Booking::findOrFail($bookingId);

            // Find the package by checking notes or user/service match
            $package = \App\Models\ClientPackageSession::where('user_id', $booking->user_id)
                ->where('service_id', $booking->service_id)
                ->where('branch_id', $booking->branch_id)
                ->first();

            if ($package) {
                // Refund the credit
                $package->refundSession();

                $message = 'Booking cancelled and credit refunded. Credits remaining: ' . $package->sessions_remaining;
            } else {
                $message = 'Booking cancelled (no package found to refund).';
            }

            // Cancel the booking
            $booking->status = 'cancelled';
            $booking->save();

            // Notify client
            if ($booking->user_id) {
                $this->sendPushNotification(
                    $booking->user_id,
                    'Booking Cancelled',
                    'Your booking has been cancelled and your session credit has been refunded.',
                    'warning',
                    $booking->id
                );
            }

            return redirect()->route('staff.appointments')->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Error cancelling session: ' . $e->getMessage());
        }
    }

    /**
     * Send reminder to client about remaining session credits
     */
    public function sendPackageReminder($bookingId)
    {
        try {
            // Find the booking first
            $booking = \App\Models\Booking::with(['user', 'service', 'branch', 'package'])->findOrFail($bookingId);

            // Get session credits for this booking
            $sessionCredit = \App\Models\ClientPackageSession::where('booking_id', $bookingId)
                ->where('status', 'active')
                ->first();

            if (!$sessionCredit || $sessionCredit->sessions_remaining <= 0) {
                return back()->with('error', 'Cannot send reminder: No active session credits found.');
            }

            $client = $booking->user;
            $service = $booking->service ?? $booking->package->services->first();
            $serviceName = $booking->package ? $booking->package->name : ($service ? $service->name : 'your service');

            // Send Email about remaining sessions
            try {
                Mail::to($client->email)->send(new \App\Mail\SessionReminder($booking, $sessionCredit));
            } catch (\Exception $e) {
                Log::warning('Failed to send session reminder email: ' . $e->getMessage());
            }

            // Send Push Notification
            $message = "You have {$sessionCredit->sessions_remaining} session credits remaining for {$serviceName}. ";
            if ($sessionCredit->expiry_date) {
                $expiryDate = \Carbon\Carbon::parse($sessionCredit->expiry_date);
                $daysUntilExpiry = now()->diffInDays($expiryDate, false);
                if ($daysUntilExpiry <= 30 && $daysUntilExpiry > 0) {
                    $message .= "Expires in {$daysUntilExpiry} days. Book your next session today!";
                } else {
                    $message .= "Book your next session today!";
                }
            } else {
                $message .= "Book your next session today!";
            }

            $this->sendPushNotification(
                $client->id,
                'Session Credits Reminder',
                $message,
                'info',
                $booking->id
            );

            return back()->with('success', 'Reminder sent to ' . $client->name . ' via email and push notification.');

        } catch (\Exception $e) {
            Log::error('Error sending package reminder: ' . $e->getMessage());
            return back()->with('error', 'Error sending reminder: ' . $e->getMessage());
        }
    }

    /**
     * Complete a session and deduct credit
     */
    public function completeSession($bookingId)
    {
        try {
            $booking = \App\Models\Booking::with(['user', 'clientPackageSessions'])->findOrFail($bookingId);

            // Verify booking belongs to staff's branch
            $staffBranchId = auth()->guard('staff')->user()->branch_id;
            if ($booking->branch_id != $staffBranchId) {
                return back()->with('error', 'This booking belongs to a different branch.');
            }

            // Check if payment is confirmed
            if ($booking->payment_status !== 'paid') {
                return back()->with('error', 'Payment must be confirmed before completing a session.');
            }

            // If booking has session credits, mark one session as complete
            if ($booking->hasSessionCredits()) {
                $remaining = $booking->getRemainingSessionsCount();

                if ($remaining <= 0) {
                    // All sessions used, mark booking as completed
                    $booking->status = 'completed';
                    $booking->save();
                    return back()->with('success', 'All sessions completed! Booking marked as complete.');
                }

                // Deduct one session - only for this specific booking_id
                try {
                    $session = \App\Models\ClientPackageSession::where('booking_id', $booking->id)
                        ->where('sessions_remaining', '>', 0)
                        ->first();

                    if ($session) {
                        $session->deductSession();
                        // Only record a transaction for the package price when all sessions are completed
                        $remainingSessions = $booking->getRemainingSessionsCount();
                        if ($remainingSessions === 0 && $booking->package_id) {
                            $package = \App\Models\Package::find($booking->package_id);
                            if ($package) {
                                // Prevent duplicate transaction for this booking/package
                                $existing = \App\Models\Transaction::where('booking_id', $booking->id)
                                    ->where('package_id', $package->id)
                                    ->first();
                                if (! $existing) {
                                    \App\Models\Transaction::create([
                                        'booking_id' => $booking->id,
                                        'package_id' => $package->id,
                                        'branch_id' => $booking->branch_id,
                                        'amount' => $package->price ?? 0,
                                        'payment_method' => $booking->payment_method ?? 'package',
                                    ]);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error completing session', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
                }

                $newRemaining = $booking->getRemainingSessionsCount();

                // Send notification
                if ($booking->user_id) {
                    $message = "Session completed! You have {$newRemaining} session(s) remaining.";
                    if ($newRemaining > 0) {
                        $message .= " Book your next session soon!";
                    }

                    $this->sendPushNotification(
                        $booking->user_id,
                        'Session Completed',
                        $message,
                        'success',
                        $booking->id
                    );
                }

                if ($newRemaining === 0) {
                    // Mark booking as completed when all sessions are used
                    $booking->status = 'completed';
                    $booking->save();
                    return back()->with('success', 'Final session completed! Booking marked as complete.');
                }

                return back()->with('success', "Session completed! Client has {$newRemaining} session(s) remaining.");

            } else {
                // Walk-in or single-session booking
                $booking->last_completed_session_date = now();
                $booking->status = 'completed';
                $booking->save();
                // Record transaction for walk-in / single-session booking
                try {
                    $amount = $booking->service ? ($booking->service->price ?? 0) : 0;
                    $recent = \App\Models\Transaction::where('booking_id', $booking->id)
                        ->where('service_id', $booking->service_id)
                        ->where('amount', $amount)
                        ->where('created_at', '>=', now()->subMinutes(5))
                        ->first();
                    if (! $recent) {
                        \App\Models\Transaction::create([
                            'booking_id' => $booking->id,
                            'service_id' => $booking->service_id,
                            'branch_id' => $booking->branch_id,
                            'amount' => $amount,
                            'payment_method' => $booking->payment_method ?? 'cash',
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to record transaction for single/walkin completion', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
                }
                return back()->with('success', 'Walk-in session completed!');
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error completing session', [
                'booking_id' => $bookingId,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Error completing session: ' . $e->getMessage());
        }
    }



}
