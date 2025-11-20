<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable()->after('id');
            // If you want to add a foreign key constraint:
            // $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('set null');
        });
    }

    public function down() {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('booking_id');
        });
    }
};
