<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),              // Random event title
            'date' => $this->faker->date(),                   // Random date for the event
            'time' => $this->faker->time(),                   // Random time for the event
            'place' => $this->faker->address(),               // Random address as the event location
            'description' => $this->faker->paragraph(),       // Event description
            'user_id' => 1,    // Assumes a User factory exists to associate with the event
        ];
    }
}
