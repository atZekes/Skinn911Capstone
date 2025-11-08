<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Promo;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Admincontroller extends Controller{

    public function admin()
    {
        return view('admin.adminlogin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = User::where('email', $request->email)
            ->where('role', 'admin')
            ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Log the admin in using the 'admin' guard to keep admin separate from client sessions
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function dashboard()
    {
        $today = Carbon::today()->toDateString();

        $admin = Auth::guard('admin')->user();
        $adminBranchId = ($admin && $admin->role === 'admin' && $admin->branch_id) ? $admin->branch_id : null;

        // KPIs (filter by branch if admin has an assigned branch)
        $kpis = [
            'today_bookings' => Booking::where('date', $today)->when($adminBranchId, function ($q) use ($adminBranchId) { return $q->where('branch_id', $adminBranchId); })->where('status', 'active')->count(),
            'walkins_today' => Booking::where('date', $today)->when($adminBranchId, function ($q) use ($adminBranchId) { return $q->where('branch_id', $adminBranchId); })->where('is_walkin', 1)->count(),
            'active_bookings' => Booking::where('status', 'active')->when($adminBranchId, function ($q) use ($adminBranchId) { return $q->where('branch_id', $adminBranchId); })->count(),
            'revenue_today' => Transaction::whereDate('created_at', $today)->when($adminBranchId, function ($q) use ($adminBranchId) { return $q->where('branch_id', $adminBranchId); })->sum('amount'),
        ];

        // recent bookings (limit to admin branch if applicable)
        $recent = Booking::with(['user', 'service', 'branch'])
            ->when($adminBranchId, function ($q) use ($adminBranchId) { return $q->where('branch_id', $adminBranchId); })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // branches and per-branch summary (today capacity usage)
        $branches = $adminBranchId ? Branch::where('id', $adminBranchId)->get() : Branch::all();
        $branchSummaries = $branches->map(function ($b) use ($today) {
            $todayBookings = Booking::where('branch_id', $b->id)->where('date', $today)->count();
            // derive number of hourly slots from branch->time_slot (fallback to 9 slots)
            $slotsCount = 9;
            if (!empty($b->time_slot) && strpos($b->time_slot, ' - ') !== false) {
                try {
                    [$s, $e] = explode(' - ', $b->time_slot, 2);
                    $start = Carbon::createFromFormat('H:i', trim($s));
                    $end = Carbon::createFromFormat('H:i', trim($e));
                    $slotsCount = 0;
                    for ($t = $start->copy(); $t->lt($end); $t->addHour()) {
                        $slotEnd = $t->copy()->addHour();
                        if ($slotEnd->lte($end)) {
                            // if branch has break times, skip slots that overlap the break
                            $skip = false;
                            if (!empty($b->break_start) && !empty($b->break_end)) {
                                try {
                                    $bs = Carbon::createFromFormat('H:i', $b->break_start);
                                    $be = Carbon::createFromFormat('H:i', $b->break_end);
                                    $sTime = $t->copy();
                                    $eTime = $t->copy()->addHour();
                                    if ($sTime->lt($be) && $eTime->gt($bs)) {
                                        $skip = true;
                                    }
                                } catch (\Exception $ex) {
                                    $skip = false;
                                }
                            }
                            if (! $skip) {
                                $slotsCount++;
                            }
                        }
                    }
                    if ($slotsCount <= 0) $slotsCount = 9;
                } catch (\Exception $ex) {
                    $slotsCount = 9;
                }
            }
            $perSlotCapacity = $b->slot_capacity ?? 0;
            $capacity = $slotsCount * $perSlotCapacity;
            $util = $capacity > 0 ? round(($todayBookings / $capacity) * 100) : 0;
            return [
                'id' => $b->id,
                'name' => $b->name,
                'slots' => $slotsCount,
                'per_slot_capacity' => $perSlotCapacity,
                'capacity' => $capacity,
                'today_bookings' => $todayBookings,
                'utilization' => $util,
            ];
        })->values();

        // bookings for last 7 days by branch (respect admin branch filter)
        $periodStart = Carbon::today()->copy()->subDays(6);
        $periodEnd = Carbon::today()->copy();

        $labels = [];
        for ($i = 0; $i < 7; $i++) {
            $labels[] = $periodStart->copy()->addDays($i)->format('M j');
        }

        $rangeStart = $periodStart->toDateString();
        $rangeEnd = $periodEnd->toDateString();

        $bookingsInRange = Booking::whereBetween('date', [$rangeStart, $rangeEnd])->when($adminBranchId, function ($q) use ($adminBranchId) { return $q->where('branch_id', $adminBranchId); })->get();
        $grouped = $bookingsInRange->groupBy(function ($item) {
            return $item->branch_id . '|' . $item->date;
        });

        $chartDatasets = [];
        foreach ($branches as $b) {
            $data = [];
            for ($i = 0; $i < 7; $i++) {
                $dateStr = $periodStart->copy()->addDays($i)->toDateString();
                $key = $b->id . '|' . $dateStr;
                $count = isset($grouped[$key]) ? $grouped[$key]->count() : 0;
                $data[] = $count;
            }
            $chartDatasets[] = ['label' => $b->name, 'data' => $data, 'branch_id' => $b->id, 'total' => array_sum($data)];
        }

        // limit datasets to top 6 branches by total bookings to keep the chart readable
        $chartDatasets = collect($chartDatasets)->sortByDesc('total')->values()->take(6)->toArray();

        return view('admin.dashboard', compact('kpis', 'recent', 'branches', 'branchSummaries', 'labels', 'chartDatasets'));
    }

    public function promo()
    {
        $admin = Auth::guard('admin')->user();
    if ($admin && $admin->role === 'admin' && $admin->branch_id) {
            // show global promos + promos for this admin's branch
            $promos = Promo::with(['services','branch'])->whereNull('branch_id')->orWhere('branch_id', $admin->branch_id)->get();
            // services may not yet have branch_id column on older DBs - guard it
            try {
                // include global services (branch_id NULL) plus branch-specific services
                $services = \App\Models\Service::whereNull('branch_id')->orWhere('branch_id', $admin->branch_id)->get();
            } catch (\Exception $e) {
                $services = \App\Models\Service::all();
            }
            // derive available categories from the services list (non-empty strings)
            $categories = $services->pluck('category')->unique()->filter()->values();
        } else {
            $promos = Promo::with(['services','branch'])->all();
            $services = \App\Models\Service::all();
            $categories = $services->pluck('category')->unique()->filter()->values();
        }
        return view('admin.promo', compact('promos','services','categories'));
    }

    // Store a new promo
    public function storePromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promos,code',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:0',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer|exists:services,id',
            'category' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
    $admin = Auth::guard('admin')->user();
    $data = $request->only(['code','title','description','discount','start_date','end_date','category']);
    $data['branch_id'] = ($admin && $admin->role === 'admin') ? $admin->branch_id : null;
        $promo = Promo::create($data);
        if ($request->filled('service_ids')) {
            $promo->services()->sync($request->input('service_ids'));
        }
        return redirect()->back()->with('success', 'Promo created.');
    }

    // Update existing promo
    public function updatePromo(Request $request, Promo $promo)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:0',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer|exists:services,id',
            'category' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->role === 'admin' && $admin->branch_id && $promo->branch_id && $promo->branch_id !== $admin->branch_id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage promos in your branch.']);
        }
        $promo->update($request->only(['title','description','discount','start_date','end_date','category']));
        if ($request->has('service_ids')) {
            $promo->services()->sync($request->input('service_ids'));
        } else {
            $promo->services()->detach();
        }
        return redirect()->back()->with('success', 'Promo updated.');
    }

    // Delete a promo
    public function deletePromo(Request $request, Promo $promo)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->role === 'admin' && $admin->branch_id && $promo->branch_id && $promo->branch_id !== $admin->branch_id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage promos in your branch.']);
        }
        $promo->delete();
        return redirect()->back()->with('success', 'Promo deleted.');
    }

    // Toggle promo active/inactive
    public function togglePromo(Request $request, Promo $promo)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->role === 'admin' && $admin->branch_id && $promo->branch_id && $promo->branch_id !== $admin->branch_id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage promos in your branch.']);
        }
        $promo->active = !$promo->active;
        $promo->save();
        return redirect()->back()->with('success', 'Promo status updated.');
    }

    public function userManage()
    {
        // Get the currently authenticated admin
        $admin = Auth::guard('admin')->user();

        // If admin has a specific branch assigned, filter users by that branch
        if ($admin && $admin->role === 'admin' && $admin->branch_id) {
            // Show only staff from the admin's branch + all clients (clients aren't branch-specific)
            $users = User::with('branch')->where(function($query) use ($admin) {
                $query->where('role', 'client') // All clients
                      ->orWhere(function($subQuery) use ($admin) {
                          $subQuery->where('role', 'staff')
                                   ->where('branch_id', $admin->branch_id); // Only staff from admin's branch
                      });
            })->get();
        } else {
            // Super admin or admin without branch - show all users
            $users = User::with('branch')->all();
        }

        return view('admin.Usermanage', compact('users'));
    }

    /**
     * Show the form to create a new staff member
     */
    public function showCreateStaffForm()
    {
    // The create staff modal is embedded in the Usermanage view; redirect there.
    return redirect()->route('admin.usermanage');
    }

    /**
     * Handle staff creation and assign to admin's branch
     */
    public function createStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Get the currently authenticated admin
    $admin = Auth::guard('admin')->user();
        // If there's no authenticated user or the user is not an admin, block the action
        if (!$admin || $admin->role !== 'admin') {
            // Redirect to admin login or return an error if called via AJAX
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized. Please log in as admin.'], 401);
            }
            return redirect()->route('adminlogin')->withErrors(['error' => 'Only authenticated admins can create staff accounts.']);
        }

        // Create staff user with same branch as admin
        $staff = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'staff',
            'branch_id' => $admin->branch_id,
        ]);

    return redirect()->route('admin.usermanage')->with('success', 'Staff account created and assigned to your branch.');
    }

    public function branchManagement()
    {
        // Use authenticated admin instead of relying on session('admin_id')
        $admin = Auth::guard('admin')->user();
        // Admins should be able to manage their branch even if it's inactive, so bypass the active global scope here
        if ($admin && $admin->branch_id) {
            $branches = Branch::withoutGlobalScope('active')->where('id', $admin->branch_id)->get();
        } else {
            $branches = collect();
        }
        return view('admin.branchmanagement', compact('branches'));
    }

    public function updateBranch(Request $request, $branchId)
    {
        // Accept break_start / break_end as optional free-form input and parse them server-side.
        // This avoids strict "The break start field must match the format H:i" validation messages.
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
            'slot_capacity' => 'required|integer|min:1',
            // break_start and break_end accepted as nullable (no strict format) and handled below
            'break_start' => 'nullable',
            'break_end' => 'nullable',
            'remove_break' => 'nullable|in:0,1',
            // New contact fields
            'contact_number' => 'nullable|string|max:20',
            'telephone_number' => 'nullable|string|max:20',
            'operating_days' => 'nullable|array',
            'operating_days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            // GCash payment fields
            'gcash_number' => 'nullable|string|max:20',
            'gcash_qr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $branch = Branch::findOrFail($branchId);
        $branch->name = $request->name;
        $branch->address = $request->address;

        // Save new contact information
        $branch->contact_number = $request->contact_number;
        $branch->telephone_number = $request->telephone_number;

        // Save operating days as comma-separated string
        if ($request->has('operating_days') && is_array($request->operating_days)) {
            $branch->operating_days = implode(',', $request->operating_days);
        } else {
            $branch->operating_days = null;
        }

        // store as "HH:MM - HH:MM"
        $branch->time_slot = $request->start_time . ' - ' . $request->end_time;
        $branch->slot_capacity = $request->slot_capacity;
        // if remove_break flag present and true, clear break fields
        if ($request->input('remove_break') && $request->input('remove_break') == '1') {
            $branch->break_start = null;
            $branch->break_end = null;
        } else {
            // Try to parse user-supplied break times with Carbon; accept flexible formats and store as H:i
            try {
                if ($request->filled('break_start')) {
                    $parsed = \Carbon\Carbon::parse($request->input('break_start'));
                    $branch->break_start = $parsed->format('H:i');
                } else {
                    $branch->break_start = null;
                }
            } catch (\Exception $e) {
                // Parsing failed: clear the value rather than failing validation
                $branch->break_start = null;
            }
            try {
                if ($request->filled('break_end')) {
                    $parsed = \Carbon\Carbon::parse($request->input('break_end'));
                    $branch->break_end = $parsed->format('H:i');
                } else {
                    $branch->break_end = null;
                }
            } catch (\Exception $e) {
                $branch->break_end = null;
            }
            // If both are present, ensure break_end is after break_start; otherwise clear them to avoid invalid state
            if ($branch->break_start && $branch->break_end) {
                try {
                    $bs = \Carbon\Carbon::createFromFormat('H:i', $branch->break_start);
                    $be = \Carbon\Carbon::createFromFormat('H:i', $branch->break_end);
                    if ($be->lte($bs)) {
                        // invalid ordering: clear both
                        $branch->break_start = null;
                        $branch->break_end = null;
                    }
                } catch (\Exception $e) {
                    // if parsing fails here, clear both to be safe
                    $branch->break_start = null;
                    $branch->break_end = null;
                }
            }
        }

        // Auto-generate formatted hours based on operating days and time slot
        if ($branch->operating_days && $branch->time_slot) {
            $branch->hours = $branch->getFormattedHoursAttribute();
        } else {
            $branch->hours = null;
        }

        // Save GCash payment information
        if ($request->filled('gcash_number')) {
            $branch->gcash_number = $request->gcash_number;
        }

        // Handle GCash QR code image upload
        if ($request->hasFile('gcash_qr')) {
            $file = $request->file('gcash_qr');
            $filename = 'gcash_qr_' . $branch->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Store in public disk under gcash folder
            $path = $file->storeAs('gcash', $filename, 'public');
            $branch->gcash_qr = 'storage/gcash/' . $filename;
        }

        $branch->save();
        return redirect()->back()->with('success', 'Branch details updated successfully.');
    }

    // Toggle branch active/inactive
    public function toggleBranch(Request $request, $branchId)
    {
        // Find the branch bypassing the global 'active' scope so inactive branches can be activated
        $branch = Branch::withoutGlobalScope('active')->findOrFail($branchId);
        $admin = Auth::guard('admin')->user();
        // only allow admin of same branch or global admin (no branch_id) to toggle
        if ($admin && $admin->role === 'admin' && $admin->branch_id && $admin->branch_id !== $branch->id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage your own branch.']);
        }
        $branch->active = !$branch->active;
        $branch->save();
        return redirect()->back()->with('success', 'Branch status updated.');
    }

    // Update services assigned to a branch (sync pivot with optional prices)
    public function updateBranchServices(Request $request, $branchId)
    {
        $request->validate([
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer|exists:services,id',
            'prices' => 'nullable|array',
            'prices.*' => 'nullable|numeric|min:0',
        ]);

        $serviceIds = $request->input('service_ids', []);
        $prices = $request->input('prices', []);
        // optional: accept submitted durations array from the form when present
        $submittedDurations = $request->input('durations', []);

        // Load branch early so we can inspect existing pivot rows and preserve duration when syncing
        $branch = \App\Models\Branch::findOrFail($branchId);

        // Build sync array with pivot data, preserving existing pivot.duration when available
        $sync = [];
        foreach ($serviceIds as $sid) {
            $existingDuration = null;
            try {
                if (method_exists($branch, 'services')) {
                    $existing = $branch->services()->where('service_id', $sid)->first();
                    if ($existing && isset($existing->pivot)) {
                        $existingDuration = $existing->pivot->duration ?? null;
                    }
                }
            } catch (\Exception $e) {
                // ignore and fall back to defaults below
                $existingDuration = null;
            }

            // prefer submitted duration if provided, otherwise keep existing pivot duration, otherwise fallback to 1
            $durationToSet = isset($submittedDurations[$sid]) ? $submittedDurations[$sid] : ($existingDuration ?? 1);

            $sync[$sid] = [
                'price' => isset($prices[$sid]) ? $prices[$sid] : null,
                'active' => 1,
                'duration' => $durationToSet,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Perform sync on branch model
        if (method_exists($branch, 'services')) {
            $branch->services()->sync($sync);
        } else {
            // fallback: write directly to DB
            \Illuminate\Support\Facades\DB::table('branch_service')->where('branch_id', $branchId)->delete();
            foreach ($sync as $sid => $pivot) {
                \Illuminate\Support\Facades\DB::table('branch_service')->insert(array_merge(['branch_id' => $branchId, 'service_id' => $sid], $pivot));
            }
        }

        return redirect()->back()->with('success', 'Branch services updated.');
    }

    // Delete a category (clears category field from all services with that category)
    public function deleteCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
        ]);
        $cat = $request->input('category');
        // Set category to empty string instead of null to avoid database constraint violation
        \App\Models\Service::where('category', $cat)->update(['category' => '']);
        return redirect()->back()->with('success', "Category '{$cat}' removed from services.");
    }

    // List packages for a branch
    public function branchPackages($branchId)
    {
        $branch = Branch::findOrFail($branchId);
        $packages = \App\Models\Package::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
        $services = \App\Models\Service::all();
        return view('admin.branchpackages', compact('branch','packages','services'));
    }

    // Create a new package for a branch
    public function storePackage(Request $request, $branchId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer|exists:services,id',
        ]);
        $data = $request->only(['name','description','price']);
        $data['branch_id'] = $branchId;
        $pkg = \App\Models\Package::create($data);
        if ($request->filled('service_ids')) {
            $pkg->services()->sync($request->input('service_ids'));
        }
        return redirect()->back()->with('success', 'Package created.');
    }

    public function updatePackage(Request $request, $packageId)
    {
        $pkg = \App\Models\Package::findOrFail($packageId);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        $pkg->update($request->only(['name','description','price']));
        return redirect()->back()->with('success', 'Package updated.');
    }

    public function deletePackage($packageId)
    {
        $pkg = \App\Models\Package::findOrFail($packageId);
        $pkg->delete();
        return redirect()->back()->with('success', 'Package deleted.');
    }

    // Attach services to a package (with optional quantities)
    public function attachPackageServices(Request $request, $packageId)
    {
        $pkg = \App\Models\Package::findOrFail($packageId);
        $request->validate([
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer|exists:services,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'nullable|integer|min:1',
        ]);
        $services = $request->input('service_ids', []);
        $quantities = $request->input('quantities', []);
        $sync = [];
        foreach ($services as $sid) {
            $sync[$sid] = ['quantity' => isset($quantities[$sid]) ? $quantities[$sid] : 1];
        }
        $pkg->services()->sync($sync);
        return redirect()->back()->with('success', 'Package services updated.');
    }
        // Add a new service to a branch
    public function addService(Request $request, $branchId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'category' => 'nullable|string',
            'new_category' => 'nullable|string',
        ]);
        $service = new \App\Models\Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
    $service->duration = $request->input('duration', 1);
        // category: prefer new_category when provided
        $category = $request->input('new_category') ?: $request->input('category');
        if ($category) $service->category = $category;
        // keep legacy branch_id for backwards compatibility but also create pivot
        $service->branch_id = $branchId;
        $service->save();

        // create pivot entry for branch_service so the service is available to this branch
        if (method_exists($service, 'branches')) {
            $service->branches()->syncWithoutDetaching([
                $branchId => ['price' => $request->price, 'active' => 1, 'duration' => $request->input('duration', 1), 'created_at' => now(), 'updated_at' => now()]
            ]);
        } else {
            // fallback: direct DB insert
            \Illuminate\Support\Facades\DB::table('branch_service')->updateOrInsert(
                ['branch_id' => $branchId, 'service_id' => $service->id],
                ['price' => $request->price, 'active' => 1, 'created_at' => now(), 'updated_at' => now()]
            );
        }
        return redirect()->back()->with('success', 'Service added successfully.');
    }

    // Update service details
    public function updateService(Request $request, $serviceId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
        ]);
        $service = \App\Models\Service::findOrFail($serviceId);
        // If a branch_id is provided, update the branch-specific pivot instead of the global service
        $branchId = $request->input('branch_id');
        if ($branchId) {
            // Debug logging: record incoming duration and whether it was present
            try { Log::info('Admin.updateService called', ['service_id' => $serviceId, 'branch_id' => $branchId, 'duration_input' => $request->input('duration'), 'has_duration' => $request->has('duration')]); } catch (\Exception $e) { /* ignore logging errors */ }
            $branch = \App\Models\Branch::find($branchId);
            $pivotData = [
                'price' => $request->price,
                'active' => 1,
                'updated_at' => now(),
            ];
            if ($request->has('duration')) {
                $pivotData['duration'] = $request->input('duration');
            }
            // Set custom_description even if empty string was submitted so admin can clear it
            if ($request->has('description')) {
                $pivotData['custom_description'] = $request->input('description');
            }
            if ($branch && method_exists($branch, 'services')) {
                // syncWithoutDetaching will insert or update the pivot for this branch-service
                $branch->services()->syncWithoutDetaching([$serviceId => $pivotData]);
                try {
                    $pivotAfter = \Illuminate\Support\Facades\DB::table('branch_service')->where('branch_id', $branchId)->where('service_id', $serviceId)->first();
                    Log::info('Admin.updateService pivot after sync', ['branch_id' => $branchId, 'service_id' => $serviceId, 'pivot' => (array) $pivotAfter]);
                } catch (\Exception $e) { Log::warning('Admin.updateService logging pivot failed', ['err' => $e->getMessage()]); }
            } else {
                \Illuminate\Support\Facades\DB::table('branch_service')->updateOrInsert(
                    ['branch_id' => $branchId, 'service_id' => $serviceId],
                    array_merge($pivotData, ['created_at' => now()])
                );
                try {
                    $pivotAfter = \Illuminate\Support\Facades\DB::table('branch_service')->where('branch_id', $branchId)->where('service_id', $serviceId)->first();
                    Log::info('Admin.updateService pivot after updateOrInsert', ['branch_id' => $branchId, 'service_id' => $serviceId, 'pivot' => (array) $pivotAfter]);
                } catch (\Exception $e) { Log::warning('Admin.updateService logging pivot failed', ['err' => $e->getMessage()]); }
            }
            return redirect()->back()->with('success', 'Service updated for branch.');
        }

        // Otherwise update global service record
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        if ($request->has('duration')) {
            $service->duration = $request->input('duration');
        }
        $service->save();
        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    // Update only the price of a service
    public function updateServicePrice(Request $request, $serviceId)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);
        $service = \App\Models\Service::findOrFail($serviceId);
        $service->price = $request->price;
        $service->save();
        return redirect()->back()->with('success', 'Service price updated successfully.');
    }

    // Delete a service
    public function deleteService($serviceId)
    {
        $service = \App\Models\Service::findOrFail($serviceId);
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }
        // Enable or disable a service
    public function toggleService(Request $request, $serviceId)
    {
        $branchId = $request->input('branch_id');
        // If branch context provided, toggle pivot active flag
        if ($branchId) {
            $pivot = \Illuminate\Support\Facades\DB::table('branch_service')
                ->where('branch_id', $branchId)
                ->where('service_id', $serviceId)
                ->first();
            if ($pivot) {
                $new = !$pivot->active;
                \Illuminate\Support\Facades\DB::table('branch_service')
                    ->where('id', $pivot->id)
                    ->update(['active' => $new, 'updated_at' => now()]);
            } else {
                // create pivot if missing and set active
                \Illuminate\Support\Facades\DB::table('branch_service')->insert([
                    'branch_id' => $branchId,
                    'service_id' => $serviceId,
                    'price' => null,
                    'active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return redirect()->back()->with('success', 'Service status updated for branch.');
        }

        // Fallback: toggle global service active
        $service = \App\Models\Service::findOrFail($serviceId);
        $service->active = !$service->active;
        $service->save();
        return redirect()->back()->with('success', 'Service status updated.');
    }

    // (Removed) toggleStaff: activate/deactivate handled removed from admin UI

    // Reset staff password to default "staff" + branch name (admin action)
    public function resetStaffPassword($staffId)
    {
        $staff = User::findOrFail($staffId);
        if ($staff->role !== 'staff') {
            return redirect()->back()->withErrors(['error' => 'User is not staff.']);
        }
    $admin = Auth::guard('admin')->user();
        if (!$admin || $admin->role !== 'admin') {
            return redirect()->back()->withErrors(['error' => 'Unauthorized.']);
        }
        if ($admin->branch_id && $admin->branch_id !== $staff->branch_id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage staff in your branch.']);
        }

        // Get the staff's branch and create dynamic password
        $branch = $staff->branch;
        if (!$branch) {
            return redirect()->back()->withErrors(['error' => 'Staff member is not assigned to a branch.']);
        }

        // Create password as "staff" + branch name (cleaned)
        $branchName = preg_replace('/[^A-Za-z0-9]/', '', $branch->name); // Remove special chars and spaces
        $defaultPassword = 'staff' . $branchName;

        $staff->password = Hash::make($defaultPassword);
        $staff->save();

        // return success message with the specific password
        return redirect()->back()
            ->with('success', 'Staff password has been reset to "' . $defaultPassword . '".');
    }

    // Change staff password to admin-provided value
    public function changeStaffPassword(Request $request, $staffId)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $staff = User::findOrFail($staffId);
        if ($staff->role !== 'staff') {
            return redirect()->back()->withErrors(['error' => 'User is not staff.']);
        }
    $admin = Auth::guard('admin')->user();
        if (!$admin || $admin->role !== 'admin') {
            return redirect()->back()->withErrors(['error' => 'Unauthorized.']);
        }
        if ($admin->branch_id && $admin->branch_id !== $staff->branch_id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage staff in your branch.']);
        }
        $staff->password = bcrypt($request->password);
        $staff->save();
        return redirect()->back()->with('success', 'Staff password changed successfully.');
    }

    // Delete a staff account (admin action)
    public function deleteStaff(Request $request, $staffId)
    {
        $staff = User::findOrFail($staffId);
        if ($staff->role !== 'staff') {
            return redirect()->back()->withErrors(['error' => 'User is not staff.']);
        }
        $admin = Auth::guard('admin')->user();
        if (!$admin || $admin->role !== 'admin') {
            return redirect()->back()->withErrors(['error' => 'Unauthorized.']);
        }
        if ($admin->branch_id && $admin->branch_id !== $staff->branch_id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage staff in your branch.']);
        }

        // Perform hard delete
        $staff->delete();
        return redirect()->back()->with('success', 'Staff account deleted successfully.');
    }

    // Toggle staff active/inactive (admin action)
    public function toggleStaffActive(Request $request, $staffId)
    {
        $staff = User::findOrFail($staffId);
        if ($staff->role !== 'staff') {
            return redirect()->back()->withErrors(['error' => 'User is not staff.']);
        }
        $admin = Auth::guard('admin')->user();
        if (!$admin || $admin->role !== 'admin') {
            return redirect()->back()->withErrors(['error' => 'Unauthorized.']);
        }
        if ($admin->branch_id && $admin->branch_id !== $staff->branch_id) {
            return redirect()->back()->withErrors(['error' => 'You can only manage staff in your branch.']);
        }
        // flip active flag (default to true if missing)
        $staff->active = !$staff->active;
        $staff->save();
        return redirect()->back()->with('success', 'Staff account status updated.');
    }

    // Show staff-facing reset form (accessed via token link)
    public function showStaffPasswordResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.staff_password_reset', compact('token', 'email'));
    }

    // Handle staff password reset submission
    public function submitStaffPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $record = \Illuminate\Support\Facades\DB::table('password_resets')->where('email', $request->email)->first();
        if (!$record) {
            return redirect()->back()->withErrors(['email' => 'Invalid or expired token.']);
        }
    if (!Hash::check($request->token, $record->token)) {
            return redirect()->back()->withErrors(['token' => 'Invalid token.']);
        }
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        // remove token
        \Illuminate\Support\Facades\DB::table('password_resets')->where('email', $request->email)->delete();
        return redirect()->route('staff.login')->with('success', 'Password updated. You can now log in.');
    }

    /**
     * Show booking settings page (Admin only)
     */
    public function bookingSettings()
    {
        $currentSettings = [
            'minimum_advance_days' => config('booking.minimum_advance_days', 2),
            'maximum_advance_days' => config('booking.maximum_advance_days', 60),
            'default_slot_capacity' => config('booking.default_slot_capacity', 5),
            'allow_staff_override' => config('booking.allow_staff_override', true),
        ];

        // Get admin's branch information for context
        $admin = Auth::guard('admin')->user();
        $branch = $admin && $admin->branch_id ? Branch::find($admin->branch_id) : null;

        return view('admin.booking-settings', compact('currentSettings', 'branch'));
    }

    /**
     * Update booking settings (Admin only)
     */
    public function updateBookingSettings(Request $request)
    {
        $request->validate([
            'minimum_advance_days' => 'required|integer|min:0|max:30',
            'maximum_advance_days' => 'required|integer|min:1|max:365',
            'default_slot_capacity' => 'required|integer|min:1|max:50',
            'allow_staff_override' => 'boolean',
        ]);

        try {
            // Update the environment file or use a settings table
            // For now, we'll update the config temporarily (this will reset on server restart)
            config(['booking.minimum_advance_days' => $request->minimum_advance_days]);
            config(['booking.maximum_advance_days' => $request->maximum_advance_days]);
            config(['booking.default_slot_capacity' => $request->default_slot_capacity]);
            config(['booking.allow_staff_override' => $request->boolean('allow_staff_override')]);

            // For persistent storage, update .env file
            $this->updateEnvFile([
                'BOOKING_MINIMUM_ADVANCE_DAYS' => $request->minimum_advance_days,
                'BOOKING_MAXIMUM_ADVANCE_DAYS' => $request->maximum_advance_days,
                'BOOKING_DEFAULT_SLOT_CAPACITY' => $request->default_slot_capacity,
                'BOOKING_ALLOW_STAFF_OVERRIDE' => $request->boolean('allow_staff_override') ? 'true' : 'false',
            ]);

            // Log the change with admin information
            $admin = Auth::guard('admin')->user();
            Log::info('Booking settings updated by admin', [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'branch_id' => $admin->branch_id,
                'settings' => [
                    'minimum_advance_days' => $request->minimum_advance_days,
                    'maximum_advance_days' => $request->maximum_advance_days,
                    'default_slot_capacity' => $request->default_slot_capacity,
                    'allow_staff_override' => $request->boolean('allow_staff_override'),
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking settings updated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating booking settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings. Please try again.'
            ], 500);
        }
    }

    /**
     * Update environment file with new values
     */
    private function updateEnvFile(array $data)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envFile, $envContent);
    }
}
