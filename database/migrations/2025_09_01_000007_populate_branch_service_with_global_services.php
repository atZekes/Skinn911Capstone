<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('branch_service')) {
            return;
        }

        if (!Schema::hasTable('services')) {
            return;
        }

        $branchIds = DB::table('branches')->pluck('id')->toArray();
        $globalServices = DB::table('services')->whereNull('branch_id')->get();
        foreach ($branchIds as $branchId) {
            foreach ($globalServices as $s) {
                DB::table('branch_service')->updateOrInsert(
                    ['branch_id' => $branchId, 'service_id' => $s->id],
                    ['price' => $s->price, 'active' => $s->active ?? 1, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('branch_service')) {
            return;
        }
        $globalServiceIds = DB::table('services')->whereNull('branch_id')->pluck('id')->toArray();
        if (empty($globalServiceIds)) return;
        DB::table('branch_service')->whereIn('service_id', $globalServiceIds)->delete();
    }
};
