<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
use App\Services\DatabaseSwitcher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

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
        $superadmin = User::create([
            'name' => 'Shereif Hashem',
            'email' => 'shashem@mindholding.net',
            'password' => '12345test',
        ]);
        $superadmin->syncRoles(['superadmin']);
    }
}
