<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AvailableExceptions;
use App\Models\Bids;
use App\Models\Sellers;
use App\Models\User;
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
        User::factory(2)->create();
        Bids::factory(10)->create();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
