<?php
// scripts/check_transaction_debug.php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

// Bootstrap Laravel if not running in artisan context
if (!function_exists('app')) {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
}

header('Content-Type: text/plain');

try {
    // 1. Check DB connection
    DB::connection()->getPdo();
    echo "✅ Database connection: OK\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    Log::error('DB connection failed', ['error' => $e->getMessage()]);
    exit;
}

// 2. Check transactions table
if (Schema::hasTable('transactions')) {
    echo "✅ 'transactions' table exists\n";
    $columns = Schema::getColumnListing('transactions');
    $required = ['id', 'booking_id', 'service_id', 'package_id', 'branch_id', 'staff_id', 'amount', 'payment_method', 'created_at'];
    $missing = array_diff($required, $columns);
    if (empty($missing)) {
        echo "✅ All required columns exist\n";
    } else {
        echo "❌ Missing columns: " . implode(', ', $missing) . "\n";
        Log::error('Missing transaction columns', ['missing' => $missing]);
    }
} else {
    echo "❌ 'transactions' table does NOT exist\n";
    Log::error('Transactions table missing');
    exit;
}

// 3. Try to insert a test transaction
try {
    $id = DB::table('transactions')->insertGetId([
        'booking_id' => null,
        'service_id' => null,
        'package_id' => null,
        'branch_id' => null,
        'staff_id' => null,
        'amount' => 0,
        'payment_method' => 'test',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "✅ Test transaction inserted (ID: $id)\n";
    // Clean up
    DB::table('transactions')->where('id', $id)->delete();
} catch (Exception $e) {
    echo "❌ Failed to insert transaction: " . $e->getMessage() . "\n";
    Log::error('Transaction insert failed', ['error' => $e->getMessage()]);
}

// 4. Check permissions
function checkWritable($path) {
    return is_writable($path) ? "✅ $path is writable\n" : "❌ $path is NOT writable\n";
}
echo checkWritable(storage_path());
echo checkWritable(base_path('bootstrap/cache'));

echo "\nCheck storage/logs/laravel.log for details.\n";
