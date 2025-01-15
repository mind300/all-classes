<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
use App\Services\DatabaseSwitcher;
use Illuminate\Database\Seeder;

class MindUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $databaseSwitcher = new DatabaseSwitcher();
        $databaseSwitcher->setConnection('mind');

        // Adding a user with more details filled in
        User::create([
            'email' => 'khaledmoussa202@gmail.com',
            'password' => '12345test',
        ]);

        // Adding a brand
        Brand::create([
            'name' => 'Zara'
        ]);
    }
}
