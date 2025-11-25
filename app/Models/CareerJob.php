<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerJob extends Model
{
    protected $table = 'career_jobs';

    protected $fillable = [
        'title',
        'user_id',
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

    public function jobType()
    {
        return $this->hasOne(JobType::class, 'id', 'job_type_id');
    }

    public function jobCategory()
    {
        return $this->hasOne(JobCategory::class, 'id', 'job_category_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
