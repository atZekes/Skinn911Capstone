<div id="loginModal" class="modal-overlay" style="background:rgba(30,30,30,0.35);align-items:center;justify-content:center;transition:background 0.3s;" aria-hidden="true">
    @props(['name'])
    <div class="modal-content" style="background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(245,98,137,0.12);padding:40px 32px;max-width:400px;width:100%;">
        <!-- Close Button -->
        <span class="modal-close-btn" style="position:absolute;top:18px;right:24px;font-size:2rem;color:#F56289;cursor:pointer;">&times;</span>
        <div class="login-container" style="display:flex;flex-direction:column;align-items:center;">
            <img src="{{ asset('img/skinlogo.png') }}" class="logo" width="120px" style="margin-bottom:18px;">
            {{-- Google Sign In Button (commented out) --}}
            {{-- <a href="{{ route('auth.google') }}" class="google-signin-btn" style="width:100%;display:flex;align-items:center;justify-content:center;padding:12px;border:1.5px solid #ddd;border-radius:8px;background:#fff;margin-bottom:20px;text-decoration:none;color:#333;font-weight:500;font-size:1rem;transition:background 0.2s, border-color 0.2s;">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="width:18px;height:18px;margin-right:12px;">
                Continue with Google
            </a>
            <div style="width:100%;text-align:center;margin:20px 0;position:relative;">
                <span style="background:#fff;padding:0 10px;color:#666;font-size:0.9rem;">or</span>
                <hr style="border:none;border-top:1px solid #ddd;margin:0;">
            </div> --}}
            <!-- LOGIN FORM -->
            @if($errors->any())
                <div class="mb-3 alert alert-danger" style="border-radius:8px;background:#ffe6f0;color:#F56289;padding:10px 16px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    @if(session('error'))
                        <div>{{ session('error') }}</div>
                    @endif
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" style="width:100%;">
                @csrf <!-- Laravel Security Token (Required) -->
                <input type="hidden" name="client_login" value="1">
                <!-- Email Input with Icon -->
                <div class="input-icon-group" style="position:relative;width:100%;margin-bottom:18px;">
                    <img src="{{ asset('img/user.png') }}" class="input-icon" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:20px;opacity:.6;">
                    <input name="email" type="email" placeholder="EMAIL ADDRESS" class="input" required value="{{ old('email') }}" style="width:100%;padding:12px 14px 12px 44px;border:1.5px solid #F56289;border-radius:8px;font-size:1rem;">
                    @if($errors->has('email'))
                        <div class="mt-1 text-danger small">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <!-- Password Input with Icon -->
                <div class="input-icon-group" style="position:relative;width:100%;margin-bottom:18px;">
                    <img src="{{ asset('img/lock.png') }}" class="input-icon" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:20px;opacity:.6;">
                    <input id="login-password" name="password" type="password" placeholder="PASSWORD" class="input" required style="width:100%;padding:12px 44px 12px 44px;border:1.5px solid #F56289;border-radius:8px;font-size:1rem;">
                    <i class="fa fa-eye password-toggle-icon" id="toggleLoginPassword" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:#F56289;opacity:.6;"></i>
                    @if($errors->has('password'))
                        <div class="mt-1 text-danger small">{{ $errors->first('password') }}</div>
                    @endif
                        <div id="login-error-message" class="text-danger small" style="display:none;position:absolute;left:0;top:100%;width:100%;padding-top:2px;font-size:0.85rem;z-index:2;"></div>
                </div>
                <button type="submit" class="button" style="width:100%;padding:12px;background:#F56289;color:#fff;border:none;border-radius:8px;font-weight:600;font-size:1.1rem;box-shadow:0 2px 8px rgba(245,98,137,0.10);margin-top:8px;transition:background 0.2s;">LOGIN</button>
                                    <div id="login-loading-spinner" style="display:none;text-align:center;margin-top:8px;">
                                        <span class="spinner-border spinner-border-sm" style="color:#F56289;"></span> Logging in...
                                    </div>
                <p class="text" style="text-align:left;margin-top:15px;font-size:0.95rem;">
                    <input type="checkbox" name="remember" style="vertical-align:middle;"> Remember me
                    <a href="#" class="links" id="openResetPasswordModal" style="margin-left:25px;color:#F56289;font-weight:500;">Forgot Password?</a>
                </p>
            </form>
            <!-- END FORM -->
            <p class="text" style="margin-top:30px;font-size:0.95rem;">
                Don't have an account?
                <a href=# id="showRegisterModalLink" class="links" style="color:#F56289;font-weight:500;">Sign up</a>
            </p>
        </div>
    </div>
</div>
<script>
// Only handle reset password modal trigger, let global script handle modal open/close
document.addEventListener('DOMContentLoaded', function() {
    var resetBtn = document.getElementById('openResetPasswordModal');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var resetModal = document.getElementById('resetPasswordModal');
            if (resetModal) {
                resetModal.classList.add('active');
                resetModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }
        });
    }
    // Auto-open login modal if there are errors
    var loginModal = document.getElementById('loginModal');
    if (loginModal && document.querySelector('#loginModal .alert-danger')) {
        loginModal.classList.add('active');
        loginModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    // Password toggle for login
    const toggleLoginPassword = document.getElementById('toggleLoginPassword');
    const loginPassword = document.getElementById('login-password');

    if (toggleLoginPassword && loginPassword) {
        toggleLoginPassword.addEventListener('click', function() {
            const type = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            loginPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // AJAX login
    const loginForm = loginModal ? loginModal.querySelector('form[action*="login"]') : null;
    const loginErrorDiv = document.getElementById('login-error-message');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            loginErrorDiv.style.display = "none";
            loginErrorDiv.textContent = "";
            const formData = new FormData(loginForm);
            // Show spinner
            const spinner = document.getElementById('login-loading-spinner');
            if (spinner) spinner.style.display = "block";

            fetch(loginForm.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': loginForm.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => {
                // If server redirected (non-JSON) assume login succeeded and reload to get session cookie
                if (response.redirected || (response.status >= 300 && response.status < 400)) {
                    if (spinner) spinner.style.display = "none";
                    window.location.reload();
                    return null;
                }
                const ct = response.headers.get('content-type') || '';
                if (ct.indexOf('application/json') !== -1) {
                    return response.json();
                }
                // fallback: try to parse text as JSON, otherwise reload
                return response.text().then(text => {
                    try { return JSON.parse(text); }
                    catch (e) { if (spinner) spinner.style.display = "none"; window.location.reload(); return null; }
                });
            })
            .then(data => {
                if (!data) return;
                if (spinner) spinner.style.display = "none";
                if (data.errors && data.errors.password) {
                    loginErrorDiv.textContent = data.errors.password[0];
                    loginErrorDiv.style.display = "block";
                } else if (data.errors && data.errors.email) {
                    loginErrorDiv.textContent = data.errors.email[0];
                    loginErrorDiv.style.display = "block";
                } else if (data.message) {
                    loginErrorDiv.textContent = data.message;
                    loginErrorDiv.style.display = "block";
                } else if (data.success) {
                    loginErrorDiv.textContent = "";
                    loginErrorDiv.style.display = "none";
                    window.location.reload();
                } else {
                    loginErrorDiv.textContent = "";
                    loginErrorDiv.style.display = "none";
                    window.location.reload();
                }
            })
            .catch((err) => {
                if (spinner) spinner.style.display = "none";
                console.error('Login AJAX error:', err);
                loginErrorDiv.textContent = "Login failed. Please try again.";
                loginErrorDiv.style.display = "block";
            });
        });
    }
});
</script>
