<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Get a test user
    $user = \App\Models\User::where('role', 'client')->first();

    if (!$user) {
        echo "No client user found. Please create a test user first.\n";
        exit(1);
    }

    echo "Sending test notifications to user: {$user->name} (ID: {$user->id})\n\n";

    // Send multiple test notifications
    $notifications = [
        [
            'title' => 'Booking Confirmed',
            'message' => 'Your appointment for Facial Treatment has been confirmed for tomorrow at 2:00 PM.',
            'type' => 'success'
        ],
        [
            'title' => 'Payment Reminder',
            'message' => 'Your payment of ₱1,500 is due. Please complete your payment to secure your booking.',
            'type' => 'warning'
        ],
        [
            'title' => 'New Message',
            'message' => 'You have received a new message from Skin911 staff regarding your upcoming appointment.',
            'type' => 'info'
        ],
        [
            'title' => 'Appointment Reminder',
            'message' => 'Your appointment is scheduled for today at 3:00 PM. Please arrive 15 minutes early.',
            'type' => 'info'
        ]
    ];

    foreach ($notifications as $i => $notification) {
        // Send notification using Pusher directly
        $pusher = new \Pusher\Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER')]
        );

        $pusher->trigger('user-' . $user->id, 'notification', [
            'title' => $notification['title'],
            'message' => $notification['message'],
            'type' => $notification['type'],
            'icon' => asset('img/skinlogo.png')
        ]);

        echo "✓ Sent notification " . ($i + 1) . ": {$notification['title']}\n";
        sleep(1); // Small delay between notifications
    }

    echo "\n✅ All test notifications sent successfully!\n";
    echo "📱 Check your browser/mobile device for the notifications.\n";
    echo "🔔 Click the bell icon in the header to view the notification sidebar.\n";
    echo "📊 The notification badge should show the unread count.\n";

} catch (Exception $e) {
    echo "❌ Error sending notifications: " . $e->getMessage() . "\n";
}
