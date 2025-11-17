<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add default_sessions column to services table
     * This defines how many sessions a service package includes
     * Default = 1 (single session), can be increased for packages (e.g., 10 sessions)
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->integer('default_sessions')->default(1)->after('price');
            $table->boolean('is_package')->default(false)->after('default_sessions'); // Flag for multi-session packages
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['default_sessions', 'is_package']);
        });
    }
};
