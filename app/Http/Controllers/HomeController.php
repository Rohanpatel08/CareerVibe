<?php

namespace App\Http\Controllers;

use App\Models\CareerJob;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = JobCategory::where('status', 1)->orderBy('category', 'ASC')->take(8)->get();
        $featured_jobs = CareerJob::where('status', 1)->where('isFeatured', 1)->orderBy('created_at', 'DESC')->take(6)->get();
        $latest_jobs = CareerJob::where('status', 1)->orderBy('created_at', 'DESC')->take(6)->get();
        // dd($featured_jobs);
        return view('front.home', [
            'categories' => $categories,
            'featured_jobs' => $featured_jobs,
            'latest_jobs' => $latest_jobs
        ]);
    }
}
