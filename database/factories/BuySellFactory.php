<?php

namespace Database\Factories;

use App\Models\BuySell;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuySellFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BuySell::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true), // Generates a title with 3 words
            'place' => $this->faker->city(),        // Generates a random city as the place
            'price' => $this->faker->randomFloat(2, 10, 1000), // Generates a random price between 10 and 1000
            'discount' => $this->faker->numberBetween(0, 50), // Discount percentage
            'description' => $this->faker->paragraph(),      // A random paragraph as description
            'user_id' => 1                  // Assumes a User factory exists
        ];
    }
}
