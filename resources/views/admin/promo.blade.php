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
                    <th>Title</th>
                    <th>Branch</th>
                    <th>Services</th>
                    <th>Discount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promos as $promo)
                <tr>
                    <td>{{ $promo->code }}</td>
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
                            <form action="{{ route('admin.promos.delete', $promo->id) }}" method="POST" class="m-0" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" style="min-width:96px">Delete</button>
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
        <form action="{{ route('admin.promos.store') }}" method="POST">
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
                        <label>Discount (%)</label>
                        <input type="number" step="0.01" name="discount" class="form-control" required>
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
        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
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
                        <label>Discount (%)</label>
                        <input type="number" step="0.01" name="discount" class="form-control" value="{{ $promo->discount }}" required>
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
