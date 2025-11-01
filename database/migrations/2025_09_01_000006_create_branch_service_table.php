<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branch_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('active')->default(true);
            $table->text('custom_description')->nullable();
            $table->timestamps();
            $table->unique(['branch_id','service_id']);
        });

        // Migrate existing services.branch_id -> branch_service pivot
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'branch_id')) {
            $rows = DB::table('services')->whereNotNull('branch_id')->get();
            foreach ($rows as $r) {
                DB::table('branch_service')->updateOrInsert(
                    ['branch_id' => $r->branch_id, 'service_id' => $r->id],
                    ['price' => $r->price ?? null, 'active' => $r->active ?? 1, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_service');
    }
};
