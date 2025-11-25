@extends('layouts.clientapp')
@section('content')
<div class="contact-page-wrapper" style="margin-top:120px;">
    <div class="background-container">
        <div class="contact-card" style="max-width:1100px;margin:48px auto 0 auto;padding:32px 24px 40px 24px;background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(0,0,0,0.08);">
            <div class="map-container" style="margin-bottom:40px;">
                <!-- Map Container with Placeholder (Always show placeholder initially) -->
                <div id="map-wrapper" style="position: relative; min-height: 500px;">
                    <!-- Placeholder when no branch selected -->
                    <div id="map-placeholder" style="display: flex; align-items: center; justify-content: center; min-height: 500px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-radius: 14px; text-align: center; box-shadow: 0 4px 24px rgba(0,0,0,0.10);">
                        <div style="padding: 40px;">
                            <i class="fas fa-map-marked-alt" style="font-size: 64px; color: #F56289; margin-bottom: 20px;"></i>
                            <h3 style="color: #333; margin-bottom: 10px;">No Branch Selected</h3>
                            <p style="color: #666; font-size: 16px;">Please select a branch below to view its location on the map</p>
                        </div>
                    </div>
                    <!-- Actual Map -->
                    <iframe id="branch-map" src="" width="100%" height="500" style="display: none; border:0;border-radius:14px;min-height:400px;max-width:1000px;margin:auto;box-shadow:0 4px 24px rgba(0,0,0,0.10);" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
            <div class="details-container">
                <div class="header">
                    <h1 class="clinic-name" style="color:#F56289;">Skin 911 Facial and Slimming Centre</h1>
                </div>
                <div class="mb-3 sub-header">
                    <span class="rating">5.0 <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> (196)</span>
                    <span id="branch-location-detail" class="location-detail"></span>
                </div>
                <div class="mb-4 info-grid" style="display:flex;gap:32px;flex-wrap:wrap;justify-content:center;align-items:stretch;">
                    <div class="info-item" style="flex:1 1 220px;min-width:220px;max-width:320px;display:flex;flex-direction:column;gap:12px;background:#f9f9f9;border-radius:10px;padding:18px 16px;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <div style="display:flex;align-items:center;gap:16px;">
                            <i class="fas fa-map-marker-alt icon" style="font-size:1.5rem;color:#F56289;"></i>
                            <div>
                                <span id="branch-address"></span>
                            </div>
                        </div>
                        <a href="#" id="get-directions-btn" class="btn btn-primary btn-sm" style="display:none;width:100%;background:#F56289;border:none;padding:8px 16px;border-radius:8px;font-weight:600;" target="_blank">
                            <i class="fas fa-directions me-2"></i>Get Directions
                        </a>
                    </div>
                    <div class="info-item" style="flex:1 1 220px;min-width:220px;max-width:320px;display:flex;align-items:center;gap:16px;background:#f9f9f9;border-radius:10px;padding:18px 16px;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <i class="fas fa-clock icon" style="font-size:1.5rem;color:#F56289;"></i>
                        <div id="branch-hours" class="branch-hours-grid">
                            @if(isset($selectedBranch))
                                <strong>Mall Hours:</strong><br>
                                @foreach($selectedBranch->hours as $day => $hours)
                                    <span>{{ $day }}: {{ $hours }}</span><br>
                                @endforeach
                            @else
                                <strong>Mall Hours:</strong><br>
                                <span>Monday - Sunday: 10:00am - 9:00pm</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-item" style="flex:1 1 220px;min-width:220px;max-width:320px;display:flex;align-items:center;gap:16px;background:#f9f9f9;border-radius:10px;padding:18px 16px;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                        <i class="fas fa-credit-card icon" style="font-size:1.5rem;color:#F56289;"></i>
                        <div>
                            <span><strong>Mode of payment</strong></span><br>
                            <span>Cash, Card, E-wallet</span>
                        </div>
                    </div>
                </div>
                <!-- Booking Form -->
                <div class="booking-form-container" style="margin-top:32px;">
                    <h2 style="color:#F56289;">Book an Appointment</h2>

                    @if($errors->any())
                        <div class="mb-4 alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('client.booking.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- City Filter and Branch Selection Row -->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="city-filter">Filter by City</label>
                                    <select id="city-filter" class="form-select">
                                        <option value="">All Cities</option>
                                        @php
                                            $cities = $branches->pluck('city')->unique()->filter()->sort()->values();
                                        @endphp
                                        @foreach($cities as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="branch_id">Branch</label>
                                    <select id="branch_id" name="branch_id" class="form-select" required>
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            @php if (is_array($branch)) $branch = (object) $branch; @endphp
                                            <option value="{{ $branch->id }}"
                                                    data-city="{{ $branch->city ?? '' }}"
                                                    data-address="{{ $branch->address }}"
                                                    data-hours="{{ $branch->hours ?? 'Monday - Sunday: 10:00am - 9:00pm' }}"
                                                    data-map="{{ $branch->map_src }}"
                                                    data-time_slot="{{ $branch->time_slot }}"
                                                    data-slot_capacity="{{ $branch->slot_capacity ?? 5 }}"
                                                    data-gcash-number="{{ $branch->gcash_number ?? '0917 123 4567' }}"
                                                    data-gcash-qr="{{ $branch->gcash_qr ? asset($branch->gcash_qr) : asset('img/gcash-qr.png') }}"
                                                    @if(request('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('branch_id'))
                                        <div class="mt-1 text-danger"><small>{{ $errors->first('branch_id') }}</small></div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="service_category">Filter by Category</label>
                                    <select id="service_category" class="form-select">
                                        <option value="">All Categories</option>
                                        <!-- Categories will be populated dynamically -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="service_dropdown">Services</label>
                                    <div class="custom-multiselect" id="service_dropdown_container">
                                        <div class="multiselect-header form-control d-flex justify-content-between align-items-center" id="service_dropdown_header">
                                            <span id="service_dropdown_text">Select Services</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div class="multiselect-options" id="service_dropdown_options" style="display: none; max-height: 300px; overflow-y: auto; border: 1px solid #ced4da; border-top: none; border-radius: 0 0 0.375rem 0.375rem; background: white; z-index: 1000; position: absolute; width: 100%;">
                                            <!-- Services will be populated dynamically -->
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">Click to select multiple services</small>
                                    @if($errors->has('service_ids'))
                                        <div class="mt-1 text-danger"><small>{{ $errors->first('service_ids') }}</small></div>
                                    @endif
                                    <!-- Hidden inputs for selected services -->
                                    <div id="selected_service_inputs"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Selected Services Display -->
                        <div id="selected-services" class="mb-3" style="display: none;">
                            <h6 class="text-pink mb-2"><i class="fas fa-list-check me-2"></i>Selected Services:</h6>
                            <div id="selected-services-list" class="border rounded p-3 bg-light">
                                <!-- Selected services will be displayed here -->
                            </div>
                        </div>

                        <!-- Recommendations Button -->
                        <div class="mb-3 text-center">
                            <button type="button" class="btn btn-outline-pink w-100" id="showRecommendationsBtn">
                                <i class="bi bi-star-fill me-2"></i>
                                Recommended Services/ Packages
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>

                        <!-- Staff Selection -->
                        <div class="mb-3 form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select_staff_checkbox" name="select_staff_checkbox">
                                <label class="form-check-label" for="select_staff_checkbox">
                                    I want to choose a specific staff member for this appointment
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 form-group" id="staff_selection_container" style="display: none;">
                            <label for="staff_id">Preferred Staff</label>
                            <select name="staff_id" id="staff_id" class="form-select">
                                <option value="">Select Staff</option>
                            </select>
                            @if($errors->has('staff_id'))
                                <div class="mt-1 text-danger"><small>{{ $errors->first('staff_id') }}</small></div>
                            @endif
                        </div>

                        <div class="mb-3 form-group">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <label for="service_price">Price</label>
                                    <input type="text" id="service_price" name="service_price" class="form-control" readonly placeholder="₱0.00">
                                    <!-- Service breakdown section -->
                                    <div id="service_breakdown" class="mt-2" style="display: none;">
                                        <small class="text-muted">Selected services:</small>
                                        <div id="service_list" class="mt-1"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="promo_code">Promo code (optional)</label>
                                    <div id="promo_input_container">
                                        <input type="text" id="promo_code" name="promo_code" class="form-control" placeholder="Enter promo code">
                                    </div>
                                    <div id="promo_applied_message" style="min-height:18px;margin-bottom:6px;color:#198754;font-size:0.95rem;"></div>
                                    @if($errors->has('promo_code'))
                                        <div class="mt-1 text-danger"><small>{{ $errors->first('promo_code') }}</small></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 form-group" id="package-container" style="display:none;">
                            <label for="package_id">Package</label>
                            <select name="package_id" id="package_id" class="form-select">
                                <option value="">Select Package (optional)</option>
                            </select>
                        </div>
                        <!-- Booking Notice -->
                        <div class="mb-4 alert alert-info" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border: 2px solid #F56289; border-radius: 12px; padding: 16px;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check" style="font-size: 1.5rem; color: #F56289; margin-right: 12px;"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: #F56289;">📅 Booking Policy</h6>
                                    <p class="mb-0" style="color: #333; font-size: 0.95rem;">
                                        Please book at least <strong>{{ config('booking.minimum_advance_days', 2) }} days in advance</strong> to secure your appointment.
                                        This ensures our team can properly prepare for your visit and provide the best service experience.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="date">Date</label>
                                <input type="date" name="date" id="date" class="form-control" required min="{{ \Carbon\Carbon::now()->addDays((int) config('booking.minimum_advance_days', 2))->format('Y-m-d') }}" value="{{ request('date') ?? '' }}">
                                @if($errors->has('date'))
                                    <div class="mt-1 text-danger"><small>{{ $errors->first('date') }}</small></div>
                                @endif
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="time_slot">Time Slot</label>
                                    @php
                                    $disabledSlots = [];
                                    $firstBranchId = null;
                                    // determine first branch id safely for arrays or Collections
                                    if (is_array($branches) && count($branches) > 0) {
                                        $first = reset($branches);
                                        $firstBranchId = is_array($first) ? ($first['id'] ?? null) : ($first->id ?? null);
                                    } elseif ($branches instanceof \Illuminate\Support\Collection) {
                                        $first = $branches->first();
                                        $firstBranchId = $first->id ?? null;
                                    } else {
                                        // fallback: try iterating
                                        foreach($branches as $b) {
                                            $firstBranchId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
                                            break;
                                        }
                                    }
                                    $selectedBranchId = request('branch_id') ?? $firstBranchId;
                                    $selectedDate = request('date') ?? date('Y-m-d');
                                    if($selectedBranchId && $selectedDate) {
                                        $selectedBranch = \App\Models\Branch::find($selectedBranchId);
                                        $slotCapacity = $selectedBranch ? ($selectedBranch->slot_capacity ?? config('booking.default_slot_capacity', 5)) : config('booking.default_slot_capacity', 5);
                                        // Generate slots based on branch's time_slot
                                        $branchSlots = [];
                                        if ($selectedBranch && $selectedBranch->time_slot && strpos($selectedBranch->time_slot, ' - ') !== false) {
                                            [$s,$e] = explode(' - ', $selectedBranch->time_slot, 2);
                                            try {
                                                $start = \Carbon\Carbon::createFromFormat('H:i', $s);
                                                $end = \Carbon\Carbon::createFromFormat('H:i', $e);
                                                for ($t = $start->copy(); $t->lt($end); $t->addHour()) {
                                                    $slotStart = $t->format('H:i');
                                                    $slotEnd = $t->copy()->addHour()->format('H:i');
                                                    if (\Carbon\Carbon::createFromFormat('H:i', $slotEnd)->lte($end)) {
                                                        $branchSlots[] = $slotStart . '-' . $slotEnd;
                                                    }
                                                }
                                            } catch (\Exception $e) {
                                                $branchSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
                                            }
                                        } else {
                                            $branchSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
                                        }
                                        foreach($branchSlots as $slot) {
                                            $count = \App\Models\Booking::where('branch_id', $selectedBranchId)
                                                ->where('date', $selectedDate)
                                                ->where('time_slot', $slot)
                                                ->where('status', 'active')
                                                ->count();
                                            if ($count >= $slotCapacity) $disabledSlots[] = $slot;
                                        }
                                    }
                                @endphp
                                <select name="time_slot" id="time_slot" class="form-select" required>
                                    <option value="">Select Time Slot</option>
                                    @php
                                        // Render time options only for selected branch's operating hours if available; otherwise show placeholder
                                        $firstBranch = null;
                                        if (isset($branches) && count((array)$branches) > 0) {
                                            if ($branches instanceof \Illuminate\Support\Collection) $firstBranch = $branches->first(); else $firstBranch = (is_array($branches) ? reset($branches) : $branches[0]);
                                        }
                                        $initialSlots = [];
                                        if ($firstBranch) {
                                            $fb = is_array($firstBranch) ? (object)$firstBranch : $firstBranch;
                                            if (!empty($fb->time_slot) && strpos($fb->time_slot, ' - ') !== false) {
                                                try {
                                                    [$ss,$se] = explode(' - ', $fb->time_slot, 2);
                                                    $start = \Carbon\Carbon::createFromFormat('H:i', trim($ss));
                                                    $end = \Carbon\Carbon::createFromFormat('H:i', trim($se));
                                                    for ($t = $start->copy(); $t->lt($end); $t->addHour()) {
                                                        $slotStart = $t->format('H:i');
                                                        $slotEnd = $t->copy()->addHour()->format('H:i');
                                                        if (\Carbon\Carbon::createFromFormat('H:i', $slotEnd)->lte($end)) {
                                                            $initialSlots[] = $slotStart . '-' . $slotEnd;
                                                        }
                                                    }
                                                } catch (\Exception $e) { $initialSlots = []; }
                                            }
                                        }
                                    @endphp
                                    @if(empty($initialSlots))
                                        <option value="" disabled selected>Select branch to view available times</option>
                                    @else
                                        @foreach($initialSlots as $slot)
                                            @php
                                                $label = $slot;
                                                if (strpos($slot, '-') !== false) {
                                                    try {
                                                        [$sstart, $send] = explode('-', $slot, 2);
                                                        $label = \Carbon\Carbon::createFromFormat('H:i', trim($sstart))->format('g:ia') . ' - ' . \Carbon\Carbon::createFromFormat('H:i', trim($send))->format('g:ia');
                                                    } catch (\Exception $e) {
                                                        $label = $slot;
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $slot }}" @if(in_array($slot, $disabledSlots)) disabled style="background:#eee;color:#aaa;" @endif @if(request('time_slot') == $slot) selected @endif>{{ $label }} @if(in_array($slot, $disabledSlots)) (Full) @endif</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="duration_note" style="margin-top:8px;font-size:0.95rem;color:#555;display:none;"></div>
                                <div id="sessions_note" style="margin-top:6px;font-size:0.95rem;color:#555;display:none;"></div>
                                @if($errors->has('time_slot'))
                                    <div class="alert alert-danger" style="margin-bottom:16px;">
                                        {{ $errors->first('time_slot') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" id="openPaymentModal" class="px-4 py-2 btn btn-pink" style="background:#F56289;color:#fff;">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recommendations Modal -->
<div class="modal fade" id="recommendationsModal" tabindex="-1" aria-labelledby="recommendationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%); border: none; padding: 25px 30px;">
                <h5 class="modal-title fw-bold d-flex align-items-center" id="recommendationsModalLabel" style="color: white !important;">
                    <i class="bi bi-star-fill me-2" style="font-size: 1.3rem; color: white !important;"></i>
                    <span style="color: white !important;">Recommended For You</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1); opacity: 1;"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                @php
                    $userPrefs = $userPreferences ?? [];
                    $recommendedServices = [];
                    $recommendedPackages = [];

                    // Map preferences to service categories
                    $categoryMap = [
                        'Facial' => ['Facial', 'Skin Care'],
                        'Laser' => ['Laser', 'Hair Removal', 'Whitening'],
                        'Slimming' => ['Slimming', 'Body Contouring'],
                        'Immuno' => ['Immunotherapy', 'Wellness', 'IV Therapy'],
                        'Hair Removal' => ['Hair Removal', 'Laser', 'Waxing']
                    ];

                    // Get recommended services based on preferences
                    if (!empty($userPrefs)) {
                        $categories = [];
                        foreach ($userPrefs as $pref) {
                            if (isset($categoryMap[$pref])) {
                                $categories = array_merge($categories, $categoryMap[$pref]);
                            }
                        }
                        $categories = array_unique($categories);

                        if (!empty($categories)) {
                            $recommendedServices = $services->filter(function($service) use ($categories) {
                                foreach ($categories as $cat) {
                                    if (stripos($service->category, $cat) !== false || stripos($service->name, $cat) !== false) {
                                        return true;
                                    }
                                }
                                return false;
                            })->take(6);

                            $recommendedPackages = $packages->filter(function($package) use ($categories) {
                                foreach ($categories as $cat) {
                                    if (stripos($package->name, $cat) !== false || stripos($package->description, $cat) !== false) {
                                        return true;
                                    }
                                }
                                return false;
                            })->take(4);
                        }
                    }

                    // Get all packages for branch filtering (will be shown/hidden by JavaScript)
                    $allPackages = $packages ?? collect();
                @endphp

                @if(empty($userPrefs))
                    <div class="py-5 text-center">
                        <i class="bi bi-info-circle" style="font-size: 4rem; color: #F56289; opacity: 0.5;"></i>
                        <h5 class="mt-3 mb-2" style="color: #666;">No Preferences Set</h5>
                        <p class="text-muted">Set your service preferences in your profile to get personalized recommendations!</p>
                        <a href="{{ route('client.profile.edit') }}" class="mt-3 btn btn-pink">
                            <i class="bi bi-gear me-2"></i>Update Preferences
                        </a>
                    </div>
                @else
                    <div class="mb-4">
                        <h6 class="mb-3 fw-bold" style="color: #333;">
                            <i class="bi bi-heart-fill me-2" style="color: #F56289;"></i>
                            Based on your interests:
                            @foreach($userPrefs as $pref)
                                <span class="badge bg-pink ms-1" style="background: #F56289;">{{ $pref }}</span>
                            @endforeach
                        </h6>
                        <div class="mb-3 alert alert-info" style="background: #e8f4ff; border: 1px solid #b3d9ff;">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Select a branch first to see prices for that location</small>
                        </div>
                    </div>

                    @if($recommendedServices->count() > 0)
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold" style="color: #555;">
                                <i class="bi bi-stars me-2" style="color: #FFD700;"></i>
                                Recommended Services
                            </h6>
                            <div class="list-group">
                                @foreach($recommendedServices as $service)
                                    <div class="list-group-item d-flex justify-content-between align-items-center" data-type="service" data-id="{{ $service->id }}" data-name="{{ $service->name }}">
                                        <div>
                                            <div class="fw-bold">{{ $service->name }}</div>
                                            <div class="text-muted small">{{ $service->category }}</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="gap:12px;">
                                            <div class="service-price text-nowrap" data-service-id="{{ $service->id }}">

                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-pink btn-select-service">
                                                Select
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($recommendedPackages->count() > 0)
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold" style="color: #555;">
                                <i class="bi bi-gift me-2" style="color: #FF69B4;"></i>
                                Recommended Packages
                            </h6>
                            <div class="list-group">
                                @foreach($recommendedPackages as $package)
                                    <div class="list-group-item package-container" data-package-id="{{ $package->id }}">
                                        <div class="fw-bold mb-2">{{ $package->name }}</div>
                                        <div class="text-muted small mb-3">{{ Str::limit($package->description, 100) }}</div>
                                        <div class="package-price mb-3" data-package-id="{{ $package->id }}">
                                            <span class="price-loader text-muted" style="font-size: 0.9rem;">₱{{ number_format($package->price, 2) }}</span>
                                        </div>
                                        <div class="services-in-package">
                                            <small class="text-muted fw-semibold mb-2 d-block">Services in this package:</small>
                                            @foreach($package->services as $service)
                                                <div class="d-flex justify-content-between align-items-center mb-2 ps-3 border-start border-primary" data-type="package-service" data-package-id="{{ $package->id }}" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}">
                                                    <div>
                                                        <div class="fw-semibold small">{{ $service->name }}</div>
                                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $service->category }} • {{ $service->duration }} min</div>
                                                    </div>
                                                    <button type="button" class="btn btn-xs btn-outline-pink btn-select-package-service">
                                                        Select
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($allPackages->count() > 0)
                        <div class="mb-3" id="packagesSection">
                            <h6 class="mb-3 fw-bold" style="color: #555;">
                                <i class="bi bi-gift me-2" style="color: #FF69B4;"></i>
                                Available Packages
                            </h6>
                            <div class="list-group" id="packagesList">
                                @foreach($allPackages as $package)
                                    @php
                                        // Find which branches have this package
                                        $packageBranches = [];
                                        foreach($branches as $branch) {
                                            $branchModel = \App\Models\Branch::find($branch->id);
                                            if ($branchModel) {
                                                $hasPackage = \App\Models\Package::where('id', $package->id)
                                                    ->where(function($q) use ($branchModel) {
                                                        $q->where('branch_id', $branchModel->id)
                                                          ->orWhereNull('branch_id');
                                                    })
                                                    ->exists();
                                                if ($hasPackage) {
                                                    $packageBranches[] = $branch->name;
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="list-group-item package-item"
                                         data-type="package"
                                         data-id="{{ $package->id }}"
                                         data-name="{{ $package->name }}">
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $package->name }}</div>
                                            <div class="mb-1 text-muted small">{{ Str::limit($package->description, 80) }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">
                                                <i class="bi bi-geo-alt"></i>
                                                Available at: <span class="text-primary fw-semibold">{{ implode(', ', $packageBranches) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center" style="gap:12px;">
                                            <div class="package-price text-nowrap" data-package-id="{{ $package->id }}">
                                                <span class="price-loader text-muted" style="font-size: 0.9rem;">₱{{ number_format($package->price, 2) }}</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-pink btn-select-package">
                                                Select
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="noPackagesMessage" class="py-3 text-center text-muted" style="display: none;">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No packages available for this branch</p>
                            </div>
                        </div>
                    @endif

                    @if($recommendedServices->count() == 0 && $recommendedPackages->count() == 0)
                        <div class="py-4 text-center">
                            <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="mt-3 text-muted">No recommendations found for your preferences yet.</p>
                            <p class="text-muted small">Check back later or browse all our services!</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Payment Method Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%); border-radius: 20px 20px 0 0; border: none;">
                <h5 class="text-white modal-title" id="paymentModalLabel">
                    <i class="fas fa-credit-card me-2"></i>Choose Payment Method
                </h5>
                <button type="button" id="closePaymentModalBtn" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <p class="mb-4 text-center text-muted">Select your preferred payment method to complete your booking</p>

                <!-- Payment Method Tabs -->
                <ul class="mb-4 nav nav-pills justify-content-center" id="paymentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="credit-card-tab" data-bs-toggle="pill" data-bs-target="#credit-card" type="button" role="tab">
                            <i class="fas fa-credit-card"></i> Card
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gcash-tab" data-bs-toggle="pill" data-bs-target="#gcash" type="button" role="tab">
                            <i class="fas fa-mobile-alt"></i> GCash
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cash-tab" data-bs-toggle="pill" data-bs-target="#cash" type="button" role="tab">
                            <i class="fas fa-money-bill-wave"></i> Cash
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="paymentTabContent">
                    <!-- Credit/Debit Card -->
                    <div class="tab-pane fade show active" id="credit-card" role="tabpanel">
                        <form id="cardPaymentForm">
                            @if(isset($savedCardData) && $savedCardData)
                            <div class="mb-3 alert alert-info" id="savedCardNotice" style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border: 2px solid #F56289; border-radius: 8px;">
                                <i class="fas fa-credit-card me-2"></i>
                                <strong>Saved Card Detected!</strong> Your previously saved card details have been loaded.
                            </div>
                            @endif
                            <div class="mb-3">
                                <label for="card_type" class="form-label">Card Type</label>
                                <select class="form-select" id="card_type" name="card_type" required>
                                    <option value="">Select Card Type</option>
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">Mastercard</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="card_number" class="form-label">Card Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" pattern="[0-9\s]*" inputmode="numeric" required>
                                    <button type="button" class="btn btn-outline-secondary" id="clearCardBtn" style="display:none;" title="Use different card">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <small class="text-success" id="savedCardHint" style="display:none;">
                                    <i class="fas fa-check-circle"></i> Saved card loaded. You can proceed or click X to use a different card.
                                </small>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="card_expiry" class="form-label">Expiry Date</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <select class="form-select" id="card_expiry_month" required>
                                                <option value="">Month</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-select" id="card_expiry_year" required>
                                                <option value="">Year</option>
                                                @php
                                                    $currentYear = date('Y');
                                                    for ($i = 0; $i <= 10; $i++) {
                                                        $year = $currentYear + $i;
                                                        echo "<option value='" . substr($year, -2) . "'>" . $year . "</option>";
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="card_expiry" name="card_expiry">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="card_cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="card_cvv" name="card_cvv" placeholder="123" maxlength="3" pattern="[0-9]*" inputmode="numeric" required>
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <div class="mt-4 mb-3">
                                <h6 class="fw-bold" style="color: #F56289;">Billing Address</h6>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="billing_first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="billing_first_name" name="billing_first_name" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="billing_last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="billing_last_name" name="billing_last_name" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Street Address</label>
                                <input type="text" class="form-control" id="billing_address" name="billing_address" placeholder="Street address" required>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="billing_city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="billing_city" name="billing_city" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="billing_zip" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="billing_zip" name="billing_zip" pattern="[0-9]*" inputmode="numeric" maxlength="4"required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="billing_country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="billing_country" name="billing_country" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="billing_phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="billing_phone" name="billing_phone" inputmode="numeric" maxlength="11" pattern="09[0-9]{9}" placeholder="Enter 11-digit number starting with 09" required>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="save_card" name="save_card">
                                <label class="form-check-label" for="save_card">
                                    Save this card for future bookings
                                </label>
                            </div>
                        </form>
                    </div>

                    <!-- GCash -->
                    <div class="tab-pane fade" id="gcash" role="tabpanel">
                        <div class="text-center">
                            <h6 class="mb-4" style="color: #007DFF; font-weight: 600;">
                                <i class="fas fa-wallet me-2"></i>Pay via GCash
                            </h6>
                            <div class="p-4 mb-3 d-flex justify-content-center align-items-center" style="background: linear-gradient(135deg, #007DFF 0%, #0099FF 100%); border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 125, 255, 0.2);">
                                <img id="gcashQrImage" src="{{ asset('img/gcash-qr.png') }}" alt="GCash QR Code" class="img-fluid" style="max-width: 300px; height: auto; border-radius: 10px; background: white; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: block; margin: 0 auto;">
                            </div>
                            <div class="p-3 mb-3" style="background: white; border-radius: 12px; border: 2px solid #007DFF;">
                                <h4 style="color: #007DFF; margin-bottom: 5px;">
                                    <i class="fas fa-mobile-alt me-2"></i><span id="gcashNumber">0917 123 4567</span>
                                </h4>
                                <p class="mb-0" style="color: #666; font-size: 0.9rem;"><span id="branchName">Skin911</span> Official GCash Account</p>
                            </div>
                            <div class="alert alert-success" style="border-left: 4px solid #28a745;">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Payment Instructions:</strong><br>
                                <small>1. Scan the QR code or send payment to the number above<br>
                                2. Upload your GCash receipt image below<br>
                                3. Click "Confirm & Book" to complete your reservation<br>
                                4. Show your GCash receipt at the branch</small>
                            </div>
                            <div class="mb-3">
                                <label for="modal_gcash_receipt" class="form-label">Upload GCash Receipt (Optional)</label>
                                <input type="file" id="modal_gcash_receipt" class="form-control" accept="image/*">
                                <div class="form-text">Please upload a clear image of your GCash payment receipt.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Cash Payment -->
                    <div class="tab-pane fade" id="cash" role="tabpanel">
                        <div class="text-center">
                            <div class="mb-4">
                                <i class="fas fa-money-bill-wave" style="font-size: 80px; color: #28a745;"></i>
                            </div>
                            <h5 class="mb-3">Pay Cash at the Branch</h5>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Your booking will be reserved. Please pay at the branch before your appointment.
                            </div>
                            <p class="text-muted">
                                Payment is due at least <strong>1 hour before</strong> your scheduled appointment.
                                Unpaid bookings may be cancelled.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border: none; padding: 1.5rem 2rem;">
                <button type="button" id="cancelPaymentBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmPaymentBtn" class="btn btn-pink" style="background:#F56289;color:#fff;">
                    <i class="fas fa-check me-2"></i>Confirm & Book
                </button>
            </div>
        </div>
    </div>
</div>

@php
    $disabledSlots = [];
    $firstBranchId = null;
    if (is_array($branches) && count($branches) > 0) {
        $first = reset($branches);
        $firstBranchId = is_array($first) ? ($first['id'] ?? null) : ($first->id ?? null);
    } elseif ($branches instanceof \Illuminate\Support\Collection) {
        $first = $branches->first();
        $firstBranchId = $first->id ?? null;
    } else {
        foreach($branches as $b) {
            $firstBranchId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            break;
        }
    }
    $selectedBranchId = request('branch_id') ?? $firstBranchId;
    $selectedDate = request('date') ?? date('Y-m-d');
    if($selectedBranchId && $selectedDate) {
        foreach(["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"] as $slot) {
            $count = \App\Models\Booking::where('branch_id', $selectedBranchId)
                ->where('date', $selectedDate)
                ->where('time_slot', $slot)
                ->where('status', 'active')
                ->count();
            if ($count >= 5) $disabledSlots[] = $slot;
        }
    }
@endphp
<style>
    .btn-pink, .table-pink, .card-body h1, .card-body h2, .modal-title, .rating i {
        background-color: #F56289 !important;
        color: #fff !important;
        border-color: #F56289 !important;
    }
    .btn-pink {
        color: #fff !important;
    }
    .table-pink {
        background-color: #F56289 !important;
        color: #fff !important;
    }
    .card-body h1, .card-body h2, .modal-title {
        color: #F56289 !important;
        background: none !important;
    }
    .rating i {
        color: #F56289 !important;
    }
    .form-label, .form-select, .form-control {
        border-radius: 8px;
    }

    /* Animated Validation Alert */
    .animated-validation-alert {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10000;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        animation: popIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        cursor: pointer;
        min-width: 300px;
        max-width: 90%;
    }

    .animated-validation-alert .alert-content {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .animated-validation-alert i {
        font-size: 1.8rem;
        animation: pulse 1s infinite;
    }

    @keyframes popIn {
        0% {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.5);
        }
        50% {
            transform: translate(-50%, -50%) scale(1.05);
        }
        100% {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    }

    @keyframes popOut {
        0% {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
        100% {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.8);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }

    /* Card Loaded Notification */
    .card-loaded-notification {
        margin-top: 10px;
        padding: 12px 15px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
        font-weight: 500;
        animation: popIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .card-loaded-notification i {
        font-size: 1.2rem;
    }

    @media (max-width: 767.98px) {
  .info-grid {
    flex-direction: column !important;
    gap: 16px !important;
    align-items: stretch !important;
  }
  .info-item {
    min-width: 0 !important;
    max-width: 100% !important;
    flex: 1 1 100% !important;
    padding: 14px 10px !important;
    font-size: 0.98rem !important;
  }
  .booking-form-container h2 {
    font-size: 1.3rem !important;
  }
  .booking-form-container .form-group label {
    font-size: 1rem !important;
  }
  .booking-form-container .row {
    flex-direction: column !important;
  }
  .booking-form-container .col-md-6 {
    width: 100% !important;
    max-width: 100% !important;
  }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var branchSelect = document.getElementById('branch_id');
    var dateInput = document.getElementById('date');
    var timeSlotSelect = document.getElementById('time_slot');
    var serviceSelect = document.getElementById('service_id');
    var packageContainer = document.getElementById('package-container');
    var packageSelect = document.getElementById('package_id');

    // Claimed promos data (ensure a plain JS array)
    var claimedPromos = @json(isset($claimedPromos) ? $claimedPromos->values()->toArray() : []);
    // Available promos data (ensure a plain JS array)
    var availablePromos = @json(isset($availablePromos) ? $availablePromos->values()->toArray() : []);

    // Set minimum date based on advance booking requirement
    var minimumAdvanceDays = {{ config('booking.minimum_advance_days', 2) }};
    if (dateInput && minimumAdvanceDays > 0) {
        var today = new Date();
        var minDate = new Date(today);
        minDate.setDate(today.getDate() + minimumAdvanceDays);

        var year = minDate.getFullYear();
        var month = String(minDate.getMonth() + 1).padStart(2, '0');
        var day = String(minDate.getDate()).padStart(2, '0');
        var minDateString = year + '-' + month + '-' + day;

        dateInput.setAttribute('min', minDateString);

        // If current value is before minimum date, clear it
        if (dateInput.value && dateInput.value < minDateString) {
            dateInput.value = '';
        }
    }

    // Build branch data map: services, packages, time_slot, slot_capacity
    var branchData = {};
    @foreach($branches as $branch)
        @php if (is_array($branch)) $branch = (object) $branch; @endphp
        @php
            $bModel = \App\Models\Branch::find($branch->id);
            $servicesForBranch = [];
            $packagesForBranch = [];
            if ($bModel) {
                try {
                    // only include services that are enabled globally and enabled in the pivot (if present)
                    $servicesForBranch = $bModel->services()->get()->filter(function($s){
                            $globActive = isset($s->active) ? (bool)$s->active : true;
                            $pivotActive = isset($s->pivot) && isset($s->pivot->active) ? (bool)$s->pivot->active : true;
                            return $globActive && $pivotActive;
                        })->map(function($s){ return [
                            'id'=>$s->id,
                            'name'=>$s->name,
                            'price'=> $s->pivot->price ?? $s->price ?? null,
                            'duration' => $s->pivot->duration ?? $s->duration ?? 1,
                            'default_sessions' => $s->pivot->default_sessions ?? $s->default_sessions ?? 1,
                            'is_package' => $s->pivot->is_package ?? $s->is_package ?? false,
                            'category' => $s->category ?? '',
                        ]; })->values()->toArray();
                } catch (\Exception $e) {
                    $servicesForBranch = [];
                }
                try {
                    $packagesForBranch = \App\Models\Package::where('branch_id', $bModel->id)->orWhereNull('branch_id')->get()->map(function($p){ return ['id'=>$p->id,'name'=>$p->name,'price'=>$p->price]; })->toArray();
                } catch (\Exception $e) {
                    $packagesForBranch = [];
                }
            }
        @endphp
        branchData[{{ $branch->id }}] = {
            services: @json($servicesForBranch),
            packages: @json(collect($packagesForBranch)->map(function($p){ $pkg = \App\Models\Package::find($p['id']); return array_merge($p, ['duration' => $pkg ? $pkg->duration : 0]); })->values()),
            time_slot: @json($branch->time_slot ?? ''),
            slot_capacity: @json($branch->slot_capacity ?? 5),
            break_start: @json($branch->break_start ?? ''),
            break_end: @json($branch->break_end ?? ''),
            operating_days: @json($branch->operating_days ?? '')
        };
    @endforeach

    function parseHHMMToMinutes(hhmm) {
        var parts = hhmm.split(':');
        var h = parseInt(parts[0], 10) || 0;
        var m = parseInt(parts[1], 10) || 0;
        return h * 60 + m;
    }

    function minutesToHHMM(mins) {
        var h = Math.floor(mins / 60);
        var m = mins % 60;
        return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0');
    }

    function buildHourlySlotsFromRange(rangeStr) {
        if (!rangeStr || rangeStr.indexOf('-') === -1) return [];
        try {
            var parts = rangeStr.split('-');
            var start = parts[0].trim();
            var end = parts[1].trim();
            var sMin = parseHHMMToMinutes(start);
            var eMin = parseHHMMToMinutes(end);
            var slots = [];
            for (var cur = sMin; cur + 60 <= eMin; cur += 60) {
                var s = minutesToHHMM(cur);
                var e = minutesToHHMM(cur + 60);
                slots.push(s + '-' + e);
            }
            return slots;
        } catch (err) {
            return [];
        }
    }

    function formatSlotLabel(slot) {
        if (!slot || slot.indexOf('-') === -1) return slot;
        var parts = slot.split('-');
        try {
            var sParts = parts[0].split(':');
            var eParts = parts[1].split(':');
            var sh = parseInt(sParts[0],10);
            var sm = parseInt(sParts[1],10);
            var eh = parseInt(eParts[0],10);
            var em = parseInt(eParts[1],10);
            function toAmPm(h,m){
                var am = h < 12 ? 'am' : 'pm';
                var hh = h % 12 === 0 ? 12 : h % 12;
                return hh + ':' + String(m).padStart(2,'0') + am;
            }
            return toAmPm(sh,sm) + ' - ' + toAmPm(eh,em);
        } catch (err) {
            return slot;
        }
    }

    function slotOverlapsBreak(slot, breakStart, breakEnd) {
        if (!breakStart || !breakEnd) return false;
        try {
            var s = slot.split('-')[0];
            var e = slot.split('-')[1];
            var sMin = parseHHMMToMinutes(s);
            var eMin = parseHHMMToMinutes(e);
            var bs = parseHHMMToMinutes(breakStart);
            var be = parseHHMMToMinutes(breakEnd);
            return (sMin < be) && (eMin > bs);
        } catch (err) { return false; }
    }

    function updateTimeSlots() {
        var branchId = branchSelect.value;
        var date = dateInput.value;
        // clear existing options
        timeSlotSelect.innerHTML = '<option value="">Select Time Slot</option>';
        if (!branchId || !date) return;
        var b = branchData[branchId] || {time_slot:'', slot_capacity:5};
        // Build hourly slots and also build duration-sized start slots (step = duration)
        var hourlySlots = buildHourlySlotsFromRange(b.time_slot);
        if (!hourlySlots.length) {
            // no branch hours configured - leave empty and let the UI show a placeholder
            hourlySlots = [];
        }
        // helper: build start slots that are duration-hours long, stepping by 60 minutes (sliding window)
    function buildDurationSlotsFromHourly(hourly, durationHours) {
            var starts = [];
            if (!hourly || hourly.length === 0) return starts;
            // parse first start and last end
            try {
                var firstStart = hourly[0].split('-')[0];
                var lastEnd = hourly[hourly.length - 1].split('-')[1];
                var sMin = parseHHMMToMinutes(firstStart);
                var eMin = parseHHMMToMinutes(lastEnd);
        var step = 60; // slide by 1 hour so a 2-hour service can start at each hour boundary
        for (var cur = sMin; cur + (durationHours * 60) <= eMin; cur += step) {
                    var start = minutesToHHMM(cur);
                    var end = minutesToHHMM(cur + (durationHours * 60));
                    // create required hourly subslots for this start
                    var required = [];
                    var fits = true;
                    for (var k = 0; k < durationHours; k++) {
                        var ss = minutesToHHMM(cur + k*60) + '-' + minutesToHHMM(cur + (k+1)*60);
                        // ensure the subslot exists in hourly list
                        if (hourly.indexOf(ss) === -1) { fits = false; break; }
                        required.push(ss);
                    }
                    if (fits) {
                        // store object: value is first hourly slot (used by backend), labelStart/labelEnd for UI label, required array for checks
                        starts.push({ value: required[0], labelStart: start, labelEnd: end, required: required });
                    }
                }
            } catch (err) {
                // ignore
            }
            return starts;
        }
        // Determine selected item duration (service or package) to validate start times
        var selectedServiceDuration = 1;
        try {
            var selectedServiceIds = getSelectedServiceIds();
            var pid = packageSelect ? packageSelect.value : null;
            if (pid && b.packages) {
                var pkg = b.packages.find(function(x){ return String(x.id) === String(pid); });
                if (pkg && pkg.duration) {
                    selectedServiceDuration = Number(pkg.duration) || 1;
                } else {
                    selectedServiceDuration = 1;
                }
            } else if (selectedServiceIds.length > 0 && b.services) {
                // Calculate total duration for all selected services
                var totalDuration = 0;
                selectedServiceIds.forEach(function(sid) {
                    var svc = b.services.find(function(x){ return String(x.id) === String(sid); });
                    if (svc && svc.duration) {
                        totalDuration += Number(svc.duration) || 1;
                    } else {
                        totalDuration += 1; // default duration
                    }
                });
                selectedServiceDuration = totalDuration;
            }
        } catch (err) { selectedServiceDuration = 1; }

        var durationStarts = buildDurationSlotsFromHourly(hourlySlots, selectedServiceDuration);

        // Render duration-sized start slots
        durationStarts.forEach(function(ds){
            var isBreak = false;
            if (b.break_start && b.break_end) {
                // if any required subslot overlaps break, mark as break
                for (var ii = 0; ii < ds.required.length; ii++) {
                    if (slotOverlapsBreak(ds.required[ii], b.break_start, b.break_end)) { isBreak = true; break; }
                }
            }
            var opt = document.createElement('option');
            opt.value = ds.value; // first hourly slot (backend expects hourly start)
            opt.textContent = formatSlotLabel(ds.labelStart + '-' + ds.labelEnd) + (isBreak ? ' (Break)' : '');
            if (isBreak) { opt.disabled = true; opt.style.background = '#f2f2f2'; opt.style.color = '#888'; }
            timeSlotSelect.appendChild(opt);
        });

        // fetch full slots and unavailable starts from API (pass duration) and disable matching
        fetch(`/api/booking/slots?branch_id=${branchId}&date=${date}&duration=${selectedServiceDuration}`)
            .then(response => response.json())
            .then(data => {
                Array.from(timeSlotSelect.options).forEach(function(option) {
                    if (!option.value) return;
                    if (data.fullSlots && data.fullSlots.includes(option.value)) {
                        option.disabled = true;
                        option.textContent = option.textContent + ' (Full)';
                        option.style.background = '#eee';
                        option.style.color = '#aaa';
                    }
                    if (data.unavailableStarts && data.unavailableStarts.includes(option.value)) {
                        option.disabled = true;
                        option.textContent = option.textContent + ' (Unavailable)';
                        option.style.background = '#f5f5f5';
                        option.style.color = '#999';
                    }
                });
                // after options updated, refresh coverage note in case a selected time remains
                updateSelectedCoverage();
            });
    }

    function toAmPm(hhmm) {
        var parts = hhmm.split(':'); var h = parseInt(parts[0],10); var m = parseInt(parts[1],10)||0; var am = h < 12 ? 'am' : 'pm'; var hh = h % 12 === 0 ? 12 : h % 12; return hh + ':' + String(m).padStart(2,'0') + am; }

    function updateSelectedCoverage() {
        var note = document.getElementById('duration_note');
        if (!note) return;
        var selectedServiceIds = getSelectedServiceIds();
        var pid = packageSelect ? packageSelect.value : null;
        var duration = 1;
        if (pid && branchData[branchSelect.value] && branchData[branchSelect.value].packages) {
            // packages currently don't have durations per-item here; keep default 1
            duration = 1;
        } else if (selectedServiceIds.length > 0 && branchData[branchSelect.value] && branchData[branchSelect.value].services) {
            // Calculate total duration for all selected services
            duration = 0;
            selectedServiceIds.forEach(function(sid) {
                var svc = branchData[branchSelect.value].services.find(function(x){ return String(x.id) === String(sid); });
                if (svc && svc.duration) {
                    duration += Number(svc.duration) || 1;
                } else {
                    duration += 1;
                }
            });
        }
        var slot = timeSlotSelect.value;
        if (!slot || duration <= 1) { note.style.display = 'none'; } // keep displaying sessions note even if duration is 1
        try {
            var parts = slot.split('-');
            var start = parts[0].trim();
            var sh = parseInt(start.split(':')[0],10);
            var sm = parseInt(start.split(':')[1],10)||0;
            var startMins = sh*60 + sm;
            var slotsList = [];
            for (var i = 0; i < duration; i++) {
                var sMin = startMins + i*60;
                var eMin = sMin + 60;
                var sHH = String(Math.floor(sMin/60)).padStart(2,'0');
                var sMM = String(sMin%60).padStart(2,'0');
                var eHH = String(Math.floor(eMin/60)).padStart(2,'0');
                var eMM = String(eMin%60).padStart(2,'0');
                slotsList.push(toAmPm(sHH + ':' + sMM) + ' - ' + toAmPm(eHH + ':' + eMM));
            }
            note.textContent = 'This booking will occupy: ' + slotsList.join(', ') + ' (' + duration + ' hr' + (duration>1?'s':'') + ')';
            note.style.display = '';
        } catch (e) { note.style.display = 'none'; }

        // Show sessions included for the selected service (from branchData mapping)
        var sessionNote = document.getElementById('sessions_note');
        if (sessionNote) {
            var sessions = 0;
            if (pid && branchData[branchSelect.value] && branchData[branchSelect.value].packages) {
                // If a package is selected, packages mapping currently doesn't include credit counts per package;
                // leaving sessions undefined for now. We'll rely on service default_sessions for single-service packages.
            }
            if (!pid && sid && branchData[branchSelect.value] && branchData[branchSelect.value].services) {
                var svc = branchData[branchSelect.value].services.find(function(x){ return String(x.id) === String(sid); });
                if (svc && svc.default_sessions) sessions = Number(svc.default_sessions) || 1;
            }
            if (sessions > 1) {
                sessionNote.textContent = 'Sessions included: ' + sessions + (sessions>1 ? ' sessions' : ' session');
                sessionNote.style.display = '';
            } else {
                sessionNote.style.display = 'none';
            }
        }
    }

    function updatePromoOptions(branchId, serviceId) {
        var container = document.getElementById('promo_input_container');
        if (!container) return;

        // Clear existing content
        container.innerHTML = '';

        if (!branchId) {
            // No branch selected, show input
            var input = document.createElement('input');
            input.type = 'text';
            input.id = 'promo_code';
            input.name = 'promo_code';
            input.className = 'form-control';
            input.placeholder = 'Enter promo code';
            container.appendChild(input);
            // Append the message below the input
            var promoMessage = document.getElementById('promo_applied_message');
            if (promoMessage) container.appendChild(promoMessage);
            return;
        }

        // Filter available promos for this branch and service
        var promosForBranch = availablePromos.filter(function(promo) {
            return (promo.branch_id == branchId) || (!promo.branch_id && (promo.branch_id !== 0 && promo.branch_id !== null));
        });

        // If no available promos but user has a claimed promo for this branch, include it so dropdown shows
        try {
            if ((!promosForBranch || promosForBranch.length === 0) && claimedPromos && Array.isArray(claimedPromos)) {
                var claimed = claimedPromos.find(function(cp){
                    var pBranch = (cp.branch_id !== undefined) ? cp.branch_id : (cp.promo && cp.promo.branch_id ? cp.promo.branch_id : null);
                    return String(pBranch) === String(branchId);
                });
                if (claimed) {
                    var claimedCode = claimed.code || (claimed.promo && claimed.promo.code) || null;
                    var claimedTitle = (claimed.promo && claimed.promo.title) || (claimed.title || 'Claimed Promo');
                    var claimedDiscount = (claimed.promo && claimed.promo.discount) || (claimed.discount || 0);
                    if (claimedCode) {
                        promosForBranch = [{ code: claimedCode, title: claimedTitle, discount: claimedDiscount, branch_id: branchId, claimed: true }];
                    }
                }
            }
        } catch (e) { console.error('Error merging claimed promo into promosForBranch', e); }

        if (serviceId) {
            promosForBranch = promosForBranch.filter(function(promo) {
                // If promo has services, check if serviceId is in them; if no services, it's global
                if (!promo.services || promo.services.length === 0) {
                    return true; // global promo
                }
                return promo.services.some(function(service) {
                    return service.id == serviceId;
                });
            });
        }

        if (promosForBranch.length > 0) {
            // Show dropdown
            var select = document.createElement('select');
            select.id = 'promo_code';
            select.name = 'promo_code';
            select.className = 'form-control';
            var defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select a promo code';
            select.appendChild(defaultOption);
            promosForBranch.forEach(function(promo) {
                var option = document.createElement('option');
                option.value = promo.code;
                // Only show the promo code (do not render full promo details)
                option.textContent = promo.code + (promo.claimed ? ' (claimed)' : '');
                select.appendChild(option);
            });
            container.appendChild(select);

            // Append the message below the select
            var promoMessage = document.getElementById('promo_applied_message');
            if (promoMessage) container.appendChild(promoMessage);

            // Handle change to trigger validation
            select.addEventListener('change', function() {
                validatePromoCode();
            });
        } else {
            // Show input
            var input = document.createElement('input');
            input.type = 'text';
            input.id = 'promo_code';
            input.name = 'promo_code';
            input.className = 'form-control';
            input.placeholder = 'Enter promo code';
            container.appendChild(input);

            // Append the message below the input
            var promoMessage = document.getElementById('promo_applied_message');
            if (promoMessage) container.appendChild(promoMessage);

            // Add input event listener
            input.addEventListener('input', function(){
                // Clear promo data immediately when input is emptied
                if (!this.value.trim()) {
                    window.currentPromo = null;
                    showPromoMessage('', true);
                    updatePriceDisplay();
                } else {
                    // For non-empty input, use the delayed validation
                    if (promoTimer) clearTimeout(promoTimer);
                    promoTimer = setTimeout(validatePromoCode, 600);
                }
            });
        }
    }

    function loadStaffForBranch(branchId) {
        var staffSelect = document.getElementById('staff_id');
        if (!staffSelect) return;

        staffSelect.innerHTML = '<option value="">Select Staff</option>';

        if (!branchId) return;

        // Fetch staff for this branch
        fetch('/api/staff?branch_id=' + branchId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        }).then(function(response) {
            return response.json();
        }).then(function(data) {
            if (data && data.staff) {
                data.staff.forEach(function(staff) {
                    var option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = staff.name;
                    staffSelect.appendChild(option);
                });
            }
        }).catch(function(error) {
            console.error('Error loading staff:', error);
        });
    }

    // Handle staff selection checkbox
    var selectStaffCheckbox = document.getElementById('select_staff_checkbox');
    var staffSelectionContainer = document.getElementById('staff_selection_container');

    if (selectStaffCheckbox && staffSelectionContainer) {
        selectStaffCheckbox.addEventListener('change', function() {
            if (this.checked) {
                staffSelectionContainer.style.display = 'block';
                // Load staff if branch is already selected
                var branchId = branchSelect ? branchSelect.value : null;
                if (branchId) {
                    loadStaffForBranch(branchId);
                }
            } else {
                staffSelectionContainer.style.display = 'none';
                // Clear staff selection
                var staffSelect = document.getElementById('staff_id');
                if (staffSelect) {
                    staffSelect.value = '';
                }
            }
        });
    }

    if (branchSelect) {
        branchSelect.addEventListener('change', function() {
            var selected = branchSelect.options[branchSelect.selectedIndex];
            var address = selected.getAttribute('data-address') || '';
            var hours = selected.getAttribute('data-hours') || '';
            var mapSrc = selected.getAttribute('data-map') || '';
            var tslot = selected.getAttribute('data-time_slot') || '';
            var cap = selected.getAttribute('data-slot_capacity') || 5;
            document.getElementById('branch-address').textContent = address;
            document.getElementById('branch-hours').innerHTML = hours + (tslot ? ('<br><strong>Available:</strong> ' + tslot) : '');

            // Update Get Directions button
            var directionsBtn = document.getElementById('get-directions-btn');
            if (directionsBtn && address) {
                var encodedAddress = encodeURIComponent(address);
                directionsBtn.href = 'https://www.google.com/maps/dir/?api=1&destination=' + encodedAddress;
                directionsBtn.style.display = 'block';
            } else if (directionsBtn) {
                directionsBtn.style.display = 'none';
            }

            // Update map visibility
            var mapIframe = document.getElementById('branch-map');
            var mapPlaceholder = document.getElementById('map-placeholder');
            if (mapSrc) {
                mapIframe.src = mapSrc;
                mapIframe.style.display = 'block';
                if (mapPlaceholder) mapPlaceholder.style.display = 'none';
            } else {
                mapIframe.style.display = 'none';
                if (mapPlaceholder) mapPlaceholder.style.display = 'flex';
            }

            // populate services and packages for this branch
            var bid = selected.value;
            var binfo = branchData[bid] || {services:[], packages:[], time_slot:'', slot_capacity:5};
            // Build category list
            var categories = [];
            binfo.services.forEach(function(s){
                if (s.category && categories.indexOf(s.category) === -1) categories.push(s.category);
            });
            // Populate category dropdown
            var categorySelect = document.getElementById('service_category');
            if (categorySelect) {
                categorySelect.innerHTML = '<option value="">All Categories</option>';
                categories.forEach(function(cat){
                    var opt = document.createElement('option');
                    opt.value = cat;
                    opt.textContent = cat;
                    categorySelect.appendChild(opt);
                });
            }
            // services
            var serviceDropdownOptions = document.getElementById('service_dropdown_options');
            serviceDropdownOptions.innerHTML = '';
            binfo.services.forEach(function(s){
                var optionDiv = document.createElement('div');
                optionDiv.className = 'multiselect-option p-2 border-bottom';
                optionDiv.style.cursor = 'pointer';

                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'service-checkbox';
                checkbox.value = s.id;
                checkbox.id = 'service_' + s.id;
                checkbox.setAttribute('data-price', s.price || 0);
                checkbox.setAttribute('data-name', s.name || 'Unknown Service');
                checkbox.setAttribute('data-default-sessions', s.default_sessions || 1);
                checkbox.setAttribute('data-is-package', s.is_package ? '1' : '0');
                checkbox.setAttribute('data-category', s.category || '');

                var label = document.createElement('label');
                label.className = 'form-check-label mb-0';
                label.htmlFor = 'service_' + s.id;
                label.textContent = s.name + (s.price ? (' - ₱' + s.price) : '');
                label.style.cursor = 'pointer';

                optionDiv.appendChild(checkbox);
                optionDiv.appendChild(label);

                // Prevent dropdown from closing when clicking checkbox/label
                optionDiv.addEventListener('click', function(e) {
                    e.stopPropagation();
                    checkbox.checked = !checkbox.checked;

                    // If a service is being selected, clear package selection
                    if (checkbox.checked) {
                        var packageSelect = document.getElementById('package_id');
                        if (packageSelect && packageSelect.value) {
                            packageSelect.value = '';
                            // Trigger package change to update UI
                            packageSelect.dispatchEvent(new Event('change'));
                        }
                    }

                    updateSelectedServices();
                    updatePriceDisplay();
                    updateTimeSlots();
                    updatePromoOptions(bid, getSelectedServiceIds());
                    checkBookingConflicts();
                });

                serviceDropdownOptions.appendChild(optionDiv);
            });
            // Trigger category filter after services are populated
            if (categorySelect) {
                categorySelect.dispatchEvent(new Event('change'));
            }
            // packages
            if (binfo.packages && binfo.packages.length) {
                packageContainer.style.display = '';
                packageSelect.innerHTML = '<option value="">Select Package (optional)</option>';
                binfo.packages.forEach(function(p){
                    var o = document.createElement('option');
                    o.value = p.id;
                    o.textContent = p.name + (p.price ? (' - ₱' + p.price) : '');
                    if (p.price) o.setAttribute('data-price', p.price);
                    packageSelect.appendChild(o);
                });
            } else {
                packageContainer.style.display = 'none';
                packageSelect.innerHTML = '';
            }
            // Load staff for this branch
            loadStaffForBranch(bid);
            updateTimeSlots();
            // Update promo options for this branch and service
            updatePromoOptions(bid, getSelectedServiceIds());
            // If user has a claimed promo for this branch, preload it
            try {
                if (claimedPromos && Array.isArray(claimedPromos)) {
                    var claimedForBranch = claimedPromos.find(function(cp){
                        // PromoClaim may include nested promo relationship
                        var pBranch = (cp.branch_id !== undefined) ? cp.branch_id : (cp.promo && cp.promo.branch_id ? cp.promo.branch_id : null);
                        return String(pBranch) === String(bid);
                    });
                    if (claimedForBranch) {
                        // Wait a tick for promo input/select to be rendered
                        setTimeout(function(){
                            var promoInput = document.getElementById('promo_code');
                            if (promoInput) {
                                // Determine the promo code (PromoClaim may nest the promo)
                                var claimedCode = claimedForBranch.code || (claimedForBranch.promo && claimedForBranch.promo.code) || null;
                                // If it's a select, try to pick the claimed code option
                                if (promoInput.tagName.toLowerCase() === 'select') {
                                    for (var i=0;i<promoInput.options.length;i++) {
                                        if (promoInput.options[i].value === claimedCode) {
                                            promoInput.selectedIndex = i;
                                            break;
                                        }
                                    }
                                } else {
                                    promoInput.value = claimedCode;
                                }
                                // Trigger validation for the preloaded promo
                                if (typeof validatePromoCode === 'function') validatePromoCode();
                                // Show a subtle message
                                var promoMessage = document.getElementById('promo_applied_message');
                                if (promoMessage && claimedForBranch) {
                                    promoMessage.textContent = 'Claimed promo applied: ' + (claimedForBranch.code || (claimedForBranch.promo && claimedForBranch.promo.code) || '');
                                    promoMessage.style.color = '#198754';
                                }
                            }
                        }, 150);
                    }
                }
            } catch (e) { console.error('Error preloading claimed promo', e); }
            // Validate operating day when branch changes
            validateOperatingDay();

            // Update GCash QR code and number when branch changes
            const gcashNumber = selected.getAttribute('data-gcash-number');
            const gcashQr = selected.getAttribute('data-gcash-qr');
            const branchName = selected.text;

            const gcashNumberEl = document.getElementById('gcashNumber');
            if (gcashNumberEl && gcashNumber) {
                gcashNumberEl.textContent = gcashNumber;
            }

            const gcashQrImage = document.getElementById('gcashQrImage');
            if (gcashQrImage && gcashQr) {
                gcashQrImage.src = gcashQr;
            }

            const branchNameEl = document.getElementById('branchName');
            if (branchNameEl && branchName) {
                branchNameEl.textContent = branchName;
            }
        });
    }

    // City filter functionality
    const cityFilter = document.getElementById('city-filter');
    if (cityFilter) {
        cityFilter.addEventListener('change', function() {
            const selectedCity = this.value;
            const branchOptions = branchSelect.querySelectorAll('option');

            branchOptions.forEach(option => {
                if (option.value === '') return; // Keep "Select Branch" option

                const branchCity = option.getAttribute('data-city') || '';
                if (selectedCity === '' || branchCity === selectedCity) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });

            // Reset branch selection if current selection is filtered out
            const currentOption = branchSelect.options[branchSelect.selectedIndex];
            if (currentOption && currentOption.value !== '') {
                const currentCity = currentOption.getAttribute('data-city') || '';
                if (selectedCity !== '' && currentCity !== selectedCity) {
                    branchSelect.value = '';
                    branchSelect.dispatchEvent(new Event('change'));
                }
            }
        });
    }

    // Function to get selected service IDs from checkboxes
    function getSelectedServiceIds() {
        var checkboxes = document.querySelectorAll('.service-checkbox:checked');
        return Array.from(checkboxes).map(function(checkbox) {
            return checkbox.value;
        });
    }

    // Function to get selected service checkboxes
    function getSelectedServiceCheckboxes() {
        return document.querySelectorAll('.service-checkbox:checked');
    }

    // Function to update selected services and hidden inputs
    function updateSelectedServices() {
        var selectedCheckboxes = getSelectedServiceCheckboxes();
        var selectedServiceInputs = document.getElementById('selected_service_inputs');
        var dropdownText = document.getElementById('service_dropdown_text');

        // Update hidden inputs
        selectedServiceInputs.innerHTML = '';
        selectedCheckboxes.forEach(function(checkbox) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'service_ids[]';
            input.value = checkbox.value;
            selectedServiceInputs.appendChild(input);
        });

        // Update dropdown button text
        if (selectedCheckboxes.length === 0) {
            dropdownText.textContent = 'Select Services';
        } else if (selectedCheckboxes.length === 1) {
            var serviceName = selectedCheckboxes[0].nextElementSibling.textContent.split(' - ₱')[0];
            dropdownText.textContent = serviceName;
        } else {
            dropdownText.textContent = selectedCheckboxes.length + ' services selected';
        }

        // Update selected services display
        updateSelectedServicesDisplay();
    }

    // Function to update the selected services display
    function updateSelectedServicesDisplay() {
        var selectedServicesDiv = document.getElementById('selected-services');
        var selectedServicesList = document.getElementById('selected-services-list');
        var selectedCheckboxes = getSelectedServiceCheckboxes();

        // Clear previous content
        selectedServicesList.innerHTML = '';

        if (selectedCheckboxes.length === 0) {
            selectedServicesDiv.style.display = 'none';
            return;
        }

        // Show the container
        selectedServicesDiv.style.display = 'block';

        // Add each selected service (simple list without prices)
        selectedCheckboxes.forEach(function(checkbox) {
            var serviceName = checkbox.getAttribute('data-name') || 'Unknown Service';

            var serviceItem = document.createElement('div');
            serviceItem.className = 'mb-2';
            serviceItem.innerHTML = `
                <i class="fas fa-check-circle text-success me-2"></i>
                <span class="fw-medium">${serviceName}</span>
            `;
            selectedServicesList.appendChild(serviceItem);
        });
    }

    // update price display when service or package changed
    function updatePriceDisplay() {
        // Prevent multiple simultaneous calls
        if (updatePriceDisplay.isRunning) {
            return;
        }
        updatePriceDisplay.isRunning = true;

        var priceEl = document.getElementById('service_price');
        var serviceBreakdownEl = document.getElementById('service_breakdown');
        var serviceListEl = document.getElementById('service_list');
        var selectedServices = getSelectedServiceCheckboxes();
        var pkg = packageSelect.options[packageSelect.selectedIndex];
        var branchId = document.getElementById('branch_id').value;

        // Clear previous service list
        serviceListEl.innerHTML = '';

        // Show loading state
        priceEl.value = 'Loading...';
        priceEl.disabled = true;

        if (pkg && pkg.value) {
            // Package selected - use local package price (packages have fixed prices)
            var packagePrice = Number(pkg.getAttribute('data-price') || 0);
            var discountedPackagePrice = packagePrice;

            // Apply promo discount if active
            if (window.currentPromo && window.currentPromo.discount_pct > 0) {
                var discountAmount = (packagePrice * window.currentPromo.discount_pct) / 100;
                discountedPackagePrice = Math.max(0, packagePrice - discountAmount);
            }

            priceEl.value = '₱' + discountedPackagePrice.toFixed(2);
            priceEl.disabled = false;
            serviceBreakdownEl.style.display = 'none';

            // Reset the running flag
            updatePriceDisplay.isRunning = false;
        } else if (selectedServices.length > 0 && branchId) {
            // Services selected - fetch latest prices from server
            var serviceIds = Array.from(selectedServices).map(function(checkbox) {
                return checkbox.value;
            });

            fetch('/api/branches/' + branchId + '/services', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Failed to fetch service prices');
                }
                return response.json();
            })
            .then(function(data) {
                // Clear service list before adding new content
                serviceListEl.innerHTML = '';
                var totalPrice = 0;
                var servicePrices = {};

                // Create price lookup map
                data.services.forEach(function(service) {
                    servicePrices[service.id] = {
                        price: service.price || 0,
                        name: service.name || 'Unknown Service'
                    };
                });

                // Calculate total and build breakdown
                selectedServices.forEach(function(checkbox) {
                    var serviceId = checkbox.value;
                    var serviceData = servicePrices[serviceId];
                    if (serviceData) {
                        var price = Number(serviceData.price);
                        totalPrice += price;

                        // Add service to breakdown list
                        var serviceItem = document.createElement('div');
                        serviceItem.className = 'd-flex justify-content-between align-items-center mb-1';
                        serviceItem.innerHTML = `
                            <small class="text-muted">${serviceData.name}</small>
                            <small class="text-muted fw-semibold">₱${price.toFixed(2)}</small>
                        `;
                        serviceListEl.appendChild(serviceItem);
                    }
                });

                // Apply promo discount if active
                var discountedTotal = totalPrice;
                if (window.currentPromo && window.currentPromo.discount_pct > 0) {
                    var discountAmount = (totalPrice * window.currentPromo.discount_pct) / 100;
                    discountedTotal = Math.max(0, totalPrice - discountAmount);

                    // Add discount line
                    var discountItem = document.createElement('div');
                    discountItem.className = 'd-flex justify-content-between align-items-center mb-1';
                    discountItem.innerHTML = `
                        <small class="text-warning">Discount (${window.currentPromo.discount_pct}%)</small>
                        <small class="text-warning fw-semibold">-₱${discountAmount.toFixed(2)}</small>
                    `;
                    serviceListEl.appendChild(discountItem);
                }

                // Show breakdown only if multiple services are selected
                serviceBreakdownEl.style.display = selectedServices.length > 1 ? 'block' : 'none';

                // Add total line showing the final discounted amount
                if (selectedServices.length > 1) {
                    var totalItem = document.createElement('div');
                    totalItem.className = 'd-flex justify-content-between align-items-center mt-2 pt-1 border-top';
                    totalItem.innerHTML = `
                        <small class="fw-semibold">Total</small>
                        <small class="fw-semibold text-primary">₱${discountedTotal.toFixed(2)}</small>
                    `;
                    serviceListEl.appendChild(totalItem);
                }

                // Update price field with discounted total
                priceEl.value = '₱' + discountedTotal.toFixed(2);
                priceEl.disabled = false;

                // Reset the running flag
                updatePriceDisplay.isRunning = false;
            })
            .catch(function(error) {
                console.error('Error fetching service prices:', error);
                // Fallback to local prices if API fails
                serviceListEl.innerHTML = ''; // Clear any previous content
                var totalPrice = 0;
                selectedServices.forEach(function(checkbox) {
                    var price = Number(checkbox.getAttribute('data-price') || 0);
                    var serviceName = checkbox.getAttribute('data-name') || 'Unknown Service';
                    totalPrice += price;

                    // Add service to breakdown list
                    var serviceItem = document.createElement('div');
                    serviceItem.className = 'd-flex justify-content-between align-items-center mb-1';
                    serviceItem.innerHTML = `
                        <small class="text-muted">${serviceName}</small>
                        <small class="text-muted fw-semibold">₱${price.toFixed(2)}</small>
                    `;
                    serviceListEl.appendChild(serviceItem);
                });

                var discountedTotal = totalPrice;
                if (window.currentPromo && window.currentPromo.discount_pct > 0) {
                    var discountAmount = (totalPrice * window.currentPromo.discount_pct) / 100;
                    discountedTotal = Math.max(0, totalPrice - discountAmount);

                    // Add discount line
                    var discountItem = document.createElement('div');
                    discountItem.className = 'd-flex justify-content-between align-items-center mb-1';
                    discountItem.innerHTML = `
                        <small class="text-warning">Discount (${window.currentPromo.discount_pct}%)</small>
                        <small class="text-warning fw-semibold">-₱${discountAmount.toFixed(2)}</small>
                    `;
                    serviceListEl.appendChild(discountItem);
                }

                serviceBreakdownEl.style.display = selectedServices.length > 1 ? 'block' : 'none';

                if (selectedServices.length > 1) {
                    var totalItem = document.createElement('div');
                    totalItem.className = 'd-flex justify-content-between align-items-center mt-2 pt-1 border-top';
                    totalItem.innerHTML = `
                        <small class="fw-semibold">Total</small>
                        <small class="fw-semibold text-primary">₱${discountedTotal.toFixed(2)}</small>
                    `;
                    serviceListEl.appendChild(totalItem);
                }

                priceEl.value = '₱' + discountedTotal.toFixed(2);
                priceEl.disabled = false;

                // Reset the running flag
                updatePriceDisplay.isRunning = false;
            });
        } else {
            // No selection or no branch selected
            priceEl.value = '';
            priceEl.disabled = false;
            serviceBreakdownEl.style.display = 'none';

            // Reset the running flag
            updatePriceDisplay.isRunning = false;
        }

        // Reset the running flag
        updatePriceDisplay.isRunning = false;
    }
    // Category filter logic
    var categorySelect = document.getElementById('service_category');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            var selectedCategory = categorySelect.value;
            var optionDivs = document.querySelectorAll('.multiselect-option');
            optionDivs.forEach(function(optionDiv) {
                var checkbox = optionDiv.querySelector('.service-checkbox');
                if (!selectedCategory || checkbox.getAttribute('data-category') === selectedCategory) {
                    optionDiv.style.display = '';
                } else {
                    optionDiv.style.display = 'none';
                    // Uncheck hidden services
                    if (checkbox.checked) {
                        checkbox.checked = false;
                        updateSelectedServices();
                    }
                }
            });
            // Update price and time slots when category changes
            updatePriceDisplay();
            updateTimeSlots();
        });
    }
    // When package changes, if a package is selected then service is optional
    packageSelect.addEventListener('change', function(){
        if (packageSelect.value) {
            // Clear all service selections when package is selected
            var checkboxes = document.querySelectorAll('.service-checkbox:checked');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            updateSelectedServices();
            updatePriceDisplay();
            updateTimeSlots();
            updatePromoOptions(branchSelect.value, []);
            checkBookingConflicts();
        }
    });

    // Custom multiselect dropdown functionality
    var dropdownHeader = document.getElementById('service_dropdown_header');
    var dropdownOptions = document.getElementById('service_dropdown_options');

    if (dropdownHeader && dropdownOptions) {
        dropdownHeader.addEventListener('click', function() {
            var isVisible = dropdownOptions.style.display !== 'none';
            dropdownOptions.style.display = isVisible ? 'none' : 'block';
            dropdownHeader.querySelector('i').className = isVisible ? 'fas fa-chevron-down' : 'fas fa-chevron-up';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownHeader.contains(e.target) && !dropdownOptions.contains(e.target)) {
                dropdownOptions.style.display = 'none';
                dropdownHeader.querySelector('i').className = 'fas fa-chevron-down';
            }
        });
    }

    // Function to validate if selected date is on an operating day
    function validateOperatingDay() {
        var branchId = branchSelect.value;
        var selectedDate = dateInput.value;

        if (!branchId || !selectedDate) return true;

        var branch = branchData[branchId];
        if (!branch || !branch.operating_days) return true;

        var operatingDays = branch.operating_days.split(',');
        var selectedDateObj = new Date(selectedDate);
        var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var selectedDayName = dayNames[selectedDateObj.getDay()];

        if (!operatingDays.includes(selectedDayName)) {
            // Show error message
            var errorDiv = document.querySelector('#date').parentNode.querySelector('.date-error');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'mt-1 text-danger date-error';
                errorDiv.innerHTML = '<small></small>';
                document.querySelector('#date').parentNode.appendChild(errorDiv);
            }
            errorDiv.querySelector('small').textContent = 'The selected branch is closed on ' + selectedDayName + 's. Operating days: ' + operatingDays.join(', ') + '.';
            dateInput.value = ''; // Clear the invalid date
            return false;
        } else {
            // Remove error message if it exists
            var errorDiv = document.querySelector('#date').parentNode.querySelector('.date-error');
            if (errorDiv) {
                errorDiv.remove();
            }
            return true;
        }
    }

    if (dateInput) {
        dateInput.addEventListener('change', function() {
            if (validateOperatingDay()) {
                updateTimeSlots();
            }
        });
    }
    // Initial load
    updateTimeSlots();
    // set initial price from defaults if any
    updatePriceDisplay();
    // Promo code validation (debounced)
    var promoTimer = null;
    function getPromoInput() {
        return document.getElementById('promo_code');
    }
    function showPromoMessage(msg, ok) {
        var promoMessage = document.getElementById('promo_applied_message');
        if (!promoMessage) return;
        promoMessage.textContent = msg;
        promoMessage.style.color = ok ? '#198754' : '#dc3545';
    }
    function validatePromoCode() {
        var promoInput = getPromoInput();
        if (!promoInput) return;
        var code = promoInput.value.trim();
        if (!code) {
            // Clear promo data when promo is removed
            window.currentPromo = null;
            showPromoMessage('', true);
            updatePriceDisplay();
            return;
        }
        var params = new URLSearchParams();
        params.append('code', code);
        params.append('branch_id', branchSelect.value || '');
        params.append('service_id', getSelectedServiceIds().length > 0 ? getSelectedServiceIds()[0] : '');
        params.append('package_id', packageSelect.value || '');
        // Add service_ids for multiple services
        var selectedServices = getSelectedServiceIds();
        if (selectedServices.length > 1) {
            selectedServices.forEach(function(sid) {
                params.append('service_ids[]', sid);
            });
        }
        fetch('/api/promo/validate?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        }).then(function(r){ return r.json(); }).then(function(json){
            if (json && json.valid) {
                // Store promo data for price breakdown calculation
                window.currentPromo = {
                    discount_pct: json.discount_pct || 0,
                    discount_amount: json.discount_amount || 0,
                    final_price: json.final_price || 0,
                    base_price: json.base_price || 0
                };

                // Update price display with promo
                updatePriceDisplay();

                showPromoMessage('Promo applied: ' + (json.discount_pct || 0) + '% off', true);
            } else {
                // Clear promo data
                window.currentPromo = null;
                showPromoMessage((json && json.message) ? json.message : 'Invalid promo code', false);
                updatePriceDisplay();
            }
        }).catch(function(){
            // Clear promo data on error
            window.currentPromo = null;
            showPromoMessage('Promo validation failed (network)', false);
            updatePriceDisplay();
        });
    }
    // Initialize promo options if branch is pre-selected
    if (branchSelect && branchSelect.value) {
        updatePromoOptions(branchSelect.value, getSelectedServiceIds());
            // Preload claimed promo for initial branch selection if present
        try {
            if (claimedPromos && Array.isArray(claimedPromos)) {
                var initialClaim = claimedPromos.find(function(cp){
                    var pBranch = (cp.branch_id !== undefined) ? cp.branch_id : (cp.promo && cp.promo.branch_id ? cp.promo.branch_id : null);
                    return String(pBranch) === String(branchSelect.value);
                });
                if (initialClaim) {
                    setTimeout(function(){
                        var promoInput = document.getElementById('promo_code');
                        if (promoInput) {
                            var claimedCode = initialClaim.code || (initialClaim.promo && initialClaim.promo.code) || null;
                            if (promoInput.tagName.toLowerCase() === 'select') {
                                for (var i=0;i<promoInput.options.length;i++) {
                                    if (promoInput.options[i].value === claimedCode) { promoInput.selectedIndex = i; break; }
                                }
                            } else {
                                promoInput.value = claimedCode;
                            }
                            if (typeof validatePromoCode === 'function') validatePromoCode();
                            var promoMessage = document.getElementById('promo_applied_message');
                            if (promoMessage && claimedCode) { promoMessage.textContent = 'Claimed promo applied: ' + claimedCode; promoMessage.style.color = '#198754'; }
                        }
                    }, 150);
                }
            }
        } catch (e) { console.error('Error preloading initial claimed promo', e); }
    }

    // Function to check booking conflicts via AJAX
    function checkBookingConflicts() {
        var branchId = branchSelect.value;
        var date = dateInput.value;
        var timeSlot = timeSlotSelect.value;
        var packageId = packageSelect.value;

        // Get selected service IDs
        var selectedServices = getSelectedServiceIds();

    // Only check if all required fields are filled
    if (!branchId || !date || !timeSlot || (selectedServices.length === 0 && !packageId)) {
        // If not all fields filled, enable Book Now button
        var bookNowBtn = document.getElementById('openPaymentModal');
        if (bookNowBtn) {
            bookNowBtn.disabled = false;
            bookNowBtn.innerHTML = 'Book Now';
            bookNowBtn.style.opacity = '';
            bookNowBtn.style.cursor = '';
        }
        return;
    }

        // Only check if all required fields are filled
        if (!branchId || !date || !timeSlot) {
            // If not all fields filled, enable Book Now button
            var bookNowBtn = document.getElementById('openPaymentModal');
            if (bookNowBtn) {
                bookNowBtn.disabled = false;
                bookNowBtn.innerHTML = 'Book Now';
                bookNowBtn.style.opacity = '';
                bookNowBtn.style.cursor = '';
            }
            return;
        }

        // Prepare data for AJAX request
        var data = {
            branch_id: branchId,
            date: date,
            time_slot: timeSlot,
            service_ids: selectedServices.length > 0 ? selectedServices : null,
            package_id: packageId || null
        };

        // Make AJAX request
        fetch('{{ route("client.booking.check-conflicts") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.conflict) {
                // Show conflict alert directly below time slot dropdown
                var timeSlotContainer = document.getElementById('time_slot').parentNode;
                var alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger conflict-alert mt-2';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + data.message;
                timeSlotContainer.appendChild(alertDiv);

                // Disable Book Now button
                var bookNowBtn = document.getElementById('openPaymentModal');
                if (bookNowBtn) {
                    bookNowBtn.disabled = true;
                    bookNowBtn.innerHTML = '<i class="fas fa-times me-2"></i>Cannot Book - Conflict';
                    bookNowBtn.style.opacity = '0.6';
                    bookNowBtn.style.cursor = 'not-allowed';
                }
            } else {
                // No conflict, enable Book Now button and remove any existing alert
                var existingAlert = document.querySelector('.conflict-alert');
                if (existingAlert) {
                    existingAlert.remove();
                }
                var bookNowBtn = document.getElementById('openPaymentModal');
                if (bookNowBtn) {
                    bookNowBtn.disabled = false;
                    bookNowBtn.innerHTML = 'Book Now';
                    bookNowBtn.style.opacity = '';
                    bookNowBtn.style.cursor = '';
                }
            }
        })
        .catch(error => {
            console.error('Error checking conflicts:', error);
            // On error, enable the button (don't disable booking due to API errors)
            var bookNowBtn = document.getElementById('openPaymentModal');
            if (bookNowBtn) {
                bookNowBtn.disabled = false;
                bookNowBtn.innerHTML = 'Book Now';
                bookNowBtn.style.opacity = '';
                bookNowBtn.style.cursor = '';
            }
        });
    }

    // Add event listeners for conflict checking
    if (branchSelect) {
        branchSelect.addEventListener('change', checkBookingConflicts);
    }
    if (dateInput) {
        dateInput.addEventListener('change', checkBookingConflicts);
    }
    if (timeSlotSelect) {
        timeSlotSelect.addEventListener('change', checkBookingConflicts);
    }
    if (packageSelect) {
        packageSelect.addEventListener('change', checkBookingConflicts);
    }

    // Initial check to ensure button state is correct
    checkBookingConflicts();

});
</script>

<!-- Responsive booking form styles -->
<style>
/* Responsive dropdown/select styles for booking form */

/* Base styles for all form elements */
.form-select,
.form-control {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
    line-height: 1.4;
}

/* Large tablets and iPad Pro (1024px - 1366px) */
@media (max-width: 1366px) and (min-width: 992px) {
    .form-select,
    .form-control {
        font-size: 0.85rem !important;
        padding: 0.45rem 0.7rem !important;
        line-height: 1.3 !important;
        max-height: 42px !important;
    }

    .form-group label {
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }

    select.form-select {
        height: 42px !important;
        min-height: 42px !important;
    }

    .form-select {
        background-position: right 0.6rem center !important;
        background-size: 13px 10px !important;
        padding-right: 1.9rem !important;
    }
}

/* Tablet styles (iPad, medium devices 768px - 991px) */
@media (max-width: 991px) and (min-width: 768px) {
    .form-select,
    .form-control {
        font-size: 0.8rem !important;
        padding: 0.4rem 0.65rem !important;
        line-height: 1.3 !important;
        max-height: 40px !important;
    }

    /* Adjust form labels */
    .form-group label {
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    select.form-select {
        height: 40px !important;
        min-height: 40px !important;
    }

    .form-select {
        background-position: right 0.55rem center !important;
        background-size: 13px 10px !important;
        padding-right: 1.8rem !important;
    }
}

/* Mobile styles (phones) */
@media (max-width: 767px) {
    .form-select,
    .form-control {
        font-size: 0.8rem !important;
        padding: 0.4rem 0.6rem !important;
        max-height: 38px !important;
        line-height: 1.2 !important;
    }

    /* Adjust form labels for mobile */
    .form-group label {
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    /* Make dropdowns full width on mobile */
    .form-select,
    .form-control {
        width: 100%;
    }

    /* Adjust option text inside dropdowns */
    .form-select option {
        font-size: 0.8rem !important;
        padding: 0.3rem !important;
        line-height: 1.2 !important;
    }

    /* Reduce container padding */
    .container-fluid,
    .container {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }

    select.form-select {
        height: 38px !important;
        min-height: 38px !important;
    }
}

/* Small mobile devices (iPhone SE, small phones) */
@media (max-width: 575px) {
    .form-select,
    .form-control {
        font-size: 0.75rem !important;
        padding: 0.35rem 0.5rem !important;
        max-height: 36px !important;
        line-height: 1.1 !important;
    }

    .form-group label {
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }

    /* Reduce spacing between form groups on small devices */
    .form-group {
        margin-bottom: 0.75rem !important;
    }

    .form-select option {
        font-size: 0.75rem !important;
        padding: 0.25rem !important;
    }

    select.form-select {
        height: 36px !important;
        min-height: 36px !important;
    }
}

/* Ensure dropdown arrows are visible and properly sized */
.form-select {
    background-position: right 0.6rem center;
    background-size: 14px 10px;
    padding-right: 2rem !important;
}

@media (max-width: 767px) {
    .form-select {
        background-position: right 0.5rem center !important;
        background-size: 12px 9px !important;
        padding-right: 1.75rem !important;
    }
}

@media (max-width: 575px) {
    .form-select {
        background-position: right 0.4rem center !important;
        background-size: 10px 8px !important;
        padding-right: 1.5rem !important;
    }
}

/* Adjust row spacing for mobile and tablet */
@media (max-width: 991px) {
    .row.g-2 {
        gap: 0.4rem;
    }

    .mb-3 {
        margin-bottom: 0.75rem !important;
    }
}

/* Responsive adjustments for price and promo code row */
@media (max-width: 767px) {
    .col-md-4,
    .col-md-8 {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }
}

/* Payment Modal Styling */
.modal-backdrop {
    z-index: 1040 !important;
}

.modal {
    z-index: 1050 !important;
}

.modal-dialog {
    z-index: 1060 !important;
}

#paymentTabs {
    position: relative;
    z-index: 10;
}

#paymentTabs .nav-link {
    border-radius: 10px;
    margin: 0 5px;
    padding: 12px 24px;
    border: 2px solid #e9ecef;
    color: #6c757d;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    z-index: 10;
    background: white;
}

#paymentTabs .nav-link:hover {
    border-color: #F56289;
    color: #F56289;
    transform: translateY(-2px);
}

#paymentTabs .nav-link.active {
    background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%) !important;
    border-color: #F56289;
    color: white !important;
    box-shadow: 0 4px 15px rgba(245, 98, 137, 0.3);
}

#paymentTabs .nav-link i {
    margin-right: 5px;
}

.modal-content {
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1070;
}

.modal-header {
    position: relative;
    z-index: 10 !important;
}

.modal-header .btn-close {
    position: relative;
    z-index: 10 !important;
    cursor: pointer !important;
    pointer-events: auto !important;
}

.modal-body {
    position: relative;
    z-index: 1;
}

.modal-footer {
    position: relative;
    z-index: 10 !important;
}

.modal-footer button {
    position: relative;
    z-index: 10 !important;
    cursor: pointer !important;
    pointer-events: auto !important;
}

.tab-content {
    position: relative;
    z-index: 1;
}

.tab-pane {
    position: relative;
    z-index: 1;
}

@media (max-width: 767px) {
    #paymentTabs .nav-link {
        padding: 8px 12px;
        font-size: 0.85rem;
        margin: 0 3px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.querySelector('form[action="{{ route('client.booking.submit') }}"]');
    const openModalBtn = document.getElementById('openPaymentModal');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const cancelPaymentBtn = document.getElementById('cancelPaymentBtn');
    const closePaymentModalBtn = document.getElementById('closePaymentModalBtn');
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'), {
        backdrop: true,
        keyboard: true,
        focus: true
    });

    // Saved card data from server (organized by card type)
    const savedCardData = @json($savedCardData ?? null);

    // Function to get selected service IDs from checkboxes
    function getSelectedServiceIds() {
        var checkboxes = document.querySelectorAll('.service-checkbox:checked');
        return Array.from(checkboxes).map(function(checkbox) {
            return checkbox.value;
        });
    }

    // Function to get selected service checkboxes
    function getSelectedServiceCheckboxes() {
        return document.querySelectorAll('.service-checkbox:checked');
    }

    // Function to load saved card data based on card type
    function loadSavedCardDataByType(cardType) {
        if (savedCardData && cardType && savedCardData[cardType]) {
            const cardInfo = savedCardData[cardType];

            // Populate card number (masked)
            if (cardInfo.card_number) {
                const cardNumberField = document.getElementById('card_number');
                cardNumberField.value = cardInfo.card_number;
                cardNumberField.setAttribute('data-saved-card', 'true');
                cardNumberField.setAttribute('data-masked-value', cardInfo.card_number);
                cardNumberField.setAttribute('readonly', 'readonly');
                cardNumberField.style.backgroundColor = '#e9ecef';
                cardNumberField.style.cursor = 'not-allowed';

                // Show clear button and hint
                document.getElementById('clearCardBtn').style.display = 'block';
                document.getElementById('savedCardHint').style.display = 'block';
            }

            // Populate expiry date
            if (cardInfo.card_expiry) {
                const expiry = cardInfo.card_expiry.split('/');
                if (expiry.length === 2) {
                    document.getElementById('card_expiry_month').value = expiry[0];
                    document.getElementById('card_expiry_year').value = expiry[1];
                    document.getElementById('card_expiry').value = cardInfo.card_expiry;
                }
            }

            // Populate billing information
            if (cardInfo.billing_first_name) {
                document.getElementById('billing_first_name').value = cardInfo.billing_first_name;
            }
            if (cardInfo.billing_last_name) {
                document.getElementById('billing_last_name').value = cardInfo.billing_last_name;
            }
            if (cardInfo.billing_address) {
                document.getElementById('billing_address').value = cardInfo.billing_address;
            }
            if (cardInfo.billing_city) {
                document.getElementById('billing_city').value = cardInfo.billing_city;
            }
            if (cardInfo.billing_zip) {
                document.getElementById('billing_zip').value = cardInfo.billing_zip;
            }
            if (cardInfo.billing_country) {
                document.getElementById('billing_country').value = cardInfo.billing_country;
            }
            if (cardInfo.billing_phone) {
                document.getElementById('billing_phone').value = cardInfo.billing_phone;
            }

            // Check the save card checkbox
            document.getElementById('save_card').checked = true;

            // Show success notification
            showCardLoadedNotification(cardType);
        } else {
            // Clear form if no saved data for this card type
            clearCardForm(cardType);
        }
    }

    // Function to show card loaded notification
    function showCardLoadedNotification(cardType) {
        const cardTypeName = cardType === 'visa' ? 'Visa' : 'Mastercard';

        // Remove existing notification if any
        const existingNotification = document.querySelector('.card-loaded-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Create notification
        const notification = document.createElement('div');
        notification.className = 'card-loaded-notification';
        notification.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            <span>${cardTypeName} card details loaded!</span>
        `;

        // Insert after card type selector
        const cardTypeSelect = document.getElementById('card_type');
        cardTypeSelect.parentNode.insertAdjacentElement('afterend', notification);

        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Function to clear card form
    function clearCardForm(exceptCardType = null) {
        // Clear all fields except card type if specified
        if (!exceptCardType) {
            document.getElementById('card_type').value = '';
        }
        document.getElementById('card_number').value = '';
        document.getElementById('card_expiry_month').value = '';
        document.getElementById('card_expiry_year').value = '';
        document.getElementById('card_expiry').value = '';
        document.getElementById('card_cvv').value = '';
        document.getElementById('billing_first_name').value = '';
        document.getElementById('billing_last_name').value = '';
        document.getElementById('billing_address').value = '';
        document.getElementById('billing_city').value = '';
        document.getElementById('billing_zip').value = '';
        document.getElementById('billing_country').value = '';
        document.getElementById('billing_phone').value = '';
        document.getElementById('save_card').checked = false;
    }

    // Listen for card type changes
    const cardTypeSelect = document.getElementById('card_type');
    if (cardTypeSelect) {
        cardTypeSelect.addEventListener('change', function(e) {
            const selectedCardType = e.target.value;
            if (selectedCardType) {
                loadSavedCardDataByType(selectedCardType);
            } else {
                clearCardForm();
            }
        });
    }

    // Legacy function for initial load (deprecated but kept for compatibility)
    function loadSavedCardData() {
        // Check if user has any saved cards and load the first available
        if (savedCardData) {
            if (savedCardData.visa) {
                document.getElementById('card_type').value = 'visa';
                loadSavedCardDataByType('visa');
            } else if (savedCardData.mastercard) {
                document.getElementById('card_type').value = 'mastercard';
                loadSavedCardDataByType('mastercard');
            }
        }
    }

    // Cancel button handler
    if (cancelPaymentBtn) {
        cancelPaymentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            paymentModal.hide();
        });
    }

    // Close (X) button handler
    if (closePaymentModalBtn) {
        closePaymentModalBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            paymentModal.hide();
        });
    }

    // Allow closing by clicking backdrop
    const modalElement = document.getElementById('paymentModal');
    if (modalElement) {
        modalElement.addEventListener('click', function(e) {
            if (e.target === modalElement) {
                paymentModal.hide();
            }
        });
    }

    // Manual tab switching functionality
    const tabButtons = document.querySelectorAll('#paymentTabs .nav-link');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Remove active class from all tabs and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Add active class to clicked tab
            this.classList.add('active');

            // Show corresponding tab pane
            const targetId = this.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetId);
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });

    // Card number formatting - numbers only with spaces
    const cardNumberInput = document.getElementById('card_number');
    if (cardNumberInput) {
        // Clear button functionality
        const clearCardBtn = document.getElementById('clearCardBtn');
        if (clearCardBtn) {
            clearCardBtn.addEventListener('click', function() {
                cardNumberInput.value = '';
                cardNumberInput.removeAttribute('data-saved-card');
                cardNumberInput.removeAttribute('data-masked-value');
                cardNumberInput.removeAttribute('readonly');
                cardNumberInput.style.backgroundColor = '';
                cardNumberInput.style.cursor = '';
                cardNumberInput.focus();
                clearCardBtn.style.display = 'none';
                document.getElementById('savedCardHint').style.display = 'none';
            });
        }

        cardNumberInput.addEventListener('input', function(e) {
            // Only format if not a saved card (saved cards are readonly)
            if (!e.target.hasAttribute('data-saved-card')) {
                let value = e.target.value.replace(/\D/g, ''); // Remove all non-digits
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formattedValue;
            }
        });
    }

    // Combine expiry month and year into hidden field
    const cardExpiryMonth = document.getElementById('card_expiry_month');
    const cardExpiryYear = document.getElementById('card_expiry_year');
    const cardExpiryHidden = document.getElementById('card_expiry');

    function updateExpiryField() {
        if (cardExpiryMonth && cardExpiryYear && cardExpiryHidden) {
            const month = cardExpiryMonth.value;
            const year = cardExpiryYear.value;
            if (month && year) {
                cardExpiryHidden.value = month + '/' + year;
            } else {
                cardExpiryHidden.value = '';
            }
        }
    }

    if (cardExpiryMonth) {
        cardExpiryMonth.addEventListener('change', updateExpiryField);
    }
    if (cardExpiryYear) {
        cardExpiryYear.addEventListener('change', updateExpiryField);
    }

    // CVV number only
    const cardCvvInput = document.getElementById('card_cvv');
    if (cardCvvInput) {
        cardCvvInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }

    // Zip code - numbers only
    const billingZipInput = document.getElementById('billing_zip');
    if (billingZipInput) {
        billingZipInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }

    // Phone number - numbers, +, and spaces only
    const billingPhoneInput = document.getElementById('billing_phone');
    if (billingPhoneInput) {
        billingPhoneInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^\d+\s]/g, '');
        });
    }

    // Open payment modal when Book Now is clicked
    if (openModalBtn) {
        openModalBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Book Now button clicked');

            // Check if button is disabled due to conflicts
            if (this.disabled) {
                console.log('Button is disabled, not opening modal');
                return; // Don't open modal if conflicts exist
            }

            console.log('Button is enabled, proceeding with validation');

            // Simple validation - check required fields
            const branchId = document.getElementById('branch_id');
            const bookingDate = document.getElementById('date');
            const timeSlot = document.getElementById('time_slot');

            // Function to show animated alert
            function showAnimatedAlert(message) {
                // Remove existing alert if any
                const existingAlert = document.querySelector('.animated-validation-alert');
                if (existingAlert) {
                    existingAlert.remove();
                }

                // Create alert element
                const alertDiv = document.createElement('div');
                alertDiv.className = 'animated-validation-alert';
                alertDiv.innerHTML = `
                    <div class="alert-content">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>${message}</span>
                    </div>
                `;
                document.body.appendChild(alertDiv);

                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alertDiv.style.animation = 'popOut 0.3s ease-out';
                    setTimeout(() => alertDiv.remove(), 300);
                }, 3000);

                // Click to dismiss
                alertDiv.addEventListener('click', function() {
                    this.style.animation = 'popOut 0.3s ease-out';
                    setTimeout(() => this.remove(), 300);
                });
            }

            if (!branchId?.value) {
                console.log('Validation failed: No branch selected');
                showAnimatedAlert('Please select a branch');
                return;
            }
            console.log('Branch validation passed');

            // Check if either service or package is selected
            const packageId = document.getElementById('package_id');
            const selectedServices = getSelectedServiceIds();
            console.log('Selected services:', selectedServices, 'Package ID:', packageId?.value);
            if (selectedServices.length === 0 && !packageId?.value) {
                console.log('Validation failed: No service or package selected');
                showAnimatedAlert('Please select a service or package');
                return;
            }
            console.log('Service/package validation passed');

            if (!bookingDate?.value) {
                console.log('Validation failed: No booking date selected');
                showAnimatedAlert('Please select a booking date');
                return;
            }
            console.log('Date validation passed');

            if (!timeSlot?.value) {
                console.log('Validation failed: No time slot selected');
                showAnimatedAlert('Please select a time slot');
                return;
            }
            console.log('Time slot validation passed');

            // Check if selected time slot is disabled (full)
            const selectedOption = timeSlot.options[timeSlot.selectedIndex];
            if (selectedOption && selectedOption.disabled) {
                showAnimatedAlert('The selected time slot is no longer available. Please choose another time slot.');
                // Refresh the time slots to show current availability
                updateTimeSlots();
                return;
            }

            // Update GCash info based on selected branch
            const branchSelect = document.getElementById('branch_id');
            if (branchSelect && branchSelect.value) {
                const selectedOption = branchSelect.options[branchSelect.selectedIndex];
                const gcashNumber = selectedOption.getAttribute('data-gcash-number');
                const gcashQr = selectedOption.getAttribute('data-gcash-qr');
                const branchName = selectedOption.text;

                // Update GCash number
                const gcashNumberEl = document.getElementById('gcashNumber');
                if (gcashNumberEl && gcashNumber) {
                    gcashNumberEl.textContent = gcashNumber;
                }

                // Update GCash QR code
                const gcashQrImage = document.getElementById('gcashQrImage');
                const gcashQrFallback = document.getElementById('gcashQrFallback');

                if (gcashQrImage && gcashQr) {
                    gcashQrImage.src = gcashQr;
                    gcashQrImage.style.display = 'block';

                    // Hide fallback when image loads successfully
                    gcashQrImage.onload = function() {
                        gcashQrImage.style.display = 'block';
                        if (gcashQrFallback) gcashQrFallback.style.display = 'none';
                    };

                    // Show fallback if image fails to load
                    gcashQrImage.onerror = function() {
                        gcashQrImage.style.display = 'none';
                        if (gcashQrFallback) gcashQrFallback.style.display = 'block';
                    };
                }

                // Update branch name
                const branchNameEl = document.getElementById('branchName');
                if (branchNameEl && branchName) {
                    branchNameEl.textContent = branchName;
                }
            }

            // Load saved card data if available
            loadSavedCardData();

            // Show the payment modal
            console.log('All validation passed, showing payment modal');
            paymentModal.show();
        });
    }

    // Confirm payment and submit form
    if (confirmPaymentBtn) {
        let isSubmitting = false; // Flag to prevent double submission

        confirmPaymentBtn.addEventListener('click', function() {
            // Prevent double submission
            if (isSubmitting) {
                return;
            }

            const activeTab = document.querySelector('#paymentTabs .nav-link.active').id;
            let paymentMethod = '';
            let paymentData = {};

            // Determine payment method
            if (activeTab === 'credit-card-tab') {
                paymentMethod = 'card';
                const cardForm = document.getElementById('cardPaymentForm');
                if (!cardForm.checkValidity()) {
                    cardForm.reportValidity();
                    return;
                }
                const cardNumberField = document.getElementById('card_number');
                let cardNumber = cardNumberField.value;

                // Allow submission with saved card (the backend will use the saved encrypted card)
                // The masked value is just for display, backend has the real encrypted card

                paymentData = {
                    card_type: document.getElementById('card_type').value,
                    card_number: cardNumber,
                    card_expiry: document.getElementById('card_expiry').value,
                    card_cvv: document.getElementById('card_cvv').value,
                    billing_first_name: document.getElementById('billing_first_name').value,
                    billing_last_name: document.getElementById('billing_last_name').value,
                    billing_address: document.getElementById('billing_address').value,
                    billing_city: document.getElementById('billing_city').value,
                    billing_zip: document.getElementById('billing_zip').value,
                    billing_country: document.getElementById('billing_country').value,
                    billing_phone: document.getElementById('billing_phone').value,
                    save_card: document.getElementById('save_card').checked
                };
            } else if (activeTab === 'gcash-tab') {
                paymentMethod = 'gcash';
                // Get the actual GCash number from the displayed text
                const gcashNumber = document.getElementById('gcashNumber').textContent;
                paymentData = {
                    gcash_payment: true,
                    gcash_number: gcashNumber
                };
            } else if (activeTab === 'cash-tab') {
                paymentMethod = 'cash';
                paymentData = {
                    payment_at_branch: true
                };
            }

            // Check if refund policy modal should be shown (for ALL payment methods)
            if (typeof window.shouldShowRefundPolicyModal === 'function' &&
                window.shouldShowRefundPolicyModal() &&
                !window.refundPolicyAgreed) {

                // Store the submission function to be called after modal agreement
                window.pendingBookingSubmission = function() {
                    submitBookingForm(paymentMethod, paymentData);
                };

                // Show refund policy modal
                if (typeof window.showRefundPolicyModal === 'function') {
                    window.showRefundPolicyModal();
                }
                return;
            }

            // If policy already agreed, proceed with submission
            submitBookingForm(paymentMethod, paymentData);
        });

        // Helper function to submit booking form
        function submitBookingForm(paymentMethod, paymentData) {
            // Set flag to prevent double submission
            isSubmitting = true;

            // If GCash payment, include the receipt file
            if (paymentMethod === 'gcash') {
                const receiptFile = document.getElementById('modal_gcash_receipt')?.files[0];
                if (receiptFile) {
                    // Create a new file input in the main form
                    let fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'gcash_receipt';
                    fileInput.style.display = 'none';
                    bookingForm.appendChild(fileInput);

                    // Create a DataTransfer to set the file
                    const dt = new DataTransfer();
                    dt.items.add(receiptFile);
                    fileInput.files = dt.files;
                }
            }

            // Disable button and show loading state
            confirmPaymentBtn.disabled = true;
            confirmPaymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

            // Add payment method and data to form as hidden inputs
            let paymentMethodInput = document.createElement('input');
            paymentMethodInput.type = 'hidden';
            paymentMethodInput.name = 'payment_method';
            paymentMethodInput.value = paymentMethod;
            bookingForm.appendChild(paymentMethodInput);

            let paymentDataInput = document.createElement('input');
            paymentDataInput.type = 'hidden';
            paymentDataInput.name = 'payment_data';
            paymentDataInput.value = JSON.stringify(paymentData);
            bookingForm.appendChild(paymentDataInput);

            // Close payment modal and submit form
            paymentModal.hide();

            // Reset refund policy agreed flag for next booking
            window.refundPolicyAgreed = false;

            bookingForm.submit();
        }
    }
});

// Recommendations Modal JavaScript
document.addEventListener('DOMContentLoaded', function() {

    // Custom notification function for selections
    function showSelectionNotification(itemName, itemType = 'Service') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'selection-notification';
        notification.innerHTML = `
            <div class="icon-wrapper">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="message">
                <div class="title">${itemType} Selected!</div>
                <div class="subtitle">${itemName}</div>
            </div>
            <button class="close-btn" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;

        // Append to body
        document.body.appendChild(notification);

        // Auto remove after 3.5 seconds
        setTimeout(() => {
            notification.classList.add('hiding');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 400); // Match animation duration
        }, 3500);
    }

    // Function to update recommendation prices based on selected branch
    function updateRecommendationPrices() {
        const branchId = document.getElementById('branch_id')?.value;

        if (!branchId || typeof branchData === 'undefined' || !branchData[branchId]) {
            // No branch selected, show message for services
            document.querySelectorAll('.service-price .price-loader').forEach(el => {

                el.style.color = '#999';
                el.style.fontSize = '0.85rem';
            });

            // Show all packages even when no branch is selected
            document.querySelectorAll('.package-item').forEach(item => {
                item.style.setProperty('display', 'flex', 'important');
                item.classList.remove('d-none');

                // Show "Available" for packages when no branch selected
                const priceEl = item.querySelector('.package-price[data-package-id]');
                const loaderEl = priceEl?.querySelector('.price-loader');
                if (loaderEl) {
                    loaderEl.textContent = 'Available';
                    loaderEl.style.color = '#28a745';
                    loaderEl.style.fontSize = '0.9rem';
                }
            });

            // Hide "no packages" message
            const noPackagesMsg = document.getElementById('noPackagesMessage');
            if (noPackagesMsg) {
                noPackagesMsg.style.display = 'none';
            }
            return;
        }

        const branchServices = branchData[branchId].services || [];
        const branchPackages = branchData[branchId].packages || [];

        // Update service prices
        document.querySelectorAll('.service-price[data-service-id]').forEach(priceEl => {
            const serviceId = parseInt(priceEl.dataset.serviceId);
            const branchService = branchServices.find(s => s.id === serviceId);

            const loaderEl = priceEl.querySelector('.price-loader');
            if (branchService && branchService.price) {
                if (loaderEl) {
                    loaderEl.innerHTML = '₱' + Number(branchService.price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    loaderEl.style.color = '#F56289';
                    loaderEl.style.fontSize = '1.1rem';
                    loaderEl.style.fontWeight = '700';
                }
            } else {
                if (loaderEl) {
                    loaderEl.textContent = 'Not available';
                    loaderEl.style.color = '#dc3545';
                    loaderEl.style.fontSize = '0.8rem';
                }
            }
        });

        // Show all packages regardless of branch (like the package dropdown)
        document.querySelectorAll('.package-item').forEach(item => {
            const packageId = parseInt(item.dataset.id);

            // Always show the package
            item.style.setProperty('display', 'flex', 'important');
            item.classList.remove('d-none');

            // Try to find price for this branch, but show package even if not available
            const branchPackage = branchPackages.find(p => {
                const pId = parseInt(p.id);
                return pId === packageId;
            });

            // Update price
            const priceEl = item.querySelector('.package-price[data-package-id]');
            const loaderEl = priceEl?.querySelector('.price-loader');
            if (loaderEl) {
                if (branchPackage && (branchPackage.price || branchPackage.price === 0)) {
                    loaderEl.innerHTML = '₱' + Number(branchPackage.price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    loaderEl.style.color = '#F56289';
                    loaderEl.style.fontSize = '1.1rem';
                    loaderEl.style.fontWeight = '700';
                } else {
                    // Show default price or "Price varies" if not available for this branch
                    loaderEl.textContent = 'Available';
                    loaderEl.style.color = '#28a745';
                    loaderEl.style.fontSize = '0.9rem';
                }
            }
        });

        // Hide "no packages" message since we always show all packages
        const noPackagesMsg = document.getElementById('noPackagesMessage');
        if (noPackagesMsg) {
            noPackagesMsg.style.display = 'none';
        }

        // Show/hide entire packages section
        const packagesSection = document.getElementById('packagesSection');
        if (packagesSection) {
            // Always show the section, let the message handle empty state
            packagesSection.style.display = 'block';
        }
    }

    // Open recommendations modal
    const showRecommendationsBtn = document.getElementById('showRecommendationsBtn');
    if (showRecommendationsBtn) {
        showRecommendationsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Recommendations button clicked');

            // Update prices based on selected branch
            try {
                updateRecommendationPrices();
            } catch (error) {
                console.error('Error updating prices:', error);
            }

            const modalEl = document.getElementById('recommendationsModal');
            if (modalEl) {
                const recommendationsModal = new bootstrap.Modal(modalEl);
                recommendationsModal.show();
                console.log('Modal shown');

                // Add manual close button handler
                const closeBtn = modalEl.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function(e) {
                        console.log('Close button clicked');
                        recommendationsModal.hide();
                    });
                }

                // Log visible items for debugging
                setTimeout(() => {
                    const visibleServices = document.querySelectorAll('#recommendationsModal .list-group-item[data-type="service"]');
                    const visiblePackages = document.querySelectorAll('#recommendationsModal .package-item');
                    const displayedPackages = Array.from(visiblePackages).filter(p => p.style.display !== 'none');

                    console.log('Total services:', visibleServices.length);
                    console.log('Total packages in modal:', visiblePackages.length);
                    console.log('Displayed packages:', displayedPackages.length);

                    displayedPackages.forEach(p => {
                        console.log('Displayed package:', p.dataset.name, 'ID:', p.dataset.id);
                    });
                }, 500);
            } else {
                console.error('Modal element not found');
            }
        });
    } else {
        console.error('Recommendations button not found');
    }

    // Update prices when branch changes
    const branchSelect = document.getElementById('branch_id');
    if (branchSelect) {
        branchSelect.addEventListener('change', function() {
            try {
                updateRecommendationPrices();
            } catch (error) {
                console.error('Error updating prices on branch change:', error);
            }
        });
    }

    // Handle service selection from recommendations using event delegation
    document.addEventListener('click', function(e) {
        // Check if clicked element or its parent is a select service button
        const serviceBtn = e.target.closest('.btn-select-service');
        if (serviceBtn) {
            e.preventDefault();
            e.stopPropagation();

            const listItem = serviceBtn.closest('.list-group-item');
            if (!listItem) {
                return;
            }

            const serviceId = listItem.dataset.id;
            const serviceName = listItem.dataset.name;

            if (!serviceId) {
                return;
            }

            // Show custom notification
            showSelectionNotification(serviceName, 'Service');

            // Close modal using jQuery
            const modalEl = document.getElementById('recommendationsModal');
            if (modalEl) {
                $(modalEl).modal('hide');
            }

            // Set the service in the booking form
            const serviceCheckbox = document.getElementById('service_' + serviceId);
            if (serviceCheckbox) {
                // Wait for modal to close, then check service
                setTimeout(() => {
                    serviceCheckbox.checked = true;
                    updateSelectedServices();
                    updatePriceDisplay();
                    updateTimeSlots();
                    updatePromoOptions(branchSelect.value, getSelectedServiceIds());
                    checkBookingConflicts();

                    // Scroll to service field
                    serviceCheckbox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
            }
        }

        // Handle package selection from recommendations using event delegation
        const packageBtn = e.target.closest('.btn-select-package');
        if (packageBtn) {
            e.preventDefault();
            e.stopPropagation();

            const listItem = packageBtn.closest('.list-group-item');
            if (!listItem) {
                return;
            }

            const packageId = listItem.dataset.id;
            const packageName = listItem.dataset.name;

            if (!packageId) {
                return;
            }

            // Show custom notification
            showSelectionNotification(packageName, 'Package');

            // Close modal using jQuery
            const modalEl = document.getElementById('recommendationsModal');
            if (modalEl) {
                $(modalEl).modal('hide');
            }

            // Set the package in the booking form
            const packageSelect = document.getElementById('package_id');
            if (packageSelect) {
                setTimeout(() => {
                    packageSelect.value = packageId;
                    packageSelect.dispatchEvent(new Event('change'));

                    // Scroll to package field
                    packageSelect.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
            }
        }

        // Handle service selection from recommended packages using event delegation
        const packageServiceBtn = e.target.closest('.btn-select-package-service');
        if (packageServiceBtn) {
            e.preventDefault();
            e.stopPropagation();

            const serviceItem = packageServiceBtn.closest('[data-type="package-service"]');
            if (!serviceItem) {
                return;
            }

            const serviceId = serviceItem.dataset.serviceId;
            const serviceName = serviceItem.dataset.serviceName;

            if (!serviceId) {
                return;
            }

            // Show custom notification
            showSelectionNotification(serviceName, 'Service');

            // Set the service in the booking form immediately
            const serviceCheckbox = document.getElementById('service_' + serviceId);
            if (serviceCheckbox) {
                serviceCheckbox.checked = true;
                updateSelectedServices();
                updatePriceDisplay();
                updateTimeSlots();
                updatePromoOptions(branchSelect.value, getSelectedServiceIds());
                checkBookingConflicts();
            }

            // Close modal using jQuery
            const modalEl = document.getElementById('recommendationsModal');
            if (modalEl) {
                $(modalEl).modal('hide');
            }

            // Scroll to service field after modal closes
            setTimeout(() => {
                if (serviceCheckbox) {
                    serviceCheckbox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 300);
        }
    });
});
</script>

<style>
/* Recommendations Modal Styles */

/* Force hide packages that are not available */
.package-item.d-none {
    display: none !important;
}

/* Custom Selection Notification Popup */
.selection-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 99999;
    background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(245, 98, 137, 0.4);
    display: flex;
    align-items: center;
    gap: 15px;
    min-width: 320px;
    max-width: 90%;
    animation: slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.selection-notification.hiding {
    animation: slideOutRight 0.4s ease-in forwards;
}

.selection-notification .icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.selection-notification .icon-wrapper i {
    font-size: 1.5rem;
    animation: checkPulse 0.6s ease-out;
}

.selection-notification .message {
    flex: 1;
}

.selection-notification .message .title {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 3px;
}

.selection-notification .message .subtitle {
    font-size: 0.9rem;
    opacity: 0.9;
}

.selection-notification .close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}

.selection-notification .close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideOutRight {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}

@keyframes checkPulse {
    0%, 100% {
        transform: scale(1);
    }
    25% {
        transform: scale(1.3);
    }
    50% {
        transform: scale(0.9);
    }
    75% {
        transform: scale(1.1);
    }
}

.btn-outline-pink {
    color: #F56289;
    border: 2px solid #F56289;
    background: #fff;
    font-weight: 600;
    padding: 12px 20px;
    transition: all 0.3s ease;
}

.btn-outline-pink:hover {
    background: #F56289;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(245, 98, 137, 0.3);
}

/* List-based recommendations (no images) */
#recommendationsModal .list-group-item {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 8px;
    padding: 16px;
    transition: all 0.2s ease;
    background: #fff;
}

#recommendationsModal .list-group-item:hover {
    background: #f9f9f9;
    border-color: #F56289;
    box-shadow: 0 2px 8px rgba(245, 98, 137, 0.1);
}

#recommendationsModal .service-price,
#recommendationsModal .package-price {
    font-weight: 700;
    color: #F56289;
    min-width: 100px;
    text-align: right;
}

#recommendationsModal .price-loader {
    font-size: 0.9rem;
}

.btn-select-service,
.btn-select-package,
.btn-select-package-service {
    background: #F56289;
    color: #fff;
    border: none;
    padding: 6px 20px;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-select-service:hover,
.btn-select-package:hover,
.btn-select-package-service:hover {
    background: #e94583;
    transform: scale(1.05);
    color: #fff;
}

.package-container {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
}

.services-in-package {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 12px;
}

.btn-xs {
    padding: 4px 12px;
    font-size: 0.75rem;
    border-radius: 4px;
}

.bg-pink {
    background: #F56289;
}

/* Conflict message styling for time slot area */
.conflict-alert {
    margin-top: 8px;
    margin-bottom: 0;
    border-radius: 8px;
    font-size: 0.9rem;
    padding: 8px 12px;
}

.conflict-alert i {
    font-size: 1rem;
}

/* Disabled Book Now button styling */
#openPaymentModal:disabled {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    cursor: not-allowed !important;
    opacity: 0.6 !important;
}

/* Custom multiselect dropdown styling */
.custom-multiselect {
    position: relative;
}

.multiselect-header {
    cursor: pointer;
    background: white;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    min-height: 38px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.multiselect-header:hover {
    border-color: #F56289;
}

.multiselect-header:focus {
    border-color: #F56289;
    box-shadow: 0 0 0 0.2rem rgba(245, 98, 137, 0.25);
    outline: none;
}

.multiselect-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1000;
    background: white;
    border: 1px solid #ced4da;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.multiselect-option:hover {
    background-color: #000000;
    color: white;
}

.multiselect-option:hover .form-check-label {
    color: white;
}

.multiselect-option {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
}

.multiselect-option .service-checkbox {
    margin-top: 0;
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    border: 2px solid #ced4da;
    background-color: white;
    border-radius: 3px;
    cursor: pointer;
    appearance: none;
    position: relative;
    outline: none;
    transition: all 0.2s ease;
}

.multiselect-option .service-checkbox:checked {
    background-color: #F56289;
    border-color: #F56289;
}

.multiselect-option .service-checkbox:checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.multiselect-option .service-checkbox:hover {
    border-color: #F56289;
}

.multiselect-option .form-check-label {
    margin-bottom: 0;
    cursor: pointer;
    flex: 1;
    color: inherit;
    margin-left: 10px;
}
</style>

<!-- Include Refund Policy Modal -->
@include('components.refund-policy-modal')

@endsection
