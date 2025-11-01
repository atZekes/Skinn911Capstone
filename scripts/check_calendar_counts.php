<?php
// Recreate calendar occupyingCount logic for a branch and date and print per-slot counts
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use App\Models\Branch;
use Carbon\Carbon;

$branchId = $argv[1] ?? null;
$date = $argv[2] ?? null;
if (! $branchId || ! $date) {
    echo "Usage: php check_calendar_counts.php <branch_id> <YYYY-MM-DD>\n";
    exit(1);
}
$branch = Branch::with('services')->find($branchId);
if (! $branch) {
    echo "Branch $branchId not found\n";
    exit(1);
}
$defaultSlots = ["09:00-10:00","10:00-11:00","11:00-12:00","12:00-13:00","13:00-14:00","14:00-15:00","15:00-16:00","16:00-17:00","17:00-18:00"];
$slots = $defaultSlots;
if ($branch->time_slot && strpos($branch->time_slot, ' - ') !== false) {
    try {
        [$bs,$be] = explode(' - ', $branch->time_slot, 2);
        $startRange = Carbon::createFromFormat('H:i', $bs);
        $endRange = Carbon::createFromFormat('H:i', $be);
        $slots = [];
        for ($t = $startRange->copy(); $t->lt($endRange); $t->addHour()) {
            $slotStart = $t->format('H:i');
            $slotEnd = $t->copy()->addHour()->format('H:i');
            if (Carbon::createFromFormat('H:i', $slotEnd)->lte($endRange)) {
                $slots[] = $slotStart . '-' . $slotEnd;
            }
        }
    } catch (Exception $e) { /* use defaults */ }
}

// build branch durations map
$branchDurations = [];
foreach ($branch->services as $s) { $branchDurations[$s->id] = $s->pivot->duration ?? null; }

$bookings = Booking::where('branch_id', $branchId)
    ->where('date', $date)
    ->where('status', 'active')
    ->with(['service','package.services'])
    ->get();

$occupyingCount = [];
foreach ($bookings as $b) {
    $dur = 1;
    if ($b->service) {
        $dur = $b->service->duration ?? 1;
        if (isset($branchDurations[$b->service->id]) && $branchDurations[$b->service->id]) $dur = $branchDurations[$b->service->id];
    } elseif ($b->package) {
        $dur = 0;
        foreach ($b->package->services as $ps) {
            $pd = $ps->duration ?? 1;
            if (isset($branchDurations[$ps->id]) && $branchDurations[$ps->id]) $pd = $branchDurations[$ps->id];
            $dur += $pd;
        }
        if ($dur <= 0) $dur = 1;
    }
    try {
        [$ss,$se] = explode('-', $b->time_slot, 2);
        $startT = Carbon::createFromFormat('H:i', trim($ss));
        for ($k=0;$k<$dur;$k++) {
            $s = $startT->copy()->addHours($k);
            $e = $s->copy()->addHour();
            $slotLabel = $s->format('H:i') . '-' . $e->format('H:i');
            if (! isset($occupyingCount[$slotLabel])) $occupyingCount[$slotLabel] = 0;
            $occupyingCount[$slotLabel]++;
        }
    } catch (Exception $e) { }
}

echo "Branch $branchId date $date occupancy:\n";
foreach ($slots as $slot) {
    $occ = $occupyingCount[$slot] ?? 0;
    echo "$slot => $occ\n";
}
