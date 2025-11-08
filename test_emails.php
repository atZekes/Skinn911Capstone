<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Booking;
use App\Mail\BookingCancellation;
use App\Mail\BookingRefund;
use App\Mail\BookingRefundConfirmed;
use App\Mail\BookingReschedule;
use Illuminate\Support\Facades\Mail;

// Test email functionality
echo "Testing Email Notifications for Skin911\n";
echo "=======================================\n\n";

// Get a test booking with proper relationships
$booking = Booking::with(['user', 'service', 'branch'])
    ->whereNotNull('user_id')
    ->whereHas('user')
    ->first();

if (!$booking) {
    echo "❌ No bookings with valid user relationships found in database. Please create a test booking first.\n";
    exit(1);
}

echo "✅ Found test booking:\n";
echo "   ID: {$booking->id}\n";
echo "   User: {$booking->user->name} ({$booking->user->email})\n";
echo "   Service: " . ($booking->service->name ?? 'N/A') . "\n";
echo "   Branch: " . ($booking->branch->name ?? 'N/A') . "\n";
echo "   Status: {$booking->status}\n";
echo "   Payment Status: {$booking->payment_status}\n\n";

// Test 1: Booking Cancellation Email
echo "🧪 Testing Booking Cancellation Email...\n";
try {
    Mail::to($booking->user->email)->send(new BookingCancellation($booking));
    echo "✅ Cancellation email sent successfully!\n";
} catch (Exception $e) {
    echo "❌ Cancellation email failed: {$e->getMessage()}\n";
}

// Test 2: Booking Refund Email
echo "\n🧪 Testing Booking Refund Email...\n";
try {
    Mail::to($booking->user->email)->send(new BookingRefund($booking));
    echo "✅ Refund email sent successfully!\n";
} catch (Exception $e) {
    echo "❌ Refund email failed: {$e->getMessage()}\n";
}

// Test 3: Booking Refund Confirmed Email
echo "\n🧪 Testing Booking Refund Confirmed Email...\n";
try {
    Mail::to($booking->user->email)->send(new BookingRefundConfirmed($booking));
    echo "✅ Refund confirmed email sent successfully!\n";
} catch (Exception $e) {
    echo "❌ Refund confirmed email failed: {$e->getMessage()}\n";
}

// Test 4: Booking Reschedule Email
echo "\n🧪 Testing Booking Reschedule Email...\n";
try {
    Mail::to($booking->user->email)->send(new BookingReschedule($booking));
    echo "✅ Reschedule email sent successfully!\n";
} catch (Exception $e) {
    echo "❌ Reschedule email failed: {$e->getMessage()}\n";
}

echo "\n🎉 Email testing complete!\n";
echo "📧 Check your email inbox for the test messages.\n";
echo "📝 Note: If using Gmail, check the 'Spam' folder as well.\n";
