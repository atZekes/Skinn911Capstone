<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('purchased_services', function (Blueprint $table) {
            $table->foreignId('booking_id')->nullable()->after('service_id')->constrained('bookings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('purchased_services', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn('booking_id');
        });
    }
};
