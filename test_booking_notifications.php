<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel environment
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Get a test client user
    $user = \App\Models\User::where('role', 'client')->first();

    if (!$user) {
        echo "No client user found. Please create a test user first.\n";
        exit(1);
    }

    // Get or create a test booking
    $booking = \App\Models\Booking::where('user_id', $user->id)->first();

    if (!$booking) {
        echo "No booking found for user. Creating a test booking notification without booking_id.\n";
        $bookingId = null;
    } else {
        $bookingId = $booking->id;
        echo "Using booking ID: {$bookingId}\n";
    }

    echo "Testing notification persistence for user: {$user->name} (ID: {$user->id})\n\n";

    // Test 1: Booking Cancelled notification
    echo "Creating 'Booking Cancelled' notification...\n";
    \App\Models\Notification::create([
        'user_id' => $user->id,
        'title' => 'Booking Cancelled',
        'message' => 'Your booking has been cancelled by staff.',
        'type' => 'warning',
        'read' => false,
        'booking_id' => $bookingId,
        'data' => ['action' => 'cancelled']
    ]);
    echo "✓ Created\n\n";

    // Test 2: Booking Completed notification
    echo "Creating 'Booking Completed' notification...\n";
    \App\Models\Notification::create([
        'user_id' => $user->id,
        'title' => 'Booking Completed',
        'message' => 'Your booking has been completed successfully.',
        'type' => 'success',
        'read' => false,
        'booking_id' => $bookingId,
        'data' => ['action' => 'completed']
    ]);
    echo "✓ Created\n\n";

    // Test 3: Appointment Reminder notification
    echo "Creating 'Appointment Reminder' notification...\n";
    \App\Models\Notification::create([
        'user_id' => $user->id,
        'title' => 'Appointment Reminder',
        'message' => 'You have an upcoming appointment. Please check your email for details.',
        'type' => 'info',
        'read' => false,
        'booking_id' => $bookingId,
        'data' => ['action' => 'reminder']
    ]);
    echo "✓ Created\n\n";

    // Test 4: Refund Processed notification
    echo "Creating 'Refund Processed' notification...\n";
    \App\Models\Notification::create([
        'user_id' => $user->id,
        'title' => 'Refund Processed',
        'message' => 'Your refund has been processed successfully.',
        'type' => 'info',
        'read' => false,
        'booking_id' => $bookingId,
        'data' => ['action' => 'refund', 'amount' => 500.00]
    ]);
    echo "✓ Created\n\n";

    // Check total notifications
    $totalNotifications = \App\Models\Notification::where('user_id', $user->id)->count();
    $unreadNotifications = \App\Models\Notification::where('user_id', $user->id)
        ->where('read', false)
        ->count();

    echo "✅ All test booking notifications created successfully!\n";
    echo "📊 Total notifications for user: {$totalNotifications}\n";
    echo "📬 Unread notifications: {$unreadNotifications}\n";
    echo "🔔 These notifications will persist across page refreshes.\n";
    echo "💻 Refresh your browser to see them in the notification dropdown.\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
