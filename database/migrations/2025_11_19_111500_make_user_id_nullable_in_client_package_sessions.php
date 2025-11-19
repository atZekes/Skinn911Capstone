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
        // Attempt to drop the foreign key if it exists, then make column nullable and re-add FK
        try {
            DB::statement('ALTER TABLE client_package_sessions DROP FOREIGN KEY IF EXISTS client_package_sessions_user_id_foreign');
        } catch (\Exception $e) {
            // ignore if FK doesn't exist or database doesn't support IF EXISTS
        }

        // Modify column to nullable (use raw SQL for broad compatibility)
        try {
            DB::statement('ALTER TABLE client_package_sessions MODIFY COLUMN user_id BIGINT UNSIGNED NULL');
        } catch (\Exception $e) {
            // Some environments may require different SQL; try using Schema change if available
            try {
                Schema::table('client_package_sessions', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable()->change();
                });
            } catch (\Exception $ex) {
                // If neither approach works, log and rethrow to surface migration error
                throw $ex;
            }
        }

        // Re-create foreign key constraint to users(id) with ON DELETE SET NULL for safety
        try {
            DB::statement('ALTER TABLE client_package_sessions ADD CONSTRAINT client_package_sessions_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL');
        } catch (\Exception $e) {
            // ignore if cannot add (already exists or unsupported)
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE client_package_sessions DROP FOREIGN KEY IF EXISTS client_package_sessions_user_id_foreign');
        } catch (\Exception $e) { }

        try {
            DB::statement('ALTER TABLE client_package_sessions MODIFY COLUMN user_id BIGINT UNSIGNED NOT NULL');
        } catch (\Exception $e) {
            try {
                Schema::table('client_package_sessions', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable(false)->change();
                });
            } catch (\Exception $ex) {
                throw $ex;
            }
        }

        try {
            DB::statement('ALTER TABLE client_package_sessions ADD CONSTRAINT client_package_sessions_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        } catch (\Exception $e) { }
    }
};
