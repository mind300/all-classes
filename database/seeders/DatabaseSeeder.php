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

        \App\Models\User::create([
            'email' => 'antonabdalla300@gmail.com',
            'password' => '12345test',
        ]);
        \App\Models\User::create([
            'email' => 'ahmaasabry22@gmail.com',
            'password' => '12345test',
        ]);
    }
}
