<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreakColumnsToBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds nullable time columns for branch breaks so admins can set a daily break period.
     */
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            if (!Schema::hasColumn('branches', 'break_start')) {
                $table->time('break_start')->nullable()->after('time_slot');
            }
            if (!Schema::hasColumn('branches', 'break_end')) {
                $table->time('break_end')->nullable()->after('break_start');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            if (Schema::hasColumn('branches', 'break_start')) {
                $table->dropColumn('break_start');
            }
            if (Schema::hasColumn('branches', 'break_end')) {
                $table->dropColumn('break_end');
            }
        });
    }
}
