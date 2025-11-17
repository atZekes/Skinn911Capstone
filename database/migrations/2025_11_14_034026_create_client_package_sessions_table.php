<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create client_package_sessions table
     * This is a SEPARATE table from bookings/appointments
     * Tracks session credits for multi-session packages per branch
     */
    public function up(): void
    {
        Schema::create('client_package_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique()->comment('Unique package booking identifier');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Client who purchased the package');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade')->comment('Service type');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade')->comment('Branch where package was purchased');
            $table->integer('total_sessions')->comment('Total sessions included in package');
            $table->integer('sessions_used')->default(0)->comment('Number of sessions completed');
            $table->integer('sessions_remaining')->comment('Remaining session credits');
            $table->enum('status', ['active', 'completed'])->default('active');
            $table->decimal('total_price', 10, 2)->comment('Total package price paid');
            $table->enum('payment_status', ['pending', 'paid'])->default('paid');
            $table->enum('payment_method', ['cash', 'card', 'gcash'])->nullable();
            $table->date('purchase_date')->comment('Date package was purchased');
            $table->date('expiry_date')->nullable()->comment('Package expiration date (default 1 year)');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for faster queries
            $table->index(['user_id', 'status']);
            $table->index(['branch_id', 'status']);
            $table->index(['service_id']);
            $table->index(['status', 'sessions_remaining']);
            $table->index(['expiry_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_package_sessions');
    }
};
