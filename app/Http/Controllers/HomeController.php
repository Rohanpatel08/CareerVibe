<?php

namespace App\Http\Controllers;

use App\Models\CareerJob;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = JobCategory::where('status', 1)->orderBy('category', 'ASC')->take(8)->get();
        $allCategories = JobCategory::where('status', 1)->orderBy('category', 'ASC')->get();
        $featured_jobs = CareerJob::where('status', 1)->where('isFeatured', 1)->orderBy('created_at', 'DESC')->take(6)->get();
        $latest_jobs = CareerJob::where('status', 1)->orderBy('created_at', 'DESC')->take(6)->get();
        $message = false;
        if (Auth::check()) {
            if (Auth::user()->mobile == null || Auth::user()->destination == null) {
                $message = true;
            }
        }
        return view('front.home', [
            'categories' => $categories,
            'allCategories' => $allCategories,
            'featured_jobs' => $featured_jobs,
            'latest_jobs' => $latest_jobs,
            'message' => $message
        ]);
    }
}
