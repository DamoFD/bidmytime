<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bids>
 */
class BidsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'user_id' => rand(1, 10),
                'sellers_id' => 1,
                'bid_date' => '2023-07-12',
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
                'amount' => fake()->randomFloat(2, 20, 30),
        ];
    }
}
