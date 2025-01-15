<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->word(),
            'brand_info' => $this->faker->company(),
            'title' => $this->faker->sentence(),
            'discount' => $this->faker->numberBetween(5, 70), // Discount percentage
            'description' => $this->faker->paragraph(),
            'qr_code' => mt_rand(10000, 99999), // Random UUID for QR code
            'brand_id' => 1 // Assumes a Brand factory exists
        ];
    }
}
