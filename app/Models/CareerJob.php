<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerJob extends Model
{
    protected $table = 'career_jobs';

    protected $fillable = [
        'title',
        'description',
        'location',
        'vacancy',
        'salary',
        'experience',
        'benefits',
        'responsibility',
        'qualifications',
        'keywords',
        'company_name',
        'company_location',
        'company_website',
        'job_type_id',
        'job_category_id',
    ];
}
