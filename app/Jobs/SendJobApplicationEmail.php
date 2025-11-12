<?php

namespace App\Jobs;

use App\Mail\JobApplicationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendJobApplicationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $employer;
    public $user;
    public $jobPost;

    /**
     * Create a new job instance.
     */
    public function __construct(User $employer, User $user, $jobPost)
    {
        $this->employer = $employer;
        $this->user = $user;
        $this->jobPost = $jobPost;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->employer->email)->send(new JobApplicationMail($this->employer, $this->user, $this->jobPost));
    }
}
