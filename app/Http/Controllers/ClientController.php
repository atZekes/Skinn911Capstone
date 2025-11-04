<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PurchasedService;

class ClientController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        // Get all bookings for statistics
        $allBookings = \App\Models\Booking::where('user_id', $userId)->get();

        // Calculate statistics
        $totalBookings = $allBookings->count();
        $activeBookings = $allBookings->where('status', 'active')->count();
        $completedBookings = $allBookings->where('status', 'completed')->count();
        $cancelledBookings = $allBookings->where('status', 'cancelled')->where('payment_status', '!=', 'refunded')->count();
        $refundedBookings = $allBookings->where(function($booking) {
            return $booking->status === 'pending_refund' || $booking->payment_status === 'refunded';
        })->count();

        return view('Client.dashboard', compact(
            'totalBookings',
            'activeBookings',
            'completedBookings',
            'cancelledBookings',
            'refundedBookings'
        ));
    }
    public function home()
    {
        if (Auth::check()) {
            Log::info('User is authenticated', ['user' => Auth::user()]);
        } else {
            Log::warning('User is NOT authenticated');
        }
        return view('Client.home', [
            'user' => Auth::user()
        ]);
    }



    // New booking form loader for route
    public function showBookingForm()
    {
        $branches = \App\Models\Branch::where('active', true)->get();
        $services = \App\Models\Service::all();
        $packages = \App\Models\Package::where('active', true)->with('services')->get();
        $userPreferences = Auth::user()->preferences ?? [];

        // Get saved card data for the authenticated user
        $savedCardData = Auth::user()->saved_card_data ?? null;

        return view('Client.booking', compact('branches', 'services', 'packages', 'savedCardData', 'userPreferences'));
    }

public function services()
{
    return view('Client.services');
}
    public function clientServices(Request $request)
    {
        $selectedCategory = $request->input('category');
        $categories = \App\Models\Service::select('category')->distinct()->pluck('category');
        $query = \App\Models\Service::query();
        if ($selectedCategory) {
            $query->where('category', $selectedCategory);
        }
        $services = $query->get();
        return view('Client.services', compact('services', 'categories', 'selectedCategory'));
    }
public function submitBooking(Request $request)
{
    // Log the incoming request for debugging
    \Log::info('Booking attempt', [
        'user_id' => Auth::id(),
        'data' => $request->all()
    ]);

    // Get minimum advance days for custom validation
    $minimumAdvanceDays = (int) config('booking.minimum_advance_days', 2);
    $minDate = \Carbon\Carbon::now()->addDays($minimumAdvanceDays)->format('Y-m-d');

    try {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            // service is required unless a package is selected
            'service_id' => 'nullable|exists:services,id|required_without:package_id',
            'package_id' => 'nullable|exists:packages,id',
            'date' => 'required|date|after_or_equal:' . $minDate,
            'time_slot' => 'required',
        ]);

        \Log::info('Booking validation passed', ['user_id' => Auth::id()]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::warning('Booking validation failed', [
            'user_id' => Auth::id(),
            'errors' => $e->errors()
        ]);
        throw $e;
    }

    // Check advance booking requirement (minimum days ahead for clients)
    // Staff can override this restriction through their interface
    $bookingDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->date);
    $currentDate = \Carbon\Carbon::now();
    $daysDifference = $currentDate->diffInDays($bookingDate, false); // false means past dates are negative

    // Get minimum advance days from config (default: 2 days) - ensure it's an integer
    $minimumAdvanceDays = (int) config('booking.minimum_advance_days', 2);

    if ($daysDifference < $minimumAdvanceDays) {
        $requiredDate = $currentDate->copy()->addDays($minimumAdvanceDays)->format('M j, Y');
        return redirect()->back()
            ->withErrors(['date' => "Bookings must be made at least {$minimumAdvanceDays} days in advance. Please select a date on or after {$requiredDate}."])
            ->withInput();
    }

    // Fetch branch and enforce break times and capacity
    $branch = \App\Models\Branch::find($request->branch_id);
    if ($branch) {
        // Check if branch is active
        if (!$branch->active) {
            return redirect()->back()->withErrors(['branch_id' => 'The selected branch is currently unavailable for bookings. Please choose another branch.'])->withInput();
        }

        // Check if the booking date falls on an operating day
        if (!empty($branch->operating_days)) {
            $bookingDayOfWeek = $bookingDate->format('l'); // Get full day name (e.g., 'Monday')
            $operatingDays = explode(',', $branch->operating_days);

            if (!in_array($bookingDayOfWeek, $operatingDays)) {
                $operatingDaysFormatted = implode(', ', $operatingDays);
                return redirect()->back()->withErrors([
                    'date' => "The selected branch is closed on {$bookingDayOfWeek}s. Operating days: {$operatingDaysFormatted}."
                ])->withInput();
            }
        }

        // check break overlap
        if ($branch->break_start && $branch->break_end) {
            try {
                [$slotStartStr, $slotEndStr] = explode('-', $request->time_slot, 2);
                $slotStart = \Carbon\Carbon::createFromFormat('H:i', $slotStartStr);
                $slotEnd = \Carbon\Carbon::createFromFormat('H:i', $slotEndStr);
                $breakStart = \Carbon\Carbon::createFromFormat('H:i', $branch->break_start);
                $breakEnd = \Carbon\Carbon::createFromFormat('H:i', $branch->break_end);
                // overlap if slotStart < breakEnd and slotEnd > breakStart
                if ($slotStart->lt($breakEnd) && $slotEnd->gt($breakStart)) {
                    return redirect()->back()->withErrors(['time_slot' => 'Selected time falls within branch break time. Please choose another slot.'])->withInput();
                }
            } catch (\Exception $e) {
                // ignore parsing errors and let other validations handle it
            }
        }

        $max = $branch->slot_capacity ?? 5;
    } else {
        $max = 5;
    }

    // Check multi-slot availability based on service duration
    $requiredSlots = [$request->time_slot];
    // Determine total duration in hours for service or package
    $totalDuration = 1;
    if ($request->filled('package_id')) {
        $pkg = \App\Models\Package::with('services')->find($request->package_id);
        if ($pkg) {
            $totalDuration = 0;
            foreach ($pkg->services as $svc) {
                $totalDuration += ($svc->duration ?? 1);
            }
        }
    } elseif ($request->filled('service_id')) {
        $svc = \App\Models\Service::find($request->service_id);
        if ($svc) $totalDuration = $svc->duration ?? 1;
    }
    // If duration > 1, compute subsequent hourly slots
    if ($totalDuration > 1) {
        try {
            [$startStr, $endStr] = explode('-', $request->time_slot, 2);
            $start = \Carbon\Carbon::createFromFormat('H:i', trim($startStr));
            for ($i = 1; $i < $totalDuration; $i++) {
                $s = $start->copy()->addHours($i);
                $e = $s->copy()->addHour();
                $requiredSlots[] = $s->format('H:i') . '-' . $e->format('H:i');
            }
        } catch (\Exception $e) {
            // fallback: just use the provided slot
        }
    }

    // Ensure required slots fit within branch operating slots (don't overflow branch end)
    if ($branch) {
        // derive branch slots similarly to getFullSlots
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
            } catch (\Exception $e) { /* ignore and use defaults */ }
        }
        foreach ($requiredSlots as $rs) {
            if (! in_array($rs, $branchSlots)) {
                return redirect()->back()->withErrors(['time_slot' => 'Selected start time cannot fit the full service duration within branch operating hours.'])->withInput();
            }
        }
    }

    // Check each required slot doesn't exceed capacity
    foreach ($requiredSlots as $slot) {
        $existingCount = \App\Models\Booking::where('branch_id', $request->branch_id)
            ->where('date', $request->date)
            ->where('time_slot', $slot)
            ->where('status', 'active')
            ->count();
        if ($existingCount >= $max) {
            return redirect()->back()->withErrors(['time_slot' => 'One or more required time slots are fully booked. Please select another start time.'])->withInput();
        }
    }

    $booking = new \App\Models\Booking();
    $booking->user_id = Auth::id();
    $booking->branch_id = $request->branch_id;
    // allow null service_id when booking a package
    $booking->service_id = $request->service_id ?? null;
    // persist chosen package on booking when provided
    $booking->package_id = $request->package_id ?? null;
    $booking->date = $request->date;
    $booking->time_slot = $request->time_slot;
    $booking->status = 'active';

    // Save payment information
    if ($request->filled('payment_method')) {
        $booking->payment_method = $request->payment_method;

        // Mark as pending if card or gcash payment (staff needs to confirm)
        if (in_array($request->payment_method, ['card', 'gcash'])) {
            $booking->payment_status = 'pending';
        } else {
            $booking->payment_status = 'unpaid'; // cash payment at branch
        }

        // Save payment data as JSON
        if ($request->filled('payment_data')) {
            $paymentData = json_decode($request->payment_data, true);
            $booking->payment_data = $request->payment_data;

            // If save_card is checked and payment method is card, save card data to user profile
            if ($request->payment_method === 'card' && isset($paymentData['save_card']) && $paymentData['save_card']) {
                $user = Auth::user();

                $cardType = $paymentData['card_type'] ?? null;

                // Get existing saved cards or initialize empty array
                $existingCards = $user->saved_card_data ?? [];

                // Save card data (excluding CVV for security) indexed by card type
                $cardData = [
                    'card_number' => $paymentData['card_number'] ?? null,
                    'card_expiry' => $paymentData['card_expiry'] ?? null,
                    'billing_first_name' => $paymentData['billing_first_name'] ?? null,
                    'billing_last_name' => $paymentData['billing_last_name'] ?? null,
                    'billing_address' => $paymentData['billing_address'] ?? null,
                    'billing_city' => $paymentData['billing_city'] ?? null,
                    'billing_zip' => $paymentData['billing_zip'] ?? null,
                    'billing_country' => $paymentData['billing_country'] ?? null,
                    'billing_phone' => $paymentData['billing_phone'] ?? null,
                ];

                // Store card data by type (visa or mastercard)
                if ($cardType) {
                    $existingCards[$cardType] = $cardData;
                }

                $user->saved_card_data = $existingCards;
                $user->save();
            }
        }
    }

    $booking->save();
    $user = Auth::user();
    // If a package is selected, create PurchasedService rows for each service in the package
    if ($request->filled('package_id')) {
        $pkg = \App\Models\Package::with('services')->find($request->package_id);
        if (!$pkg) {
            return redirect()->back()->withErrors(['package_id' => 'Invalid package selected.'])->withInput();
        }
        // Ensure package belongs to branch or is global
        if ($pkg->branch_id && $pkg->branch_id != $request->branch_id) {
            return redirect()->back()->withErrors(['package_id' => 'Selected package is not available for the chosen branch.'])->withInput();
        }
        foreach ($pkg->services as $svc) {
            \App\Models\PurchasedService::create([
                'user_id' => $user->id,
                'service_id' => $svc->id,
                'booking_id' => $booking->id,
                'price' => $svc->price ?? 0,
                'description' => $svc->description ?? '',
            ]);
        }
    } else {
        // Single service booking
        $service = \App\Models\Service::find($request->service_id);
        if ($service) {
            \App\Models\PurchasedService::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'booking_id' => $booking->id,
                'price' => $service->price ?? 0,
                'description' => $service->description ?? '',
            ]);
        }
    }

    // Send booking confirmation email
    $emailSent = false;
    if ($user->email && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
        try {
            // Load relationships for email
            $booking->load(['user', 'branch', 'service', 'package']);

            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\BookingConfirmation($booking));

            \Log::info('Booking confirmation email sent', [
                'booking_id' => $booking->id,
                'user_email' => $user->email
            ]);

            $emailSent = true;
        } catch (\Exception $e) {
            \Log::error('Failed to send booking confirmation email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            // Don't fail the booking if email fails
        }
    } else {
        \Log::warning('Booking created but email not sent - invalid or missing email', [
            'booking_id' => $booking->id,
            'user_id' => $user->id,
            'email' => $user->email
        ]);
    }

    if ($emailSent) {
        return redirect()->route('client.dashboard')->with('success', 'Successfully booked! A confirmation email has been sent to ' . $user->email);
    } else {
        return redirect()->route('client.dashboard')->with('success', 'Successfully booked! Note: Please update your email address in your profile to receive booking confirmations.');
    }
}

public function cancelBooking($id)
{
    $booking = \App\Models\Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    // Prevent cancellation only if booking payment is confirmed/paid by staff
    if ($booking->payment_status === 'paid') {
        return redirect()->route('client.dashboard')->withErrors(['error' => 'Cannot cancel a booking that has been confirmed as paid by staff. Please contact support for assistance.']);
    }

    $booking->status = 'cancelled';
    $booking->save();
    // Also mark the related purchased services as cancelled (match by booking_id)
    $purchasedServices = \App\Models\PurchasedService::where('booking_id', $booking->id)->get();
    foreach ($purchasedServices as $ps) {
        $ps->status = 'cancelled';
        $ps->save();
    }
    return redirect()->route('client.dashboard')->with('success', 'Successfully cancelled booking!');
}

public function requestRefund($id)
{
    $booking = \App\Models\Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    // Only allow refund request for paid bookings
    if ($booking->payment_status !== 'paid') {
        return redirect()->route('client.dashboard')->withErrors(['error' => 'Only paid bookings can request a refund.']);
    }

    // Check if already refunded or pending refund
    if ($booking->status === 'pending_refund' || $booking->payment_status === 'refunded') {
        return redirect()->route('client.dashboard')->withErrors(['error' => 'This booking already has a refund request or has been refunded.']);
    }

    // Update booking status to pending_refund
    $booking->status = 'pending_refund';
    $booking->save();

    return redirect()->route('client.dashboard')->with('success', 'Refund requested successfully! Please visit the branch to collect your refund once approved by staff.');
}

public function cancelAllBookings()
{
    // Get all active unpaid bookings for the current user
    $bookings = \App\Models\Booking::where('user_id', Auth::id())
        ->where('status', 'active')
        ->where(function($query) {
            $query->where('payment_status', '!=', 'paid')
                  ->orWhereNull('payment_status');
        })
        ->get();

    $cancelledCount = 0;

    foreach ($bookings as $booking) {
        // Skip if somehow a paid booking got through
        if ($booking->payment_status === 'paid') {
            continue;
        }

        $booking->status = 'cancelled';
        $booking->save();

        // Also mark the related purchased services as cancelled
        $purchasedServices = \App\Models\PurchasedService::where('booking_id', $booking->id)->get();
        foreach ($purchasedServices as $ps) {
            $ps->status = 'cancelled';
            $ps->save();
        }

        $cancelledCount++;
    }

    if ($cancelledCount > 0) {
        return redirect()->route('client.dashboard')->with('success', "Successfully cancelled {$cancelledCount} booking(s)!");
    } else {
        return redirect()->route('client.dashboard')->with('info', 'No unpaid bookings to cancel.');
    }
}

public function rescheduleBooking(Request $request, $id)
{
    // Find the booking and ensure it belongs to the current user
    $booking = \App\Models\Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    // Validate the request
    $request->validate([
        'new_date' => 'required|date',
        'new_time_slot' => 'required|string',
    ]);

    // Check if the new date is at least 3 days from the current booking date
    $currentBookingDate = \Carbon\Carbon::parse($booking->date);
    $newDate = \Carbon\Carbon::parse($request->new_date);
    $minAllowedDate = $currentBookingDate->copy()->addDays(3);

    if ($newDate->lt($minAllowedDate)) {
        return redirect()->back()->withErrors(['new_date' => 'You can only reschedule to a date at least 3 days from your current booking date.']);
    }

    // Check if the new slot is available
    $branch = $booking->branch;
    $slotCapacity = $branch->slot_capacity ?? 1;

    // Count bookings for this branch, date, and time slot
    $existingBookingsCount = \App\Models\Booking::where('branch_id', $branch->id)
        ->where('date', $newDate->format('Y-m-d'))
        ->where('time_slot', $request->new_time_slot)
        ->where('status', 'active')
        ->where('id', '!=', $booking->id) // Exclude current booking
        ->count();

    if ($existingBookingsCount >= $slotCapacity) {
        return redirect()->back()->withErrors(['new_time_slot' => 'This time slot is already fully booked. Please select another time slot.']);
    }

    // Update the booking
    $booking->date = $newDate->format('Y-m-d');
    $booking->time_slot = $request->new_time_slot;
    $booking->save();

    return redirect()->route('client.dashboard')->with('success', 'Booking rescheduled successfully!');
}

    public function getFullSlots(Request $request)
    {
        $branchId = $request->query('branch_id');
        $date = $request->query('date');
    $duration = intval($request->query('duration', 1));
        $fullSlots = [];
    $unavailableStarts = [];
        if ($branchId && $date) {
            $branch = \App\Models\Branch::find($branchId);
            if ($branch && $branch->active) {
                // derive slots from branch->time_slot if present, otherwise use default slots
                $default = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
                $slots = $default;
                if ($branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
                    [$s,$e] = explode(' - ', $branch->time_slot, 2);
                    // build hourly slots between s and e
                    try {
                        $start = \Carbon\Carbon::createFromFormat('H:i', $s);
                        $end = \Carbon\Carbon::createFromFormat('H:i', $e);
                        $slots = [];
                        for ($t = $start->copy(); $t->lt($end); $t->addHour()) {
                            $slotStart = $t->format('H:i');
                            $slotEnd = $t->copy()->addHour()->format('H:i');
                            if (\Carbon\Carbon::createFromFormat('H:i', $slotEnd)->lte($end)) {
                                // if branch has break times, skip slots that overlap the break
                                $skip = false;
                                if ($branch->break_start && $branch->break_end) {
                                    try {
                                        $bs = \Carbon\Carbon::createFromFormat('H:i', $branch->break_start);
                                        $be = \Carbon\Carbon::createFromFormat('H:i', $branch->break_end);
                                        $sTime = \Carbon\Carbon::createFromFormat('H:i', $slotStart);
                                        $eTime = \Carbon\Carbon::createFromFormat('H:i', $slotEnd);
                                        if ($sTime->lt($be) && $eTime->gt($bs)) {
                                            $skip = true;
                                        }
                                    } catch (\Exception $ex) {
                                        // ignore parsing errors and don't skip
                                    }
                                }
                                if (! $skip) {
                                    $slots[] = $slotStart . '-' . $slotEnd;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        $slots = $default;
                    }
                }
                $max = $branch->slot_capacity ?? 5;
                foreach ($slots as $slot) {
                    // Treat slot as start of service duration=1 for full slots list.
                    $count = \App\Models\Booking::where('branch_id', $branchId)
                        ->where('date', $date)
                        ->where('time_slot', $slot)
                        ->where('status', 'active')
                        ->count();
                    if ($count >= $max) $fullSlots[] = $slot;
                }

                // If caller provided a requested duration > 1, compute which start slots are unavailable
                // because one or more of the consecutive required slots are already at capacity.
                if ($duration > 1) {
                    foreach ($slots as $slot) {
                        try {
                            [$startStr, $endStr] = explode('-', $slot, 2);
                            $start = \Carbon\Carbon::createFromFormat('H:i', trim($startStr));
                            $required = [$slot];
                            for ($i = 1; $i < $duration; $i++) {
                                $s = $start->copy()->addHours($i);
                                $e = $s->copy()->addHour();
                                $required[] = $s->format('H:i') . '-' . $e->format('H:i');
                            }
                            // verify each required slot exists in computed $slots (avoids exceeding branch end)
                            $fitsInRange = true;
                            foreach ($required as $rs) {
                                if (! in_array($rs, $slots)) { $fitsInRange = false; break; }
                            }
                            if (! $fitsInRange) { $unavailableStarts[] = $slot; continue; }
                            // check capacity for each required slot
                            $blocked = false;
                            foreach ($required as $rs) {
                                $cnt = \App\Models\Booking::where('branch_id', $branchId)
                                    ->where('date', $date)
                                    ->where('time_slot', $rs)
                                    ->where('status', 'active')
                                    ->count();
                                if ($cnt >= $max) { $blocked = true; break; }
                            }
                            if ($blocked) $unavailableStarts[] = $slot;
                        } catch (\Exception $e) {
                            // ignore parsing errors
                        }
                    }
                }
            }
        }
        return response()->json(['fullSlots' => $fullSlots, 'unavailableStarts' => $unavailableStarts]);
    }

    // Return authoritative service details (duration, price) optionally scoped to a branch
    public function serviceDetail(Request $request, $id)
    {
        $branchId = $request->query('branch_id');
        $service = \App\Models\Service::find($id);
        if (! $service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $price = $service->price ?? 0;
        $duration = intval($service->duration ?? 1);

        if ($branchId) {
            try {
                $branch = \App\Models\Branch::find($branchId);
                if ($branch) {
                    $pivot = $branch->services()->where('service_id', $id)->first();
                    if ($pivot && isset($pivot->pivot)) {
                        $price = $pivot->pivot->price ?? $price;
                        $duration = intval($pivot->pivot->duration ?? $duration);
                    }
                }
            } catch (\Exception $e) {
                // ignore and return base service values
            }
        }

        return response()->json([
            'id' => $service->id,
            'name' => $service->name,
            'price' => $price,
            'duration' => $duration,
        ]);
    }

    // Validate promo code for a given branch and optional service/package
    public function validatePromo(Request $request)
    {
        $code = $request->query('code');
        $branchId = $request->query('branch_id');
        $serviceId = $request->query('service_id');
        $packageId = $request->query('package_id');
        if (! $code) {
            return response()->json(['valid' => false, 'message' => 'No promo code provided.'], 400);
        }
        $promo = \App\Models\Promo::where('code', $code)->where('active', 1)->first();
        if (! $promo) {
            return response()->json(['valid' => false, 'message' => 'Promo code not found or inactive.'], 404);
        }

        // Branch restriction - STRICT: Promo must belong to the selected branch
        // If no branch_id in request, reject promo
        if (!$branchId) {
            return response()->json(['valid' => false, 'message' => 'Please select a branch first.'], 400);
        }

        // Promo MUST have a branch_id and it MUST match the selected branch
        if (!$promo->branch_id) {
            return response()->json(['valid' => false, 'message' => 'This promo is not assigned to any branch.'], 400);
        }

        if ($promo->branch_id != $branchId) {
            return response()->json(['valid' => false, 'message' => 'This promo is not valid for the selected branch.'], 400);
        }

        // check date range
        $now = \Carbon\Carbon::now();
        if ($promo->start_date) {
            $sd = \Carbon\Carbon::parse($promo->start_date);
            if ($sd->gt($now)) {
                return response()->json(['valid' => false, 'message' => 'Promo is not yet active.'], 400);
            }
        }
        if ($promo->end_date) {
            $ed = \Carbon\Carbon::parse($promo->end_date);
            if ($ed->lt($now)) {
                return response()->json(['valid' => false, 'message' => 'Promo has expired.'], 400);
            }
        }
        $basePrice = 0;
        if ($packageId) {
            $pkg = \App\Models\Package::find($packageId);
            if ($pkg) $basePrice = $pkg->price ?? 0;
        } elseif ($serviceId) {
            $svc = \App\Models\Service::find($serviceId);
            if ($svc) $basePrice = $svc->price ?? 0;
        }
        // if promo is tied to services, ensure target is allowed
        if ($promo->services()->count() > 0) {
            // if service/package provided ensure one of the promo services matches
            if ($serviceId) {
                if (! $promo->services->contains($serviceId)) {
                    return response()->json(['valid' => false, 'message' => 'Promo does not apply to this service.'], 400);
                }
            }
            if ($packageId) {
                // check if any service in package is included
                $pkg = \App\Models\Package::with('services')->find($packageId);
                if ($pkg) {
                    $matches = false;
                    foreach ($pkg->services as $s) {
                        if ($promo->services->contains($s->id)) { $matches = true; break; }
                    }
                    if (! $matches) {
                        return response()->json(['valid' => false, 'message' => 'Promo does not apply to selected package.'], 400);
                    }
                }
            }
        }

        // compute discount
        $discountPct = floatval($promo->discount ?? 0);
        $discountAmount = round(($basePrice * $discountPct) / 100, 2);
        $final = max(0, round($basePrice - $discountAmount, 2));

        return response()->json([
            'valid' => true,
            'message' => 'Promo applied',
            'discount_pct' => $discountPct,
            'discount_amount' => $discountAmount,
            'final_price' => $final,
            'base_price' => $basePrice,
            'promo_title' => $promo->title,
        ]);
    }
public function calendarViewer()
{
    return view('Client.calendar_viewer');
}
    public function purchasedServices()
    {
        $purchasedServices = PurchasedService::where('user_id', Auth::id())->get();
        return view('Client.services', compact('purchasedServices'));
    }

    // AJAX: Get dashboard statistics
    public function getDashboardStats()
    {
        $allBookings = \App\Models\Booking::where('user_id', Auth::id())->get();

        return response()->json([
            'total' => $allBookings->count(),
            'active' => $allBookings->where('status', 'active')->count(),
            'completed' => $allBookings->where('status', 'completed')->count(),
            'cancelled' => $allBookings->where('status', 'cancelled')->where('payment_status', '!=', 'refunded')->count(),
            'refunded' => $allBookings->where(function($booking) {
                return $booking->status === 'pending_refund' || $booking->payment_status === 'refunded';
            })->count(),
        ]);
    }

    // AJAX: Get purchased services
    public function getPurchasedServices()
    {
        $purchasedServices = \App\Models\PurchasedService::with(['service', 'booking.branch'])
            ->where('user_id', Auth::id())
            ->orderBy('purchase_date', 'desc')
            ->get();

        $html = '';
        foreach ($purchasedServices as $ps) {
            $service = $ps->service;
            $booking = $ps->booking;

            $statusClass = match(strtolower($ps->status)) {
                'active' => 'bg-success',
                'cancelled' => 'bg-danger',
                'completed' => 'bg-secondary',
                'pending_refund' => 'bg-warning',
                'refunded' => 'bg-info',
                default => 'bg-warning'
            };

            $html .= '<div class="mb-3 col-md-4">';
            $html .= '<div class="shadow-sm card h-100" style="border-radius: 15px; border: none;">';
            $html .= '<div class="card-body">';
            $html .= '<h5 class="card-title" style="color:#e75480;">' . e($service ? $service->name : 'N/A') . '</h5>';
            $html .= '<p class="card-text"><strong>Price:</strong> ₱' . number_format($ps->price ?? 0, 2) . '</p>';
            $html .= '<p class="card-text"><strong>Purchase Date:</strong> ' . \Carbon\Carbon::parse($ps->purchase_date)->format('M d, Y') . '</p>';
            $html .= '<p class="card-text"><strong>Branch:</strong> ' . e($booking && $booking->branch ? $booking->branch->name : 'N/A') . '</p>';
            $html .= '<span class="badge ' . $statusClass . '">' . ucfirst($ps->status) . '</span>';
            $html .= '</div></div></div>';
        }

        if (empty($html)) {
            $html = '<div class="py-5 text-center col-12">';
            $html .= '<i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ddd;"></i>';
            $html .= '<h4 class="mt-3 text-muted">No Services Purchased Yet</h4>';
            $html .= '<p class="text-muted">Start exploring our services and make your first booking!</p>';
            $html .= '</div>';
        }

        return response()->json(['html' => $html]);
    }

    // AJAX: Get bookings with filters
    public function getBookings(Request $request)
    {
        $query = \App\Models\Booking::with(['service', 'package.services', 'branch'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['active', 'pending_refund', 'refunded', 'cancelled', 'completed']);

        // Apply search filter (search in booking ID, branch name and service/package name)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // Search by booking ID
                $q->where('id', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('branch', function($branchQuery) use ($searchTerm) {
                    $branchQuery->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('service', function($serviceQuery) use ($searchTerm) {
                    $serviceQuery->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('package', function($packageQuery) use ($searchTerm) {
                    $packageQuery->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        // Apply status filter with same logic as staff
        if ($request->has('status') && !empty($request->status)) {
            $statusFilter = $request->status;

            switch($statusFilter) {
                case 'active':
                    // Active filter: Show all active bookings
                    $query->where('status', 'active');
                    break;
                case 'refunded':
                    // Refunded filter: Show only refunded bookings (payment_status='refunded')
                    $query->where('payment_status', 'refunded');
                    break;
                case 'completed':
                    // Completed filter: Show only completed bookings
                    $query->where('status', 'completed');
                    break;
                case 'cancelled':
                    // Cancelled filter: Show all cancelled bookings (including refunded)
                    $query->where('status', 'cancelled');
                    break;
                case 'pending_refund':
                    // Pending Refund filter: Show pending refund bookings
                    $query->where('status', 'pending_refund');
                    break;
                default:
                    $query->where('status', $statusFilter);
            }
        }

        // Apply date filter
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('date', $request->date);
        }

        $activeBookings = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $html = '';
        foreach ($activeBookings as $booking) {
            $serviceName = '-';
            $bookingDuration = 1;

            if ($booking->service) {
                $serviceName = $booking->service->name;
                $bookingDuration = $booking->service->duration ?? 1;
            } elseif ($booking->package) {
                $serviceName = $booking->package->name;
                $bookingDuration = $booking->package->services->sum('duration') ?? 1;
            }

            $displaySlot = $booking->time_slot;
            if ($displaySlot && strpos($displaySlot, '-') !== false) {
                try {
                    [$sstr, $estr] = explode('-', $displaySlot, 2);
                    $sTime = \Carbon\Carbon::createFromFormat('H:i', trim($sstr));
                    $endTime = $sTime->copy()->addHours($bookingDuration);
                    $displaySlot = $sTime->format('g:ia') . ' - ' . $endTime->format('g:ia');
                } catch (\Exception $e) { /* ignore */ }
            }

            $statusClass = match(strtolower($booking->status)) {
                'active' => 'bg-success',
                'cancelled' => 'bg-danger',
                'completed' => 'bg-secondary',
                'pending_refund' => 'bg-warning',
                'refunded' => 'bg-info',
                default => 'bg-warning'
            };

            $html .= '<tr data-booking-id="' . $booking->id . '" data-status="' . $booking->status . '" data-payment-status="' . $booking->payment_status . '" data-date="' . $booking->date . '">';
            // Column 0: Booking ID
            $html .= '<td><span class="badge" style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color: white; cursor: pointer;" title="Click to search">#' . $booking->id . '</span></td>';
            // Column 1: Branch
            $html .= '<td>' . e($booking->branch ? $booking->branch->name : 'N/A') . '</td>';
            // Column 2: Service
            $html .= '<td>' . e($serviceName) . '</td>';
            // Column 3: Date
            $html .= '<td>' . \Carbon\Carbon::parse($booking->date)->format('M d, Y') . '</td>';
            // Column 4: Time Slot
            $html .= '<td>' . e($displaySlot) . '</td>';
            // Column 5: Status (same logic as staff)
            $html .= '<td>';

            if ($booking->status === 'pending_refund') {
                $html .= '<span class="badge bg-warning">Pending Refund</span>';
            } elseif ($booking->payment_status === 'refunded') {
                $html .= '<span class="badge bg-secondary">Cancelled & Refunded</span>';
            } elseif ($booking->status === 'cancelled') {
                $html .= '<span class="badge bg-danger">Cancelled</span>';
            } elseif ($booking->status === 'completed') {
                $html .= '<span class="badge bg-success">Completed</span>';
            } elseif ($booking->status === 'active') {
                if ($booking->payment_status === 'paid') {
                    $html .= '<span class="badge bg-success">Confirmed</span>';
                } elseif ($booking->payment_status === 'pending') {
                    $html .= '<span class="badge bg-warning">Payment Pending</span>';
                } else {
                    $html .= '<span class="badge bg-info">Active</span>';
                }
            } else {
                $html .= '<span class="badge bg-secondary">' . ucfirst($booking->status) . '</span>';
            }

            $html .= '</td>';
            // Column 6: Action
            $html .= '<td>';

            if (strtolower($booking->status) === 'active') {
                $html .= '<div class="flex-wrap gap-1 d-flex">';
                $html .= '<button type="button" class="btn btn-sm btn-info reschedule-booking-btn" data-booking-id="' . $booking->id . '" data-bs-toggle="modal" data-bs-target="#rescheduleModal' . $booking->id . '" style="border-radius: 8px;"><i class="fas fa-calendar-alt me-1"></i>Reschedule</button>';

                if ($booking->payment_status === 'paid' && $booking->status !== 'pending_refund') {
                    $html .= '<button type="button" class="btn btn-sm btn-success request-refund-btn" data-action="' . route('client.booking.requestRefund', $booking->id) . '" data-booking-id="' . $booking->id . '" style="border-radius: 8px;"><i class="fas fa-undo-alt me-1"></i>Request Refund</button>';
                } elseif ($booking->payment_status !== 'paid') {
                    $html .= '<button type="button" class="btn btn-sm btn-danger cancel-booking-btn" data-action="' . route('client.booking.cancel', $booking->id) . '" style="border-radius: 8px;"><i class="fas fa-times me-1"></i>Cancel</button>';
                }

                $html .= '</div>';

                if ($booking->status === 'pending_refund') {
                    $html .= '<span class="mt-1 badge bg-warning text-dark">Refund Requested</span>';
                }
            } else {
                $html .= '<span class="text-muted">-</span>';
            }

            $html .= '</td>';
            $html .= '</tr>';
        }

        if (empty($html)) {
            $html = '<tr><td colspan="6" class="py-5 text-center">';
            $html .= '<div class="py-4">';
            $html .= '<i class="fas fa-calendar-times" style="font-size: 4rem; color: #ddd;"></i>';
            $html .= '<h4 class="mt-3 text-muted">No Bookings Found</h4>';
            $html .= '<p class="text-muted">You don\'t have any bookings yet. Start booking your favorite services!</p>';
            $html .= '</div></td></tr>';
        }

        return response()->json(['html' => $html]);
    }
}
