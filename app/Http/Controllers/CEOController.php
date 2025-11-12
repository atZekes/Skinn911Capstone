<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            // Monthly bookings and revenue with error handling
            try {
                $totalBookings = \App\Models\Booking::whereMonth('created_at', $currentMonth)
                                              ->whereYear('created_at', $currentYear)
                                              ->count();

                $lastMonthBookings = \App\Models\Booking::whereMonth('created_at', $lastMonth)
                                                       ->whereYear('created_at', $lastMonthYear)
                                                       ->count();
            } catch (\Exception $e) {
                $totalBookings = 0;
                $lastMonthBookings = 0;
            }

            try {
                $monthlyRevenue = \App\Models\Transaction::whereMonth('created_at', $currentMonth)
                                                        ->whereYear('created_at', $currentYear)
                                                        ->sum('amount') ?? 0;

                $lastMonthRevenue = \App\Models\Transaction::whereMonth('created_at', $lastMonth)
                                                          ->whereYear('created_at', $lastMonthYear)
                                                          ->sum('amount') ?? 0;
            } catch (\Exception $e) {
                $monthlyRevenue = 0;
                $lastMonthRevenue = 0;
            }

            // Branch Performance Comparison
            $branchPerformance = $this->getBranchPerformance();

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
                round((($totalBookings - $lastMonthBookings) / $lastMonthBookings) * 100, 1) : 0;

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
        }

        // Get branches for the comparison dropdown
        $branches = Branch::all();

        // Pass all data to the view
        return view('CEO.dashboard', compact(
            'totalUsers',
            'totalClients',
            'totalStaff',
            'totalAdmins',
            'activeBranches',
            'totalBookings',
            'monthlyRevenue',
            'branchPerformance',
            'revenueGrowth',
            'topServices',
            'clientRetention',
            'bookingGrowth',
            'revenueGrowthPercent',
            'peakBookingHours',
            'branches'
        ));
    }

    // Helper method to get branch performance data
    private function getBranchPerformance()
    {
        try {
            $branches = Branch::where('active', true)->get();
            $performance = [];

            foreach ($branches as $branch) {
                // Get bookings count for this branch this month
                $bookings = \App\Models\Booking::where('branch_id', $branch->id)
                                               ->whereMonth('created_at', now()->month)
                                               ->whereYear('created_at', now()->year)
                                               ->count();

                // Get revenue for this branch this month
                $revenue = \App\Models\Transaction::join('bookings', 'transactions.service_id', '=', 'bookings.service_id')
                                                  ->where('bookings.branch_id', $branch->id)
                                                  ->whereMonth('transactions.created_at', now()->month)
                                                  ->whereYear('transactions.created_at', now()->year)
                                                  ->sum('transactions.amount') ?? 0;

                $performance[] = [
                    'name' => $branch->name,
                    'bookings' => $bookings,
                    'revenue' => $revenue
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
                                           ->whereMonth('bookings.created_at', now()->month)
                                           ->whereYear('bookings.created_at', now()->year)
                                           ->groupBy('services.id', 'services.name')
                                           ->orderByDesc('booking_count')
                                           ->limit(5)
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

        if (!$branch1Id || !$branch2Id || $branch1Id == $branch2Id) {
            return response()->json(['error' => 'Please select two different branches'], 400);
        }

        $branchData = [];
        $branchIds = [$branch1Id, $branch2Id];

        foreach ($branchIds as $branchId) {
            $branch = Branch::find($branchId);

            // Get monthly revenue data for the last 6 months
            $monthlyRevenue = [];
            $monthlyBookings = [];
            $monthLabels = [];

            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthLabels[] = $month->format('M Y');

                $revenue = Transaction::where('branch_id', $branchId)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('amount');

                $bookings = Booking::where('branch_id', $branchId)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();

                $monthlyRevenue[] = floatval($revenue);
                $monthlyBookings[] = $bookings;
            }

            // Calculate current month metrics
            $currentRevenue = Transaction::where('branch_id', $branchId)
                ->whereMonth('created_at', now()->month)
                ->sum('amount');

            $currentBookings = Booking::where('branch_id', $branchId)
                ->whereMonth('created_at', now()->month)
                ->count();

            $currentClients = Booking::where('branch_id', $branchId)
                ->whereMonth('created_at', now()->month)
                ->distinct('user_id')
                ->count('user_id');

            // Get previous month for growth calculation
            $previousRevenue = Transaction::where('branch_id', $branchId)
                ->whereMonth('created_at', now()->subMonth()->month)
                ->sum('amount');

            $previousBookings = Booking::where('branch_id', $branchId)
                ->whereMonth('created_at', now()->subMonth()->month)
                ->count();

            // Calculate growth percentages
            $revenueGrowth = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
            $bookingsGrowth = $previousBookings > 0 ? (($currentBookings - $previousBookings) / $previousBookings) * 100 : 0;

            // Get top service
            $topService = DB::table('bookings')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->where('bookings.branch_id', $branchId)
                ->whereMonth('bookings.created_at', now()->month)
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
        \Log::info('CEO Branch Update Request', [
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

            \Log::info('CEO Branch Update Data', [
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

            \Log::info('CEO Branch Update Success', ['branch_id' => $branch->id]);

            return response()->json([
                'success' => true,
                'message' => 'Branch updated successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('CEO Branch Update Failed', [
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

            $query = \App\Models\Transaction::query();
            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            switch ($period) {
                case 'week':
                    // Last 7 days
                    for ($i = 6; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $label = $date->format('D'); // Mon, Tue, etc.
                        $revenue = (clone $query)->whereDate('created_at', $date->toDateString())
                                                          ->sum('amount') ?? 0;

                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;

                case 'month':
                    // Last 30 days
                    for ($i = 29; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $label = $date->format('M j'); // Jan 1, Jan 2, etc.
                        $revenue = (clone $query)->whereDate('created_at', $date->toDateString())
                                                          ->sum('amount') ?? 0;

                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;

                case 'quarter':
                    // Last 3 months
                    for ($i = 2; $i >= 0; $i--) {
                        $date = now()->subMonths($i);
                        $label = $date->format('M Y'); // Jan 2024, Feb 2024, etc.
                        $revenue = (clone $query)->whereMonth('created_at', $date->month)
                                                          ->whereYear('created_at', $date->year)
                                                          ->sum('amount') ?? 0;

                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;

                case 'year':
                    // Last 12 months
                    for ($i = 11; $i >= 0; $i--) {
                        $date = now()->subMonths($i);
                        $label = $date->format('M Y'); // Jan 2024, Feb 2024, etc.
                        $revenue = (clone $query)->whereMonth('created_at', $date->month)
                                                          ->whereYear('created_at', $date->year)
                                                          ->sum('amount') ?? 0;

                        $labels[] = $label;
                        $revenues[] = $revenue;
                    }
                    break;

                default:
                    // Default to month view
                    for ($i = 29; $i >= 0; $i--) {
                        $date = now()->subDays($i);
                        $label = $date->format('M j');
                        $revenue = (clone $query)->whereDate('created_at', $date->toDateString())
                                                          ->sum('amount') ?? 0;

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
}
