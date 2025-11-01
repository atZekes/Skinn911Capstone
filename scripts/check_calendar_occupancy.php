<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Branch;

$branchId = $argv[1] ?? 1;
$date = $argv[2] ?? Carbon::now()->addDay()->format('Y-m-d');
$branch = Branch::find($branchId);
if (! $branch) {
    echo "Branch {$branchId} not found\n";
    exit(1);
}
$default = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
$slots = $default;
if ($branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
    try {
        [$s,$e] = explode(' - ', $branch->time_slot, 2);
        $start = Carbon::createFromFormat('H:i', $s);
        $end = Carbon::createFromFormat('H:i', $e);
        $slots = [];
        for ($t = $start->copy(); $t->lt($end); $t->addHour()) {
            $slotStart = $t->format('H:i');
            $slotEnd = $t->copy()->addHour()->format('H:i');
            if (Carbon::createFromFormat('H:i', $slotEnd)->lte($end)) {
                $slots[] = $slotStart . '-' . $slotEnd;
            }
        }
    } catch (Exception $e) { $slots = $default; }
}
$max = $branch->slot_capacity ?? 5;

// compute occupancy including multi-hour coverage
$bookings = Booking::where('branch_id', $branchId)->where('date', $date)->where('status', 'active')->with(['service','package.services'])->get();
$occ = [];
foreach ($slots as $s) $occ[$s] = 0;
foreach ($bookings as $b) {
    $dur = 1;
    if ($b->service) $dur = $b->service->duration ?? 1;
    elseif ($b->package) {
        $dur = 0;
        foreach ($b->package->services as $ps) $dur += ($ps->duration ?? 1);
        if ($dur <= 0) $dur = 1;
    }
    try {
        [$ss,$se] = explode('-', $b->time_slot, 2);
        $startT = Carbon::createFromFormat('H:i', trim($ss));
        for ($k = 0; $k < $dur; $k++) {
            $sStart = $startT->copy()->addHours($k);
            $sEnd = $sStart->copy()->addHour();
            $slot = $sStart->format('H:i') . '-' . $sEnd->format('H:i');
            if (array_key_exists($slot, $occ)) $occ[$slot]++;
        }
    } catch (Exception $e) { }
}

$output = [];
foreach ($slots as $slot) {
    $output[$slot] = ['occupied' => $occ[$slot], 'available' => max(0, $max - $occ[$slot])];
}

echo "Branch: {$branch->id} - {$branch->name}\n";
echo "Date: {$date}\n";
echo json_encode($output, JSON_PRETTY_PRINT) . "\n";

return 0;
