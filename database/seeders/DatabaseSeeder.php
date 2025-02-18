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
        // Roles Seeder
        $this->call(LaratrustSeeder::class);

        // Community Seeders
        $this->call(CommunityUsersSeeder::class);
        // Add Fileds For All Models
        $news = News::factory()->create();
        $buyAndSells = BuySell::factory()->create();
        $jobs = JobAnnouncement::factory()->create();
        $rewards = Reward::factory()->create();
        $events = Event::factory()->create();

        // Roles Seeder
        $this->call(LaratrustSeeder::class);

        // Mind Seeders
        $this->call(MindUsersSeeder::class);
        // Add Fileds For All Models
        $offers = Offer::factory()->create();
        $charities = Charity::factory()->create();

        // Point System Actions Seeder
        $this->call(PointSystemSeeder::class);

        // Roles Seeder
        $this->call(LaratrustSeeder::class);

        // Suppliers Seeders
        $this->call(SupplierUsersSeeder::class);
    }
}
