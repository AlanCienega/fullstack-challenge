<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(5),
            'status' => $this->faker->numberBetween(1, 3),
            'deadline' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'user_id' => 1,
        ];
    }
}
