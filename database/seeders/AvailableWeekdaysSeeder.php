<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailableWeekdaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(2, 6) as $weekday) {
            \App\Models\AvailableWeekdays::create([
                'sellers_id' => 1,
                'day_of_week' => $weekday,
            ]);
        }
    }
}
