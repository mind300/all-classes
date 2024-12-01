<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Community Seeders
        $this->call(CommunityUsersSeeder::class);

        // Roles Seeder
        $this->call(LaratrustSeeder::class);

        // Mind Seeders
        $this->call(MindUsersSeeder::class);

        // Point System Actions Seeder
        $this->call(PointSystemSeeder::class);

        // Roles Seeder
        $this->call(LaratrustSeeder::class);

        // Suppliers Seeders
        $this->call(SupplierUsersSeeder::class);
    }
}
