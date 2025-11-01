<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Branch;

$branches = Branch::all();
if ($branches->isEmpty()) {
    echo "No branches found\n";
    exit(0);
}

foreach ($branches as $b) {
    $id = $b->id;
    $ts = $b->time_slot ?? '[null]';
    $bs = $b->break_start ?? '[null]';
    $be = $b->break_end ?? '[null]';
    echo "ID:{$id} time_slot:{$ts} break_start:{$bs} break_end:{$be}\n";
}

return 0;
