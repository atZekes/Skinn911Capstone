<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Branch;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Service;

class CEOController extends Controller
{
    public function loginForm()
    {
        return view('CEO.ceologin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find CEO user in database
        $ceo = User::where('email', $request->email)
            ->where('role', 'ceo')
            ->first();

        if ($ceo && Hash::check($request->password, $ceo->password)) {
            // Log the CEO in using the 'ceo' guard to keep CEO separate from other sessions
            Auth::guard('ceo')->login($ceo);
            return redirect()->route('ceo.dashboard')->with('success', 'Welcome, CEO!');
        }

        return back()->withErrors(['email' => 'Invalid CEO credentials'])->withInput();
    }

    public function dashboard()
    {
        try {
            // Basic stats - separate user counts by role
            $totalUsers = User::count();
            $totalClients = User::where('role', 'client')->count();
            $totalStaff = User::where('role', 'staff')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $activeBranches = Branch::where('active', true)->count();

            // Get current month and year for calculations
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $lastMonth = now()->subMonth()->month;
            $lastMonthYear = now()->subMonth()->year;

            // Total completed bookings and revenue with error handling
            try {
                // Count distinct bookings that have purchased services and are completed
                $totalCompletedBookings = DB::table('purchased_services')
                    ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                    ->where('bookings.status', 'completed')
                    ->distinct()
                    ->count('purchased_services.booking_id');

                // Last month bookings based on purchased_services.created_at
                $lastMonthBookings = DB::table('purchased_services')
                    ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                    ->where('bookings.status', 'completed')
                    ->whereMonth('purchased_services.created_at', $lastMonth)
                    ->whereYear('purchased_services.created_at', $lastMonthYear)
                    ->distinct()
                    ->count('purchased_services.booking_id');
            } catch (\Exception $e) {
                $totalCompletedBookings = 0;
                $lastMonthBookings = 0;
            }

            try {
                // Use purchased_services.price as the authoritative revenue source
                // These will be recalculated below for consistency
                $totalRevenue = 0;
                $monthlyRevenue = 0;
                $lastMonthRevenue = 0;
                $serviceRevenue = 0;
                $packageRevenue = 0;
            } catch (\Exception $e) {
                $totalRevenue = 0;
                $monthlyRevenue = 0;
                $lastMonthRevenue = 0;
                $serviceRevenue = 0;
                $packageRevenue = 0;
            }

            // Branch Performance Comparison
            $branchPerformance = $this->getBranchPerformance();

            // Set totalRevenue, serviceRevenue, and packageRevenue as sum of all branch values for consistency
            $totalRevenue = collect($branchPerformance)->sum('revenue_overall');
            $serviceRevenue = collect($branchPerformance)->sum(function($branch) {
                // If you have a way to distinguish services vs packages in purchased_services, update here
                return $branch['revenue_overall'];
            });
            $packageRevenue = 0; // If you want to split package revenue, update branchPerformance to include it

            // Revenue Growth (last 6 months)
            $revenueGrowth = $this->getRevenueGrowth();

            // Top Performing Services
            $topServices = $this->getTopServices();

            // Client Retention Analysis
            $clientRetention = $this->getClientRetention();

            // Peak Booking Hours Analysis
            $peakBookingHours = $this->getPeakBookingHours();

            // Calculate growth percentages
            $bookingGrowth = $lastMonthBookings > 0 ?
                round((($totalCompletedBookings - $lastMonthBookings) / $lastMonthBookings) * 100, 1) : 0;

            $revenueGrowthPercent = $lastMonthRevenue > 0 ?
                round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

        } catch (\Exception $e) {
            // Default values if there are errors
            $totalUsers = 0;
            $activeBranches = 0;
            $totalBookings = 0;
            $monthlyRevenue = 0;
            $branchPerformance = [];
            $revenueGrowth = [];
            $topServices = [];
            $clientAcquisition = [];
            $bookingGrowth = 0;
            $revenueGrowthPercent = 0;
            $serviceRevenue = 0;
            $packageRevenue = 0;
        }

        // Get branches for the comparison dropdown
        $branches = Branch::all();

        // Get retention summary for dashboard
        $retentionSummary = $this->getRetentionSummary();

        // Pass all data to the view
        return view('CEO.dashboard', compact(
            'totalUsers',
            'totalClients',
            'totalStaff',
            'totalAdmins',
            'activeBranches',
            'totalCompletedBookings',
            'totalRevenue',
            'serviceRevenue',
            'packageRevenue',
            'branchPerformance',
            'revenueGrowth',
            'topServices',
            'clientRetention',
            'bookingGrowth',
            'revenueGrowthPercent',
            'peakBookingHours',
            'branches',
            'retentionSummary'
        ));
    }

    // Helper method to get branch performance data
    private function getBranchPerformance()
    {
        try {
            // Show all branches regardless of active flag
            $branches = Branch::all();
            $performance = [];

            foreach ($branches as $branch) {
                // Bookings overall: count distinct completed bookings with purchased services for this branch
                $bookings_overall = DB::table('purchased_services')
                    ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                    ->where('bookings.branch_id', $branch->id)
                    ->where('bookings.status', 'completed')
                    ->distinct()
                    ->count('purchased_services.booking_id');

                // Bookings this month: count distinct completed bookings with purchased services for this branch and month
                $bookings_month = DB::table('purchased_services')
                    ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                    ->where('bookings.branch_id', $branch->id)
                    ->where('bookings.status', 'completed')
                    ->whereMonth('purchased_services.created_at', now()->month)
                    ->whereYear('purchased_services.created_at', now()->year)
                    ->distinct()
                    ->count('purchased_services.booking_id');

                // Revenue for this branch this month: sum purchased_services.price for this branch and month
                $revenue_month = DB::table('purchased_services')
                    ->where('purchased_services.branch_id', $branch->id)
                    ->whereMonth('purchased_services.created_at', now()->month)
                    ->whereYear('purchased_services.created_at', now()->year)
                    ->sum('purchased_services.price') ?? 0;

                // Overall revenue (all time) for branch: sum purchased_services.price for this branch
                $revenue_overall = DB::table('purchased_services')
                    ->where('purchased_services.branch_id', $branch->id)
                    ->sum('purchased_services.price') ?? 0;

                $performance[] = [
                    'name' => $branch->name,
                    'bookings_month' => $bookings_month,
                    'bookings_overall' => $bookings_overall,
                    'revenue_month' => floatval($revenue_month),
                    'revenue_overall' => floatval($revenue_overall),
                    // legacy aliases expected by older views / JS
                    'bookings' => $bookings_month,
                    'revenue' => floatval($revenue_month),
                ];
            }

            return $performance;
        } catch (\Exception $e) {
            return [];
        }
    }

    // Helper method to get revenue growth data (last 6 months)
    private function getRevenueGrowth()
    {
        try {
            $months = [];
            $revenues = [];

            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $month = $date->format('M');
                $revenue = \App\Models\Transaction::whereMonth('created_at', $date->month)
                                                  ->whereYear('created_at', $date->year)
                                                  ->sum('amount') ?? 0;

                $months[] = $month;
                $revenues[] = $revenue;
            }

            return [
                'months' => $months,
                'revenues' => $revenues
            ];
        } catch (\Exception $e) {
            return [
                'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'revenues' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    // Helper method to get top performing services
    private function getTopServices()
    {
        try {
            $services = \App\Models\Service::join('bookings', 'services.id', '=', 'bookings.service_id')
                                           ->selectRaw('services.name, COUNT(bookings.id) as booking_count')
                                           ->groupBy('services.id', 'services.name')
                                           ->orderByDesc('booking_count')
                                           ->limit(10)
                                           ->get()
                                           ->map(function($service) {
                                               return [
                                                   'name' => $service->name,
                                                   'bookings' => $service->booking_count
                                               ];
                                           });

            return $services;
        } catch (\Exception $e) {
            return [];
        }
    }

    // Helper method to get client acquisition trends
    private function getClientAcquisition()
    {
        try {
            $months = [];
            $newClients = [];

            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $month = $date->format('M');
                $clients = User::where('role', 'client')
                               ->whereMonth('created_at', $date->month)
                               ->whereYear('created_at', $date->year)
                               ->count();

                $months[] = $month;
                $newClients[] = $clients;
            }

            return [
                'months' => $months,
                'newClients' => $newClients
            ];
        } catch (\Exception $e) {
            return [
                'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'newClients' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }

    private function getClientRetention($days = null, $branchId = null)
    {
        try {
            // If days is specified, filter by time period, otherwise get all-time data
            $query = \App\Models\Booking::whereNotNull('user_id');

            if ($days) {
                $query->where('created_at', '>=', now()->subDays($days));
            }

            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            $bookings = $query->get();

            if ($bookings->isEmpty()) {
                return [
                    'total_customers' => 0,
                    'repeat_customers' => 0,
                    'retention_rate' => 0,
                    'average_bookings_per_customer' => 0,
                    'period' => $days ? ($days === 7 ? 'Week' : ($days === 30 ? 'Month' : 'Quarter')) : 'All Time'
                ];
            }

            // Count unique customers who made bookings
            $totalCustomers = $bookings->pluck('user_id')->unique()->count();

            // Count customers who made more than one booking (repeat customers)
            $customerBookingCounts = $bookings->groupBy('user_id')->map->count();
            $repeatCustomers = $customerBookingCounts->filter(function ($count) {
                return $count > 1;
            })->count();

            // Calculate retention percentage
            $retentionRate = $totalCustomers > 0 ? round(($repeatCustomers / $totalCustomers) * 100, 1) : 0;

            // Calculate average bookings per customer
            $totalBookings = $bookings->count();
            $averageBookingsPerCustomer = $totalCustomers > 0 ? round($totalBookings / $totalCustomers, 1) : 0;

            return [
                'total_customers' => $totalCustomers,
                'repeat_customers' => $repeatCustomers,
                'retention_rate' => $retentionRate,
                'average_bookings_per_customer' => $averageBookingsPerCustomer,
                'period' => $days ? ($days === 7 ? 'Week' : ($days === 30 ? 'Month' : 'Quarter')) : 'All Time'
            ];
        } catch (\Exception $e) {
            return [
                'total_customers' => 0,
                'repeat_customers' => 0,
                'retention_rate' => 0,
                'average_bookings_per_customer' => 0,
                'period' => $days ? ($days === 7 ? 'Week' : ($days === 30 ? 'Month' : 'Quarter')) : 'All Time'
            ];
        }
    }

    public function compareBranches(Request $request)
    {
        $branch1Id = $request->input('branch1');
        $branch2Id = $request->input('branch2');
        $from = $request->input('from', null);
        $to = $request->input('to', null);

        if (!$branch1Id || !$branch2Id || $branch1Id == $branch2Id) {
            return response()->json(['error' => 'Please select two different branches'], 400);
        }

        $branchData = [];
        $branchIds = [$branch1Id, $branch2Id];

        foreach ($branchIds as $branchId) {
            $branch = Branch::find($branchId);

            // Get monthly revenue and bookings from purchased_services for the last 6 months
            $monthlyRevenue = [];
            $monthlyBookings = [];
            $monthLabels = [];

            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthLabels[] = $month->format('M Y');

                $revenue = DB::table('purchased_services')
                    ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                    ->where('bookings.branch_id', $branchId)
                    ->whereYear('purchased_services.created_at', $month->year)
                    ->whereMonth('purchased_services.created_at', $month->month)
                    ->sum('purchased_services.price');

                $bookings = DB::table('purchased_services')
                    ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                    ->where('bookings.branch_id', $branchId)
                    ->whereYear('purchased_services.created_at', $month->year)
                    ->whereMonth('purchased_services.created_at', $month->month)
                    ->count();

                $monthlyRevenue[] = floatval($revenue);
                $monthlyBookings[] = $bookings;
            }

            // Current month metrics
            $currentRevenue = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->where('bookings.branch_id', $branchId)
                ->whereMonth('purchased_services.created_at', now()->month)
                ->sum('purchased_services.price');

            $currentBookings = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->where('bookings.branch_id', $branchId)
                ->whereMonth('purchased_services.created_at', now()->month)
                ->count();

            $currentClients = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->where('bookings.branch_id', $branchId)
                ->whereMonth('purchased_services.created_at', now()->month)
                ->distinct('purchased_services.user_id')
                ->count('purchased_services.user_id');

            // Previous month for growth calculation
            $previousRevenue = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->where('bookings.branch_id', $branchId)
                ->whereMonth('purchased_services.created_at', now()->subMonth()->month)
                ->sum('purchased_services.price');

            $previousBookings = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->where('bookings.branch_id', $branchId)
                ->whereMonth('purchased_services.created_at', now()->subMonth()->month)
                ->count();

            // Growth percentages
            $revenueGrowth = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
            $bookingsGrowth = $previousBookings > 0 ? (($currentBookings - $previousBookings) / $previousBookings) * 100 : 0;

            // Top service by purchased_services
            $topService = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id')
                ->where('bookings.status', 'completed')
                ->when($from, fn($q) => $q->whereDate('bookings.created_at', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('bookings.created_at', '<=', $to))
                ->select('services.name', DB::raw('COUNT(*) as booking_count'))
                ->groupBy('services.id', 'services.name')
                ->orderBy('booking_count', 'desc')
                ->first();

            $branchData[] = [
                'id' => $branchId,
                'name' => $branch->name,
                'address' => $branch->address,
                'monthly_revenue' => $monthlyRevenue,
                'monthly_bookings' => $monthlyBookings,
                'month_labels' => $monthLabels,
                'current_revenue' => floatval($currentRevenue),
                'current_bookings' => $currentBookings,
                'current_clients' => $currentClients,
                'revenue_growth' => round($revenueGrowth, 1),
                'bookings_growth' => round($bookingsGrowth, 1),
                'top_service' => $topService ? $topService->name : 'N/A',
                'top_service_count' => $topService ? $topService->booking_count : 0
            ];
        }

        return response()->json(['branches' => $branchData]);
    }

    public function addUserAdmin()
    {
        $branches = Branch::all();
        return view('CEO.adduseradmin', compact('branches'));
    }

    public function userManage(Request $request)
    {
        $branches = Branch::all();
        $branchId = $request->get('branch_id');
        $usersQuery = User::where('role', 'admin');
        if ($branchId) {
            $usersQuery->where('branch_id', $branchId);
        }
        $users = $usersQuery->get();
        // Get staff from users table
        $staffByBranch = User::where('role', 'staff')->get()->groupBy('branch_id');
        return view('CEO.Usermanage', compact('users', 'branches', 'branchId', 'staffByBranch'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'branch_id' => 'required|exists:branches,id',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'admin';
        $user->branch_id = $request->branch_id;
        $user->save();
        return redirect()->back()->with('success', 'Admin created successfully.');
    }

    public function updateAdmin(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff',
            'branch_id' => 'nullable|exists:branches,id',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->branch_id = $request->branch_id;
        $user->save();
        return redirect()->back()->with('success', 'Admin updated successfully.');
    }

    public function deleteAdmin(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Admin deleted successfully.');
    }

    public function logout()
    {
        // Clear session or authentication for CEO
        session()->flush();
        return redirect()->route('ceo.login')->with('success', 'Logged out successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        // Example: hardcoded CEO credentials
        if ($request->current_password !== 'ceo123') {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        // Here you would update the CEO password in the database if using a real user model
        // For demo, just show success
        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    public function adminChangePassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password changed successfully for ' . $user->name . '.');
    }

    public function resetAdminPassword(User $user)
    {
        // Example: password is branch name (lowercase, no spaces) + '_admin'
        $branch = $user->branch_id ? Branch::find($user->branch_id) : null;
        $newPassword = $branch ? strtolower(str_replace(' ', '', $branch->name)) . '_admin' : 'default_admin';
        $user->password = bcrypt($newPassword);
        $user->save();
        return redirect()->back()->with('success', 'Password reset for ' . $user->name . '. New password: ' . $newPassword);
    }

    // Branch Management Methods
    public function branchManagement()
    {
        $branches = Branch::orderBy('created_at', 'desc')->get();
        return view('CEO.branchmanagement', compact('branches'));
    }

    public function storeBranch(Request $request)
    {
        try {
            // VALIDATE FIRST before any database operations
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:500',
                'city' => 'nullable|string|max:255',
                'map_src' => 'nullable|url|max:1000',
                'contact_number' => [
                    'required',
                    'string',
                    'regex:/^09[0-9]{9}$/' // Philippine mobile: 09XXXXXXXXX (11 digits)
                ],
                'telephone_number' => [
                    'nullable',
                    'string',
                    'regex:/^[0-9]{7,8}$/' // Philippine landline: 7-8 digits
                ],
                'operating_days' => 'nullable|array',
                'operating_days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'
            ], [
                'contact_number.regex' => 'Mobile number must be 11 digits starting with 09 (e.g., 09171234567)',
                'telephone_number.regex' => 'Telephone number must be 7-8 digits (e.g., 1234567 or 12345678)'
            ]);

            // TRIPLE LAYER PROTECTION against double submission (AFTER VALIDATION)

            // Layer 1: Session-based lock
            $sessionKey = 'creating_branch_' . session()->getId();

            // Layer 2: Request signature lock
            $requestSignature = md5($validated['name'] . '|' . $validated['address'] . '|' . session()->getId());
            $signatureKey = 'branch_request_' . $requestSignature;

            $lockTimeout = 30; // 30 seconds

            if (cache()->has($sessionKey)) {
                Log::warning('Duplicate branch creation attempt blocked by session lock', [
                    'session_id' => session()->getId(),
                    'ip' => $request->ip(),
                    'branch_name' => $validated['name']
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Branch creation already in progress. Please wait.'
                ], 429);
            }

            if (cache()->has($signatureKey)) {
                Log::warning('Duplicate branch creation attempt blocked by request signature', [
                    'session_id' => session()->getId(),
                    'signature' => $requestSignature,
                    'branch_name' => $validated['name']
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'This exact branch is already being created. Please wait.'
                ], 429);
            }

            // Set BOTH locks
            cache()->put($sessionKey, true, $lockTimeout);
            cache()->put($signatureKey, true, $lockTimeout);

            // Use database transaction to prevent race conditions
            $branch = DB::transaction(function () use ($validated) {
                // Double-check name uniqueness inside transaction
                $existingBranch = Branch::where('name', $validated['name'])->first();
                if ($existingBranch) {
                    Log::info('Branch already exists, returning existing branch', [
                        'branch_id' => $existingBranch->id,
                        'branch_name' => $existingBranch->name
                    ]);
                    return $existingBranch;
                }

                // Create the branch
                $operatingDays = isset($validated['operating_days']) && $validated['operating_days']
                    ? implode(',', $validated['operating_days'])
                    : null;

                // Normalize city to proper case (first letter uppercase)
                $city = isset($validated['city']) && $validated['city']
                    ? ucwords(strtolower(trim($validated['city'])))
                    : null;

                $branch = Branch::create([
                    'key' => 'temp_key', // Temporary key
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'city' => $city,
                    'map_src' => $validated['map_src'] ?? null,
                    'contact_number' => $validated['contact_number'] ?? null,
                    'telephone_number' => $validated['telephone_number'] ?? null,
                    'operating_days' => $operatingDays,
                    'active' => true
                ]);

                // Generate formatted hours if operating days are provided
                if ($operatingDays) {
                    $formattedHours = $branch->getFormattedHoursAttribute();
                    if ($formattedHours) {
                        $branch->update(['hours' => $formattedHours]);
                    }
                }

                // Create key based on branch name + ID
                $cleanName = strtolower($validated['name']);
                $cleanName = str_replace(' ', '_', $cleanName);
                $cleanName = preg_replace('/[^a-z0-9_]/', '', $cleanName);
                $branchKey = $cleanName . '_' . $branch->id;

                // Update the branch with the proper key
                $branch->update(['key' => $branchKey]);

                Log::info('Creating new branch', [
                    'name' => $validated['name'],
                    'key' => $branchKey,
                    'id' => $branch->id,
                    'session_id' => session()->getId()
                ]);

                return $branch;
            }, 5);

            // Remove locks after successful creation
            cache()->forget($sessionKey);
            cache()->forget($signatureKey);

            Log::info('Branch created successfully', [
                'branch_id' => $branch->id,
                'name' => $branch->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Branch created successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Get the first error message
            $errors = $e->errors();
            $errorMessage = 'Validation failed';

            if (isset($errors['contact_number'])) {
                $errorMessage = $errors['contact_number'][0];
            } elseif (isset($errors['telephone_number'])) {
                $errorMessage = $errors['telephone_number'][0];
            } elseif (isset($errors['name'])) {
                $errorMessage = $errors['name'][0];
            } elseif (isset($errors['address'])) {
                $errorMessage = 'Address is required';
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);

        } catch (\Exception $e) {
            Log::error('Branch creation failed', [
                'error' => $e->getMessage(),
                'session_id' => session()->getId(),
                'branch_name' => $validated['name'] ?? 'unknown'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create branch. Please try again.'
            ], 500);
        }
    }

    public function updateBranch(Request $request, Branch $branch)
    {
        // Add debugging
        Log::info('CEO Branch Update Request', [
            'branch_id' => $branch->id,
            'request_data' => $request->all(),
            'has_active' => $request->has('active'),
            'has_name' => $request->has('name'),
            'has_address' => $request->has('address')
        ]);

        // Handle status toggle (only active field is sent)
        if ($request->has('active') && !$request->has('name') && !$request->has('address')) {
            try {
                $branch->update([
                    'active' => $request->active == '1' ? true : false
                ]);

                $statusText = $request->active == '1' ? 'enabled' : 'disabled';
                return response()->json([
                    'success' => true,
                    'message' => "Branch {$statusText} successfully!"
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update branch status. Please try again.'
                ], 500);
            }
        }

        // Handle full branch update with Philippine phone number validation
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:255',
            'map_src' => 'nullable|url|max:1000',
            'contact_number' => [
                'required',
                'string',
                'regex:/^09[0-9]{9}$/' // Philippine mobile: 09XXXXXXXXX (11 digits)
            ],
            'telephone_number' => [
                'nullable',
                'string',
                'regex:/^[0-9]{7,8}$/' // Philippine landline: 7-8 digits
            ],
            'operating_days' => 'nullable|array',
            'operating_days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'
        ], [
            'contact_number.regex' => 'Mobile number must be 11 digits starting with 09 (e.g., 09171234567)',
            'telephone_number.regex' => 'Telephone number must be 7-8 digits (e.g., 1234567 or 12345678)'
        ]);

        try {
            $operatingDays = $request->operating_days ? implode(',', $request->operating_days) : null;

            // Normalize city to proper case (first letter uppercase)
            $city = isset($request->city) && $request->city
                ? ucwords(strtolower(trim($request->city)))
                : null;

            Log::info('CEO Branch Update Data', [
                'branch_id' => $branch->id,
                'operating_days_raw' => $request->operating_days,
                'operating_days_processed' => $operatingDays,
                'contact_number' => $request->contact_number,
                'telephone_number' => $request->telephone_number
            ]);

            $branch->update([
                'name' => $request->name,
                'address' => $request->address,
                'city' => $city,
                'map_src' => $request->map_src,
                'contact_number' => $request->contact_number,
                'telephone_number' => $request->telephone_number,
                'operating_days' => $operatingDays,
                'active' => $request->has('active') ? true : false
            ]);

            // Generate formatted hours if operating days are provided
            if ($operatingDays) {
                $formattedHours = $branch->getFormattedHoursAttribute();
                if ($formattedHours) {
                    $branch->update(['hours' => $formattedHours]);
                }
            }

            Log::info('CEO Branch Update Success', ['branch_id' => $branch->id]);

            return response()->json([
                'success' => true,
                'message' => 'Branch updated successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('CEO Branch Update Failed', [
                'branch_id' => $branch->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update branch. Please try again.'
            ], 500);
        }
    }

    public function deleteBranch(Branch $branch)
    {
        try {
            // Check if branch has associated users or bookings
            $hasUsers = User::where('branch_id', $branch->id)->exists();
            $hasBookings = Booking::where('branch_id', $branch->id)->exists();

            if ($hasUsers || $hasBookings) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete branch. It has associated users or bookings.'
                ], 400);
            }

            $branch->delete();

            return response()->json([
                'success' => true,
                'message' => 'Branch deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete branch. Please try again.'
            ], 500);
        }
    }

    // Helper method to get peak booking hours data
    private function getPeakBookingHours($days = 30, $branchId = null)
    {
        try {
            // Get bookings from the specified number of days
            $query = \App\Models\Booking::where('created_at', '>=', now()->subDays($days))
                                          ->whereNotNull('time_slot');

            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            $bookings = $query->get();

            // Initialize hourly data (9 AM to 8 PM)
            $hourlyData = [];
            for ($hour = 9; $hour <= 20; $hour++) {
                $hourlyData[$hour] = [
                    'hour' => $hour,
                    'hour_12' => $hour > 12 ? $hour - 12 . ' PM' : ($hour == 12 ? '12 PM' : $hour . ' AM'),
                    'bookings' => 0,
                    'percentage' => 0
                ];
            }

            $totalBookings = 0;

            // Count bookings by hour
            foreach ($bookings as $booking) {
                // Parse time slot (assuming format like "10:00-11:00" or "10:00 AM")
                $timeSlot = $booking->time_slot;

                // Extract hour from time slot
                if (strpos($timeSlot, '-') !== false) {
                    // Format: "10:00-11:00"
                    $startTime = explode('-', $timeSlot)[0];
                } elseif (strpos($timeSlot, ' ') !== false) {
                    // Format: "10:00 AM"
                    $startTime = explode(' ', $timeSlot)[0];
                } else {
                    // Format: "10:00"
                    $startTime = $timeSlot;
                }

                // Extract hour from start time
                $hour = (int) explode(':', $startTime)[0];

                // Convert 12-hour to 24-hour if needed
                if (strpos($timeSlot, 'PM') !== false && $hour != 12) {
                    $hour += 12;
                } elseif (strpos($timeSlot, 'AM') !== false && $hour == 12) {
                    $hour = 0;
                }

                // Only count hours between 9 AM and 8 PM
                if ($hour >= 9 && $hour <= 20 && isset($hourlyData[$hour])) {
                    $hourlyData[$hour]['bookings']++;
                    $totalBookings++;
                }
            }

            // Calculate percentages
            if ($totalBookings > 0) {
                foreach ($hourlyData as &$data) {
                    $data['percentage'] = round(($data['bookings'] / $totalBookings) * 100, 1);
                }
            }

            // Sort by bookings count (descending)
            usort($hourlyData, function($a, $b) {
                return $b['bookings'] <=> $a['bookings'];
            });

            // Format data for Chart.js
            $hours = [];
            $percentages = [];
            foreach ($hourlyData as $data) {
                $hours[] = $data['hour_12'];
                $percentages[] = $data['percentage'];
            }

            return [
                'hours' => $hours,
                'percentages' => $percentages
            ];

        } catch (\Exception $e) {
            // Return empty data if there's an error
            return [];
        }
    }

    public function getPeakHoursData(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, quarter
        $branchId = $request->get('branch_id');

        $days = match($period) {
            'week' => 7,
            'month' => 30,
            'quarter' => 90,
            default => 30
        };

        return response()->json($this->getPeakBookingHours($days, $branchId));
    }

    public function getRetentionData(Request $request)
    {
        $period = $request->get('period', 'all'); // week, month, quarter, all
        $branchId = $request->get('branch_id');

        $days = match($period) {
            'week' => 7,
            'month' => 30,
            'quarter' => 90,
            'all' => null,
            default => null
        };

        return response()->json($this->getClientRetention($days, $branchId));
    }

    public function getRevenueData(Request $request)
    {
        $period = $request->get('period', 'month'); // week, month, quarter, year
        $branchId = $request->get('branch_id');

        return response()->json($this->getRevenueDataByPeriod($period, $branchId));
    }

    // Helper method to get revenue data by period
    private function getRevenueDataByPeriod($period, $branchId = null)
    {
        try {
            $labels = [];
            $revenues = [];

            // Use purchased_services for revenue analytics
            $baseQuery = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id');
            if ($branchId) {
                $baseQuery->where('bookings.branch_id', $branchId);
            }

            switch ($period) {
                case 'week':
                    for ($i = 6; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $label = $date->format('D');
                        $revenue = (clone $baseQuery)
                            ->whereDate('purchased_services.created_at', $date->toDateString())
                            ->sum('purchased_services.price') ?? 0;
                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;
                case 'month':
                    for ($i = 29; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $label = $date->format('M j');
                        $revenue = (clone $baseQuery)
                            ->whereDate('purchased_services.created_at', $date->toDateString())
                            ->sum('purchased_services.price') ?? 0;
                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;
                case 'quarter':
                    for ($i = 2; $i >= 0; $i--) {
                        $date = now()->subMonths($i);
                        $label = $date->format('M Y');
                        $revenue = (clone $baseQuery)
                            ->whereMonth('purchased_services.created_at', $date->month)
                            ->whereYear('purchased_services.created_at', $date->year)
                            ->sum('purchased_services.price') ?? 0;
                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;
                case 'year':
                    for ($i = 11; $i >= 0; $i--) {
                        $date = now()->subMonths($i);
                        $label = $date->format('M Y');
                        $revenue = (clone $baseQuery)
                            ->whereMonth('purchased_services.created_at', $date->month)
                            ->whereYear('purchased_services.created_at', $date->year)
                            ->sum('purchased_services.price') ?? 0;
                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;
                default:
                    for ($i = 29; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $label = $date->format('M j');
                        $revenue = (clone $baseQuery)
                            ->whereDate('purchased_services.created_at', $date->toDateString())
                            ->sum('purchased_services.price') ?? 0;
                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;
            }

            return [
                'labels' => $labels,
                'revenues' => $revenues
            ];
        } catch (\Exception $e) {
            // Return empty data on error
            return [
                'labels' => [],
                'revenues' => []
            ];
        }
    }

    /**
     * Client Retention Overview
     */
    public function clientRetention(Request $request)
    {
        // Get filter parameters
        $branchFilter = $request->input('branch_id');
        $dateRange = $request->input('date_range', 'all'); // all, 3months, 6months, 12months
        $inactiveDays = $request->input('inactive_days', 90);
        $showInactiveOnly = $request->input('show_inactive', false);

        // Base query for users with role 'client' and at least one completed booking
        $query = User::where('role', 'client')
            ->whereHas('bookings', function($q) {
                $q->where('status', 'completed');
            });

        // Apply branch filter
        if ($branchFilter) {
            $query->whereHas('bookings', function($q) use ($branchFilter) {
                $q->where('branch_id', $branchFilter);
            });
        }

        // Apply date range filter on bookings
        if ($dateRange !== 'all') {
            $months = match($dateRange) {
                '3months' => 3,
                '6months' => 6,
                '12months' => 12,
                default => null,
            };

            if ($months) {
                $startDate = \Carbon\Carbon::now()->subMonths($months);
                $query->whereHas('bookings', function($q) use ($startDate) {
                    $q->where('status', 'completed')
                      ->where('date', '>=', $startDate);
                });
            }
        }

        // Get clients with their booking data
        $clients = $query->with(['bookings' => function($q) use ($branchFilter) {
            $q->where('status', 'completed')
              ->orderBy('date', 'desc')
              ->orderBy('time_slot', 'desc');

            if ($branchFilter) {
                $q->where('branch_id', $branchFilter);
            }
        }])->get();

        // Calculate retention metrics for each client
        $retentionData = $clients->map(function($client) use ($branchFilter, $inactiveDays) {
            $completedBookings = $client->bookings->where('status', 'completed');

            if ($branchFilter) {
                $completedBookings = $completedBookings->where('branch_id', $branchFilter);
            }

            $totalVisits = $completedBookings->count();
            $lastVisit = $completedBookings->first();

            $returnInterval = null;
            if ($completedBookings->count() >= 2) {
                $lastTwo = $completedBookings->take(2)->values();
                $returnInterval = \Carbon\Carbon::parse($lastTwo[1]->date)
                    ->diffInDays(\Carbon\Carbon::parse($lastTwo[0]->date));
            }

            $daysSinceLastVisit = $lastVisit
                ? now()->diffInDays(\Carbon\Carbon::parse($lastVisit->date))
                : null;

            return [
                'id' => $client->id,
                'name' => $client->masked_name, // Privacy: Masked name
                'email' => $client->masked_email, // Privacy: Masked email
                'mobile_phone' => $client->masked_phone, // Privacy: Masked phone
                'total_visits' => $totalVisits,
                'last_visit_date' => $lastVisit ? $lastVisit->date : null,
                'days_since_last_visit' => $daysSinceLastVisit,
                'return_interval' => $returnInterval,
                'is_inactive' => $daysSinceLastVisit !== null && $daysSinceLastVisit > $inactiveDays,
            ];
        });

        // Filter inactive clients if requested
        if ($showInactiveOnly) {
            $retentionData = $retentionData->filter(function($client) {
                return $client['is_inactive'];
            });
        }

        // Sort by last visit date (most recent first)
        $retentionData = $retentionData->sortByDesc('last_visit_date')->values();

        // Calculate average metrics
        $totalClients = $retentionData->count();
        $activeClients = $retentionData->where('is_inactive', false)->count();
        $inactiveClients = $retentionData->where('is_inactive', true)->count();

        $averageReturnInterval = $retentionData
            ->filter(fn($c) => $c['return_interval'] !== null)
            ->avg('return_interval');

        $averageVisits = $retentionData->avg('total_visits');

        // Get branches for filter dropdown
        $branches = Branch::where('active', true)->get();

        return view('CEO.client-retention', compact(
            'retentionData',
            'branches',
            'branchFilter',
            'dateRange',
            'inactiveDays',
            'showInactiveOnly',
            'totalClients',
            'activeClients',
            'inactiveClients',
            'averageReturnInterval',
            'averageVisits'
        ));
    }

    /**
     * Get retention analytics for dashboard
     * Calculates: Total Clients, Average Return Rate (Past 30 Days),
     * Average Days Between Bookings, Total Visits
     */
    private function getRetentionSummary()
    {
        try {
            // METRIC 1: Total Clients
            $totalClients = DB::table('purchased_services')
                ->distinct('user_id')
                ->count('user_id');

            // METRIC 2: Average Return Rate (Past 30 Days)
            $thirtyDaysAgo = now()->subDays(30);
            $clientsBookedInLast30Days = DB::table('purchased_services')
                ->where('created_at', '>=', $thirtyDaysAgo)
                ->distinct('user_id')
                ->count('user_id');

            $clientsWithTwoOrMoreBookings = DB::table('purchased_services')
                ->where('created_at', '>=', $thirtyDaysAgo)
                ->select('user_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('user_id')
                ->having('cnt', '>=', 2)
                ->get()->count();

            $averageReturnRate = $clientsBookedInLast30Days > 0
                ? round(($clientsWithTwoOrMoreBookings / $clientsBookedInLast30Days) * 100, 1)
                : 0;

            // METRIC 3: Average Days Between Bookings
            $intervals = [];
            $users = DB::table('purchased_services')
                ->select('user_id')
                ->groupBy('user_id')
                ->get();
            foreach ($users as $user) {
                $dates = DB::table('purchased_services')
                    ->where('user_id', $user->user_id)
                    ->orderBy('created_at', 'asc')
                    ->pluck('created_at');
                for ($i = 1; $i < count($dates); $i++) {
                    $prev = \Carbon\Carbon::parse($dates[$i-1]);
                    $curr = \Carbon\Carbon::parse($dates[$i]);
                    $intervals[] = $prev->diffInDays($curr);
                }
            }
            $averageDaysBetweenBookings = count($intervals) > 0
                ? round(array_sum($intervals) / count($intervals), 1)
                : 0;

            // METRIC 4: Total Visits (Overall)
            $totalVisits = DB::table('purchased_services')->count();

            return [
                'total_clients' => $totalClients,
                'average_return_rate' => $averageReturnRate,
                'average_days_between_bookings' => $averageDaysBetweenBookings,
                'total_visits' => $totalVisits,
            ];
        } catch (\Exception $e) {
            logger()->error('Retention Summary Error: ' . $e->getMessage());
            return [
                'total_clients' => 0,
                'average_return_rate' => 0,
                'average_days_between_bookings' => 0,
                'total_visits' => 0,
            ];
        }
    }

    /**
     * Get retention analytics chart data (AJAX endpoint)
     * Returns time-series data for return rate and total visits
     */
    public function getRetentionChartData(Request $request)
    {
        try {
            $period = $request->input('period', 'month'); // month, quarter, year
            $chartType = $request->input('chart_type', 'line'); // line or bar

            // Determine date range and grouping
            $endDate = now();
            $startDate = match($period) {
                'month' => now()->subMonths(6), // Last 6 months
                'quarter' => now()->subMonths(12), // Last 12 months
                'year' => now()->subYears(2), // Last 2 years
                default => now()->subMonths(6),
            };

            // Determine date format for grouping
            $dateFormat = match($period) {
                'month' => '%Y-%m', // Group by month
                'quarter' => '%Y-%m', // Group by month
                'year' => '%Y-%m', // Group by month
                default => '%Y-%m',
            };

            // Get bookings grouped by month with client counts
            $monthlyData = \App\Models\Booking::where('status', 'completed')
                ->whereBetween('date', [$startDate, $endDate])
                ->selectRaw('DATE_FORMAT(date, "' . $dateFormat . '") as period')
                ->selectRaw('COUNT(*) as total_visits')
                ->selectRaw('COUNT(DISTINCT user_id) as unique_clients')
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            $labels = [];
            $totalVisitsData = [];
            $returnRateData = [];

            foreach ($monthlyData as $data) {
                // Format label based on period
                $carbonDate = \Carbon\Carbon::createFromFormat('Y-m', $data->period);
                $labels[] = $carbonDate->format('M Y');

                // Total visits for this period
                $totalVisitsData[] = $data->total_visits;

                // Calculate return rate for this specific period
                // Get clients who booked 2+ times in this month
                $periodStart = $carbonDate->startOfMonth()->toDateString();
                $periodEnd = $carbonDate->endOfMonth()->toDateString();

                $clientsWithMultipleBookings = User::where('role', 'client')
                    ->whereHas('bookings', function($q) use ($periodStart, $periodEnd) {
                        $q->where('status', 'completed')
                          ->whereBetween('date', [$periodStart, $periodEnd]);
                    }, '>=', 2)
                    ->count();

                // Return rate percentage for this period
                $returnRate = $data->unique_clients > 0
                    ? round(($clientsWithMultipleBookings / $data->unique_clients) * 100, 1)
                    : 0;

                $returnRateData[] = $returnRate;
            }

            return response()->json([
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Average Return Rate (%)',
                        'data' => $returnRateData,
                        'borderColor' => '#F56289',
                        'backgroundColor' => 'rgba(245, 98, 137, 0.1)',
                        'yAxisID' => 'y',
                        'tension' => 0.4,
                    ],
                    [
                        'label' => 'Total Visits',
                        'data' => $totalVisitsData,
                        'borderColor' => '#667eea',
                        'backgroundColor' => 'rgba(102, 126, 234, 0.1)',
                        'yAxisID' => 'y1',
                        'tension' => 0.4,
                    ]
                ],
                'chart_type' => $chartType,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'labels' => [],
                'datasets' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sales report UI and filter
     */
    public function salesReport(Request $request)
    {
        $branches = Branch::all();

        $from = $request->get('from');
        $to = $request->get('to');
        $branchId = $request->get('branch_id');

        $report = null;
        $metrics = null;
        if ($from || $to || $branchId) {
            $psQuery = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('branches', 'purchased_services.branch_id', '=', 'branches.id')
                ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id')
                ->where(function($q) {
                    $q->whereNull('purchased_services.booking_id')
                      ->orWhere('bookings.status', 'completed');
                })
                ->where('purchased_services.session_status', 'completed')
                ->select(
                    'purchased_services.id as ps_id',
                    'bookings.id as booking_id',
                    'branches.name as branch_name',
                    'services.name as service_name',
                    'purchased_services.price',
                    'purchased_services.created_at'
                );

            if ($from) {
                $psQuery->whereDate('purchased_services.created_at', '>=', $from);
            }
            if ($to) {
                $psQuery->whereDate('purchased_services.created_at', '<=', $to);
            }
            if ($branchId) {
                $psQuery->where('purchased_services.branch_id', $branchId);
            }

            $rows = $psQuery->orderBy('purchased_services.created_at', 'desc')->get();
            $total = $rows->sum('price');
            $count = $rows->count();

            $report = [
                'rows' => $rows,
                'total' => $total,
                'count' => $count
            ];
        }

        // Compute metrics across all branches (date filtered if from/to provided)
        try {
            $txQuery = Transaction::join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                ->leftJoin('branches', 'bookings.branch_id', '=', 'branches.id')
                ->leftJoin('services', 'bookings.service_id', '=', 'services.id');

            if ($from) $txQuery->whereDate('transactions.created_at', '>=', $from);
            if ($to) $txQuery->whereDate('transactions.created_at', '<=', $to);

            // Total revenue per branch: use purchased_services prices (user-requested)
            $psQuery = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('branches', 'purchased_services.branch_id', '=', 'branches.id')
                ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id')
                ->where(function($q) {
                    $q->whereNull('purchased_services.booking_id')
                      ->orWhere('bookings.status', 'completed');
                })
                ->where('purchased_services.session_status', 'completed');

            if ($from) $psQuery->whereDate('purchased_services.created_at', '>=', $from);
            if ($to) $psQuery->whereDate('purchased_services.created_at', '<=', $to);

            $branchRevenues = (clone $psQuery);
            if ($branchId) {
                $branchRevenues->where('purchased_services.branch_id', $branchId);
            }
            $branchRevenues = $branchRevenues->selectRaw('branches.id as branch_id, branches.name as branch_name, SUM(purchased_services.price) as total')
                ->groupBy('branches.id', 'branches.name')
                ->orderByDesc('total')
                ->get();

            // Total bookings and cancellations
            $bookingQuery = Booking::query();
            if ($from) $bookingQuery->whereDate('created_at', '>=', $from);
            if ($to) $bookingQuery->whereDate('created_at', '<=', $to);
            if ($branchId) $bookingQuery->where('branch_id', $branchId);
            $totalBookings = (clone $bookingQuery)->count();
            $cancelled = (clone $bookingQuery)->where('status', 'cancelled')->count();
            $cancellationRate = $totalBookings > 0 ? round(($cancelled / $totalBookings) * 100, 2) : 0;

            // Top services by transactions (count + revenue)
            $topServices = (clone $txQuery);
            if ($branchId) $topServices->where('bookings.branch_id', $branchId);
            $topServices = $topServices->selectRaw('services.id as service_id, services.name as service_name, COUNT(*) as tx_count, SUM(transactions.amount) as revenue')
                ->groupBy('services.id', 'services.name')
                ->orderByDesc('tx_count')
                ->limit(10)
                ->get();

            // Profit per service based on purchased_services.price (user requested using purchased services)
            $profitPerService = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id')
                ->where(function($q) {
                    $q->whereNull('purchased_services.booking_id')
                      ->orWhere('bookings.status', 'completed');
                })
                ->where('purchased_services.session_status', 'completed')
                ->when($from, fn($q) => $q->whereDate('purchased_services.created_at', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('purchased_services.created_at', '<=', $to))
                ->when($branchId, fn($q) => $q->where('purchased_services.branch_id', $branchId))
                ->selectRaw('services.id as service_id, services.name as service_name, SUM(purchased_services.price) as profit')
                ->groupBy('services.id', 'services.name')
                ->orderByDesc('profit')
                ->get();

            // Promo impact
            $promoTx = (clone $txQuery);
            if ($branchId) $promoTx->where('bookings.branch_id', $branchId);
            $promoCount = $promoTx->whereNotNull('transactions.promo_code')->count();
            $promoRevenue = $promoTx->whereNotNull('transactions.promo_code')->sum('transactions.amount');

            // Overall revenue should be derived from purchased_services to match branch totals
            $totalRevenueQuery = DB::table('purchased_services');
            if ($branchId) $totalRevenueQuery->where('branch_id', $branchId);
            $totalRevenue = $totalRevenueQuery->sum('price') ?? 0;
            $promoRevenuePct = $totalRevenue > 0 ? round(($promoRevenue / $totalRevenue) * 100, 2) : 0;

            // Peak hours/days (simple aggregates)
            $peakHours = (clone $bookingQuery)->selectRaw("HOUR(created_at) as hour, COUNT(*) as cnt")
                ->groupByRaw('HOUR(created_at)')
                ->orderByDesc('cnt')
                ->limit(6)
                ->get();

            $peakDays = (clone $bookingQuery)->selectRaw("DATE(created_at) as day, COUNT(*) as cnt")
                ->groupByRaw('DATE(created_at)')
                ->orderByDesc('cnt')
                ->limit(6)
                ->get();

            $metrics = [
                'branch_revenues' => $branchRevenues,
                'total_bookings' => $totalBookings,
                'cancelled' => $cancelled,
                'cancellation_rate' => $cancellationRate,
                'top_services' => $topServices,
                'profit_per_service' => $profitPerService,
                'promo' => [
                    'count' => $promoCount,
                    'revenue' => $promoRevenue,
                    'pct_of_revenue' => $promoRevenuePct
                ],
                'peak_hours' => $peakHours,
                'peak_days' => $peakDays,
                'total_revenue_all' => $totalRevenue,
            ];
        } catch (\Exception $e) {
            Log::error('Sales report metrics error: ' . $e->getMessage());
            $metrics = null;
        }

        return view('CEO.sales-report', compact('branches', 'report', 'metrics'));
    }

    /**
     * Download sales report as PDF (if dompdf present) or CSV
     */
    public function downloadSalesReport(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $branchId = $request->get('branch_id');
        $branch = null;
        if ($branchId) {
            $branch = \App\Models\Branch::find($branchId)->name ?? null;
        }

        $psQuery = DB::table('purchased_services')
            ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
            ->leftJoin('branches', 'purchased_services.branch_id', '=', 'branches.id')
            ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id')
            ->where(function($q) {
                $q->whereNull('purchased_services.booking_id')
                  ->orWhere('bookings.status', 'completed');
            })
            ->where('purchased_services.session_status', 'completed')
            ->select(
                'purchased_services.id as ps_id',
                'bookings.id as booking_id',
                'branches.name as branch_name',
                'services.name as service_name',
                'purchased_services.price',
                'purchased_services.created_at'
            );

        if ($from) {
            $psQuery->whereDate('purchased_services.created_at', '>=', $from);
        }
        if ($to) {
            $psQuery->whereDate('purchased_services.created_at', '<=', $to);
        }
        if ($branchId) {
            $psQuery->where('purchased_services.branch_id', $branchId);
        }

        $rows = $psQuery->orderBy('purchased_services.created_at', 'desc')->get();
        $total = $rows->sum('price');
        $count = $rows->count();

        $report = [
            'rows' => $rows,
            'total' => $total,
            'count' => $count
        ];

        // Compute same metrics for download (so PDF includes metrics)
        try {
            $txQuery = Transaction::join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                ->leftJoin('branches', 'bookings.branch_id', '=', 'branches.id')
                ->leftJoin('services', 'bookings.service_id', '=', 'services.id');

            if ($from) $txQuery->whereDate('transactions.created_at', '>=', $from);
            if ($to) $txQuery->whereDate('transactions.created_at', '<=', $to);

            // Use purchased_services to compute branch revenues so totals align
            $psQuery = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('branches', 'bookings.branch_id', '=', 'branches.id')
                ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id');

            if ($from) $psQuery->whereDate('purchased_services.created_at', '>=', $from);
            if ($to) $psQuery->whereDate('purchased_services.created_at', '<=', $to);

            $branchRevenues = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('branches', 'purchased_services.branch_id', '=', 'branches.id')
                ->where(function($q) {
                    $q->whereNull('purchased_services.booking_id')
                      ->orWhere('bookings.status', 'completed');
                })
                ->where('purchased_services.session_status', 'completed')
                ->when($from, fn($q) => $q->whereDate('purchased_services.created_at', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('purchased_services.created_at', '<=', $to))
                ->selectRaw('branches.id as branch_id, branches.name as branch_name, SUM(purchased_services.price) as total')
                ->groupBy('branches.id', 'branches.name')
                ->orderByDesc('total')
                ->get();

            $bookingQuery = Booking::query();
            if ($from) $bookingQuery->whereDate('created_at', '>=', $from);
            if ($to) $bookingQuery->whereDate('created_at', '<=', $to);
            $totalBookings = (clone $bookingQuery)->count();
            $cancelled = (clone $bookingQuery)->where('status', 'cancelled')->count();
            $cancellationRate = $totalBookings > 0 ? round(($cancelled / $totalBookings) * 100, 2) : 0;

            $topServices = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id')
                ->where('bookings.status', 'completed')
                ->where('purchased_services.session_status', 'completed')
                ->when($from, fn($q) => $q->whereDate('purchased_services.created_at', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('purchased_services.created_at', '<=', $to))
                ->selectRaw('services.id as service_id, services.name as service_name, COUNT(*) as tx_count, SUM(purchased_services.price) as revenue')
                ->groupBy('services.id', 'services.name')
                ->orderByDesc('tx_count')
                ->limit(10)
                ->get();

            $profitPerService = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->leftJoin('services', 'purchased_services.service_id', '=', 'services.id')
                ->where('bookings.status', 'completed')
                ->where('purchased_services.session_status', 'completed')
                ->when($from, fn($q) => $q->whereDate('purchased_services.created_at', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('purchased_services.created_at', '<=', $to))
                ->selectRaw('services.id as service_id, services.name as service_name, SUM(purchased_services.price) as profit')
                ->groupBy('services.id', 'services.name')
                ->orderByDesc('profit')
                ->get();

            $promoTx = (clone $txQuery)->whereNotNull('transactions.promo_code');
            $promoCount = $promoTx->count();
            $promoRevenue = $promoTx->sum('transactions.amount');

            // Overall revenue derived from purchased_services to match branch totals
            $totalRevenueAll = DB::table('purchased_services')
                ->leftJoin('bookings', 'purchased_services.booking_id', '=', 'bookings.id')
                ->where('bookings.status', 'completed')
                ->where('purchased_services.session_status', 'completed')
                ->when($from, fn($q) => $q->whereDate('purchased_services.created_at', '>=', $from))
                ->when($to, fn($q) => $q->whereDate('purchased_services.created_at', '<=', $to))
                ->sum('purchased_services.price') ?? 0;

            $peakHours = (clone $bookingQuery)->selectRaw("HOUR(created_at) as hour, COUNT(*) as cnt")
                ->groupByRaw('HOUR(created_at)')
                ->orderByDesc('cnt')
                ->limit(6)
                ->get();

            $peakDays = (clone $bookingQuery)->selectRaw("DATE(created_at) as day, COUNT(*) as cnt")
                ->groupByRaw('DATE(created_at)')
                ->orderByDesc('cnt')
                ->limit(6)
                ->get();

            $metrics = [
                'branch_revenues' => $branchRevenues,
                'total_bookings' => $totalBookings,
                'cancelled' => $cancelled,
                'cancellation_rate' => $cancellationRate,
                'top_services' => $topServices,
                'profit_per_service' => $profitPerService,
                'promo' => [
                    'count' => $promoCount,
                    'revenue' => $promoRevenue,
                    'pct_of_revenue' => $totalRevenueAll > 0 ? round(($promoRevenue / $totalRevenueAll) * 100, 2) : 0
                ],
                'peak_hours' => $peakHours,
                'peak_days' => $peakDays,
                'total_revenue_all' => $totalRevenueAll,
            ];
        } catch (\Exception $e) {
            Log::error('Sales report download metrics error: ' . $e->getMessage());
            $metrics = null;
        }

        // If dompdf is installed and bound, render PDF
        if (app()->bound('dompdf.wrapper')) {
            $fromLabel = $from ?: '';
            $toLabel = $to ?: '';
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('CEO.sales-report-pdf', [
                'report' => $report,
                'from' => $fromLabel,
                'to' => $toLabel,
                'branch' => $branch,
                'metrics' => $metrics
            ]);

            $fileName = 'sales-report-' . ($from ?: 'start') . '-to-' . ($to ?: 'end') . '.pdf';
            return $pdf->download($fileName);
        }

        // Fallback to CSV download
        $fileName = 'sales-report-' . ($from ?: 'start') . '-to-' . ($to ?: 'end') . '.csv';

        $callback = function() use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Booking ID', 'Branch', 'Service', 'Date', 'Amount']);
            foreach ($rows as $r) {
                fputcsv($handle, [
                    $r->booking_id,
                    $r->branch_name,
                    $r->service_name,
                    Carbon::parse($r->created_at)->toDateString(),
                    number_format($r->amount, 2)
                ]);
            }
            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
