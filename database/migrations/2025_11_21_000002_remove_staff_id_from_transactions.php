<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop foreign key first if exists
            $table->dropForeign(['staff_id']);
            // Remove staff_id column
            $table->dropColumn('staff_id');
        });
    }

    public function down() {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id')->nullable();
            // You may want to re-add the foreign key if needed
            // $table->foreign('staff_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};
