<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommunityUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================================== //
        // Adding a user with more details filled in
        $user = User::create([
            'name' => 'Ahmed Sabry',
            'email' => 'ahmaasabry22@gmail.com',
            'password' => '12345test',
        ]);

        $member = Member::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Sabry',
            'mobile_number' => '1234567890',
            'mobile_number_view' => 1,
            'date_of_birth' => '1990-01-01',
            'date_of_birth_view' => 1,
            'location' => 'New York',
            'location_view' => 1,
            'job' => 'Developer',
            'job_view' => 1,
            'bio' => 'This is a sample bio for John Doe.',
            'following_number' => 0,
            'followers_number' => 0,
            'user_id' => 1
        ]);

        // ============================================================== //
        User::create([
            'name' => 'Anton Abdallah',
            'email' => 'antonabdalla3000@gmail.com',
            'password' => '12345test',
        ]);

        Member::create([
            'first_name' => 'Anton',
            'last_name' => 'Abdallah',
            'mobile_number' => '1234567890',
            'mobile_number_view' => 1,
            'date_of_birth' => '1990-01-01',
            'date_of_birth_view' => 1,
            'location' => 'New York',
            'location_view' => 1,
            'job' => 'Developer',
            'job_view' => 1,
            'bio' => 'This is a sample bio for John Doe.',
            'following_number' => 0,
            'followers_number' => 0,
            'user_id' => 2
        ]);
    }
}
