<?php

namespace Database\Factories;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

class RewardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reward::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),                   // Generates a random word for the reward name
            'quantity' => $this->faker->numberBetween(1, 100), // Random quantity between 1 and 100
            'redeem_points' => $this->faker->numberBetween(50, 1000), // Random redeem points
            'description' => $this->faker->sentence(),        // Short description
            'status' => $this->faker->randomElement(['active', 'inactive']), // Random status
        ];
    }
}
