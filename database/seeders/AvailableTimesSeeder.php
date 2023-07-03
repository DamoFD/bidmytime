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
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '11:00:00',
                'end_time' => '12:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '13:00:00',
                'end_time' => '14:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '14:00:00',
                'end_time' => '15:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '15:00:00',
                'end_time' => '16:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
            ]);
            \App\Models\AvailableTimes::create([
                'available_weekdays_id' => $weekday,
                'start_time' => '23:58:00',
                'end_time' => '23:59:00',
            ]);
        }
    }
}
