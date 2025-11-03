<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;

echo "Checking services with images but missing treatment_details...\n";
echo str_repeat("=", 60) . "\n\n";

// Services with images but no treatment_details
$servicesWithImageButNoDetails = Service::whereNotNull('image')
    ->where('image', '!=', '')
    ->whereNull('treatment_details')
    ->orWhere('treatment_details', '')
    ->get();

if ($servicesWithImageButNoDetails->count() > 0) {
    echo "⚠️  Found " . $servicesWithImageButNoDetails->count() . " services with images but no treatment details:\n";
    echo str_repeat("-", 60) . "\n";

    $grouped = $servicesWithImageButNoDetails->groupBy('name');

    foreach ($grouped as $name => $services) {
        echo "\n{$name} ({$services->count()} instances)\n";
        echo "  Image: {$services->first()->image}\n";
        echo "  IDs: " . $services->pluck('id')->implode(', ') . "\n";
    }

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "These services won't show on the services page because\n";
    echo "the blade template filters for: whereNotNull('treatment_details')\n";
} else {
    echo "✅ All services with images have treatment details!\n";
}

echo "\n";
