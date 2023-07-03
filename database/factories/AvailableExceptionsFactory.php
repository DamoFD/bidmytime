<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AvailableExceptions>
 */
class AvailableExceptionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sellers_id' => 1,
            'date' => '2023-07-07',
            'start_time'=> '09:00',
            'end_time' => '10:00'
        ];
    }
}
