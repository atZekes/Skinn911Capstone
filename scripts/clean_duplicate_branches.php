<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Branch;

// Initialize Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Scanning for duplicate branches...\n";

// Find duplicates by name
$duplicates = DB::table('branches')
    ->select('name', DB::raw('COUNT(*) as count'), DB::raw('GROUP_CONCAT(id ORDER BY id) as ids'))
    ->groupBy('name')
    ->having('count', '>', 1)
    ->get();

if ($duplicates->count() > 0) {
    echo "Found " . $duplicates->count() . " sets of duplicate branch names:\n\n";

    foreach ($duplicates as $duplicate) {
        $ids = explode(',', $duplicate->ids);
        echo "Branch name: '{$duplicate->name}'\n";
        echo "Appears {$duplicate->count} times with IDs: " . implode(', ', $ids) . "\n";

        // Keep the first (oldest) branch, remove the rest
        $keepId = array_shift($ids); // Remove and get the first ID
        $removeIds = $ids; // Remaining IDs to remove

        echo "Keeping branch ID: {$keepId}\n";
        echo "Removing branch IDs: " . implode(', ', $removeIds) . "\n";

        // Remove duplicates
        foreach ($removeIds as $removeId) {
            try {
                $branch = Branch::find($removeId);
                if ($branch) {
                    echo "Deleting branch ID {$removeId}: '{$branch->name}'\n";
                    $branch->delete();
                }
            } catch (Exception $e) {
                echo "Error deleting branch ID {$removeId}: " . $e->getMessage() . "\n";
            }
        }
        echo "\n";
    }

    echo "Duplicate cleanup completed!\n";
} else {
    echo "No duplicate branch names found.\n";
}

// Show final count
$totalBranches = Branch::count();
echo "Total branches remaining: {$totalBranches}\n";

// Show all branches
echo "\nCurrent branches:\n";
$branches = Branch::orderBy('id')->get();
foreach ($branches as $branch) {
    echo "ID: {$branch->id} - Name: '{$branch->name}' - Key: '{$branch->key}'\n";
}
