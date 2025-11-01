<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUserNullableAndAddIsWalkinToBookings extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            // add is_walkin flag
            if (! Schema::hasColumn('bookings', 'is_walkin')) {
                $table->boolean('is_walkin')->default(false)->after('user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // drop is_walkin
            if (Schema::hasColumn('bookings', 'is_walkin')) {
                $table->dropColumn('is_walkin');
            }
            // revert user_id to not nullable (may fail if nulls exist)
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
}
