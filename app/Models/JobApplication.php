<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $table = 'job_applications';

    protected $fillable = [
        'job_id',
        'user_id',
        'employer_id',
        'applied_at',
    ];


    public function jobPost()
    {
        return $this->belongsTo(CareerJob::class, 'job_id', 'id');
    }
}
