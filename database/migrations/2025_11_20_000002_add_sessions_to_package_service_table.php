<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('package_service', function (Blueprint $table) {
            $table->integer('sessions')->nullable()->after('quantity');
        });
    }
    public function down() {
        Schema::table('package_service', function (Blueprint $table) {
            $table->dropColumn('sessions');
        });
    }
};
