<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;

echo "Updating remaining services with generic images...\n\n";

// Get all services that don't have images yet
$servicesWithoutImages = Service::whereNull('image')
    ->orWhere('image', '')
    ->get();

echo "Found {$servicesWithoutImages->count()} services without images.\n\n";

// Generic beauty/spa images for services without specific images
$genericImages = [
    'img/services/skin1.jpg',
    'img/services/skin2.jpg',
    'img/services/skin3.jpg',
    'img/services/skin4.jpg',
    'img/services/skin5.jpg',
];

$updated = 0;
$imageIndex = 0;

foreach ($servicesWithoutImages as $service) {
    // Assign a generic image in rotation
    $service->image = $genericImages[$imageIndex % count($genericImages)];
    $service->save();

    echo "✓ Updated: {$service->name} (ID: {$service->id}) -> {$service->image}\n";
    $updated++;
    $imageIndex++;
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "Summary:\n";
echo "- Services updated with generic images: {$updated}\n";
echo "\n✅ Done! All services now have images.\n";
