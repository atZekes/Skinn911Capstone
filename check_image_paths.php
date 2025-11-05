<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DATABASE IMAGE PATHS CHECK ===\n\n";

$services = \App\Models\Service::take(10)->get(['id', 'name', 'image']);

foreach ($services as $service) {
    echo sprintf("ID: %d | %s\n", $service->id, $service->name);
    echo "  DB Path: {$service->image}\n";
    echo "  asset() would generate: " . asset($service->image) . "\n";
    echo "  Full path on disk: " . public_path($service->image) . "\n";
    echo "  Exists locally: " . (file_exists(public_path($service->image)) ? 'YES' : 'NO') . "\n";
    echo "\n";
}

echo "\n=== APP_URL Configuration ===\n";
echo "APP_URL: " . config('app.url') . "\n";
echo "APP_ENV: " . config('app.env') . "\n";
