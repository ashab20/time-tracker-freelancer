<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create(
            [
                'title' => fake()->name(),
                'description' => fake()->sentence(),
                'client_id' => 1,
                'user_id' => 1,
                'status' => 'active',
                'deadline' => now()->addDays(10),
            ],
            [
                'title' => fake()->name(),
                'description' => fake()->sentence(),
                'client_id' => 2,
                'user_id' => 1,
                'status' => 'active',
                'deadline' => now()->addDays(20),

            ]
        );
    }
}