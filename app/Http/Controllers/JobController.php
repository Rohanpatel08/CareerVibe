<?php

namespace App\Http\Controllers;

use App\Models\CareerJob;
use App\Models\JobCategory;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{

    public function myJobs()
    {
        $user = Auth::user();
        $jobs = CareerJob::where('user_id', $user->id)->paginate(5);
        // dd($jobs);
        return view('front.job.my-jobs', [
            'jobs' => $jobs,
            'user' => $user
        ]);
    }
    public function create()
    {
        $user = Auth::user();
        $categories = JobCategory::where('status', 1)->get();
        $job_types = JobType::where('status', 1)->get();
        return view('front.job.create', compact('user'))->with('categories', $categories)->with('job_types', $job_types);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            "title" => "required|min:3",
            "category" => "required",
            "job_type" => "required",
            "vacancy" => "required",
            "experience" => "required",
            "salary" => "required",
            "location" => "required|min:3",
            "description" => "required",
            "benefits" => "required|max:200",
            "responsibility" => "required|max:200",
            "qualifications" => "required|max:200",
            "keywords" => "required|max:150",
            "company_name" => "required",
            "company_location" => "required",
            "company_website" => "required"
        ]);

        if ($validator->passes()) {
            CareerJob::create([
                "title" => $request->title,
                "job_category_id" => $request->category,
                "job_type_id" => $request->job_type,
                "user_id" => Auth::user()->id,
                "vacancy" => $request->vacancy,
                "experience" => $request->experience,
                "salary" => $request->salary,
                "location" => $request->location,
                "description" => $request->description,
                "benefits" => $request->benefits,
                "responsibility" => $request->responsibility,
                "qualifications" => $request->qualifications,
                "keywords" => $request->keywords,
                "company_name" => $request->company_name,
                "company_location" => $request->company_location,
                "company_website" => $request->company_website
            ]);

            return redirect()->route('job.myJobs')->with('success', 'Job created successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}
