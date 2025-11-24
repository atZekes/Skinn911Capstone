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
        Schema::table('promos', function (Blueprint $table) {
            $table->integer('quantity_available')->default(0)->after('image'); // 0 means unlimited
            $table->integer('max_claims_per_user')->default(1)->after('quantity_available'); // how many times a user can claim this promo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropColumn(['quantity_available', 'max_claims_per_user']);
        });
    }
};
