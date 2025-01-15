<?php

namespace Database\Factories;

use App\Models\JobAnnouncement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobAnnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobAnnouncement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),              // Generates a random job title
            'type' => $this->faker->randomElement(['Full-Time', 'Part-Time', 'Contract', 'Internship']), // Job type
            'location' => $this->faker->city(),              // Random city as location
            'salary_range' => 3000,
            'user_experience' => $this->faker->randomElement(['Entry Level', 'Mid Level', 'Senior Level']), // Experience level
            'description' => $this->faker->paragraphs(3, true), // Detailed description
            'how_to_apply' => $this->faker->sentence(),      // How to apply instructions
            'user_id' => 1,                    // Assumes a User factory exists for relation
        ];
    }
}
