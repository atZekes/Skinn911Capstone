<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('client_package_sessions', function (Blueprint $table) {
            // Modify status enum to include 'expired', 'cancelled', 'refunded'
            DB::statement("ALTER TABLE client_package_sessions MODIFY COLUMN status ENUM('active', 'completed', 'cancelled', 'refunded', 'expired') DEFAULT 'active'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_package_sessions', function (Blueprint $table) {
            // Revert to original status enum
            DB::statement("ALTER TABLE client_package_sessions MODIFY COLUMN status ENUM('active', 'completed') DEFAULT 'active'");
        });
    }
};
