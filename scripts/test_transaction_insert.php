<?php
// scripts/test_transaction_insert.php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

if (!function_exists('app')) {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
}

header('Content-Type: text/plain');

try {
    $id = DB::table('transactions')->insertGetId([
        'booking_id' => 99999, // test value
        'service_id' => 1,
        'package_id' => 1,
        'branch_id' => 1,
        // staff_id removed
        'amount' => 123.45,
        'payment_method' => 'test',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "✅ Test transaction inserted (ID: $id)\n";
    Log::info('Test transaction inserted', ['id' => $id]);
    // Clean up
    DB::table('transactions')->where('id', $id)->delete();
    echo "✅ Test transaction deleted\n";
} catch (Exception $e) {
    echo "❌ Failed to insert transaction: " . $e->getMessage() . "\n";
    Log::error('Test transaction insert failed', ['error' => $e->getMessage()]);
}

echo "Check storage/logs/laravel.log for details.\n";
