@extends('layouts.clientapp')

@section('content')
@php
    // Ensure $user is an object to avoid template errors
    if (! isset($user) || ! is_object($user)) {
        $user = (object)[];
    }
@endphp
<div class="container" style="margin-top:120px; max-width:820px;">
    <h2>Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('client.profile.update') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name">Full name</label>
            <input id="name" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}">
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email">Email address</label>
            <input id="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Mobile phone -->
        <div class="mb-3">
            <label for="mobile_phone">Mobile phone</label>
            <input id="mobile_phone" name="mobile_phone" class="form-control" value="{{ old('mobile_phone', $user->mobile_phone ?? '') }}">
            @error('mobile_phone') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Telephone -->
        <div class="mb-3">
            <label for="telephone">Telephone</label>
            <input id="telephone" name="telephone" class="form-control" value="{{ old('telephone', $user->telephone ?? '') }}">
            @error('telephone') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address">Address</label>
            <textarea id="address" name="address" class="form-control">{{ old('address', $user->address ?? '') }}</textarea>
            @error('address') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Birthday -->
        <div class="mb-3">
            <label for="birthday">Birthday</label>
            <input id="birthday" name="birthday" type="date" class="form-control" value="{{ old('birthday', optional($user->birthday)->format('Y-m-d') ?? '') }}">
            @error('birthday') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Service Preferences -->
        <div class="mb-4">
            <label class="form-label fw-bold d-flex align-items-center mb-3" style="font-size: 1.1rem; color: #333;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill me-2" viewBox="0 0 16 16" style="color: #ff69b4;">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
                Service Preferences
            </label>
            <div class="text-muted mb-3" style="font-size: 0.95rem;">
                <i class="bi bi-info-circle me-1"></i>
                Select the types of services you're interested in to personalize your experience
            </div>
            @php
                $userPreferences = old('preferences', $user->preferences ?? []);
                if (is_string($userPreferences)) {
                    $userPreferences = json_decode($userPreferences, true) ?? [];
                }
                $availablePreferences = [
                    'Facial' => 'bi-emoji-smile',
                    'Laser' => 'bi-lightning-charge',
                    'Slimming' => 'bi-heart-pulse',
                    'Immuno' => 'bi-shield-check',
                    'Hair Removal' => 'bi-scissors'
                ];
            @endphp
            <div class="preference-grid">
                @foreach($availablePreferences as $preference => $icon)
                    <div class="preference-item">
                        <input
                            class="preference-checkbox"
                            type="checkbox"
                            name="preferences[]"
                            value="{{ $preference }}"
                            id="preference_{{ Str::slug($preference) }}"
                            {{ in_array($preference, $userPreferences) ? 'checked' : '' }}
                        >
                        <label class="preference-label" for="preference_{{ Str::slug($preference) }}">
                            <div class="preference-content">
                                <i class="bi {{ $icon }} preference-icon"></i>
                                <span class="preference-text">{{ $preference }}</span>
                                <i class="bi bi-check-circle-fill preference-check"></i>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
            @error('preferences') <div class="text-danger mt-2">{{ $message }}</div> @enderror
        </div>

        <!-- Security Settings Section -->
        <div class="mb-4 mt-5">
            <h5 class="mb-3" style="color: #333; font-weight: 600;">
                <i class="fas fa-shield-alt" style="color: #ff69b4;"></i> Security Settings
            </h5>
            <div class="security-card">
                <div class="security-header">
                    <div class="d-flex align-items-center">
                        <div class="security-icon-wrapper">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1" style="font-weight: 600; color: #333;">Two-Factor Authentication</h6>
                            <p class="mb-0 text-muted" style="font-size: 0.9rem;">Add an extra layer of security to your account</p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        @if(Auth::user()->google2fa_enabled)
                            <span class="status-badge status-enabled">
                                <i class="fas fa-check-circle"></i> Enabled
                            </span>
                        @else
                            <span class="status-badge status-disabled">
                                <i class="fas fa-times-circle"></i> Disabled
                            </span>
                        @endif
                    </div>
                </div>
                <div class="security-body">
                    <p class="text-muted mb-3" style="font-size: 0.95rem;">
                        Protect your account with time-based one-time passwords (TOTP) using Google Authenticator app.
                        When enabled, you'll need to enter a 6-digit code from your phone each time you sign in.
                    </p>
                    <a href="{{ route('two-factor.setup') }}" class="btn-security">
                        <i class="fas fa-cog me-2"></i>
                        @if(Auth::user()->google2fa_enabled)
                            Manage Two-Factor Authentication
                        @else
                            Setup Two-Factor Authentication
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <button class="btn btn-pink" type="submit">Save</button>
    </form>
</div>

<script>
// Double-submit prevention for profile edit form
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[method="POST"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && submitBtn.disabled) {
                e.preventDefault();
                return false;
            }
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
                // Re-enable after 3 seconds as fallback
                setTimeout(function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 3000);
            }
        });
    }
});
</script>

<style>
/* Modern preference cards design */
.preference-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
    margin-top: 10px;
}

.preference-item {
    position: relative;
}

.preference-checkbox {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.preference-label {
    display: block;
    cursor: pointer;
    margin: 0;
    position: relative;
    user-select: none;
}

.preference-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px 15px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 2px solid #e0e0e0;
    border-radius: 80px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 1px;
    position: relative;
    overflow: hidden;
}

.preference-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 105, 180, 0.1) 0%, rgba(255, 192, 203, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 0;
}

.preference-icon {
    font-size: 2rem;
    color: #6c757d;
    margin-bottom: 10px;
    transition: all 0.3s ease;
    z-index: 1;
}

.preference-text {
    font-size: 0.95rem;
    font-weight: 500;
    color: #495057;
    text-align: center;
    transition: all 0.3s ease;
    z-index: 1;
}

.preference-check {
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 1.2rem;
    color: #ff69b4;
    opacity: 0;
    transform: scale(0) rotate(-180deg);
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    z-index: 1;
}

/* Hover state */
.preference-label:hover .preference-content {
    transform: translateY(-3px);
    border-color: #ff69b4;
    box-shadow: 0 6px 20px rgba(255, 105, 180, 0.25);
}

.preference-label:hover .preference-content::before {
    opacity: 1;
}

.preference-label:hover .preference-icon {
    color: #ff69b4;
    transform: scale(1.1);
}

/* Checked state */
.preference-checkbox:checked + .preference-label .preference-content {
    background: linear-gradient(135deg, #ff69b4 0%, #F56289 100%);
    border-color: #ff69b4;
    box-shadow: 0 8px 25px rgba(255, 105, 180, 0.4);F56289
    transform: translateY(-2px);
}

.preference-checkbox:checked + .preference-label .preference-content::before {
    opacity: 0;
}

.preference-checkbox:checked + .preference-label .preference-icon {
    color: #ffffff;
    transform: scale(1.15);
}

.preference-checkbox:checked + .preference-label .preference-text {
    color: #ffffff;
    font-weight: 600;
}

.preference-checkbox:checked + .preference-label .preference-check {
    opacity: 1;
    transform: scale(1) rotate(0deg);
}

/* Focus state for accessibility */
.preference-checkbox:focus + .preference-label .preference-content {
    outline: 2px solid #ff69b4;
    outline-offset: 2px;
}

/* Active/Click animation */
.preference-label:active .preference-content {
    transform: translateY(0) scale(0.98);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .preference-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
    }

    .preference-content {
        padding: 15px 10px;
        min-height: 100px;
    }

    .preference-icon {
        font-size: 1.5rem;
    }

    .preference-text {
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .preference-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Security Settings Styles */
.security-card {
    background: #fff;
    border-radius: 15px;
    border: 2px solid #f0f0f0;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.security-card:hover {
    border-color: #ff69b4;
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.15);
    transform: translateY(-2px);
}

.security-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, #fff5f8 0%, #ffffff 100%);
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.security-icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #ff69b4 0%, #ff8fb4 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(255, 105, 180, 0.3);
}

.security-icon-wrapper i {
    font-size: 1.5rem;
    color: #fff;
}

.security-body {
    padding: 25px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-enabled {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.status-disabled {
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(156, 163, 175, 0.3);
}

.btn-security {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 28px;
    background: linear-gradient(135deg, #ff69b4 0%, #ff8fb4 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(255, 105, 180, 0.3);
}

.btn-security:hover {
    background: linear-gradient(135deg, #ff8fb4 0%, #ff69b4 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
}

.btn-security:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(255, 105, 180, 0.3);
}

/* Responsive adjustments for security section */
@media (max-width: 768px) {
    .security-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .security-header > div:first-child {
        width: 100%;
    }

    .security-header > div:last-child {
        width: 100%;
        display: flex;
        justify-content: flex-start;
    }

    .security-icon-wrapper {
        width: 45px;
        height: 45px;
    }

    .security-icon-wrapper i {
        font-size: 1.3rem;
    }

    .btn-security {
        width: 100%;
        padding: 14px 20px;
    }
}
</style>
@endsection
