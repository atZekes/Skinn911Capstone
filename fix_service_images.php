<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATING SERVICE IMAGES TO USE PROPER TREATMENT IMAGES ===\n\n";

// Map of service names to their proper image files
$serviceImageMap = [
    'Skin911 Complete Facial' => 'img/services/Skin911 Complete Facial.jpg',
    'Diamond Peel with complete facial' => 'img/services/Diamond Peel with complete facial.jpg',
    'Hydrafacial' => 'img/services/HydraFacial.jpg',
    'Wart removal (face and neck)' => 'img/services/Wart removal (face and neck).jpg',
    'Microneedling' => 'img/services/Acne Treatment.jpg',  // Using Acne Treatment as closest match
    'Skin Rejuvenation Laser + Facial' => 'img/services/Skin Rejuvenation Laser + Facial.jpg',
    'Pigmentation Laser + Facial' => 'img/services/Skin Rejuvenation Laser + Facial.jpg',  // Using same as rejuvenation
    'Acne laser + Acne Facial' => 'img/services/Acne laser + Acne Facial.jpg',
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
    // Laser Hair Removal - use Underarm whitening as a good visual
    'Bikini' => 'img/services/Underarm whitening.jpg',
    'Full Brazilian' => 'img/services/Underarm whitening.jpg',
    'Mustache' => 'img/services/Underarm whitening.jpg',
    'Beard' => 'img/services/Underarm whitening.jpg',
    'Mustache & Beard' => 'img/services/Underarm whitening.jpg',
    'Half Legs' => 'img/services/Underarm whitening.jpg',
    'Full Legs' => 'img/services/Underarm whitening.jpg',
    'Full Arms' => 'img/services/Underarm whitening.jpg',
    'Full Face' => 'img/services/Underarm whitening.jpg',
    'Chest/Back' => 'img/services/Underarm whitening.jpg',
];

$updated = 0;
$skipped = 0;

foreach ($serviceImageMap as $serviceName => $properImage) {
    // Check if the image file exists
    if (!file_exists(public_path($properImage))) {
        echo "⚠ Image not found for {$serviceName}: {$properImage}\n";
        continue;
    }
    
    // Find all services with this name
    $services = \App\Models\Service::where('name', $serviceName)->get();
    
    foreach ($services as $service) {
        $oldImage = $service->image;
        
        // Only update if currently using generic placeholder
        if (strpos($oldImage, 'skin1.jpg') !== false || 
            strpos($oldImage, 'skin2.jpg') !== false || 
            strpos($oldImage, 'skin3.jpg') !== false || 
            strpos($oldImage, 'skin4.jpg') !== false || 
            strpos($oldImage, 'skin5.jpg') !== false ||
            $oldImage !== $properImage) {
            
            $service->image = $properImage;
            $service->save();
            
            echo "✓ Updated: {$serviceName} (ID: {$service->id})\n";
            echo "  From: {$oldImage}\n";
            echo "  To:   {$properImage}\n\n";
            $updated++;
        } else {
            $skipped++;
        }
    }
}

// For laser hair removal services without specific images, use a generic laser hair removal image
$laserHairServices = [
    'Bikini', 'Full Brazilian', 'Mustache', 'Beard', 'Mustache & Beard',
    'Half Legs', 'Full Legs', 'Full Arms', 'Full Face', 'Chest/Back'
];

$genericLaserImage = 'img/services/Laser Hair Removal.jpg';

// If generic laser image doesn't exist, we'll leave them as is
if (file_exists(public_path($genericLaserImage))) {
    foreach ($laserHairServices as $serviceName) {
        $services = \App\Models\Service::where('name', $serviceName)
            ->where('category', 'Laser Hair Removal')
            ->get();
        
        foreach ($services as $service) {
            $oldImage = $service->image;
            if (strpos($oldImage, 'skin') !== false) {
                $service->image = $genericLaserImage;
                $service->save();
                echo "✓ Updated laser service: {$serviceName} (ID: {$service->id})\n";
                $updated++;
            }
        }
    }
} else {
    echo "\n⚠ Generic laser hair removal image not found: {$genericLaserImage}\n";
    echo "Laser hair removal services will keep their current placeholder images.\n";
}

echo "\n=== SUMMARY ===\n";
echo "Services updated: {$updated}\n";
echo "Services skipped: {$skipped}\n";
echo "\nDone! You should now see proper treatment-specific images.\n";
