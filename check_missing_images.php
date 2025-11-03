<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;

echo "Checking for missing or broken service images...\n";
echo str_repeat("=", 60) . "\n\n";

$services = Service::select('id', 'name', 'image')
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->get();

$missing = [];
$found = [];

foreach ($services as $service) {
    $imagePath = public_path($service->image);

    if (!file_exists($imagePath)) {
        $missing[] = [
            'id' => $service->id,
            'name' => $service->name,
            'image' => $service->image,
            'expected_path' => $imagePath
        ];
    } else {
        $found[] = $service->name;
    }
}

if (count($missing) > 0) {
    echo "❌ MISSING IMAGES (" . count($missing) . " issues found):\n";
    echo str_repeat("-", 60) . "\n";

    foreach ($missing as $item) {
        echo "\nService: {$item['name']} (ID: {$item['id']})\n";
        echo "Expected: {$item['image']}\n";
        echo "Full path: {$item['expected_path']}\n";
    }

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "Looking for similar files in public/img/services/...\n\n";

    // List all actual files in the services directory
    $servicesDir = public_path('img/services');
    if (is_dir($servicesDir)) {
        $files = scandir($servicesDir);
        echo "Available files:\n";
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                echo "  - {$file}\n";
            }
        }
    }
} else {
    echo "✅ All service images exist and are accessible!\n";
    echo "Total services checked: " . count($services) . "\n";
}

echo "\n";
