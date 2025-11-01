<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('branches', 'active')) {
            Schema::table('branches', function (Blueprint $table) {
                $table->boolean('active')->default(true);
            });
            // Ensure existing rows are marked active
            DB::table('branches')->update(['active' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('branches', 'active')) {
            Schema::table('branches', function (Blueprint $table) {
                $table->dropColumn('active');
            });
        }
    }
};
