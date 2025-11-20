<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['service_id']);

            // Make service_id nullable
            $table->unsignedBigInteger('service_id')->nullable()->change();

            // Re-add the foreign key
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign(['service_id']);

            // Make service_id not nullable
            $table->unsignedBigInteger('service_id')->nullable(false)->change();

            // Re-add the foreign key
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }
};
