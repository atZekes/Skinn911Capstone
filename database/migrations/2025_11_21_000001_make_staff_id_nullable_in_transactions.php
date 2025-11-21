<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('transactions', function (Blueprint $table) {
            // Make staff_id nullable
            $table->unsignedBigInteger('staff_id')->nullable()->change();
            // Drop old foreign key
            $table->dropForeign(['staff_id']);
            // Add new foreign key with ON DELETE SET NULL
            $table->foreign('staff_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down() {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->unsignedBigInteger('staff_id')->nullable(false)->change();
            $table->foreign('staff_id')
                ->references('id')->on('users');
        });
    }
};
