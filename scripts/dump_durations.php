<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;
use Illuminate\Support\Facades\DB;

echo "Services:\n";
foreach (Service::all() as $s) {
    $dur = $s->duration ?? '(null)';
    echo "Service id={$s->id} name={$s->name} duration={$dur}\n";
}

echo "\nBranch pivot rows:\n";
$rows = DB::table('branch_service')->get();
foreach ($rows as $r) {
    $dur = property_exists($r, 'duration') ? ($r->duration ?? '(null)') : '(no-column)';
    echo "branch_id={$r->branch_id} service_id={$r->service_id} duration={$dur}\n";
}
