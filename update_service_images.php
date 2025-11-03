<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Service;

// Mapping of service names to their specific image files
$imageMapping = [
    'Skin911 Complete Facial' => 'img/services/Skin911 Complete Facial.jpg',
    'Diamond Peel with complete facial' => 'img/services/Diamond Peel with complete facial.jpg',
    'Hydrafacial' => 'img/services/HydraFacial.jpg',
    'Wart removal (face and neck)' => 'img/services/Wart removal (face and neck).jpg',
    'Skin Rejuvenation Laser + Facial' => 'img/services/Skin Rejuvenation Laser + Facial.jpg',
    'Acne laser + Acne Facial' => 'img/services/skin5.jpg',
    'HIFU Ultralift' => 'img/services/HIFU Ultralift.jpg',
    'Immuno gold + Vitamin C' => 'img/services/Immuno Gold + Vitamin C Treatment.jpg',
    'Elea White Drip' => 'img/services/Elea White Treatment.jpg',
    'Cindella Drip' => 'img/services/Cinderella Drip Treatment.jpg',
    'Luminous White Drip' => 'img/services/Luminous White Drip Treatment.jpg',
    'Collagen Injection' => 'img/services/Collagen Injection.jpg',
    'Placenta Injection' => 'img/services/Placenta Injection.jpg',
    'Radio frequency RF' => 'img/services/Radio frequency RF.jpg',
    'Lipo Cavitation + RF' => 'img/services/Lipo Cavitation + RF.jpg',
    'Lipo-cavitation' => 'img/services/Lipo-cavitation.jpg',
    'Diode Lipo Laser' => 'img/services/Diode Lipo Laser.jpg',
    'TRIO slim' => 'img/services/TRIO slim.jpg',
    'Underarms' => 'img/services/Underarm whitening.jpg',
    'Complete Facial' => 'img/services/Complete Facial.jpg',
    'Diamond peel' => 'img/services/Diamond peel.jpg',
    'Acne Treatment' => 'img/services/Acne Treatment.jpg',
    'HIFU' => 'img/services/HIFU.jpg',
];

echo "Starting to update service images...\n\n";

$updated = 0;
$notFound = [];

foreach ($imageMapping as $serviceName => $imagePath) {
    // Find all services with this name (across all branches)
    $services = Service::where('name', $serviceName)->get();

    if ($services->count() > 0) {
        foreach ($services as $service) {
            $service->image = $imagePath;
            $service->save();
            echo "✓ Updated: {$serviceName} (ID: {$service->id}) -> {$imagePath}\n";
            $updated++;
        }
    } else {
        $notFound[] = $serviceName;
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "Summary:\n";
echo "- Total services updated: {$updated}\n";

if (count($notFound) > 0) {
    echo "\nServices not found in database:\n";
    foreach ($notFound as $name) {
        echo "  - {$name}\n";
    }
}

echo "\n✅ Done!\n";
