<?php

namespace Database\Seeders;

use App\Models\BuySell;
use App\Models\Charity;
use App\Models\Event;
use App\Models\JobAnnouncement;
use App\Models\News;
use App\Models\Offer;
use App\Models\Reward;
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
        // Add Fileds For All Models
        $news = News::factory()->make()->toArray();
        $buyAndSells = BuySell::factory()->make()->toArray();
        $jobs = JobAnnouncement::factory()->create();
        $rewards = Reward::factory()->create();
        $events = Event::factory()->create();

        // Roles Seeder
        $this->call(LaratrustSeeder::class);

        // Mind Seeders
        $this->call(MindUsersSeeder::class);
        // Add Fileds For All Models
        $offers = Offer::factory()->make()->toArray();
        $charities = Charity::factory()->create();

        // Point System Actions Seeder
        $this->call(PointSystemSeeder::class);

        // Roles Seeder
        $this->call(LaratrustSeeder::class);

        // Suppliers Seeders
        $this->call(SupplierUsersSeeder::class);
    }
}
