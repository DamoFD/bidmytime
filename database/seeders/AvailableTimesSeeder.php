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
        foreach (range(1, 6) as $weekday) {
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '17:00:00',
                'end_time' => '18:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '20:00:00',
                'end_time' => '21:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '22:00:00',
                'end_time' => '23:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '23:00:00',
                'end_time' => '00:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '00:00:00',
                'end_time' => '01:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '07:58:00',
                'end_time' => '07:59:00',
            ]);
        }
    }
}
