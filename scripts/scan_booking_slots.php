<?php

use Illuminate\Support\Carbon;
use App\Models\Booking;

// Bootstrap Laravel
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Scan next 30 days
$dates = [];
for ($i = 0; $i < 31; $i++) {
    $dates[] = Carbon::now()->addDays($i)->format('Y-m-d');
}

$bookings = Booking::whereIn('date', $dates)->get();

$invalidFormat = [];
$overlaps = [];
$activeBookings = [];

foreach ($bookings as $b) {
    // Check time_slot format
    if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $b->time_slot)) {
        $invalidFormat[] = $b;
    }
    // Collect active bookings for overlap check
    if ($b->status === 'active') {
        $activeBookings[] = $b;
    }
}

// Check for overlaps
foreach ($activeBookings as $i => $b1) {
    [$start1, $end1] = explode('-', $b1->time_slot);
    $start1 = Carbon::createFromFormat('H:i', $start1);
    $end1 = Carbon::createFromFormat('H:i', $end1);
    foreach ($activeBookings as $j => $b2) {
        if ($i === $j || $b1->date !== $b2->date || $b1->branch_id !== $b2->branch_id) continue;
        [$start2, $end2] = explode('-', $b2->time_slot);
        $start2 = Carbon::createFromFormat('H:i', $start2);
        $end2 = Carbon::createFromFormat('H:i', $end2);
        if ($start1 < $end2 && $end1 > $start2) {
            $overlaps[] = [$b1, $b2];
        }
    }
}

// Output results
function printBooking($b) {
    echo "ID: {$b->id}, Date: {$b->date}, Slot: {$b->time_slot}, Branch: {$b->branch_id}, Status: {$b->status}, Walk-in: {$b->walkin_name}, User: {$b->user_id}\n";
}

echo "==== Invalid time_slot format ====" . PHP_EOL;
foreach ($invalidFormat as $b) {
    printBooking($b);
}

echo "\n==== Overlapping active bookings ====" . PHP_EOL;
foreach ($overlaps as [$b1, $b2]) {
    printBooking($b1);
    printBooking($b2);
    echo "---" . PHP_EOL;
}

echo "\n==== All active bookings for next 30 days ====" . PHP_EOL;
foreach ($activeBookings as $b) {
    printBooking($b);
}

echo "\nScan complete." . PHP_EOL;
