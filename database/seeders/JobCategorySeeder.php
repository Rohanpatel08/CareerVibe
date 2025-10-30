<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $job_categories = [
            ['category' => 'Engineering'],
            ['category' => 'Accountant'],
            ['category' => 'Information Technology'],
            ['category' => 'Fashion designing'],
        ];

        foreach ($job_categories as $job_category) {
            JobCategory::create($job_category);
        }
    }
}
