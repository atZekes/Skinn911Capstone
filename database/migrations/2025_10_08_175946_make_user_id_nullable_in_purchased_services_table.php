<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchased_services', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['user_id']);

            // Make user_id nullable for walk-in bookings
            $table->foreignId('user_id')->nullable()->change()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchased_services', function (Blueprint $table) {
            // Remove nullable constraint and restore NOT NULL
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->change()->constrained('users')->onDelete('cascade');
        });
    }
};
