<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Skin911</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verification-container {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(245, 98, 137, 0.3);
            max-width: 500px;
            width: 100%;
            padding: 50px 40px;
            text-align: center;
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

        .logo-container {
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 140px;
            height: auto;
        }

        .icon-wrapper {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #FFE6F0 0%, #FFF0F5 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 8px 20px rgba(245, 98, 137, 0.15);
        }

        .icon-wrapper i {
            font-size: 48px;
            color: #F56289;
        }

        h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .message {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .user-email {
            background: #F8F9FA;
            padding: 12px 20px;
            border-radius: 10px;
            color: #F56289;
            font-weight: 600;
            margin: 20px 0;
            display: inline-block;
        }

        .success-message {
            background: linear-gradient(135deg, #D4EDDA 0%, #C3E6CB 100%);
            border: 2px solid #28A745;
            color: #155724;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .success-message i {
            font-size: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%);
            color: #fff;
            padding: 16px 40px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(245, 98, 137, 0.3);
            display: inline-block;
            text-decoration: none;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 98, 137, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: transparent;
            color: #F56289;
            padding: 14px 30px;
            border: 2px solid #F56289;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            margin-top: 15px;
        }

        .btn-secondary:hover {
            background: #FFF0F5;
        }

        .info-box {
            background: #FFF9E6;
            border-left: 4px solid #FFC107;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 25px 0;
            text-align: left;
        }

        .info-box i {
            color: #FFC107;
            margin-right: 10px;
        }

        .info-box p {
            color: #856404;
            font-size: 14px;
            margin: 0;
        }

        .divider {
            height: 1px;
            background: #E5E7EB;
            margin: 30px 0;
        }

        .footer-text {
            color: #999;
            font-size: 13px;
            margin-top: 20px;
        }

        form {
            width: 100%;
        }

        @media (max-width: 600px) {
            .verification-container {
                padding: 40px 25px;
            }

            h1 {
                font-size: 24px;
            }

            .message {
                font-size: 15px;
            }

            .btn-primary, .btn-secondary {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('img/skinlogo.png') }}" alt="Skin911 Logo">
        </div>

        <!-- Icon -->
        <div class="icon-wrapper">
            <i class="fas fa-envelope-open-text"></i>
        </div>

        <!-- Success Message (if email was resent) -->
        @if (session('status') == 'verification-link-sent')
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <span>Verification email sent successfully!</span>
            </div>
        @endif

        <!-- Main Content -->
        <h1>Verify Your Email Address</h1>

        <p class="message">
            Welcome to <strong>Skin911</strong>! 🎉<br>
            We've sent a verification link to:
        </p>

        <div class="user-email">
            <i class="fas fa-envelope"></i> {{ Auth::user()->email }}
        </div>

        <p class="message">
            Please check your inbox and click the verification link to activate your account and start booking amazing skincare services!
        </p>

        <!-- Info Box -->
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <p><strong>Can't find the email?</strong> Check your spam or junk folder, or click the button below to resend.</p>
        </div>

        <!-- Resend Button -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i> Resend Verification Email
            </button>
        </form>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-secondary">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </button>
        </form>

        <!-- Footer -->
        <p class="footer-text">
            Need help? Contact us at <strong>skin911.mainofc@gmail.com</strong>
        </p>
    </div>
</body>
</html>
