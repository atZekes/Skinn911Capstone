<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$services = DB::table('services')
    ->select('name', 'category', 'image')
    ->whereNotNull('treatment_details')
    ->whereNotNull('image')
    ->distinct()
    ->orderBy('category')
    ->orderBy('name')
    ->get();

echo "=== ALL SERVICE NAMES AND THEIR CURRENT IMAGES ===\n\n";

$currentCategory = '';
foreach ($services as $service) {
    if ($currentCategory !== $service->category) {
        $currentCategory = $service->category;
        echo "\n--- {$currentCategory} ---\n";
    }
    
    $slug = strtolower(str_replace(' ', '-', $service->name));
    echo "Service: {$service->name}\n";
    echo "  Slug: '{$slug}'\n";
    echo "  Current Image: {$service->image}\n\n";
}
