<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bookings')) return;

        // Make service_id nullable if column exists
        if (Schema::hasColumn('bookings', 'service_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->unsignedBigInteger('service_id')->nullable()->change();
            });
        }

        // Add package_id column if not exists
        if (!Schema::hasColumn('bookings', 'package_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->unsignedBigInteger('package_id')->nullable()->after('service_id');
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('bookings')) return;

        if (Schema::hasColumn('bookings', 'package_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropForeign(['package_id']);
                $table->dropColumn('package_id');
            });
        }

        if (Schema::hasColumn('bookings', 'service_id')) {
            // revert nullable to not nullable if possible
            Schema::table('bookings', function (Blueprint $table) {
                $table->unsignedBigInteger('service_id')->nullable(false)->change();
            });
        }
    }
};
