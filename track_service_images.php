<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$services = \App\Models\Service::all();

echo "=== SERVICE IMAGES TRACKING REPORT ===\n\n";
echo "Total Services: " . $services->count() . "\n";
echo "Services with images: " . $services->whereNotNull('image')->count() . "\n";
echo "Services without images: " . $services->whereNull('image')->count() . "\n\n";

echo "=== SERVICES WITHOUT IMAGES ===\n";
foreach ($services->whereNull('image') as $service) {
    echo sprintf("ID: %d | %s | Category: %s\n", $service->id, $service->name, $service->category);
}

echo "\n=== SERVICES WITH IMAGES ===\n";
foreach ($services->whereNotNull('image') as $service) {
    $imagePath = public_path($service->image);
    $exists = file_exists($imagePath) ? '✓' : '✗';
    echo sprintf("%s ID: %d | %s | Image: %s\n", $exists, $service->id, $service->name, $service->image);
}

echo "\n=== MISSING IMAGE FILES (DB has path but file doesn't exist) ===\n";
foreach ($services->whereNotNull('image') as $service) {
    $imagePath = public_path($service->image);
    if (!file_exists($imagePath)) {
        echo sprintf("ID: %d | %s | Missing: %s\n", $service->id, $service->name, $service->image);
    }
}
