<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add package_booking_id to bookings table
     * Links individual scheduled sessions to their parent package
     * NULL = standalone single session booking
     * NOT NULL = part of multi-session package
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('package_booking_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('package_bookings')
                  ->onDelete('cascade');

            $table->index('package_booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['package_booking_id']);
            $table->dropColumn('package_booking_id');
        });
    }
};
