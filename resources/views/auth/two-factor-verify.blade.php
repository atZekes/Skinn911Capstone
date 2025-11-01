<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Verification - Skin911</title>
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

        .verify-container {
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
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(231, 84, 128, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(231, 84, 128, 0.5);
            }
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
            line-height: 1.5;
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

        .form-control {
            width: 100%;
            padding: 18px;
            border: 3px solid #e75480;
            border-radius: 15px;
            font-size: 2rem;
            transition: all 0.3s;
            text-align: center;
            letter-spacing: 15px;
            font-weight: 700;
            color: #e75480;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff8fab;
            box-shadow: 0 0 0 4px rgba(231, 84, 128, 0.1);
        }

        .form-text {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #6c757d;
            text-align: center;
        }

        .btn-verify {
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

        .btn-verify:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(231, 84, 128, 0.4);
        }

        .btn-verify:active {
            transform: translateY(-1px);
        }

        .btn-verify:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .help-links {
            margin-top: 30px;
            text-align: center;
        }

        .help-link {
            display: inline-block;
            color: #e75480;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            margin: 0 10px;
        }

        .help-link:hover {
            color: #ff8fab;
            text-decoration: underline;
        }

        .logo {
            display: block;
            margin: 0 auto 30px;
            max-width: 150px;
        }

        .security-info {
            background: linear-gradient(135deg, #fff0f5 0%, #ffffff 100%);
            border-left: 4px solid #e75480;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
        }

        .security-info h5 {
            color: #e75480;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .security-info p {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.5;
        }

        @media (max-width: 576px) {
            .verify-container {
                padding: 40px 30px;
            }

            h1 {
                font-size: 1.6rem;
            }

            .form-control {
                font-size: 1.5rem;
                letter-spacing: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo" class="logo">

        <div class="icon-header">
            <i class="fas fa-mobile-alt"></i>
        </div>

        <h1>Two-Factor Verification</h1>
        <p class="subtitle">
            Enter the 6-digit code from your<br>
            <strong>Google Authenticator</strong> app
        </p>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Error!</strong>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.verify.post') }}" id="verifyForm">
            @csrf

            <div class="form-group">
                <label for="one_time_password" class="form-label">
                    <i class="fas fa-key me-1"></i>Verification Code
                </label>
                <input
                    type="text"
                    id="one_time_password"
                    name="one_time_password"
                    class="form-control"
                    placeholder="000000"
                    maxlength="6"
                    pattern="[0-9]{6}"
                    required
                    autofocus
                    autocomplete="off">
                <small class="form-text">
                    <i class="fas fa-info-circle"></i> Open your authenticator app to get the code
                </small>
            </div>

            <button type="submit" class="btn-verify">
                <i class="fas fa-check-circle me-2"></i>Verify & Continue
            </button>
        </form>

        <div class="security-info">
            <h5>
                <i class="fas fa-shield-alt me-2"></i>Security Notice
            </h5>
            <p>
                This code changes every 30 seconds. If your code expired, wait for the next one to appear in your app.
            </p>
        </div>

        <div class="help-links">
            <a href="{{ route('logout') }}"
               class="help-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-1"></i>Sign Out
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <script>
        // Auto-submit when 6 digits are entered
        const input = document.getElementById('one_time_password');
        const form = document.getElementById('verifyForm');
        const submitBtn = form.querySelector('.btn-verify');

        input.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto-submit when 6 digits entered
            if (this.value.length === 6) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
                form.submit();
            }
        });

        // Form submission handling
        form.addEventListener('submit', function(e) {
            const code = input.value;
            if (code.length !== 6) {
                e.preventDefault();
                alert('Please enter a 6-digit code');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
        });
    </script>
</body>
</html>
