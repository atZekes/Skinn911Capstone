<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Skin911</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e75480 0%, #ff8fab 50%, #ffc8d8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(231, 84, 128, 0.3);
            max-width: 500px;
            width: 100%;
            padding: 50px 40px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-header {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 10px 30px rgba(231, 84, 128, 0.4);
        }

        .icon-header i {
            font-size: 48px;
            color: white;
        }

        h1 {
            color: #e75480;
            font-weight: 700;
            text-align: center;
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .subtitle {
            text-align: center;
            color: #6c757d;
            margin-bottom: 35px;
            font-size: 1rem;
        }

        .alert {
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 25px;
            border: none;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
        }

        .alert-danger i {
            margin-right: 8px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #495057;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-icon i {
            font-size: 14px;
            color: white;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 55px;
            border: 2px solid #e75480;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff8fab;
            box-shadow: 0 0 0 4px rgba(231, 84, 128, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #e75480;
            font-size: 18px;
            transition: all 0.3s;
        }

        .password-toggle:hover {
            color: #ff8fab;
        }

        .form-text {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .btn-reset {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(231, 84, 128, 0.3);
        }

        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(231, 84, 128, 0.4);
        }

        .btn-reset:active {
            transform: translateY(-1px);
        }

        .btn-reset:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #e75480;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-link:hover {
            color: #ff8fab;
            text-decoration: underline;
        }

        .logo {
            display: block;
            margin: 0 auto 30px;
            max-width: 150px;
        }

        @media (max-width: 576px) {
            .reset-container {
                padding: 40px 30px;
            }

            h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo" class="logo">

        <div class="icon-header">
            <i class="fas fa-lock-open"></i>
        </div>

        <h1>Create New Password</h1>
        <p class="subtitle">Enter your new password below to reset your account password</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Error!</strong>
                <ul style="margin: 10px 0 0 25px; list-style-type: disc;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $request->email) }}"
                        required
                        readonly
                        style="background-color: #f8f9fa;">
                </div>
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label for="password" class="form-label">New Password</label>
                <div class="input-wrapper">
                    <div class="input-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter new password"
                        required>
                    <span class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-icon"></i>
                    </span>
                </div>
                <small class="form-text">
                    <i class="fas fa-info-circle"></i> Password must be at least 8 characters
                </small>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <div class="input-wrapper">
                    <div class="input-icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm new password"
                        required>
                    <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-reset">
                <i class="fas fa-shield-alt me-2"></i>Reset Password
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left me-1"></i>Back to Login
        </a>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form submission handling
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-reset');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Resetting Password...';
        });
    </script>
</body>
</html>
