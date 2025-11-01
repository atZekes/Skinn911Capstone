@extends('layouts.clientapp')

@section('title', 'Two-Factor Authentication Setup - Skin911')

@section('content')
<div class="container-fluid" style="margin-top: 100px; margin-bottom: 50px; padding-top: 20px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg" style="border-radius: 25px; border: none; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 60px; height: 60px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                            <i class="fas fa-shield-alt" style="font-size: 28px;"></i>
                        </div>
                        <div>
                            <h2 class="mb-0" style="font-weight: 700; font-size: 2rem;">Two-Factor Authentication</h2>
                            <p class="mb-0" style="opacity: 0.9;">Add an extra layer of security to your account</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('success'))
                <div class="alert alert-success shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- Status Card -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100" style="border-radius: 20px; border: none;">
                        <div class="card-body p-4 text-center">
                            <div class="status-icon mb-3" style="width: 100px; height: 100px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, {{ $enabled ? '#28a745' : '#e75480' }} 0%, {{ $enabled ? '#20c997' : '#ff8fab' }} 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba({{ $enabled ? '40, 167, 69' : '231, 84, 128' }}, 0.3);">
                                <i class="fas fa-{{ $enabled ? 'check-circle' : 'times-circle' }} text-white" style="font-size: 48px;"></i>
                            </div>
                            <h4 style="color: {{ $enabled ? '#28a745' : '#e75480' }}; font-weight: 700;">
                                {{ $enabled ? 'Enabled' : 'Disabled' }}
                            </h4>
                            <p class="text-muted mb-0">
                                2FA is currently <strong>{{ $enabled ? 'active' : 'inactive' }}</strong>
                            </p>
                            @if($enabled)
                                <p class="text-muted small mt-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    Enabled: {{ Auth::user()->google2fa_enabled_at->format('M d, Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Setup/Manage Card -->
                <div class="col-md-8 mb-4">
                    <div class="card shadow-sm h-100" style="border-radius: 20px; border: none;">
                        <div class="card-body p-4">
                            @if(!$enabled)
                                <!-- Enable 2FA -->
                                <h4 style="color: #e75480; font-weight: 700; margin-bottom: 20px;">
                                    <i class="fas fa-qrcode me-2"></i>Enable Two-Factor Authentication
                                </h4>

                                <div class="setup-steps">
                                    <div class="step mb-4">
                                        <div class="step-header" style="background: linear-gradient(135deg, #fff0f5 0%, #ffffff 100%); padding: 15px; border-radius: 15px; border-left: 4px solid #e75480;">
                                            <h5 style="color: #e75480; margin: 0;">
                                                <span class="badge" style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); margin-right: 10px;">1</span>
                                                Install Google Authenticator
                                            </h5>
                                        </div>
                                        <div class="step-content mt-3">
                                            <p class="text-muted">Download and install Google Authenticator app on your phone:</p>
                                            <div class="d-flex gap-3 flex-wrap">
                                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank" class="btn btn-sm" style="background: #34a853; color: white; border-radius: 10px; padding: 8px 16px;">
                                                    <i class="fab fa-android me-1"></i>Android
                                                </a>
                                                <a href="https://apps.apple.com/app/google-authenticator/id388497605" target="_blank" class="btn btn-sm" style="background: #000000; color: white; border-radius: 10px; padding: 8px 16px;">
                                                    <i class="fab fa-apple me-1"></i>iOS
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step mb-4">
                                        <div class="step-header" style="background: linear-gradient(135deg, #fff0f5 0%, #ffffff 100%); padding: 15px; border-radius: 15px; border-left: 4px solid #e75480;">
                                            <h5 style="color: #e75480; margin: 0;">
                                                <span class="badge" style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); margin-right: 10px;">2</span>
                                                Scan QR Code
                                            </h5>
                                        </div>
                                        <div class="step-content mt-3 text-center">
                                            <p class="text-muted">Open Google Authenticator and scan this QR code:</p>
                                            <div class="qr-code-container" style="background: white; padding: 20px; border-radius: 15px; display: inline-block; box-shadow: 0 4px 12px rgba(231, 84, 128, 0.1);">
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeUrl) }}" alt="QR Code" style="width: 200px; height: 200px; border-radius: 10px;">
                                            </div>
                                            <div class="mt-3">
                                                <p class="text-muted small mb-1">Or enter this code manually:</p>
                                                <div class="secret-key" style="background: #f8f9fa; padding: 12px; border-radius: 10px; font-family: monospace; font-weight: 600; color: #e75480; letter-spacing: 2px;">
                                                    {{ $secret }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step mb-4">
                                        <div class="step-header" style="background: linear-gradient(135deg, #fff0f5 0%, #ffffff 100%); padding: 15px; border-radius: 15px; border-left: 4px solid #e75480;">
                                            <h5 style="color: #e75480; margin: 0;">
                                                <span class="badge" style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); margin-right: 10px;">3</span>
                                                Verify and Enable
                                            </h5>
                                        </div>
                                        <div class="step-content mt-3">
                                            <form method="POST" action="{{ route('two-factor.enable') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="one_time_password" class="form-label" style="color: #495057; font-weight: 600;">
                                                        <i class="fas fa-mobile-alt me-1"></i>Verification Code from App
                                                    </label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="one_time_password"
                                                           name="one_time_password"
                                                           placeholder="Enter 6-digit code"
                                                           required
                                                           maxlength="6"
                                                           style="border: 2px solid #e75480; border-radius: 12px; padding: 12px; font-size: 1.1rem; text-align: center; letter-spacing: 5px; font-weight: 600;">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label" style="color: #495057; font-weight: 600;">
                                                        <i class="fas fa-lock me-1"></i>Confirm Your Password
                                                    </label>
                                                    <input type="password"
                                                           class="form-control"
                                                           id="password"
                                                           name="password"
                                                           placeholder="Enter your password"
                                                           required
                                                           style="border: 2px solid #e75480; border-radius: 12px; padding: 12px;">
                                                </div>
                                                <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); color: white; padding: 14px; border-radius: 12px; font-weight: 600; font-size: 1.1rem; border: none; box-shadow: 0 4px 12px rgba(231, 84, 128, 0.3);">
                                                    <i class="fas fa-shield-check me-2"></i>Enable 2FA
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Disable 2FA -->
                                <h4 style="color: #28a745; font-weight: 700; margin-bottom: 20px;">
                                    <i class="fas fa-check-circle me-2"></i>2FA is Active
                                </h4>

                                <div class="alert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: none; border-radius: 15px; padding: 20px;">
                                    <h5 style="color: #155724; margin-bottom: 10px;">
                                        <i class="fas fa-info-circle me-2"></i>Your Account is Protected
                                    </h5>
                                    <p class="mb-0" style="color: #155724;">
                                        Two-factor authentication is currently active on your account. You'll need to enter a code from your Google Authenticator app every time you log in.
                                    </p>
                                </div>

                                <div class="mt-4" style="background: linear-gradient(135deg, #fff0f5 0%, #ffffff 100%); padding: 20px; border-radius: 15px; border-left: 4px solid #dc3545;">
                                    <h5 style="color: #dc3545; margin-bottom: 15px;">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Disable Two-Factor Authentication
                                    </h5>
                                    <p class="text-muted mb-3">
                                        Disabling 2FA will make your account less secure. You'll only need your password to log in.
                                    </p>

                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#disableModal" style="border-radius: 10px; padding: 10px 20px; font-weight: 600;">
                                        <i class="fas fa-shield-alt me-2"></i>Disable 2FA
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Disable 2FA Modal -->
<div class="modal fade" id="disableModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%); color: white; border-radius: 20px 20px 0 0; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-shield-alt me-2"></i>Disable Two-Factor Authentication
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('two-factor.disable') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-warning" style="border-radius: 12px; border: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> Your account will be less secure without 2FA.
                    </div>

                    <div class="mb-3">
                        <label for="disable_one_time_password" class="form-label" style="font-weight: 600;">
                            <i class="fas fa-mobile-alt me-1"></i>Verification Code
                        </label>
                        <input type="text"
                               class="form-control"
                               id="disable_one_time_password"
                               name="one_time_password"
                               placeholder="Enter 6-digit code"
                               required
                               maxlength="6"
                               style="border: 2px solid #dee2e6; border-radius: 12px; padding: 12px; font-size: 1.1rem; text-align: center; letter-spacing: 5px;">
                    </div>
                    <div class="mb-3">
                        <label for="disable_password" class="form-label" style="font-weight: 600;">
                            <i class="fas fa-lock me-1"></i>Confirm Password
                        </label>
                        <input type="password"
                               class="form-control"
                               id="disable_password"
                               name="password"
                               placeholder="Enter your password"
                               required
                               style="border: 2px solid #dee2e6; border-radius: 12px; padding: 12px;">
                    </div>
                </div>
                <div class="modal-footer" style="border: none; padding: 20px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 20px;">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="border-radius: 10px; padding: 10px 20px; font-weight: 600;">
                        <i class="fas fa-shield-alt me-2"></i>Disable 2FA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.step {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-control:focus {
    border-color: #ff8fab !important;
    box-shadow: 0 0 0 3px rgba(231, 84, 128, 0.1) !important;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(231, 84, 128, 0.4) !important;
    transition: all 0.3s;
}

.qr-code-container {
    animation: scaleIn 0.5s ease-out;
}

@keyframes scaleIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>
@endsection
