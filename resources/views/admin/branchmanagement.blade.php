@extends('layouts.adminapp')
@section('head')
<link href="{{ asset('css/admin/branchmanagement.css') }}?v={{ time() }}" rel="stylesheet">
@endsection
@section('content')
<div class="container branch-card">
    <div class="branch-title">Branch Management</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-branch">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branches as $branch)
                @php
                    if (is_array($branch)) $branch = (object) $branch;
                    // ensure we have a scalar id for route generation and form inputs
                    $branchId = is_array($branch) ? ($branch['id'] ?? null) : ($branch->id ?? null);
                @endphp
                <tr>
                    <td>
                        <strong>{{ $branch->name }}</strong>
                    </td>
                    <td>
                        {{ $branch->address ?? $branch->location_detail ?? '' }}
                    </td>
                    <td class="text-center">
                        @if(isset($branch->active) && $branch->active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="gap-2 mb-2 d-flex justify-content-center">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editBranchModal{{ $branch->id }}">Edit Branch</button>
                            <form action="{{ route('admin.branch.toggle', $branchId) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm {{ (isset($branch->active) && $branch->active) ? 'btn-warning' : 'btn-success' }}">
                                    {{ (isset($branch->active) && $branch->active) ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <button class="btn btn-admin btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#managePackagesModal{{ $branch->id }}">Service Packages</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <div class="mt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 style="color:#e75480; margin:0;">Services for this Branch</h6>
                                <div class="gap-2 d-flex align-items-center">
                                        @php
                                            // Normalize branch id (handle array or object)
                                            $branchId = is_array($branch) ? ($branch['id'] ?? null) : ($branch->id ?? null);
                                            // Include global services (branch_id NULL)
                                            $globalServices = App\Models\Service::whereNull('branch_id')->get();
                                            // Get branch-specific services via relation (if model object) or by branch_id
                                            if (is_object($branch) && method_exists($branch, 'services')) {
                                                $branchServices = $branch->services()->get();
                                            } else {
                                                $branchServices = App\Models\Service::where('branch_id', $branchId)->get();
                                            }
                                            // Merge and dedupe by id
                                            $servicesForBranch = $globalServices->merge($branchServices)->unique('id')->values();
                                            // Fallback: if merge yields nothing (unexpected), show all services so UI isn't empty
                                            if ($servicesForBranch->isEmpty()) {
                                                $servicesForBranch = App\Models\Service::all();
                                            }
                                                // make a full services list available for package creation/attachment modals
                                                $allServicesForPackage = App\Models\Service::all();
                                            $categories = $servicesForBranch->pluck('category')->unique()->filter()->values();
                                        @endphp
                                        <select id="categoryFilter{{ $branch->id }}" class="form-select form-select-sm">
                                        <option value="">All categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-admin btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#manageCategoriesModal{{ $branch->id }}">Manage Categories</button>
                                    <button class="btn btn-admin btn-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#addServiceModal{{ $branch->id }}">Add New Service</button>
                                </div>
                            </div>

                                <!-- services count (hidden in production) -->

                                <div class="services-scroll">
                                    <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Description</th>
                                        <th>Price (₱)</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servicesForBranch as $service)
                                    <tr data-category="{{ $service->category ?? '' }}">
                                        <td>
                                            {{ $service->name }}
                                            <div class="small text-muted">{{ $service->category ?? '' }}</div>
                                            @if(isset($service->pivot) && $service->pivot->custom_description)
                                                <div class="small">{{ $service->pivot->custom_description }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $service->description ?? ($service->pivot->custom_description ?? '') }}</td>
                                        <td>{{ $service->pivot->price ?? $service->price }}</td>
                                        <td>
                                            @php $isActive = isset($service->pivot) ? $service->pivot->active : ($service->active ?? 1); @endphp
                                            @if($isActive)
                                                <span class="badge bg-success">Enabled</span>
                                            @else
                                                <span class="badge bg-secondary">Disabled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.toggleService', $service->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="branch_id" value="{{ $branchId }}">
                                                @php $isActive = isset($service->pivot) ? $service->pivot->active : ($service->active ?? 1); @endphp
                                                <button type="submit" class="btn btn-sm {{ $isActive ? 'btn-warning' : 'btn-success' }}">
                                                    {{ $isActive ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">Edit</button>
                                            <!-- Delete button opens a floating confirmation modal -->
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-service"
                                                data-action="{{ route('admin.deleteService', $service->id) }}"
                                                data-name="{{ $service->name }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Edit Service Modal -->
                                    <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-labelledby="editServiceModalLabel{{ $service->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('admin.updateService', $service->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editServiceModalLabel{{ $service->id }}">Edit Service</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $pivotPrice = $service->pivot->price ?? null;
                                                            $pivotDesc = $service->pivot->custom_description ?? null;
                                                        @endphp
                                                        <input type="hidden" name="branch_id" value="{{ $branchId }}">
                                                        <div class="mb-3">
                                                            <label>Service Name</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Description</label>
                                                            <textarea name="description" class="form-control">{{ $pivotDesc ?? $service->description }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Price (₱)</label>
                                                            <input type="number" name="price" class="form-control" value="{{ $pivotPrice ?? $service->price }}" min="0" step="0.01" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Duration (hours)</label>
                                                            <input type="number" name="duration" class="form-control" value="{{ $service->pivot->duration ?? $service->duration ?? 1 }}" min="1" step="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-admin">Update</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                                    </table>
                                </div>

                            <!-- Inline Service Packages (summary below services) -->
                            @php
                                $packagesInline = \App\Models\Package::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
                            @endphp
                            <div class="mt-3">
                                @if($packagesInline->isEmpty())
                                    <div class="text-muted small">No service packages for this branch. <button class="btn btn-sm btn-admin ms-2" data-bs-toggle="modal" data-bs-target="#managePackagesModal{{ $branch->id }}">Manage Packages</button></div>

                                    <!-- Create Package Modal -->
                                    <div class="modal fade" id="createPackageModal{{ $branch->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <form action="{{ route('admin.packages.store', $branch->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                                <div class="modal-content">
                                                    <div class="modal-header"><h5 class="modal-title">Create Package</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                                    <div class="modal-body">
                                                        <div class="mb-3"><label>Name</label><input class="form-control" name="name" required></div>
                                                        <div class="mb-3"><label>Price</label><input class="form-control" name="price" type="number" step="0.01" required></div>
                                                        <div class="mb-3"><label>Description</label><textarea class="form-control" name="description"></textarea></div>
                                                        <p class="small text-muted">Total package duration: <strong id="newPkgDuration{{ $branch->id }}">0 hrs</strong></p>
                                                        <div class="row" id="newPkgServicesContainer{{ $branch->id }}">
                                                            @foreach($allServicesForPackage as $s)
                                                                <div class="mb-2 col-12 d-flex align-items-center">
                                                                    <input class="form-check-input me-2 newpkg-svc-checkbox" type="checkbox" data-duration="{{ $s->duration ?? 1 }}" name="service_ids[]" value="{{ $s->id }}" id="newpkgsvc{{ $branch->id }}_{{ $s->id }}">
                                                                    <label for="newpkgsvc{{ $branch->id }}_{{ $s->id }}" class="me-3">{{ $s->name }} <small class="text-muted">({{ $s->category }})</small></label>
                                                                    <input type="number" name="quantities[{{ $s->id }}]" class="form-control form-control-sm ms-auto newpkg-svc-qty" data-duration="{{ $s->duration ?? 1 }}" style="width:120px;" min="1" value="1">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer"><button class="btn btn-admin">Create</button><button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <script>
                                        (function(){
                                            var branchId = {{ $branch->id }};
                                            var container = document.getElementById('newPkgServicesContainer'+branchId);
                                            var display = document.getElementById('newPkgDuration'+branchId);
                                            if(!container || !display) return;
                                            function recompute(){
                                                var total = 0;
                                                var checks = container.querySelectorAll('.newpkg-svc-checkbox');
                                                checks.forEach(function(ch){
                                                    if(ch.checked){
                                                        var dur = Number(ch.getAttribute('data-duration')||1) || 1;
                                                        var id = ch.value;
                                                        var qtyEl = container.querySelector('.newpkg-svc-qty[name="quantities['+id+']"]');
                                                        var qty = qtyEl ? (Number(qtyEl.value)||1) : 1;
                                                        total += dur * qty;
                                                    }
                                                });
                                                display.textContent = total + ' hr' + (total>1?'s':'');
                                            }
                                            container.addEventListener('change', function(e){ if(e.target.classList.contains('newpkg-svc-checkbox') || e.target.classList.contains('newpkg-svc-qty')) recompute(); });
                                            recompute();
                                        })();
                                    </script>
                                @else
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <div class="branch-title" style="font-size:2.25rem;margin:0;color:#e75480;">Service Packages</div>
                                    </div>
                                @endif
                            </div>
                            <!-- Add Service Modal -->
                            <div class="modal fade" id="addServiceModal{{ $branch->id }}" tabindex="-1" aria-labelledby="addServiceModalLabel{{ $branch->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.addService', $branch->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addServiceModalLabel{{ $branch->id }}">Add New Service</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Service Name</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Category (optional)</label>
                                                    @php $allCats = isset($categories) ? $categories : App\Models\Service::pluck('category')->unique()->filter()->values(); @endphp
                                                    <select name="category" id="categorySelect{{ $branch->id }}" class="form-select">
                                                        <option value="">-- None / Select category --</option>
                                                        @foreach($allCats as $cat)
                                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                                        @endforeach
                                                        <option value="__new">+ Add new category...</option>
                                                    </select>
                                                    <input type="text" name="new_category" id="newCategoryInput{{ $branch->id }}" class="mt-2 form-control" placeholder="Enter new category" style="display:none;">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Description</label>
                                                    <textarea name="description" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Price (₱)</label>
                                                    <input type="number" name="price" class="form-control" min="0" step="0.01" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Duration (hours)</label>
                                                    <input type="number" name="duration" class="form-control" value="1" min="1" step="1" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-admin">Add Service</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <script>
                                (function(){
                                    var sel = document.getElementById('categorySelect'+{{ $branch->id }});
                                    var input = document.getElementById('newCategoryInput'+{{ $branch->id }});
                                    if(!sel || !input) return;
                                    sel.addEventListener('change', function(){
                                        if(this.value === '__new') {
                                            input.style.display = '';
                                            input.focus();
                                        } else {
                                            input.style.display = 'none';
                                            input.value = '';
                                        }
                                    });
                                })();
                            </script>

                            <script>
                                (function(){
                                    var sel = document.getElementById('categoryFilter'+{{ $branch->id }});
                                    if(!sel) return;
                                    sel.addEventListener('change', function(){
                                        var val = this.value;
                                        // scope to services-scroll inside the same branch cell
                                        var td = sel.closest('td') || sel.closest('tr');
                                        if(!td) return;
                                        var container = td.querySelector('.services-scroll');
                                        if(!container) return;
                                        var rows = container.querySelectorAll('[data-category]');
                                        rows.forEach(function(r){
                                            var cat = r.getAttribute('data-category') || '';
                                            if(!val || cat === val) r.style.display = '';
                                            else r.style.display = 'none';
                                        });
                                    });
                                })();
                            </script>


                        </div>
                    </td>
                </tr>

                <!-- Edit Branch Modal -->
                <div class="modal fade" id="editBranchModal{{ $branch->id }}" tabindex="-1" aria-labelledby="editBranchModalLabel{{ $branch->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.updateBranch', $branch->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBranchModalLabel{{ $branch->id }}">Edit Branch Details & Time Slot</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Branch Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $branch->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="{{ $branch->address ?? $branch->location_detail ?? '' }}" required>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="mb-3">
                                        <label>Contact Number</label>
                                        <input type="text" name="contact_number" class="form-control" value="{{ $branch->contact_number ?? '' }}" placeholder="09XX XXX XXXX">
                                    </div>

                                    <div class="mb-3">
                                        <label>Telephone Number</label>
                                        <input type="text" name="telephone_number" class="form-control" value="{{ $branch->telephone_number ?? '' }}" placeholder="(032) XXX XXXX">
                                    </div>

                                    <!-- Operating Days -->
                                    <div class="mb-3">
                                        <label>Operating Days</label>
                                        <div class="row">
                                            @php
                                                // Get the days this branch operates (stored as comma-separated values)
                                                $operating_days = !empty($branch->operating_days) ? explode(',', $branch->operating_days) : [];
                                                $all_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                            @endphp
                                            @foreach($all_days as $day)
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                               name="operating_days[]"
                                                               value="{{ $day }}"
                                                               class="form-check-input"
                                                               id="day_{{ strtolower($day) }}"
                                                               {{ in_array($day, $operating_days) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="day_{{ strtolower($day) }}">
                                                            {{ $day }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @php
                                        // parse existing time_slot into start/end for the time inputs
                                        $startTime = '';
                                        $endTime = '';
                                        if (!empty($branch->time_slot) && strpos($branch->time_slot, ' - ') !== false) {
                                            [$startTime, $endTime] = explode(' - ', $branch->time_slot, 2);
                                        }
                                    @endphp
                                    <div class="mb-3">
                                        <label>Available Time Slot</label>
                                        <div class="row g-2">
                                            <div class="col">
                                                    <input type="time" class="form-control" name="start_time" id="start_time" value="{{ old('start_time', optional($branch)->time_slot ? explode(' - ', $branch->time_slot)[0] : '') }}" required>
                                            </div>
                                            <div class="col-auto align-self-center">to</div>
                                            <div class="col">
                                                    <input type="time" class="form-control" name="end_time" id="end_time" value="{{ old('end_time', optional($branch)->time_slot ? explode(' - ', $branch->time_slot)[1] : '') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="mb-3">
                                            <label for="break_start" class="form-label">Break Start (optional)</label>
                                            <input type="time" class="form-control" name="break_start" id="break_start" value="{{ old('break_start', optional($branch)->break_start) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="break_end" class="form-label">Break End (optional)</label>
                                            <input type="time" class="form-control" name="break_end" id="break_end" value="{{ old('break_end', optional($branch)->break_end) }}">
                                        </div>
                                    <div class="mb-3">
                                        <label>Slot Capacity (per day)</label>
                                        <input type="number" name="slot_capacity" class="form-control" value="{{ $branch->slot_capacity ?? '' }}" min="1" required>
                                    </div>

                                    <!-- GCash Payment Information -->
                                    <hr class="my-4">
                                    <h6 class="mb-3" style="color:#e75480;">GCash Payment Information</h6>

                                    <div class="mb-3">
                                        <label for="gcash_number">GCash Number</label>
                                        <input type="text" name="gcash_number" class="form-control" value="{{ $branch->gcash_number ?? '' }}" placeholder="09XX XXX XXXX">
                                        <small class="text-muted">This number will be displayed to clients for GCash payments</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="gcash_qr">GCash QR Code Image</label>
                                        <input type="file" name="gcash_qr" id="gcash_qr" class="form-control" accept="image/*">
                                        <div class="alert alert-warning mt-2 mb-0" style="font-size: 0.85rem; padding: 8px 12px;">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <strong>Important:</strong> Please upload <strong>ONLY QR code images</strong> here. This image will be displayed to clients for GCash payments.
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-admin">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Manage Services Modal -->
                <div class="modal fade" id="manageServicesModal{{ $branch->id }}" tabindex="-1" aria-labelledby="manageServicesModalLabel{{ $branch->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('admin.updateBranchServices', $branchId) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header" style="background:#ffe4ec;">
                                    <h5 class="modal-title" id="manageServicesModalLabel{{ $branch->id }}" style="color:#e75480;">Manage Services</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <p>Select which services this branch should offer. You can override the price per branch.</p>
                                    <div class="row">
                                        @php
                                            // Build a map of service_id => pivot record for quick lookup
                                            $pivotMap = [];
                                            if (is_object($branch) && method_exists($branch, 'services')) {
                                                foreach ($branch->services()->get() as $p) {
                                                    $pivotMap[$p->id] = $p->pivot;
                                                }
                                            } else {
                                                foreach (App\Models\Service::where('branch_id', $branchId)->get() as $p) {
                                                    $pivotMap[$p->id] = null;
                                                }
                                            }
                                            $allServices = App\Models\Service::all();
                                        @endphp
                                        @foreach($allServices as $s)
                                            <div class="mb-2 col-12">
                                                <div class="form-check d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="checkbox" name="service_ids[]" value="{{ $s->id }}" id="svc{{ $branchId }}_{{ $s->id }}" {{ isset($pivotMap[$s->id]) ? 'checked' : '' }}>
                                                    <label class="form-check-label me-3" for="svc{{ $branchId }}_{{ $s->id }}">{{ $s->name }} <small class="text-muted">({{ $s->category }})</small></label>
                                                        <input type="number" step="0.01" min="0" name="prices[{{ $s->id }}]" class="form-control form-control-sm ms-2" style="width:120px;" placeholder="Price" value="{{ isset($pivotMap[$s->id]) ? $pivotMap[$s->id]->price : $s->price }}">
                                                        <input type="number" step="1" min="1" name="durations[{{ $s->id }}]" class="form-control form-control-sm ms-2" style="width:100px;" placeholder="Hours" value="{{ isset($pivotMap[$s->id]) && isset($pivotMap[$s->id]->duration) ? $pivotMap[$s->id]->duration : ($s->duration ?? 1) }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-admin">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Manage Packages Modal (inline package manager) -->
                <div class="modal fade" id="managePackagesModal{{ $branch->id }}" tabindex="-1" aria-labelledby="managePackagesModalLabel{{ $branch->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background:#ffe4ec;">
                                <h5 class="modal-title" id="managePackagesModalLabel{{ $branch->id }}" style="color:#e75480;">Service Packages</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $packages = \App\Models\Package::where('branch_id', $branchId)->orWhereNull('branch_id')->get();
                                    $allServicesForPackage = \App\Models\Service::all();
                                @endphp
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <p style="color:#e75480; margin:0;">Configure service packages for this branch.</p>
                                    </div>
                                        <button class="btn btn-admin btn-sm" data-bs-toggle="modal" data-bs-target="#createPackageModal{{ $branch->id }}">Add New Package</button>
                                    </div>
                                </div>

                                @if($packages->isEmpty())
                                    <div class="alert alert-secondary">No packages yet for this branch.</div>
                                @else
                                    <div class="mb-2">
                                        <div class="branch-title" style="font-size:1.25rem;margin:0 0 8px 0;color:#e75480;">Service Packages</div>
                                    </div>
                                    <div style="max-height:260px; overflow-y:auto;">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Duration (hrs)</th>
                                                <th>Services</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($packages as $pkg)
                                            @php $pkgDuration = $pkg->duration ?? 0; @endphp
                                            <tr>
                                                <td>{{ $pkg->name }}</td>
                                                <td>{{ $pkg->price }}</td>
                                                <td class="text-center">{{ $pkgDuration }} hr{{ $pkgDuration>1 ? 's' : '' }}</td>
                                                <td style="min-width:220px;">
                                                    @foreach($pkg->services as $s)
                                                        <div>{{ $s->name }} <small class="text-muted">(x{{ $s->pivot->quantity ?? 1 }})</small></div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.packages.delete', $pkg->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                    <button class="btn btn-sm btn-admin" data-bs-toggle="modal" data-bs-target="#editPackageModal{{ $pkg->id }}">Edit</button>
                                                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#attachServicesModal{{ $pkg->id }}">Services</button>
                                                </td>
                                            </tr>

                                            <!-- Edit Package Modal -->
                                            <div class="modal fade" id="editPackageModal{{ $pkg->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('admin.packages.update', $pkg->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header"><h5 class="modal-title">Edit Package</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                                            <div class="modal-body">
                                                                <div class="mb-3"><label>Name</label><input class="form-control" name="name" value="{{ $pkg->name }}" required></div>
                                                                <div class="mb-3"><label>Price</label><input class="form-control" name="price" type="number" step="0.01" value="{{ $pkg->price }}" required></div>
                                                                <div class="mb-3"><label>Description</label><textarea class="form-control" name="description">{{ $pkg->description }}</textarea></div>
                                                            </div>
                                                            <div class="modal-footer"><button class="btn btn-admin">Save</button><button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Attach Services Modal -->
                                            <div class="modal fade" id="attachServicesModal{{ $pkg->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <form action="{{ route('admin.packages.attachServices', $pkg->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header"><h5 class="modal-title">Package Services - {{ $pkg->name }}</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                                            <div class="modal-body">
                                                                <p class="small text-muted">Total package duration: <strong id="pkgDurationDisplay{{ $pkg->id }}">{{ $pkgDuration }} hr{{ $pkgDuration>1 ? 's' : '' }}</strong></p>
                                                                <div class="row" id="pkgServicesContainer{{ $pkg->id }}">
                                                                    @foreach($allServicesForPackage as $s)
                                                                        @php
                                                                            $inPkg = $pkg->services->contains($s->id);
                                                                            $pivotQty = optional($pkg->services->firstWhere('id',$s->id))->pivot->quantity ?? 1;
                                                                            // prefer pivot.duration (package-level) falling back to branch pivot or global service duration
                                                                            $svcDur = $s->pivot->duration ?? (
                                                                                // check branch_service table for branch-specific duration if available
                                                                                Illuminate\Support\Facades\DB::table('branch_service')->where('service_id',$s->id)->where('branch_id',$branchId)->value('duration') ?? $s->duration ?? 1
                                                                            );
                                                                        @endphp
                                                                        <div class="mb-2 col-12 d-flex align-items-center">
                                                                            <input class="form-check-input me-2 pkg-svc-checkbox" type="checkbox" data-pkgid="{{ $pkg->id }}" data-duration="{{ $svcDur }}" name="service_ids[]" value="{{ $s->id }}" id="pkgsvc{{ $pkg->id }}_{{ $s->id }}" {{ $inPkg ? 'checked' : '' }}>
                                                                            <label for="pkgsvc{{ $pkg->id }}_{{ $s->id }}" class="me-3">{{ $s->name }} <small class="text-muted">({{ $s->category }})</small></label>
                                                                            <input type="number" name="quantities[{{ $s->id }}]" class="form-control form-control-sm ms-auto pkg-svc-qty" data-pkgid="{{ $pkg->id }}" data-duration="{{ $svcDur }}" style="width:120px;" min="1" value="{{ $inPkg ? $pivotQty : 1 }}">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer"><button class="btn btn-admin">Save</button><button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <script>
                                                (function(){
                                                    var pkgId = {{ $pkg->id }};
                                                    var container = document.getElementById('pkgServicesContainer'+pkgId);
                                                    var display = document.getElementById('pkgDurationDisplay'+pkgId);
                                                    if(!container || !display) return;
                                                    function recompute(){
                                                        var total = 0;
                                                        var checks = container.querySelectorAll('.pkg-svc-checkbox');
                                                        checks.forEach(function(ch){
                                                            if(ch.checked){
                                                                var dur = Number(ch.getAttribute('data-duration')||1) || 1;
                                                                var id = ch.value;
                                                                var qtyEl = container.querySelector('.pkg-svc-qty[name="quantities['+id+']"]');
                                                                var qty = qtyEl ? (Number(qtyEl.value)||1) : 1;
                                                                total += dur * qty;
                                                            }
                                                        });
                                                        display.textContent = total + ' hr' + (total>1?'s':'');
                                                    }
                                                    container.addEventListener('change', function(e){ if(e.target.classList.contains('pkg-svc-checkbox') || e.target.classList.contains('pkg-svc-qty')) recompute(); });
                                                    recompute();
                                                })();
                                            </script>

                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create Package Modal -->
                <div class="modal fade" id="createPackageModal{{ $branch->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('admin.packages.store', $branch->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header"><h5 class="modal-title">Create Package</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">
                                    <div class="mb-3"><label>Name</label><input class="form-control" name="name" required></div>
                                    <div class="mb-3"><label>Price</label><input class="form-control" name="price" type="number" step="0.01" required></div>
                                    <div class="mb-3"><label>Description</label><textarea class="form-control" name="description"></textarea></div>
                                    <div class="mb-3"><label>Include Services</label>
                                                                    @foreach($allServicesForPackage as $s)
                                                                        @php $svcDur = Illuminate\Support\Facades\DB::table('branch_service')->where('branch_id', $branchId)->where('service_id', $s->id)->value('duration') ?? $s->duration ?? 1; @endphp
                                                                        <div class="form-check"><input class="form-check-input" type="checkbox" data-duration="{{ $svcDur }}" name="service_ids[]" value="{{ $s->id }}" id="newpkgsvc{{ $branch->id }}_{{ $s->id }}"><label class="form-check-label" for="newpkgsvc{{ $branch->id }}_{{ $s->id }}">{{ $s->name }}</label></div>
                                                                    @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer"><button class="btn btn-admin">Create</button><button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></div>
                            </div>
                        </form>
                    </div>
                </div>

                    <!-- Manage Categories Modal -->
                    <div class="modal fade" id="manageCategoriesModal{{ $branch->id }}" tabindex="-1" aria-labelledby="manageCategoriesModalLabel{{ $branch->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Manage Categories</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small text-muted">Deleting a category will remove it from all services. This action is reversible only by reassigning categories manually.</p>
                                    <form action="{{ route('admin.deleteCategory') }}" method="POST" onsubmit="return confirm('Remove this category from all services?');">
                                        @csrf
                                        <div class="mb-3">
                                            <label>Select category to delete</label>
                                            <select name="category" class="form-select">
                                                <option value="">-- Select --</option>
                                                @foreach(App\Models\Service::pluck('category')->unique()->filter()->values() as $cat)
                                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-0 text-end">
                                            <button type="submit" class="btn btn-danger">Delete Category</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Floating Delete Confirmation Modal (reusable) -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmDeleteMessage">Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <form id="confirmDeleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/branchmanagement.js') }}?v={{ time() }}"></script>

    <script>
        (function(){
            function onDeleteClick(e){
                var btn = e.currentTarget;
                var action = btn.getAttribute('data-action');
                var name = btn.getAttribute('data-name') || 'this item';
                var form = document.getElementById('confirmDeleteForm');
                var msg = document.getElementById('confirmDeleteMessage');
                if(!form || !msg) return;
                form.setAttribute('action', action);
                msg.textContent = 'Are you sure you want to delete "' + name + '"? This action cannot be undone.';
                var modalEl = document.getElementById('confirmDeleteModal');
                var modal = new bootstrap.Modal(modalEl, {});
                modal.show();
            }

            document.addEventListener('DOMContentLoaded', function(){
                var dels = document.querySelectorAll('.btn-delete-service');
                dels.forEach(function(d){ d.addEventListener('click', onDeleteClick); });
            });
        })();
    </script>

</div>
@endsection
