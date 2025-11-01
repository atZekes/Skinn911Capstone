<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed a client user
        \App\Models\User::updateOrCreate(
            ['email' => 'client@test.com'],
            [
                'name' => 'Test Client',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'client',
            ]
        );

        // Seed a staff user
        \App\Models\User::updateOrCreate(
            ['email' => 'staffuser@example.com'],
            [
                'name' => 'Sample Staff',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'staff',
            ]
        );

        // Call existing seeders
        $this->call([
            BranchSeeder::class,
            ServiceSeeder::class,
            CEOUserSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
