@extends('layouts.ceoapp')
@section('usermanage')
<title>CEO User Management - Skin911</title>
<div class="container ceo-mgmt-card">
    <div class="ceo-mgmt-title">CEO User Management</div>
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

    <div class="filter-form mb-4 d-flex align-items-center" style="gap: 1rem;">
        <form method="GET" action="" class="d-flex align-items-center w-100" style="gap: 1rem;">
            <label for="branch_id" style="font-weight:600;color:#e75480;">Filter by Branch:</label>
            <select name="branch_id" id="branch_id" class="form-control" style="max-width:300px;">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ (isset($branchId) && $branchId == $branch->id) ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-ceo">Filter</button>
        </form>
    </div>

    <button type="button" class="mb-3 btn btn-ceo" data-bs-toggle="modal" data-bs-target="#createAdminModal">Create Admin</button>

    <!-- Desktop Table View -->
    <div class="table-responsive">
        <table class="table table-user">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Branch</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->branch_id ? $branches->where('id', $user->branch_id)->first()?->name : '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal{{ $user->id }}">Change Password</button>
                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $user->id }}">Reset Password</button>
                        <form action="{{ route('ceo.deleteAdmin', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#staffTable{{ $user->id }}" aria-expanded="false" aria-controls="staffTable{{ $user->id }}">View Staff</button>
                    </td>
                </tr>
                <tr class="collapse" id="staffTable{{ $user->id }}">
                    <td colspan="4">
                        <div class="card card-body" style="background:#ffe4ec;">
                            <strong style="color:#e75480;">Staff under this admin ({{ $user->branch_id ? $branches->where('id', $user->branch_id)->first()?->name : '-' }}):</strong>
                            <table class="table table-sm">
                                <thead>
                                    <tr style="color:#e75480;">
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staffByBranch[$user->branch_id] ?? [] as $staff)
                                    <tr>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#staffInfoModal{{ $staff->id }}" style="color:#e75480;text-decoration:underline;">{{ $staff->name }}</a>
                                        </td>
                                        <td>{{ $staff->email }}</td>
                                        <td>{{ $staff->role }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#staffInfoModal{{ $staff->id }}">View Info</button>
                                        </td>
                                    </tr>
                                    <!-- Staff Info Modal -->
                                    <div class="modal fade" id="staffInfoModal{{ $staff->id }}" tabindex="-1" aria-labelledby="staffInfoModalLabel{{ $staff->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:#ffe4ec;">
                                                    <h5 class="modal-title" id="staffInfoModalLabel{{ $staff->id }}" style="color:#e75480;">Staff Information</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="color:#e75480;">
                                                    <strong>Name:</strong> {{ $staff->name }}<br>
                                                    <strong>Email:</strong> {{ $staff->email }}<br>
                                                    <strong>Role:</strong> {{ $staff->role }}<br>
                                                    <strong>Branch:</strong> {{ $staff->branch_id ? $branches->where('id', $staff->branch_id)->first()?->name : '-' }}<br>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('ceo.updateAdmin', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Role</label>
                                        <select name="role" class="form-control">
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Branch</label>
                                        <select name="branch_id" class="form-control">
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-ceo">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Change Password Modal -->
                <div class="modal fade" id="changePasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="changePasswordModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('ceo.adminChangePassword', $user->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel{{ $user->id }}">Change Password for {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>New Password</label>
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Confirm New Password</label>
                                        <input type="password" name="new_password_confirmation" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-ceo">Change Password</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Reset Password Modal -->
                <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('ceo.resetAdminPassword', $user->id) }}" method="POST">
                            @csrf
                            <div class="modal-content" style="background:#fff;border-radius:12px;">
                                <div class="modal-header" style="background:#ffe4ec;">
                                    <h5 class="modal-title" id="resetPasswordModalLabel{{ $user->id }}" style="color:#e75480;">Reset Password for {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="color:#e75480;">
                                    Are you sure you want to reset this admin's password?<br>
                                    <small style="color:#d13c6a;">This will set a new password based on their branch assignment.</small>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-ceo">Yes, Reset</button>
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

    <!-- Mobile/Tablet Card View -->
    <div class="mobile-user-cards">
        @if(count($users) > 0)
            @foreach($users as $user)
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <h5 class="user-name">{{ $user->name }}</h5>
                        <p class="user-email">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="user-details">
                    <div class="user-detail-row">
                        <span class="user-detail-label">Branch:</span>
                        <span class="user-detail-value">{{ $user->branch_id ? $branches->where('id', $user->branch_id)->first()?->name : 'Not Assigned' }}</span>
                    </div>
                    <div class="user-detail-row">
                        <span class="user-detail-label">Role:</span>
                        <span class="user-detail-value">Administrator</span>
                    </div>
                </div>

                <div class="user-actions">
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal{{ $user->id }}">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $user->id }}">
                        <i class="fas fa-undo"></i> Reset Password
                    </button>
                    <form action="{{ route('ceo.deleteAdmin', $user->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this admin?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>

                <!-- Staff Toggle Button -->
                <button class="staff-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#staffSection{{ $user->id }}" aria-expanded="false" aria-controls="staffSection{{ $user->id }}">
                    <i class="fas fa-users"></i> View Staff ({{ count($staffByBranch[$user->branch_id] ?? []) }})
                    <i class="fas fa-chevron-down"></i>
                </button>

                <!-- Collapsible Staff Section -->
                <div class="collapse" id="staffSection{{ $user->id }}">
                    <div class="staff-section">
                        <h6><i class="fas fa-users"></i> Staff under {{ $user->branch_id ? $branches->where('id', $user->branch_id)->first()?->name : 'this admin' }}</h6>
                        @if(count($staffByBranch[$user->branch_id] ?? []) > 0)
                            @foreach($staffByBranch[$user->branch_id] ?? [] as $staff)
                            <div class="staff-card">
                                <div class="staff-name">{{ $staff->name }}</div>
                                <div class="staff-details">
                                    <strong>Email:</strong> {{ $staff->email }}<br>
                                    <strong>Role:</strong> {{ $staff->role }}<br>
                                    <strong>Branch:</strong> {{ $staff->branch_id ? $branches->where('id', $staff->branch_id)->first()?->name : '-' }}
                                </div>
                                <div class="staff-actions">
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staffInfoModal{{ $staff->id }}">
                                        <i class="fas fa-info-circle"></i> View Info
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <p>No staff assigned to this branch</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <div class="user-card" style="border: 2px dashed #e9ecef; background: #f8f9fa;">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No administrators found</h5>
                    <p class="text-muted">There are no administrators to display. Click "Create Admin" to add one.</p>
                    <button type="button" class="btn btn-ceo mt-3" data-bs-toggle="modal" data-bs-target="#createAdminModal">
                        <i class="fas fa-plus"></i> Create First Admin
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Create Admin Modal -->
<div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('ceo.createAdmin') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAdminModalLabel">Create Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Branch</label>
                        <select name="branch_id" class="form-control" required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-ceo">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
