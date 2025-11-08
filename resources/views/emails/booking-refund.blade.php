<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skin911 - Refund Request Submitted</title>
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
        .success-box {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .success-box h4 {
            margin: 0 0 10px 0;
            color: #0c5460;
        }
        .success-box p {
            margin: 0;
            color: #0c5460;
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
            color: #212529;
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
            <h1>Refund Request Submitted</h1>
            <p>Your refund request has been received</p>
        </div>

        <div class="content">
            <div class="greeting">
                Hi {{ $booking->user->name }},
            </div>

            <p>Your refund request has been submitted successfully. Here are the details:</p>

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
                    <span class="info-value"><span class="status-badge">Refund Pending</span></span>
                </div>
            </div>

            <div class="success-box">
                <h4>What happens next?</h4>
                <p>Your refund request is now pending approval from our staff. Once approved, you will receive another email with instructions on how to collect your refund at the branch.</p>
            </div>

            <div class="warning-box">
                <h4>Important Information</h4>
                <p>Please keep this email and your booking confirmation. You will need to show these when visiting the branch to collect your refund.</p>
            </div>

            <p>If you have any questions about your refund, please contact the branch directly:</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('contact') }}" class="btn">Contact Branch</a>
                <a href="{{ route('client.dashboard') }}" class="btn">View Dashboard</a>
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
