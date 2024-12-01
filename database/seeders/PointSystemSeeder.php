<?php

namespace Database\Seeders;

use App\Models\PointSystem;
use App\Services\DatabaseSwitcher;
use Illuminate\Database\Seeder;

class PointSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            [
                'action' => 'jobs',
                'display_name' => 'Jobs',
            ],
            [
                'action' => 'buy_sell',
                'display_name' => 'Buy & Sell',
            ],
            [
                'action' => 'redeem_offer',
                'display_name' => 'Redeem Offer',
            ],
            [
                'action' => 'invite_friend',
                'display_name' => 'Invite Friend',
            ],
            [
                'action' => 'renew_subscription',
                'display_name' => 'Renew Subscription',
            ],
            [
                'action' => 'create_chat_room',
                'display_name' => 'Create Chat Room',
            ],
        ];

        // Iterate through each action and create a new PointSystem record
        foreach ($actions as $action) {
            PointSystem::create($action);
        }

        // Change connection to supplier for next seeder
        $databaseSwitcher = new DatabaseSwitcher();
        $databaseSwitcher->setConnection('suppliers');
    }
}
