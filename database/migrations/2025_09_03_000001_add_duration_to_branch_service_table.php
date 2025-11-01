<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToBranchServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('branch_service') && ! Schema::hasColumn('branch_service', 'duration')) {
            Schema::table('branch_service', function (Blueprint $table) {
                $table->integer('duration')->nullable()->after('price');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('branch_service') && Schema::hasColumn('branch_service', 'duration')) {
            Schema::table('branch_service', function (Blueprint $table) {
                $table->dropColumn('duration');
            });
        }
    }
}
