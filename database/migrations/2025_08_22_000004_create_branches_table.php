<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('location_detail')->nullable();
            $table->text('hours')->nullable();
            $table->text('map_src')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('branches');
    }
};
