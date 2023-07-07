<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sellers>
 */
class SellersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'The Flooring Masters',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'image' => 'https://images.unsplash.com/photo-1575204015311-0fe377370780?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=735&q=80',
            'service' => 'Flooring Consultation',
            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut',
            'remember_token' => Str::random(10),
        ];
    }
}
