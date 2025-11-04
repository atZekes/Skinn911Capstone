<!-- resources/views/components/register-modal.blade.php -->

<div id="registerModal" class="modal-overlay" style="background:rgba(30,30,30,0.35);align-items:center;justify-content:center;transition:background 0.3s;" aria-hidden="true">
    <div class="modal-content" style="background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(245,98,137,0.12);padding:40px 32px;max-width:400px;width:100%;position:relative;">
        <span class="modal-close-btn" style="position:absolute;top:18px;right:24px;font-size:2rem;color:#F56289;cursor:pointer;">&times;</span>
        <div class="login-container" style="display:flex;flex-direction:column;align-items:center;">
            <img src="{{ asset('img/skinlogo.png') }}" class="logo" width="120px" style="margin-bottom:18px;">
            <h3 class="modal-title" style="color: #F56289; font-family: Montserrat, sans-serif; margin-top: 0; margin-bottom: 20px;">Create an Account</h3>
            @if($errors->any())
                <div class="alert alert-danger mb-3" style="border-radius:8px;background:#ffe6f0;color:#F56289;padding:10px 16px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}" style="width:100%;">
                @csrf
                <div class="input-icon-group" style="position:relative;width:100%;margin-bottom:18px;">
                    <img src="{{ asset('img/user.png') }}" class="input-icon" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:20px;opacity:.6;">
                    <input name="name" type="text" placeholder="FULL NAME" class="input" required autofocus value="{{ old('name') }}" style="width:100%;padding:12px 14px 12px 44px;border:1.5px solid #F56289;border-radius:8px;font-size:1rem;">
                    @if($errors->has('name'))
                        <div class="text-danger small mt-1">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="input-icon-group" style="position:relative;width:100%;margin-bottom:18px;">
                    <img src="{{ asset('img/user.png') }}" class="input-icon" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:20px;opacity:.6;">
                    <input name="email" type="email" placeholder="EMAIL ADDRESS" class="input" required autocomplete="username" value="{{ old('email') }}" style="width:100%;padding:12px 14px 12px 44px;border:1.5px solid #F56289;border-radius:8px;font-size:1rem;">
                    @if($errors->has('email'))
                        <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="input-icon-group" style="position:relative;width:100%;margin-bottom:18px;">
                    <img src="{{ asset('img/lock.png') }}" class="input-icon" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:20px;opacity:.6;">
                    <input id="register-password" name="password" type="password" placeholder="PASSWORD" class="input" required autocomplete="new-password" style="width:100%;padding:12px 44px 12px 44px;border:1.5px solid #F56289;border-radius:8px;font-size:1rem;">
                    <i class="fa fa-eye password-toggle-icon" id="toggleRegisterPassword" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:#F56289;opacity:.6;"></i>
                    @if($errors->has('password'))
                        <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="input-icon-group" style="position:relative;width:100%;margin-bottom:18px;">
                    <img src="{{ asset('img/lock.png') }}" class="input-icon" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:20px;opacity:.6;">
                    <input id="register-password-confirmation" name="password_confirmation" type="password" placeholder="CONFIRM PASSWORD" class="input" required autocomplete="new-password" style="width:100%;padding:12px 44px 12px 44px;border:1.5px solid #F56289;border-radius:8px;font-size:1rem;">
                    <i class="fa fa-eye password-toggle-icon" id="toggleRegisterPasswordConfirmation" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:#F56289;opacity:.6;"></i>
                    @if($errors->has('password_confirmation'))
                        <div class="text-danger small mt-1">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <!-- Service Preferences -->
                <div style="margin-bottom:15px;">
                    <label style="color:#333;font-weight:600;font-size:0.85rem;margin-bottom:8px;display:flex;align-items:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#F56289" class="me-1" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        Service Preferences
                        <span style="color:#999;font-weight:400;font-size:0.75rem;margin-left:4px;">(Optional)</span>
                    </label>
                    @php
                        $availablePreferences = [
                            'Facial' => 'bi-emoji-smile',
                            'Laser' => 'bi-lightning-charge',
                            'Slimming' => 'bi-heart-pulse',
                            'Immuno' => 'bi-shield-check',
                            'Hair Removal' => 'bi-scissors'
                        ];
                    @endphp
                    <div style="display:grid;grid-template-columns:repeat(2, 1fr);gap:8px;">
                        @foreach($availablePreferences as $preference => $icon)
                            <div class="pref-card">
                                <input
                                    type="checkbox"
                                    name="preferences[]"
                                    value="{{ $preference }}"
                                    id="reg_{{ Str::slug($preference) }}"
                                    class="pref-checkbox"
                                >
                                <label for="reg_{{ Str::slug($preference) }}" class="pref-label">
                                    <div class="pref-content">
                                        <i class="bi {{ $icon }} pref-icon"></i>
                                        <span class="pref-text">{{ $preference }}</span>
                                        <i class="bi bi-check-circle-fill pref-check"></i>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="button" style="width:100%;padding:12px;background:#F56289;color:#fff;border:none;border-radius:8px;font-weight:600;font-size:1.1rem;box-shadow:0 2px 8px rgba(245,98,137,0.10);margin-top:8px;transition:background 0.2s;">REGISTER</button>
            </form>
            <p class="text" style="margin-top:30px;font-size:0.95rem;">

                Already have an account?
                <a href="#" id="showLoginModalLink" class="links" style="color:#F56289;font-weight:500;">Log in</a>
            </p>
        </div>
    </div>
</div>

<style>
/* Preference cards for register modal */
.pref-card {
    position: relative;
}

.pref-checkbox {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.pref-label {
    display: block;
    cursor: pointer;
    margin: 0;
}

.pref-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px 6px;
    background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
    border: 2px solid #e8e8e8;
    border-radius: 80px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 15px;
    position: relative;
    overflow: hidden;
}

.pref-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(245, 98, 137, 0.08) 0%, rgba(255, 192, 203, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.pref-icon {
    font-size: 1.2rem;
    color: #999;
    margin-bottom: 4px;
    transition: all 0.3s ease;
    z-index: 1;
}

.pref-text {
    font-size: 0.7rem;
    font-weight: 500;
    color: #555;
    text-align: center;
    transition: all 0.3s ease;
    z-index: 1;
    line-height: 1.1;
}

.pref-check {
    position: absolute;
    top: 4px;
    right: 4px;
    font-size: 0.85rem;
    color: #fff;
    opacity: 0;
    transform: scale(0) rotate(-180deg);
    transition: all 0.35s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    z-index: 2;
}

/* Hover state */
.pref-label:hover .pref-content {
    transform: translateY(-2px);
    border-color: #F56289;
    box-shadow: 0 4px 12px rgba(245, 98, 137, 0.2);
}

.pref-label:hover .pref-content::before {
    opacity: 1;
}

.pref-label:hover .pref-icon {
    color: #F56289;
    transform: scale(1.1);
}

/* Checked state */
.pref-checkbox:checked + .pref-label .pref-content {
    background: linear-gradient(135deg, #F56289 0%, #e94583 100%);
    border-color: #F56289;
    box-shadow: 0 5px 15px rgba(245, 98, 137, 0.35);
    transform: translateY(-1px);
}

.pref-checkbox:checked + .pref-label .pref-icon {
    color: #ffffff;
    transform: scale(1.15);
}

.pref-checkbox:checked + .pref-label .pref-text {
    color: #ffffff;
    font-weight: 600;
}

.pref-checkbox:checked + .pref-label .pref-check {
    opacity: 1;
    transform: scale(1) rotate(0deg);
}

/* Active state */
.pref-label:active .pref-content {
    transform: translateY(0) scale(0.98);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility for register modal
    const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
    const registerPassword = document.getElementById('register-password');

    if (toggleRegisterPassword && registerPassword) {
        toggleRegisterPassword.addEventListener('click', function() {
            const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            registerPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Toggle password confirmation visibility for register modal
    const toggleRegisterPasswordConfirmation = document.getElementById('toggleRegisterPasswordConfirmation');
    const registerPasswordConfirmation = document.getElementById('register-password-confirmation');

    if (toggleRegisterPasswordConfirmation && registerPasswordConfirmation) {
        toggleRegisterPasswordConfirmation.addEventListener('click', function() {
            const type = registerPasswordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            registerPasswordConfirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});
</script>

