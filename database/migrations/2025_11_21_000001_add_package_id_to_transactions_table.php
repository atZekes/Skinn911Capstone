<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transactions', 'package_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('package_id')->nullable()->after('booking_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('transactions', 'package_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('package_id');
            });
        }
    }
};
