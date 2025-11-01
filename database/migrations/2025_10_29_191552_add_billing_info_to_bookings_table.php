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
        Schema::table('bookings', function (Blueprint $table) {
            // Card information (encrypted)
            $table->string('card_type')->nullable(); // visa, mastercard
            $table->text('card_number_encrypted')->nullable(); // Last 4 digits only, encrypted
            $table->string('card_last_four')->nullable(); // Plain text for display
            $table->string('card_expiry_month')->nullable();
            $table->string('card_expiry_year')->nullable();

            // Billing information
            $table->string('billing_first_name')->nullable();
            $table->string('billing_last_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'card_type',
                'card_number_encrypted',
                'card_last_four',
                'card_expiry_month',
                'card_expiry_year',
                'billing_first_name',
                'billing_last_name',
                'billing_address',
                'billing_address_2',
                'billing_city',
                'billing_zip',
                'billing_country',
                'billing_phone'
            ]);
        });
    }
};
