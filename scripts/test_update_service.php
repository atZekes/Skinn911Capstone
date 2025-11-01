<?php
// Boot Laravel and simulate calling Admincontroller::updateService with branch_id and duration
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Admincontroller;

$controller = new Admincontroller();

// simulate request: set serviceId 1 and branch 1 with duration 2
$r = Request::create('/dummy', 'POST', ['branch_id' => 1, 'duration' => 2, 'price' => 1000, 'name' => 'Test Service Update']);
try {
    $response = $controller->updateService($r, 1);
    echo "Controller run finished.\n";
} catch (Exception $e) {
    echo "Controller run failed: " . $e->getMessage() . "\n";
}
