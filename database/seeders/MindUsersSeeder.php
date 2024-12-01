<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\DatabaseSwitcher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'email' => 'antonabdalla3000@gmail.com',
            'password' => '12345@Test',
        ]);
    }
}
