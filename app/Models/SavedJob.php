<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    protected $table = 'saved_jobs';

    protected $fillable = [
        'job_id',
        'user_id',
    ];

    public function job()
    {
        return $this->belongsTo(CareerJob::class);
    }
}
