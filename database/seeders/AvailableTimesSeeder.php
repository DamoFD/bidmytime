<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailableTimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $weekday) {
            \App\Models\AvailableTimes::create([
                'available_day_id' => $weekday,
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'timeslot' => 60,
            ]);
            \App\Models\AvailableTimes::create([
                'available_day_id' => $weekday,
                'start_time' => '14:00:00',
                'end_time' => '17:00:00',
                'timeslot' => 60,
            ]);
        }
    }
}
