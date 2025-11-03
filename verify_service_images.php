<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;

echo "Service Images Verification\n";
echo str_repeat("=", 60) . "\n\n";

// Count services without images
$withoutImages = Service::whereNull('image')->orWhere('image', '')->count();
$withImages = Service::whereNotNull('image')->where('image', '!=', '')->count();
$total = Service::count();

echo "Total Services: {$total}\n";
echo "With Images: {$withImages}\n";
echo "Without Images: {$withoutImages}\n\n";

// Show sample of services with specific images
echo "Sample of services with their images:\n";
echo str_repeat("-", 60) . "\n";

$samples = Service::select('id', 'name', 'image')
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->distinct('name')
    ->take(15)
    ->get();

foreach ($samples as $service) {
    $status = file_exists(public_path($service->image)) ? '✓' : '✗';
    echo "{$status} {$service->name}\n";
    echo "   → {$service->image}\n\n";
}

echo "\n✅ Verification complete!\n";
