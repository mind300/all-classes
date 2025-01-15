<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Services\DatabaseSwitcher;
use Illuminate\Database\Seeder;

class SupplierUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $databaseSwitcher = new DatabaseSwitcher();
        $databaseSwitcher->setConnection('suppliers');

        // ============================================================== //
        // Adding a user with more details filled in
        $user = User::create([
            'email' => 'zara@gmail.com',
            'password' => '12345test',
            'brand_id' => 1
        ]);

        Profile::create([
            'name' => 'Khaled Moussa',
            'mobile_number' => '01015571129',
            'job_id' => '1234567890',
            'user_id' => 1,
        ]);

        $user->syncRoles(['owner']);
    }
}
