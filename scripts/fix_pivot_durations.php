<?php
// Boot Laravel and fix pivot durations where NULL by copying from services.duration (fallback to 1)
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Service;

echo "Fixing NULL pivot durations by copying from services.duration (fallback 1)\n";
$updated = 0;
$rows = DB::table('branch_service')->whereNull('duration')->get();
foreach ($rows as $r) {
    $s = Service::find($r->service_id);
    $d = ($s && $s->duration) ? $s->duration : 1;
    DB::table('branch_service')->where('branch_id', $r->branch_id)->where('service_id', $r->service_id)->update(['duration' => $d, 'updated_at' => now()]);
    $updated++;
}

echo "Updated {$updated} pivot rows.\n";

// Ensure services.duration not null
$supdated = 0;
$services = Service::whereNull('duration')->get();
foreach ($services as $s) {
    $s->duration = 1;
    $s->save();
    $supdated++;
}
echo "Updated {$supdated} service rows to duration=1.\n";

echo "Done.\n";
