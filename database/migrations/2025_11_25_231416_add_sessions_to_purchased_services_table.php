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
            $table->integer('total_sessions')->default(1)->after('status')->comment('Total sessions for this service');
            $table->integer('sessions_used')->default(0)->after('total_sessions')->comment('Number of sessions completed');
            $table->integer('sessions_remaining')->after('sessions_used')->comment('Remaining session credits');
            $table->enum('session_status', ['active', 'completed', 'expired'])->default('active')->after('sessions_remaining');
            $table->date('session_expiry_date')->nullable()->after('session_status')->comment('When this service sessions expire');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchased_services', function (Blueprint $table) {
            $table->dropColumn(['total_sessions', 'sessions_used', 'sessions_remaining', 'session_status', 'session_expiry_date']);
        });
    }
};
