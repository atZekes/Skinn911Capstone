<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Package Bookings Table
     * Stores multi-session service packages as prepaid credits
     * Sessions are scheduled one at a time, not all at once
     */
    public function up(): void
    {
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();

            // Client who purchased the package
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Service that this package is for (e.g., "HIFU 10 Sessions")
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');

            // Branch where package was purchased (optional filter)
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');

            // Session Credits Tracking
            $table->integer('total_credits')->default(1); // Total sessions in package (e.g., 10)
            $table->integer('used_credits')->default(0);   // Sessions already scheduled
            $table->integer('remaining_credits')->default(1); // Sessions left to schedule

            // Package Status
            $table->enum('status', ['active', 'completed', 'expired', 'cancelled'])->default('active');

            // Pricing & Payment
            $table->decimal('total_price', 10, 2); // Total package price
            $table->enum('payment_status', ['paid', 'pending', 'refunded'])->default('paid');
            $table->string('payment_method')->nullable(); // gcash, card, cash

            // Expiry Management
            $table->date('expiry_date')->nullable(); // Package expiration date

            // Notes
            $table->text('notes')->nullable(); // Admin/staff notes

            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['service_id', 'status']);
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_bookings');
    }
};
