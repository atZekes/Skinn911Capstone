@extends('layouts.adminapp')
@section('head')
<style>
    .promo-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(231,84,128,0.10);
        padding: 32px 28px;
        margin-top: 32px;
    }
    .promo-title {
        color: #e75480;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 24px;
        text-align: center;
    }
    .btn-admin {
        background: #e75480;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
    }
    .btn-admin:hover {
        background: #d13c6a;
    }
    .table-promo th {
        background: #ffe4ec;
        color: #e75480;
        font-weight: 600;
        border: none;
    }
    .table-promo td {
        border: none;
        vertical-align: middle;
    }
</style>
@endsection
@section('content')
<div class="container promo-card">
    <div class="promo-title">Promo Management</div>
    <button class="mb-3 btn btn-admin" data-bs-toggle="modal" data-bs-target="#createPromoModal">Add New Promo</button>

    {{-- Flash messages --}}
    @if(session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mt-2">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-promo">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Branch</th>
                    <th>Services</th>
                    <th>Discount</th>
                    <th>Quantity</th>
                    <th>Claims</th>
                    <th>Expiration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promos as $promo)
                <tr>
                    <td>{{ $promo->code }}</td>
                    <td>
                        @if($promo->image)
                            <img src="{{ asset($promo->image) }}" alt="Promo Image" style="max-width: 50px; max-height: 50px; object-fit: cover;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>{{ $promo->title }}</td>
                    <td>{{ $promo->branch ? $promo->branch->name : 'Global' }}</td>
                    <td>
                        @if($promo->services && $promo->services->count())
                            <button class="btn btn-sm btn-link p-0" data-bs-toggle="modal" data-bs-target="#promoServicesModal{{ $promo->id }}">
                                {{ $promo->services->count() }} service{{ $promo->services->count() > 1 ? 's' : '' }}
                            </button>
                        @elseif($promo->category)
                            <span>Category: {{ $promo->category }}</span>
                        @else
                            <span>All services</span>
                        @endif
                    </td>
                    <td>{{ $promo->discount }}%</td>
                    <td>
                        @if($promo->quantity_available === null)
                            <span class="text-success">Unlimited</span>
                        @elseif($promo->quantity_available === 0)
                            <span class="text-danger">No availability</span>
                        @else
                            <span>{{ $promo->remaining_quantity ?? 0 }} / {{ $promo->quantity_available }}</span>
                        @endif
                        <br><small class="text-muted">Max per user: {{ $promo->max_claims_per_user }}</small>
                    </td>
                    <td>{{ $promo->total_claims }}
                        @if($promo->total_claims > 0)
                            <i class="fas fa-users text-info" title="{{ $promo->total_claims }} client(s) have claimed this promo"></i>
                        @endif
                    </td>
                    <td>
                        @if($promo->end_date)
                            @if($promo->is_expired)
                                <span class="badge bg-danger">{{ $promo->end_date->format('M d, Y') }}<br><small>Expired</small></span>
                            @elseif($promo->days_left <= 7)
                                <span class="badge bg-warning">{{ $promo->end_date->format('M d, Y') }}<br><small>{{ $promo->days_left }} days left</small></span>
                            @else
                                <span class="badge bg-info">{{ $promo->end_date->format('M d, Y') }}</span>
                            @endif
                        @else
                            <span class="text-muted">No expiry</span>
                        @endif
                    </td>
                    <td>
                        @if($promo->active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2 align-items-center" style="min-width:220px;">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editPromoModal{{ $promo->id }}" style="min-width:96px">Edit</button>
                            <form action="{{ route('admin.promos.toggle', $promo->id) }}" method="POST" class="m-0" style="display:inline-block">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-sm btn-warning" style="min-width:96px">{{ $promo->active ? 'Deactivate' : 'Activate' }}</button>
                            </form>
                            <form action="{{ route('admin.promos.delete', $promo->id) }}" method="POST" class="m-0 promo-delete-form" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                @php $claimCount = $promo->claims()->count(); @endphp
                                <button type="button" class="btn btn-sm {{ $claimCount > 0 ? 'btn-warning' : 'btn-danger' }} btn-delete-promo" style="min-width:96px"
                                        data-claims="{{ $claimCount }}" data-code="{{ $promo->code }}">
                                    Delete
                                </button>
                                <input type="hidden" name="_confirmed_delete" value="0" class="confirmed-delete-input">
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Create Promo Modal -->
<div class="modal fade" id="createPromoModal" tabindex="-1" aria-labelledby="createPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPromoModalLabel">Create Promo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Code</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image (optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Upload a promo image (JPEG, PNG, JPG, GIF, max 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label>Discount (%)</label>
                        <input type="number" step="0.01" name="discount" class="form-control" required min="0" max="100">
                        <small class="text-muted">Enter discount percentage (0-100%)</small>
                    </div>
                    <div class="mb-3">
                        <label>Quantity Available</label>
                        <input type="number" name="quantity_available" class="form-control" min="0" max="9999999" maxlength="7" value="{{ old('quantity_available', '') }}" placeholder="Leave empty for unlimited">
                        <small class="text-muted">How many times can this promo be claimed total? Leave empty for unlimited, enter 0 to hide from frontend</small>
                    </div>
                    <div class="mb-3">
                        <label>Max Claims Per User</label>
                        <input type="number" name="max_claims_per_user" class="form-control" min="1" value="1">
                        <small class="text-muted">How many times can each user claim this promo? (default: 1)</small>
                    </div>
                    <div class="mb-3">
                        <label>Apply to specific services (optional)</label>
                        <div style="max-height:160px; overflow:auto; border:1px solid #eee; padding:8px; border-radius:6px;">
                            @foreach($services as $service)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $service->id }}" id="create_service_{{ $service->id }}">
                                    <label class="form-check-label" for="create_service_{{ $service->id }}">{{ $service->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">If none selected, promo applies to all services (or by category).</small>
                    </div>
                    <div class="mb-3">
                        <label>Category (optional)</label>
                        <select name="category" class="form-select">
                            <option value="">-- Select category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">If you need a new category, create it by adding a service with that category first.</div>
                    </div>
                    <div class="mb-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-admin">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($promos as $promo)
<!-- Edit Promo Modal -->
<div class="modal fade" id="editPromoModal{{ $promo->id }}" tabindex="-1" aria-labelledby="editPromoModalLabel{{ $promo->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPromoModalLabel{{ $promo->id }}">Edit Promo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $promo->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{ $promo->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image (optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($promo->image)
                            <div class="mt-2">
                                <img src="{{ asset($promo->image) }}" alt="Current Image" style="max-width: 100px; max-height: 100px;">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        @endif
                        <small class="text-muted">Upload a promo image (JPEG, PNG, JPG, GIF, max 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label>Discount (%)</label>
                        <input type="number" step="0.01" name="discount" class="form-control" value="{{ $promo->discount }}" required min="0" max="100">
                        <small class="text-muted">Enter discount percentage (0-100%)</small>
                    </div>
                    <div class="mb-3">
                        <label>Quantity Available</label>
                        <input type="number" name="quantity_available" class="form-control" min="0" max="9999999" maxlength="7" value="{{ old('quantity_available', $promo->quantity_available ?? '') }}" placeholder="Leave empty for unlimited">
                        <small class="text-muted">How many times can this promo be claimed total? Leave empty for unlimited, enter 0 to hide from frontend</small>
                    </div>
                    <div class="mb-3">
                        <label>Max Claims Per User</label>
                        <input type="number" name="max_claims_per_user" class="form-control" min="1" value="{{ $promo->max_claims_per_user ?? 1 }}">
                        <small class="text-muted">How many times can each user claim this promo? (default: 1)</small>
                    </div>
                    <div class="mb-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $promo->start_date ? $promo->start_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="mb-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $promo->end_date ? $promo->end_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="mb-3">
                        <label>Apply to specific services (optional)</label>
                        <div style="max-height:160px; overflow:auto; border:1px solid #eee; padding:8px; border-radius:6px;">
                            @foreach($services as $service)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $service->id }}" id="edit_service_{{ $promo->id }}_{{ $service->id }}" {{ $promo->services->contains($service->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_service_{{ $promo->id }}_{{ $service->id }}">{{ $service->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">If none selected, promo applies to all services (or by category).</small>
                    </div>
                    <div class="mb-3">
                        <label>Category (optional)</label>
                        <select name="category" class="form-select">
                            <option value="">-- Select category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ (isset($promo) && $promo->category == $category) ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">If you need a new category, create it by adding a service with that category first.</div>
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
<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeletePromoModal" tabindex="-1" aria-labelledby="confirmDeletePromoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeletePromoModalLabel">Confirm Promo Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deletePromoMessage">Are you sure you want to delete this promo?</p>
                <div class="alert alert-warning" id="deletePromoWarning" style="display:none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePromoBtn">Yes, delete promo</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.btn-delete-promo');
    var confirmModalEl = document.getElementById('confirmDeletePromoModal');
    var confirmModal = new bootstrap.Modal(confirmModalEl);
    var confirmBtn = document.getElementById('confirmDeletePromoBtn');
    var deletePromoMessage = document.getElementById('deletePromoMessage');
    var deletePromoWarning = document.getElementById('deletePromoWarning');

    var pendingForm = null;

    deleteButtons.forEach(function(btn){
        btn.addEventListener('click', function(e){
            e.preventDefault();
            var claims = parseInt(btn.getAttribute('data-claims') || '0', 10);
            var code = btn.getAttribute('data-code') || '';
            // find the closest form
            pendingForm = btn.closest('form.promo-delete-form');

            if (!pendingForm) {
                console.error('Delete form not found');
                return;
            }

            // Set message
            deletePromoMessage.textContent = 'Delete promo "' + code + '"? This action cannot be undone.';
            if (claims > 0) {
                deletePromoWarning.style.display = '';
                deletePromoWarning.innerHTML = '<strong>Warning:</strong> ' + claims + ' client(s) have already claimed this promo. Deleting it will remove it from the system and may affect those users. Consider deactivating instead if you want to preserve historical data.';
            } else {
                deletePromoWarning.style.display = 'none';
                deletePromoWarning.innerHTML = '';
            }

            confirmModal.show();
        });
    });

    confirmBtn.addEventListener('click', function(){
        if (!pendingForm) return;
        // mark confirmed and submit
        var hidden = pendingForm.querySelector('.confirmed-delete-input');
        if (hidden) hidden.value = '1';
        pendingForm.submit();
    });
});
</script>
@endsection

@foreach($promos as $promo)
<!-- Promo Services Modal -->
<div class="modal fade" id="promoServicesModal{{ $promo->id }}" tabindex="-1" aria-labelledby="promoServicesModalLabel{{ $promo->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="promoServicesModalLabel{{ $promo->id }}">Services for Promo: {{ $promo->code }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($promo->services && $promo->services->count())
                    <ul class="list-group">
                        @foreach($promo->services as $svc)
                            <li class="list-group-item">
                                <div class="fw-bold">{{ $svc->name }}</div>
                                @if($svc->description)
                                    <div class="small text-muted">{{ $svc->description }}</div>
                                @endif
                                <div class="small text-muted">Price: {{ number_format($svc->price, 2) }}</div>
                            </li>
                        @endforeach
                    </ul>
                @elseif($promo->category)
                    <p>Promo applies to category: <strong>{{ $promo->category }}</strong></p>
                @else
                    <p>This promo applies to <strong>all services</strong>.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
// Discount validation - prevent values over 100%
document.addEventListener('DOMContentLoaded', function() {
    // Handle both create and edit modal discount inputs
    const discountInputs = document.querySelectorAll('input[name="discount"]');

    discountInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const value = parseFloat(this.value);
            if (value > 100) {
                this.value = 100;
                // Show a brief warning
                showDiscountWarning(this);
            } else if (value < 0) {
                this.value = 0;
            }
        });

        input.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (isNaN(value) || value < 0) {
                this.value = 0;
            } else if (value > 100) {
                this.value = 100;
            }
        });
    });

    function showDiscountWarning(input) {
        // Remove any existing warning
        const existingWarning = input.parentNode.querySelector('.discount-warning');
        if (existingWarning) {
            existingWarning.remove();
        }

        // Create and show warning
        const warning = document.createElement('div');
        warning.className = 'discount-warning text-danger small mt-1';
        warning.textContent = 'Maximum discount is 100%';
        warning.style.fontSize = '0.8rem';

        input.parentNode.appendChild(warning);

        // Remove warning after 3 seconds
        setTimeout(function() {
            if (warning.parentNode) {
                warning.remove();
            }
        }, 3000);
    }
});
</script>
@endsection
