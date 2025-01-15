<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'caption' => $this->faker->sentence(),
            'user_id' => 1,
            'likes_count' => $this->faker->numberBetween(0, 1000),
            'comment_count' => $this->faker->numberBetween(0, 500),
        ];
    }
}
