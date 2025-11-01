<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking GCash QR Codes in Branches:\n";
echo "=====================================\n\n";

$branches = \App\Models\Branch::all();

foreach ($branches as $branch) {
    echo "Branch ID: {$branch->id}\n";
    echo "Branch Name: {$branch->name}\n";
    echo "GCash Number: " . ($branch->gcash_number ?? 'Not set') . "\n";
    echo "GCash QR Path: " . ($branch->gcash_qr ?? 'Not set') . "\n";

    if ($branch->gcash_qr) {
        $fullPath = public_path($branch->gcash_qr);
        echo "Full Path: {$fullPath}\n";
        echo "File Exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
        echo "Asset URL: " . asset($branch->gcash_qr) . "\n";
    }

    echo "\n---\n\n";
}
