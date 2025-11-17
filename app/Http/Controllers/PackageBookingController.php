<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageBooking;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Models\Branch;
use Carbon\Carbon;

/**
 * Package Booking Controller
 * Handles multi-session package bookings for Admin, Staff, and Client
 */
class PackageBookingController extends Controller
{
    /**
     * STAFF: View all client packages with filters
     * Filter by: branch, status, expiring soon, low credits
     */
    public function staffIndex(Request $request)
    {
        $user = auth()->user();

        // Build query
        $query = PackageBooking::with(['client', 'service', 'branch'])
            ->where(function($q) use ($user) {
                // Staff can see packages for their branch
                if ($user->role === 'staff' && $user->branch_id) {
                    $q->where('branch_id', $user->branch_id);
                }
            });

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'active'); // Default: show active only
        }

        if ($request->filled('branch_id') && $user->role === 'admin') {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Special filters
        if ($request->filter === 'expiring_soon') {
            $query->expiringSoon();
        } elseif ($request->filter === 'low_credits') {
            $query->nearCompletion();
        }

        // Get packages with pagination
        $packages = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get branches for filter
        $branches = Branch::where('active', true)->get();

        return view('staff.package-sessions', compact('packages', 'branches'));
    }

    /**
     * STAFF: Show single package details with all scheduled sessions
     */
    public function staffShow($id)
    {
        $package = PackageBooking::with(['client', 'service', 'branch', 'bookings' => function($q) {
            $q->orderBy('date', 'desc');
        }])->findOrFail($id);

        // Check authorization
        $user = auth()->user();
        if ($user->role === 'staff' && $user->branch_id !== $package->branch_id) {
            abort(403, 'Unauthorized');
        }

        return view('staff.package-details', compact('package'));
    }

    /**
     * STAFF: Schedule next session for a package
     */
    public function staffScheduleSession(Request $request, $id)
    {
        $package = PackageBooking::findOrFail($id);

        // Validate package can schedule
        if (!$package->hasRemainingCredits()) {
            return back()->with('error', 'No remaining credits for this package.');
        }

        if ($package->isExpired()) {
            return back()->with('error', 'This package has expired.');
        }

        // Validate request
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
        ]);

        // Create booking
        $booking = Booking::create([
            'user_id' => $package->user_id,
            'package_booking_id' => $package->id,
            'service_id' => $package->service_id,
            'branch_id' => $package->branch_id,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'status' => 'scheduled',
            'payment_method' => 'package', // Already paid via package
            'payment_status' => 'paid',
        ]);

        // Ensure per-service client package sessions exist for this scheduled session
        try {
            $booking->ensurePackageSessionsExist();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('PackageBookingController.staffScheduleSession ensurePackageSessionsExist failed', ['booking_id' => $booking->id, 'err' => $e->getMessage()]);
        }

        // Deduct credit
        $package->deductCredit();

        return redirect()->back()->with('success', 'Session scheduled successfully! ' . $package->remaining_credits . ' credits remaining.');
    }

    /**
     * STAFF: Mark session as completed
     */
    public function staffCompleteSession($bookingId)
    {
        $booking = Booking::with('packageBooking')->findOrFail($bookingId);

        if (!$booking->isPackageSession()) {
            return back()->with('error', 'This booking is not part of a package.');
        }

        // Update booking status
        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Session marked as completed.');
    }

    /**
     * STAFF: Cancel a scheduled session (refunds credit)
     */
    public function staffCancelSession($bookingId)
    {
        $booking = Booking::with('packageBooking')->findOrFail($bookingId);

        if (!$booking->isPackageSession()) {
            return back()->with('error', 'This booking is not part of a package.');
        }

        // Refund credit
        $booking->packageBooking->refundCredit();

        // Cancel booking
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Session cancelled and credit refunded.');
    }

    /**
     * ADMIN: View all packages across all branches
     */
    public function adminIndex(Request $request)
    {
        $query = PackageBooking::with(['client', 'service', 'branch']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $packages = $query->orderBy('created_at', 'desc')->paginate(20);
        $branches = Branch::where('active', true)->get();

        return view('admin.package-bookings', compact('packages', 'branches'));
    }

    /**
     * CLIENT: View my packages
     */
    public function clientIndex()
    {
        $user = auth()->user();

        $packages = PackageBooking::where('user_id', $user->id)
            ->with(['service', 'branch', 'bookings'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.my-packages', compact('packages'));
    }

    /**
     * API: Get package credits for a client (for booking flow)
     */
    public function getClientPackageCredits(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();
        $serviceId = $request->service_id;

        $package = PackageBooking::where('user_id', $userId)
            ->where('service_id', $serviceId)
            ->where('status', 'active')
            ->where('remaining_credits', '>', 0)
            ->first();

        if ($package) {
            return response()->json([
                'has_package' => true,
                'package_id' => $package->id,
                'remaining_credits' => $package->remaining_credits,
                'total_credits' => $package->total_credits,
                'expiry_date' => $package->expiry_date ? $package->expiry_date->format('M d, Y') : null,
                'days_until_expiry' => $package->expiry_date ? now()->diffInDays($package->expiry_date, false) : null,
            ]);
        }

        return response()->json(['has_package' => false]);
    }
}
