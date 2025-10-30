<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $job_types = [
            ['job_type' => 'Full Time'],
            ['job_type' => 'Part Time'],
            ['job_type' => 'Internship'],
        ];

        foreach ($job_types as $job_type) {
            JobType::create($job_type);
        }
    }
}
