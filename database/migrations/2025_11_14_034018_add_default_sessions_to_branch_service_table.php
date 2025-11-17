<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add default_sessions to branch_service pivot table
     * This allows each branch to configure their own session count per service
     */
    public function up(): void
    {
        Schema::table('branch_service', function (Blueprint $table) {
            $table->integer('default_sessions')->default(1)->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_service', function (Blueprint $table) {
            $table->dropColumn('default_sessions');
        });
    }
};
