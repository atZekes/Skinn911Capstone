<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skin911 - Booking Reminder</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #F56289 0%, #FF8FAB 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #F56289;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 14px;
        }
        .info-value {
            color: #333;
            font-size: 14px;
            text-align: right;
            font-weight: 500;
        }
        .highlight {
            color: #F56289;
            font-weight: 700;
        }
        .reminder-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .reminder-box strong {
            color: #856404;
            font-size: 18px;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .footer a {
            color: #F56289;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 30px 0;
        }
        .contact-info {
            background: #f0f8ff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .contact-info p {
            margin: 8px 0;
            color: #555;
        }
        .icon {
            color: #F56289;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>⏰ Booking Reminder!</h1>
            <p>Your upcoming appointment at Skin911</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello <strong>{{ $booking->user->name ?? 'Valued Customer' }}</strong>,
            </div>

            <div class="reminder-box">
                <strong>🔔 Friendly Reminder</strong>
                <p style="margin: 10px 0 0 0; color: #666; font-size: 16px;">
                    This is a reminder about your upcoming appointment with <strong>Skin911</strong>.
                </p>
            </div>

            <p style="color: #555; line-height: 1.6;">
                We're looking forward to seeing you! Please review your appointment details below:
            </p>

            <!-- Booking Details -->
            <div class="info-box">
                <h3 style="margin-top: 0; color: #F56289;">📋 Appointment Details</h3>

                <div class="info-row">
                    <span class="info-label">Booking ID:</span>
                    <span class="info-value highlight">#{{ $booking->id }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Branch:</span>
                    <span class="info-value">{{ $booking->branch->name ?? 'N/A' }}</span>
                </div>

                @if($booking->service)
                <div class="info-row">
                    <span class="info-label">Service:</span>
                    <span class="info-value">{{ $booking->service->name }}</span>
                </div>
                @endif

                @if($booking->package)
                <div class="info-row">
                    <span class="info-label">Package:</span>
                    <span class="info-value">{{ $booking->package->name }}</span>
                </div>
                @endif

                <div class="info-row">
                    <span class="info-label">Date:</span>
                    <span class="info-value highlight">{{ \Carbon\Carbon::parse($booking->date)->format('l, F j, Y') }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Time:</span>
                    <span class="info-value highlight">{{ $booking->time_slot }}</span>
                </div>

                @if($booking->payment_method)
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">{{ ucfirst($booking->payment_method) }}</span>
                </div>
                @endif
            </div>

            <!-- Branch Contact Info -->
            @if($booking->branch)
            <div class="contact-info">
                <h4 style="margin-top: 0; color: #F56289;">📍 Branch Information</h4>
                <p><span class="icon">📍</span> {{ $booking->branch->address ?? 'N/A' }}</p>
                @if($booking->branch->contact_number)
                <p><span class="icon">📞</span> {{ $booking->branch->contact_number }}</p>
                @endif
                @if($booking->branch->operating_days)
                <p><span class="icon">🗓️</span> Operating Days: {{ $booking->branch->operating_days }}</p>
                @endif
                @if($booking->branch->time_slot)
                <p><span class="icon">⏰</span> Hours: {{ $booking->branch->time_slot }}</p>
                @endif
            </div>
            @endif

            <div class="divider"></div>

            <!-- Important Notes -->
            <h4 style="color: #F56289;">⚠️ Important Reminders:</h4>
            <ul style="color: #555; line-height: 1.8;">
                <li>Please arrive <strong>10 minutes early</strong> for your appointment</li>
                <li>Bring a valid ID for verification</li>
                <li>If you need to reschedule or cancel, please contact us at least 24 hours in advance</li>
                @if($booking->payment_status === 'pending')
                <li>Your payment confirmation is still pending. Please bring your payment proof.</li>
                @elseif($booking->payment_method === 'cash' && $booking->payment_status !== 'paid')
                <li>Remember to bring cash payment for your appointment</li>
                @endif
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin-bottom: 15px;">
                <strong>Need help?</strong> Contact us at
                <a href="mailto:skin911.mainofc@gmail.com">skin911.mainofc@gmail.com</a>
                or call <a href="tel:09173963828">0917 396 3828</a>
            </p>
            <p style="font-size: 12px; color: #999;">
                This is an automated reminder email. Please do not reply directly to this message.
            </p>
            <p style="margin-top: 20px;">
                <a href="https://www.facebook.com/Skin911Official/" target="_blank" style="margin: 0 10px;">Facebook</a> |
                <a href="https://www.instagram.com/skin911/" target="_blank" style="margin: 0 10px;">Instagram</a>
            </p>
            <p style="margin-top: 15px; color: #999;">
                © {{ date('Y') }} Skin911. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
