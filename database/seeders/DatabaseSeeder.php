<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AvailableExceptions;
use App\Models\Sellers;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Sellers::factory()->create();

        $this->call([
            AvailableWeekdaysSeeder::class,
            AvailableTimesSeeder::class,
        ]);

        AvailableExceptions::factory()->create();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
