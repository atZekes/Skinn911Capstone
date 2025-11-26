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
        Schema::table('purchased_services', function (Blueprint $table) {
            if (!Schema::hasColumn('purchased_services', 'promo_code')) {
                $table->string('promo_code')->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchased_services', function (Blueprint $table) {
            $table->dropColumn('promo_code');
        });
    }
};
