<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skin911 - Booking Cancellation</title>
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
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #F56289;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .warning-box h4 {
            margin: 0 0 10px 0;
            color: #856404;
        }
        .warning-box p {
            margin: 0;
            color: #856404;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .footer p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .footer a {
            color: #F56289;
            text-decoration: none;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #F56289;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #e0557a;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #F56289;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Booking Cancelled</h1>
            <p>Your booking has been successfully cancelled</p>
        </div>

        <div class="content">
            <div class="greeting">
                Hi {{ $booking->user->name }},
            </div>

            <p>Your booking has been cancelled as requested. Here are the details:</p>

            <div class="info-box">
                <h3>Booking Details</h3>
                <div class="info-row">
                    <span class="info-label">Booking ID:</span>
                    <span class="info-value">#{{ $booking->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Service:</span>
                    <span class="info-value">{{ $booking->service->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Branch:</span>
                    <span class="info-value">{{ $booking->branch->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date & Time:</span>
                    <span class="info-value">{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'N/A' }} at {{ $booking->booking_time ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value"><span class="status-badge">Cancelled</span></span>
                </div>
            </div>

            @if($booking->payment_status !== 'paid')
            <div class="warning-box">
                <h4>No Refund Required</h4>
                <p>This booking was not paid, so no refund is needed.</p>
            </div>
            @else
            <div class="warning-box">
                <h4>Refund Information</h4>
                <p>If you paid for this booking, please visit the branch to collect your refund. Bring your booking confirmation or ID for verification.</p>
            </div>
            @endif

            <p>If you need to book again, you can do so through our website:</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('home') }}" class="btn">Book Again</a>
                <a href="{{ route('contact') }}" class="btn">Contact Support</a>
            </div>
        </div>

        <div class="footer">
            <p>
                Thank you for choosing Skin911!<br>
                <a href="{{ route('home') }}">Visit our website</a> | <a href="mailto:support@skin911.com">Contact Support</a>
            </p>
            <p style="margin-top: 10px; font-size: 12px; color: #999;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
