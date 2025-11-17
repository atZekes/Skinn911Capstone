<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Credits Reminder</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #e75480;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.8;
        }
        .credit-box {
            background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
            color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            text-align: center;
        }
        .credit-number {
            font-size: 48px;
            font-weight: bold;
            margin: 10px 0;
        }
        .credit-label {
            font-size: 16px;
            opacity: 0.9;
        }
        .expiry-warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #856404;
        }
        .expiry-warning strong {
            display: block;
            margin-bottom: 5px;
        }
        .cta-button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.3s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .footer-logo {
            margin-bottom: 15px;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            color: #e75480;
            text-decoration: none;
            margin: 0 10px;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .email-header h1 {
                font-size: 24px;
            }
            .credit-number {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🎉 Session Credits Reminder</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p class="greeting">Hello {{ $clientName }},</p>

            <p class="message">
                We hope you're enjoying your treatments at {{ $branchName }}! This is a friendly reminder about your remaining session credits.
            </p>

            <!-- Credit Display -->
            <div class="credit-box">
                <div class="credit-label">YOU HAVE</div>
                <div class="credit-number">{{ $sessionsRemaining }}</div>
                <div class="credit-label">SESSION CREDIT{{ $sessionsRemaining > 1 ? 'S' : '' }} REMAINING</div>
                <div style="margin-top: 15px; font-size: 14px; opacity: 0.9;">
                    For: <strong>{{ $serviceName }}</strong>
                </div>
            </div>

            @if($expiryDate && $daysUntilExpiry !== null && $daysUntilExpiry <= 30 && $daysUntilExpiry > 0)
                <div class="expiry-warning">
                    <strong>⏰ Expiring Soon!</strong>
                    Your session credits will expire on <strong>{{ $expiryDate }}</strong> ({{ $daysUntilExpiry }} day{{ $daysUntilExpiry > 1 ? 's' : '' }} remaining).
                    Book your next appointment soon to make the most of your credits!
                </div>
            @elseif($expiryDate)
                <p class="message" style="text-align: center; color: #6c757d;">
                    <small>Valid until: {{ $expiryDate }}</small>
                </p>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/client/dashboard') }}" class="cta-button">
                    📅 Book Your Next Session
                </a>
            </div>

            <p class="message">
                Don't let your credits go to waste! Book your next appointment today and continue your journey to healthier, more beautiful skin.
            </p>

            <p class="message">
                <strong>Need help booking?</strong><br>
                Contact us at {{ $branchName }} and our team will be happy to assist you.
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-logo">
                <strong style="color: #e75480; font-size: 18px;">Skin911</strong>
            </div>
            <p>Thank you for choosing Skin911 for your skincare needs!</p>
            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Instagram</a> |
                <a href="#">Website</a>
            </div>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                This is an automated reminder. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
