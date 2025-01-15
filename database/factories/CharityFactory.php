<?php

namespace Database\Factories;

use App\Models\Charity;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Charity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),          // Generates a random company name
            'phone' => $this->faker->phoneNumber(),     // Generates a random phone number
            'address' => $this->faker->address(),       // Generates a random address
            'website' => $this->faker->url(),           // Generates a random URL for the website
            'email' => $this->faker->unique()->safeEmail(), // Generates a unique email address
            'description' => $this->faker->paragraph(), // Generates a random paragraph for description
        ];
    }
}
