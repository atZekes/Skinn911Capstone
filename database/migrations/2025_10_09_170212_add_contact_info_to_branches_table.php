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
        Schema::table('branches', function (Blueprint $table) {
            // Add contact information fields
            $table->string('contact_number')->nullable()->after('address');
            $table->string('telephone_number')->nullable()->after('contact_number');
            $table->text('operating_days')->nullable()->after('telephone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            // Remove the added columns
            $table->dropColumn(['contact_number', 'telephone_number', 'operating_days']);
        });
    }
};
