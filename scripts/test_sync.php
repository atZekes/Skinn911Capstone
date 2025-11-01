<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Branch;
use Illuminate\Support\Facades\DB;

$branchId = 1;
$serviceId = 1;
$newDuration = 3;
$newPrice = 1234.56;

echo "Syncing branch_id={$branchId} service_id={$serviceId} duration={$newDuration} price={$newPrice}\n";
$branch = Branch::find($branchId);
if (!$branch) {
    echo "Branch not found\n";
    exit(1);
}

$sync = [
    $serviceId => ['price' => $newPrice, 'active' => 1, 'duration' => $newDuration, 'created_at' => now(), 'updated_at' => now()]
];

try {
    $branch->services()->syncWithoutDetaching($sync);
    $row = DB::table('branch_service')->where('branch_id', $branchId)->where('service_id', $serviceId)->first();
    echo "Pivot after sync: ";
    print_r($row);
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

echo "Done.\n";
