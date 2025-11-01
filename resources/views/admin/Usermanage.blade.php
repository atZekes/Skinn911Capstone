@extends('layouts.adminapp')

@section('styles')
    <link href="{{ asset('css/admin/usermanage.css') }}?v={{ time() }}" rel="stylesheet">
@endsection

@push('head')
    <!-- Session data for JavaScript -->
    @if(session('temp_password_for'))
        <meta name="temp-password-for" content="{{ session('temp_password_for') }}">
    @endif
    @if(session('temp_password'))
        <meta name="temp-password" content="{{ session('temp_password') }}">
    @endif
@endpush

<style>
    .user-mgmt-title {
    color: #e75480 !important;
    font-weight: 700 !important;
    font-size: 2.5rem !important;
    margin-bottom: 24px;
    text-align: center;
    text-shadow: 0 2px 4px rgba(231, 84, 128, 0.2);
}

/* Additional specificity */
.container .user-mgmt-title,
div.user-mgmt-title {
    color: #e75480 !important;
    font-size: 2.5rem !important;
    font-weight: 700 !important;
}
</style>

@section('content')
<div class="container user-mgmt-card">
    <div class="user-mgmt-title">Staff Management</div>
    <button class="mb-3 btn btn-admin" data-bs-toggle="modal" data-bs-target="#createStaffModal">Create Staff</button>
    <div class="table-responsive">
        <table class="table table-user">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users->where('role', 'staff') as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(isset($user->active))
                            @if($user->active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">Unknown</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex-wrap gap-2 d-flex align-items-center">
                            {{-- status badge removed from Actions to avoid duplication; see Status column --}}
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#confirmResetModal{{ $user->id }}">Reset</button>
                            <form action="{{ route('admin.toggleStaffActive', $user->id) }}" method="POST" style="display:inline-block;" class="toggle-active-form">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-warning">
                                    {{ isset($user->active) && $user->active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#viewTempModal{{ $user->id }}" style="position:relative;">
                                View Temp
                                @if(session('temp_password_for') == $user->id)
                                    <span class="temp-indicator" aria-hidden="true" style="position:absolute; top:-3px; right:-3px; width:14px; height:14px; background:#dc3545; border-radius:50%; box-shadow:0 0 0 3px rgba(220,53,69,0.15); display:inline-block;"></span>
                                @endif
                            </button>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#changePasswordModal{{ $user->id }}">Change</button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $user->id }}">Delete</button>
                        </div>
                    </td>
                </tr>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="#" method="POST">
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
                                            <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    {{-- <div class="mb-3">
                                        <label>Access Level</label>
                                        <input type="number" name="access_level" class="form-control" value="{{ $user->access_level ?? '' }}" min="1" max="10">
                                    </div> --}}
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

                @if(session('reset_link'))
                    <div class="container mt-3">
                        <div class="alert alert-success">
                            Password reset link: <a href="{{ session('reset_link') }}" target="_blank">Open reset link</a>
                            <p class="small">Copy or send this link to the staff securely. It expires when used.</p>
                        </div>
                    </div>
                @endif

                {{-- Temporary password is shown only when admin clicks the "View Temp Password" button. --}}

                @foreach($users->where('role', 'staff') as $user)
                <!-- Confirm Reset Modal -->
                <div class="modal fade" id="confirmResetModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmResetModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.resetStaffPassword', $user->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmResetModalLabel{{ $user->id }}">Confirm Reset Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to generate a password reset link for <strong>{{ $user->name }}</strong>? This link should be shared securely with the staff.
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Generate temporary password</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach

                @foreach($users->where('role', 'staff') as $user)
                <!-- View Temp Password Modal -->
                <div class="modal fade" id="viewTempModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewTempModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Temporary Password for {{ $user->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p id="tempPasswordDisplay{{ $user->id }}">No temporary password generated for this user.</p>
                                {{-- access_level input removed per request --}}
                                <button class="btn btn-sm btn-outline-secondary" id="copyTempBtn{{ $user->id }}" style="display:none;">Copy</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                        @foreach($users->where('role', 'staff') as $user)
                        <!-- Confirm Delete Modal -->
                        <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.deleteStaff', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel{{ $user->id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to permanently delete the account for <strong>{{ $user->name }}</strong>? This action cannot be undone.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Delete</button>
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
</div>

    @foreach($users->where('role', 'staff') as $user)
    <!-- Change Password Modal for staff -->
    <div class="modal fade" id="changePasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="changePasswordModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.changeStaffPassword', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel{{ $user->id }}">Change Password for {{ $user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-admin">Change Password</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach
<!-- Create Staff Modal -->
<div class="modal fade" id="createStaffModal" tabindex="-1" aria-labelledby="createStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.createStaff') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStaffModalLabel">Create Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                    {{-- <div class="mb-3">
                        <label>Access Level</label>
                        <input type="number" name="access_level" class="form-control" min="1" max="10">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-admin">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/usermanage.js') }}"></script>
@endpush
