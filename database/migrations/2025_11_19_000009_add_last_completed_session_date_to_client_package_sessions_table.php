<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastCompletedSessionDateToClientPackageSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('client_package_sessions', function (Blueprint $table) {
            $table->timestamp('last_completed_session_date')->nullable()->after('expiry_date');
        });
    }

    public function down()
    {
        Schema::table('client_package_sessions', function (Blueprint $table) {
            $table->dropColumn('last_completed_session_date');
        });
    }
}
