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
        // =============================Owners================================= //
        // ----------------------- Adding a Shereif Hashem ----------------------- //
        $owner_1 = User::create([
            'name' => 'Khaled Moussa',
            'email' => 'khaledmoussa202@gmail.com',
            'password' => '12345test',
        ]);

        $owner_member_1 = Member::create([
            'first_name' => 'Shereif',
            'last_name' => 'Hashem',
            'mobile_number' => '01001550667',
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

        // Sync Role User
        $owner_1->syncRoles(['owner']);
        // ----------------------- Adding a Anton Abdallah ----------------------- //
        $owner_2 = User::create([
            'name' => 'Anton Abdallah',
            'email' => 'antonabdalla30@gmail.com',
            'password' => '12345test',
        ]);

        $owner_member_2 = Member::create([
            'first_name' => 'Anton',
            'last_name' => 'Abdallah',
            'mobile_number' => '01200835855',
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

        // Sync Role User
        $owner_2->syncRoles(['owner']);
        // =============================Members================================= //
        $user_1 = User::create([
            'name' => 'Ahmed Sabry',
            'email' => 'ahmaasabry22@gmail.com',
            'password' => '12345test',
        ]);

        $member_1 = Member::create([
            'first_name' => 'Anton',
            'last_name' => 'Abdallah',
            'mobile_number' => '01283819268',
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

        // Sync Role User
        $user_1->syncRoles(['user']);
    }
}
