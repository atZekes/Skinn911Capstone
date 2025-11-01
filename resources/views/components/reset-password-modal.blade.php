<div id="resetPasswordModal" class="modal-overlay" style="background:rgba(30,30,30,0.35);align-items:center;justify-content:center;transition:background 0.3s;" aria-hidden="true">
    <div class="modal-content" style="background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(245,98,137,0.12);padding:40px 32px;max-width:450px;width:100%;">
        <!-- Close Button -->
        <span class="modal-close-btn reset-password-close" style="position:absolute;top:18px;right:24px;font-size:2rem;color:#F56289;cursor:pointer;">&times;</span>

        <div class="reset-password-container" style="display:flex;flex-direction:column;align-items:center;">
            <!-- Icon Header -->
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(231, 84, 128, 0.3);">
                <i class="fas fa-key" style="font-size: 36px; color: white;"></i>
            </div>

            <h2 style="color: #e75480; font-weight: 700; margin-bottom: 10px; font-size: 1.8rem;">Forgot Password?</h2>
            <p style="text-align: center; color: #6c757d; margin-bottom: 25px; font-size: 0.95rem;">
                No problem! Enter your email address and we'll send you a password reset link.
            </p>

            <!-- Success Message -->
            <div id="resetSuccessMessage" class="alert alert-success" style="display: none; border-radius: 12px; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 15px; margin-bottom: 20px; width: 100%; border: none; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Email Sent!</strong>
                <p class="mb-0 mt-2" style="font-size: 0.9rem;">We've sent a password reset link to your email. Please check your inbox and follow the instructions.</p>
            </div>

            <!-- Error Message -->
            <div id="resetErrorMessage" class="alert alert-danger" style="display: none; border-radius: 12px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; padding: 15px; margin-bottom: 20px; width: 100%; border: none; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong>
                <p class="mb-0 mt-2" id="resetErrorText" style="font-size: 0.9rem;"></p>
            </div>

            <!-- RESET PASSWORD FORM -->
            <form id="resetPasswordForm" method="POST" action="{{ route('password.email') }}" style="width:100%;">
                @csrf

                <!-- Email Input with Icon -->
                <div class="input-icon-group" style="position:relative;width:100%;margin-bottom:25px;">
                    <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:24px;height:24px;border-radius:50%;background:linear-gradient(135deg, #e75480 0%, #ff8fab 100%);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-envelope" style="font-size: 12px; color: white;"></i>
                    </div>
                    <input
                        name="email"
                        type="email"
                        placeholder="Enter your email address"
                        class="input reset-email-input"
                        required
                        style="width:100%;padding:14px 14px 14px 50px;border:2px solid #e75480;border-radius:12px;font-size:1rem;transition:all 0.3s;">
                    <small class="text-muted" style="display: block; margin-top: 8px; font-size: 0.85rem;">
                        <i class="fas fa-info-circle"></i> We'll send a secure reset link to this email
                    </small>
                </div>

                <button
                    type="submit"
                    class="button reset-submit-btn"
                    style="width:100%;padding:14px;background:linear-gradient(135deg, #e75480 0%, #ff8fab 100%);color:#fff;border:none;border-radius:12px;font-weight:600;font-size:1.1rem;box-shadow:0 4px 12px rgba(231, 84, 128, 0.3);transition:all 0.3s;cursor:pointer;">
                    <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                </button>
            </form>
            <!-- END FORM -->

            <p class="text" style="margin-top:25px;font-size:0.95rem;text-align:center;">
                Remember your password?
                <a href="#" id="backToLoginLink" class="links" style="color:#e75480;font-weight:600;text-decoration:none;">
                    <i class="fas fa-arrow-left me-1"></i>Back to Login
                </a>
            </p>
        </div>
    </div>
</div>

<style>
/* Hover effects for reset password modal */
.reset-email-input:focus {
    outline: none;
    border-color: #ff8fab !important;
    box-shadow: 0 0 0 3px rgba(231, 84, 128, 0.1) !important;
}

.reset-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(231, 84, 128, 0.4) !important;
}

.reset-submit-btn:active {
    transform: translateY(0);
}

.reset-submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

#backToLoginLink:hover {
    color: #ff8fab !important;
    text-decoration: underline !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const resetPasswordModal = document.getElementById('resetPasswordModal');
    const resetPasswordForm = document.getElementById('resetPasswordForm');
    const resetSuccessMessage = document.getElementById('resetSuccessMessage');
    const resetErrorMessage = document.getElementById('resetErrorMessage');
    const resetErrorText = document.getElementById('resetErrorText');
    const backToLoginLink = document.getElementById('backToLoginLink');
    const resetPasswordCloseBtn = document.querySelector('.reset-password-close');
    const loginModal = document.getElementById('loginModal');

    // Handle back to login
    if (backToLoginLink) {
        backToLoginLink.addEventListener('click', function(e) {
            e.preventDefault();
            // Close reset password modal
            if (resetPasswordModal) {
                resetPasswordModal.classList.remove('active');
                resetPasswordModal.setAttribute('aria-hidden', 'true');
            }
            // Open login modal
            if (loginModal) {
                loginModal.classList.add('active');
                loginModal.setAttribute('aria-hidden', 'false');
            }
        });
    }

    // Handle close button
    if (resetPasswordCloseBtn) {
        resetPasswordCloseBtn.addEventListener('click', function() {
            resetPasswordModal.classList.remove('active');
            resetPasswordModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = 'auto';
        });
    }

    // Handle form submission with AJAX
    if (resetPasswordForm) {
        resetPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('.reset-submit-btn');
            const originalBtnText = submitBtn.innerHTML;

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';

            // Hide previous messages
            resetSuccessMessage.style.display = 'none';
            resetErrorMessage.style.display = 'none';

            // Get form data
            const formData = new FormData(this);

            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;

                if (data.status === 'success' || data.message) {
                    // Show success message
                    resetSuccessMessage.style.display = 'block';
                    resetPasswordForm.reset();

                    // Close modal after 3 seconds
                    setTimeout(function() {
                        resetPasswordModal.classList.remove('active');
                        resetPasswordModal.setAttribute('aria-hidden', 'true');
                        document.body.style.overflow = 'auto';
                        resetSuccessMessage.style.display = 'none';
                    }, 3000);
                } else {
                    // Show error message
                    resetErrorText.textContent = data.message || 'An error occurred. Please try again.';
                    resetErrorMessage.style.display = 'block';
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                resetErrorText.textContent = 'Network error. Please check your connection and try again.';
                resetErrorMessage.style.display = 'block';
            });
        });
    }
});
</script>
