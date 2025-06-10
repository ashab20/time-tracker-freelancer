<?php

namespace Database\Seeders;

use App\Models\TimeLogs;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeLogs::create(
            [
                'project_id' => 1,
                'start_time' => now(),
                'end_time' => Carbon::now()->addHours(3),
                'hour' => 1,
            ],
            [
                'project_id' => 2,
                'start_time' => now(),
                'end_time' => Carbon::now()->addHours(2),
                'hour' => 1,
            ],
            [
                'project_id' => 1,
                'start_time' => now(),
                'end_time' => Carbon::now()->addHours(1),
                'hour' => 1,
            ],
            [
                'project_id' => 2,
                'start_time' => now(),
                'end_time' => Carbon::now()->addHours(1),
                'hour' => 1,
            ],
            [
                'project_id' => 1,
                'start_time' => now(),
                'end_time' => Carbon::now()->addHours(5),
                'hour' => 1,
            ],
            [
                'project_id' => 2,
                'start_time' => now(),
                'end_time' => Carbon::now()->addHours(5),
                'hour' => 1,
            ],



        );
    }
}