<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Request Denied</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #F56289 0%, #e75480 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
        }
        .alert-box strong {
            color: #856404;
        }
        .booking-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .booking-details h3 {
            color: #F56289;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #212529;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #F56289 0%, #e75480 100%);
            color: white;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">⛔</div>
            <h1>Refund Request Denied</h1>
        </div>

        <div class="content">
            <div class="alert-box">
                <strong>⚠️ Notice:</strong> Your refund request for Booking #{{ $booking->id }} has been denied by our staff.
            </div>

            <p>Dear {{ $booking->user->name ?? 'Valued Client' }},</p>

            <p>We regret to inform you that your refund request has been denied after careful review by our staff.</p>

            <div class="booking-details">
                <h3>📋 Booking Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">#{{ $booking->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Branch:</span>
                    <span class="detail-value">{{ $booking->branch->name ?? 'N/A' }}</span>
                </div>

                @php
                    $purchasedServices = $booking->purchasedServices()->with('service')->get();
                @endphp

                @if($purchasedServices->count() > 1)
                <div class="detail-row">
                    <span class="detail-label">Services:</span>
                    <span class="detail-value">
                        @foreach($purchasedServices as $ps)
                            {{ $ps->service->name }}@if(!$loop->last), @endif
                        @endforeach
                    </span>
                </div>
                @elseif($purchasedServices->count() === 1)
                <div class="detail-row">
                    <span class="detail-label">Service:</span>
                    <span class="detail-value">{{ $purchasedServices->first()->service->name }}</span>
                </div>
                @else
                <div class="detail-row">
                    <span class="detail-label">Service:</span>
                    <span class="detail-value">{{ $booking->service->name ?? $booking->package->name ?? 'N/A' }}</span>
                </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Appointment Date:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->date)->format('F d, Y') }}</span>
                </div>
            </div>

            <p><strong>Common reasons for refund denial:</strong></p>
            <ul>
                <li>One or more sessions have already been completed</li>
                <li>Booking is within 24 hours of the appointment</li>
                <li>Service has already been partially rendered</li>
                <li>Outside of refund policy timeframe</li>
            </ul>

            <p><strong>What happens next?</strong></p>
            <p>Your booking remains active. If you have questions or would like to discuss this decision, please contact our branch directly.</p>

            <div style="text-align: center;">
                <a href="tel:{{ $booking->branch->contact_number ?? '' }}" class="cta-button">
                    📞 Contact Branch
                </a>
            </div>
        </div>

        <div class="footer">
            <p><strong>Skin911</strong> - Your Skin Care Partner</p>
            <p>{{ $booking->branch->address ?? '' }}</p>
            <p>Phone: {{ $booking->branch->contact_number ?? 'N/A' }}</p>
            <p style="margin-top: 15px; font-size: 11px;">
                This is an automated email. Please do not reply directly to this message.
            </p>
        </div>
    </div>
</body>
</html>
