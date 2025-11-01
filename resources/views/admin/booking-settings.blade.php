@extends('layouts.adminapp')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="border: 2px solid #F56289; border-radius: 15px; box-shadow: 0 8px 25px rgba(245,98,137,0.15);">
                <div class="card-header" style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); border-radius: 13px 13px 0 0;">
                    <h3 class="mb-0 text-white">
                        <i class="fas fa-cog me-2"></i>Booking Settings
                    </h3>
                    <p class="mb-0 text-white opacity-75">
                        Configure booking rules and restrictions
                        @if($branch)
                            for {{ $branch->name }}
                        @endif
                    </p>
                </div>

                <div class="card-body p-4">
                    @if($branch)
                        <div class="alert alert-info mb-4" style="background: #e3f2fd; border: 1px solid #90caf9; border-radius: 8px;">
                            <h6 class="fw-bold mb-2" style="color: #1976d2;">
                                <i class="fas fa-building me-2"></i>Branch Information
                            </h6>
                            <p class="mb-0" style="color: #1565c0;">
                                <strong>{{ $branch->name }}</strong><br>
                                {{ $branch->address }}
                            </p>
                        </div>
                    @endif

                    <form id="bookingSettingsForm">
                        @csrf

                        <!-- Minimum Advance Days -->
                        <div class="mb-4">
                            <label for="minimum_advance_days" class="form-label fw-bold" style="color: #F56289;">
                                <i class="fas fa-calendar-plus me-2"></i>Minimum Advance Days
                            </label>
                            <input type="number"
                                   class="form-control form-control-lg"
                                   id="minimum_advance_days"
                                   name="minimum_advance_days"
                                   value="{{ $currentSettings['minimum_advance_days'] }}"
                                   min="0"
                                   max="30"
                                   style="border: 2px solid #ffe4ec; border-radius: 8px;">
                            <div class="form-text">
                                Number of days in advance clients must book (0 = same day allowed)
                            </div>
                        </div>

                        <!-- Maximum Advance Days -->
                        <div class="mb-4">
                            <label for="maximum_advance_days" class="form-label fw-bold" style="color: #F56289;">
                                <i class="fas fa-calendar-times me-2"></i>Maximum Advance Days
                            </label>
                            <input type="number"
                                   class="form-control form-control-lg"
                                   id="maximum_advance_days"
                                   name="maximum_advance_days"
                                   value="{{ $currentSettings['maximum_advance_days'] }}"
                                   min="1"
                                   max="365"
                                   style="border: 2px solid #ffe4ec; border-radius: 8px;">
                            <div class="form-text">
                                Maximum days in advance clients can book (prevents far-future bookings)
                            </div>
                        </div>

                        <!-- Default Slot Capacity -->
                        <div class="mb-4">
                            <label for="default_slot_capacity" class="form-label fw-bold" style="color: #F56289;">
                                <i class="fas fa-users me-2"></i>Default Slot Capacity
                            </label>
                            <input type="number"
                                   class="form-control form-control-lg"
                                   id="default_slot_capacity"
                                   name="default_slot_capacity"
                                   value="{{ $currentSettings['default_slot_capacity'] }}"
                                   min="1"
                                   max="50"
                                   style="border: 2px solid #ffe4ec; border-radius: 8px;">
                            <div class="form-text">
                                Default number of concurrent bookings per time slot
                            </div>
                        </div>

                        <!-- Staff Override -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="allow_staff_override"
                                       name="allow_staff_override"
                                       value="1"
                                       {{ $currentSettings['allow_staff_override'] ? 'checked' : '' }}
                                       style="transform: scale(1.5);">
                                <label class="form-check-label fw-bold ms-2" for="allow_staff_override" style="color: #F56289;">
                                    <i class="fas fa-user-shield me-2"></i>Allow Staff Override
                                </label>
                            </div>
                            <div class="form-text">
                                Staff can bypass booking restrictions when creating appointments
                            </div>
                        </div>

                        <!-- Current Status -->
                        <div class="alert alert-success" style="background: #e8f5e8; border: 1px solid #4caf50; border-radius: 8px;">
                            <h6 class="fw-bold mb-2" style="color: #2e7d32;">
                                <i class="fas fa-info-circle me-2"></i>Current Status
                            </h6>
                            <ul class="mb-0" style="color: #1b5e20;">
                                <li>Clients must book <strong>{{ $currentSettings['minimum_advance_days'] }} days</strong> in advance</li>
                                <li>Maximum booking window: <strong>{{ $currentSettings['maximum_advance_days'] }} days</strong></li>
                                <li>Default capacity: <strong>{{ $currentSettings['default_slot_capacity'] }} bookings</strong> per slot</li>
                                <li>Staff override: <strong>{{ $currentSettings['allow_staff_override'] ? 'Enabled' : 'Disabled' }}</strong></li>
                            </ul>
                        </div>

                        <!-- Save Button -->
                        <div class="text-center">
                            <button type="submit"
                                    class="btn btn-lg px-5"
                                    style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%);
                                           border: none; border-radius: 25px; color: white; font-weight: 600;">
                                <i class="fas fa-save me-2"></i>Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('bookingSettingsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

    const formData = new FormData(this);

    fetch('{{ route("admin.booking-settings.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 3000);

            // Refresh page to show updated settings
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to save settings');
        }
    })
    .catch(error => {
        // Show error message
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alert.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>${error.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);

        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
@endsection
