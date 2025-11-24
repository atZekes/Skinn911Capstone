<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promo_usages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('promo_id')->nullable(false);
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();

            // Indexes for quick lookups
            $table->index(['user_id', 'promo_id']);
            $table->index(['promo_id', 'service_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('promo_usages');
    }
};
