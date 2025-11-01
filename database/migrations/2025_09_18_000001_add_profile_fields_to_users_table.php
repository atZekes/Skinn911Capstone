<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add nullable columns for client profile details
            $table->string('mobile_phone')->nullable()->after('password');
            $table->string('telephone')->nullable()->after('mobile_phone');
            $table->text('address')->nullable()->after('telephone');
            $table->date('birthday')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile_phone', 'telephone', 'address', 'birthday']);
        });
    }
}
