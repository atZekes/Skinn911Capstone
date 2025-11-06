@extends('layouts.ceoapp')

@section('styles')
        <!-- Styles -->
    <link href="{{ asset('css/CEO/branchmanagement.css') }}" rel="stylesheet">
@endsection

@section('branch')
<!-- Loading Overlay -->
<div class="loading-overlay">
    <div class="spinner"></div>
</div>

<div class="container ceo-mgmt-card">
    <div class="ceo-mgmt-title">CEO Branch Management</div>

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


    <!-- Desktop/Tablet Table View -->
    <div class="branches-table fade-in">
        @if(isset($branches) && count($branches) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Branch Name</th>
                        <th>Address</th>
                        <th>Map</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add New Branch Row -->
                    <tr class="add-branch-row slide-up">
                        <td>
                            <button class="btn add-branch-btn-table" id="addBranchBtnTable">
                                <i class="fas fa-plus me-2"></i>Add New Branch
                            </button>
                        </td>
                        <td colspan="5" class="text-muted">
                            <em>Click to add a new branch location</em>
                        </td>
                    </tr>
                    @foreach($branches as $branch)
                    <tr data-branch-id="{{ $branch->id }}" class="slide-up">
                        <td><strong>#{{ $branch->id }}</strong></td>
                        <td class="branch-name">{{ $branch->name }}</td>
                        <td class="branch-address">{{ $branch->address ?? 'N/A' }}</td>
                        <td class="text-center">
                            @if($branch->map_src)
                                <button class="btn btn-sm btn-map"
                                        data-bs-toggle="modal"
                                        data-bs-target="#mapModal"
                                        data-map-src="{{ $branch->map_src }}"
                                        data-branch-name="{{ $branch->name }}"
                                        title="View Map">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $branch->active ? 'status-active' : 'status-inactive' }}">
                                {{ $branch->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="actions-cell">
                            <div class="btn-group-horizontal">
                                <button class="btn btn-action btn-edit"
                                        data-branch-id="{{ $branch->id }}"
                                        data-contact-number="{{ $branch->contact_number ?? '' }}"
                                        data-telephone-number="{{ $branch->telephone_number ?? '' }}"
                                        data-operating-days="{{ $branch->operating_days ?? '' }}">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                @if($branch->active)
                                    <button class="btn btn-action btn-disable"
                                            data-branch-id="{{ $branch->id }}"
                                            data-branch-name="{{ $branch->name }}">
                                        <i class="fas fa-ban me-1"></i>Disable
                                    </button>
                                @else
                                    <button class="btn btn-action btn-enable"
                                            data-branch-id="{{ $branch->id }}"
                                            data-branch-name="{{ $branch->name }}">
                                        <i class="fas fa-check me-1"></i>Enable
                                    </button>
                                @endif
                                <button class="btn btn-action btn-delete"
                                        data-branch-id="{{ $branch->id }}"
                                        data-branch-name="{{ $branch->name }}">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-building"></i>
            <h4>No Branches Found</h4>
            <p>Start by adding your first branch location to get started.</p>
            <button class="mt-3 btn btn-ceo" id="addBranchBtnEmpty">
                <i class="fas fa-plus me-2"></i>Add Your First Branch
            </button>
        </div>
        @endif
    </div>

    <!-- Mobile Card View (for very small screens only) -->
    <div class="mobile-branch-cards">
        @if(isset($branches) && count($branches) > 0)
            <!-- Add New Branch Card -->
            <div class="add-branch-card" id="addBranchCardMobile">
                <i class="fas fa-plus"></i>
                <h5>Add New Branch</h5>
                <p>Click to add a new branch location</p>
            </div>

            @foreach($branches as $branch)
            <div class="branch-card" data-branch-id="{{ $branch->id }}">
                <div class="branch-status-badge {{ $branch->active ? 'active' : 'inactive' }}">
                    {{ $branch->active ? 'Active' : 'Inactive' }}
                </div>

                <div class="branch-card-header">
                    <div class="branch-avatar">
                        {{ strtoupper(substr($branch->name, 0, 1)) }}
                    </div>
                    <div class="branch-info">
                        <h5 class="branch-name">{{ $branch->name }}</h5>
                        <p class="branch-id">Branch ID: #{{ $branch->id }}</p>
                    </div>
                </div>

                <div class="branch-details">
                    <div class="branch-detail-row">
                        <span class="branch-detail-label">Address:</span>
                        <span class="branch-detail-value branch-address">{{ $branch->address ?? 'Not specified' }}</span>
                    </div>
                    @if($branch->map_src)
                    <div class="branch-detail-row">
                        <span class="branch-detail-label">Location:</span>
                        <span class="branch-detail-value has-map">
                            <span>Map Available</span>
                            <button class="branch-map-btn btn-map"
                                    data-map-src="{{ $branch->map_src }}"
                                    data-branch-id="{{ $branch->id }}"
                                    data-branch-name="{{ $branch->name }}">
                                <i class="fas fa-map-marker-alt"></i> View Map
                            </button>
                        </span>
                    </div>
                    @endif
                </div>

                <div class="branch-actions">
                    <button class="btn btn-action btn-edit"
                            data-branch-id="{{ $branch->id }}"
                            data-contact-number="{{ $branch->contact_number ?? '' }}"
                            data-telephone-number="{{ $branch->telephone_number ?? '' }}"
                            data-operating-days="{{ $branch->operating_days ?? '' }}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    @if($branch->active)
                        <button class="btn btn-action btn-disable"
                                data-branch-id="{{ $branch->id }}"
                                data-branch-name="{{ $branch->name }}">
                            <i class="fas fa-ban"></i> Disable
                        </button>
                    @else
                        <button class="btn btn-action btn-enable"
                                data-branch-id="{{ $branch->id }}"
                                data-branch-name="{{ $branch->name }}">
                            <i class="fas fa-check"></i> Enable
                        </button>
                    @endif
                    <button class="btn btn-action btn-delete"
                            data-branch-id="{{ $branch->id }}"
                            data-branch-name="{{ $branch->name }}">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            @endforeach
        @else
            <!-- Mobile Empty State -->
            <div class="empty-state-card">
                <i class="fas fa-building"></i>
                <h5>No Branches Found</h5>
                <p>Start by adding your first branch location to get started.</p>
                <button class="btn btn-ceo" id="addBranchBtnEmptyMobile">
                    <i class="fas fa-plus"></i> Add Your First Branch
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Add Branch Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBranchModalLabel">
                    <i class="fas fa-plus me-2"></i>Add New Branch
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBranchForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Branch Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Map Source (Google Maps Embed URL)</label>
                        <input type="url" name="map_src" class="form-control" placeholder="https://www.google.com/maps/embed?...">
                        <small class="form-text text-muted">Paste the Google Maps embed URL here (optional)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Number (Mobile)</label>
                        <input type="text" 
                               name="contact_number" 
                               id="addContactNumber"
                               class="form-control" 
                               placeholder="09171234567"
                               pattern="09[0-9]{9}"
                               maxlength="11"
                               title="Must be 11 digits starting with 09">
                        <small class="form-text text-muted">Format: 09XXXXXXXXX (11 digits, optional)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telephone Number (Landline)</label>
                        <input type="text" 
                               name="telephone_number" 
                               id="addTelephoneNumber"
                               class="form-control" 
                               placeholder="1234567 or 12345678"
                               pattern="[0-9]{7,8}"
                               maxlength="8"
                               title="Must be 7-8 digits">
                        <small class="form-text text-muted">Format: 7-8 digits (optional)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Operating Days</label>
                        <div class="mt-2">
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp
                            @foreach($days as $day)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="operating_days[]"
                                           value="{{ $day }}"
                                           id="addOperatingDay{{ $day }}">
                                    <label class="form-check-label" for="addOperatingDay{{ $day }}">
                                        {{ $day }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted">Select the days when this branch operates</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="mt-2 form-check">
                            <input class="form-check-input" type="checkbox" name="active" id="addBranchActive" checked>
                            <label class="form-check-label" for="addBranchActive">
                                Active Branch
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-2"></i>Add Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBranchModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Branch
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBranchForm">
                <input type="hidden" id="editBranchId" name="branch_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Branch Name</label>
                        <input type="text" id="editBranchName" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea id="editBranchAddress" name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Map Source (Google Maps Embed URL)</label>
                        <input type="url" id="editBranchMapSrc" name="map_src" class="form-control" placeholder="https://www.google.com/maps/embed?...">
                        <small class="form-text text-muted">Paste the Google Maps embed URL here (optional)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Number (Mobile)</label>
                        <input type="text" 
                               id="editBranchContactNumber" 
                               name="contact_number" 
                               class="form-control" 
                               placeholder="09171234567"
                               pattern="09[0-9]{9}"
                               maxlength="11"
                               title="Must be 11 digits starting with 09">
                        <small class="form-text text-muted">Format: 09XXXXXXXXX (11 digits, optional)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telephone Number (Landline)</label>
                        <input type="text" 
                               id="editBranchTelephoneNumber" 
                               name="telephone_number" 
                               class="form-control" 
                               placeholder="1234567 or 12345678"
                               pattern="[0-9]{7,8}"
                               maxlength="8"
                               title="Must be 7-8 digits">
                        <small class="form-text text-muted">Format: 7-8 digits (optional)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Operating Days</label>
                        <div class="mt-2">
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp
                            @foreach($days as $day)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="operating_days[]"
                                           value="{{ $day }}"
                                           id="editOperatingDay{{ $day }}">
                                    <label class="form-check-label" for="editOperatingDay{{ $day }}">
                                        {{ $day }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted">Select the days when this branch operates</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="mt-2 form-check">
                            <input class="form-check-input" type="checkbox" name="active" id="editBranchActive">
                            <label class="form-check-label" for="editBranchActive">
                                Active Branch
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-2"></i>Update Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">
                    <i class="fas fa-map-marker-alt me-2"></i>Branch Location
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-0 modal-body">
                <div id="mapContainer" style="height: 500px;">
                    <iframe id="mapFrame"
                            width="100%"
                            height="500"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Philippine phone number validation
        document.addEventListener('DOMContentLoaded', function() {
            // Add phone number validation for ADD form
            const addContactNumber = document.getElementById('addContactNumber');
            const addTelephoneNumber = document.getElementById('addTelephoneNumber');
            
            // Add phone number validation for EDIT form
            const editContactNumber = document.getElementById('editBranchContactNumber');
            const editTelephoneNumber = document.getElementById('editBranchTelephoneNumber');
            
            // Function to restrict input to numbers only
            function numbersOnly(event) {
                const input = event.target;
                input.value = input.value.replace(/[^0-9]/g, '');
            }
            
            // Function to validate mobile number (09XXXXXXXXX)
            function validateMobile(event) {
                const input = event.target;
                // Remove non-digits
                input.value = input.value.replace(/[^0-9]/g, '');
                
                // Enforce 11 digit limit
                if (input.value.length > 11) {
                    input.value = input.value.substring(0, 11);
                }
                
                // Validate format on blur
                if (event.type === 'blur' && input.value.length > 0) {
                    if (!input.value.match(/^09[0-9]{9}$/)) {
                        input.setCustomValidity('Mobile number must be 11 digits starting with 09');
                        input.classList.add('is-invalid');
                    } else {
                        input.setCustomValidity('');
                        input.classList.remove('is-invalid');
                    }
                }
            }
            
            // Function to validate telephone number (7-8 digits)
            function validateTelephone(event) {
                const input = event.target;
                // Remove non-digits
                input.value = input.value.replace(/[^0-9]/g, '');
                
                // Enforce 8 digit limit
                if (input.value.length > 8) {
                    input.value = input.value.substring(0, 8);
                }
                
                // Validate format on blur
                if (event.type === 'blur' && input.value.length > 0) {
                    if (!input.value.match(/^[0-9]{7,8}$/)) {
                        input.setCustomValidity('Telephone number must be 7-8 digits');
                        input.classList.add('is-invalid');
                    } else {
                        input.setCustomValidity('');
                        input.classList.remove('is-invalid');
                    }
                }
            }
            
            // Attach listeners to ADD form fields
            if (addContactNumber) {
                addContactNumber.addEventListener('input', validateMobile);
                addContactNumber.addEventListener('blur', validateMobile);
                addContactNumber.addEventListener('focus', function() {
                    this.classList.remove('is-invalid');
                });
            }
            
            if (addTelephoneNumber) {
                addTelephoneNumber.addEventListener('input', validateTelephone);
                addTelephoneNumber.addEventListener('blur', validateTelephone);
                addTelephoneNumber.addEventListener('focus', function() {
                    this.classList.remove('is-invalid');
                });
            }
            
            // Attach listeners to EDIT form fields
            if (editContactNumber) {
                editContactNumber.addEventListener('input', validateMobile);
                editContactNumber.addEventListener('blur', validateMobile);
                editContactNumber.addEventListener('focus', function() {
                    this.classList.remove('is-invalid');
                });
            }
            
            if (editTelephoneNumber) {
                editTelephoneNumber.addEventListener('input', validateTelephone);
                editTelephoneNumber.addEventListener('blur', validateTelephone);
                editTelephoneNumber.addEventListener('focus', function() {
                    this.classList.remove('is-invalid');
                });
            }
        });
    </script>
    <script src="{{ asset('js/CEO/branchmanagement_basic.js') }}"></script>
@endsection
