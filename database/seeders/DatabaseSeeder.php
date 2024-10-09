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
        $this->call(LaratrustSeeder::class);

        // \App\Models\User::create([
        //     'email' => 'Khaledmoussa202@gmail.com',
        //     'password' => '24001091Km',
        // ]);
    }
}
