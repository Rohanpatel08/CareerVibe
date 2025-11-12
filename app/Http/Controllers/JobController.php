<?php

namespace App\Http\Controllers;

use App\Jobs\SendJobApplicationEmail;
use App\Mail\JobApplicationMail;
use App\Models\CareerJob;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{

    public function index(Request $request)
    {
        $categories = JobCategory::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = CareerJob::where('status', 1);

        //Search Filter
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->location)) {
            $jobs = $jobs->where('location', 'like', '%' . $request->location . '%');
        }

        if (!empty($request->category)) {
            $jobs = $jobs->where('job_category_id', $request->category);
        }

        $jobtypeArray = [];
        if (!empty($request->job_type)) {
            $jobtypeArray = explode(',', $request->job_type);
            $jobs = $jobs->whereIn('job_type_id', $jobtypeArray);
        }

        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

        $jobs = $jobs->get();

        return view('front.job.find-jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobtypeArray' => $jobtypeArray
        ]);
    }

    public function myJobs()
    {
        $user = Auth::user();
        $jobs = CareerJob::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(5);
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

    public function edit($id)
    {
        $user = Auth::user();
        $id = base64_decode($id);
        $job = CareerJob::find($id);
        $categories = JobCategory::where('status', 1)->get();
        $job_types = JobType::where('status', 1)->get();
        return view('front.job.edit', compact('job'))->with('categories', $categories)->with('job_types', $job_types)->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $id = base64_decode($id);
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
            $job = CareerJob::find($id);
            $job->title = $request->title;
            $job->job_category_id = $request->category;
            $job->job_type_id = $request->job_type;
            $job->vacancy = $request->vacancy;
            $job->experience = $request->experience;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            return redirect()->route('job.myJobs')->with('success', 'Job updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function delete($id)
    {
        try {
            $id = base64_decode($id);
            $job = CareerJob::findorFail($id);
            $job->delete();
            session()->flash('success', 'Job deleted successfully.');
            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error occured while deleting job.');
            return response()->json([
                'status' => false,
                'errors' => "Error occured while deleting job."
            ]);
        }
    }

    public function details($id)
    {
        $id = base64_decode($id);
        $job = CareerJob::findOrFail($id);
        return view('front.job.details', compact('job'));
    }


    public function applyForJob(Request $request)
    {
        $job = CareerJob::findorFail($request->id);

        if (!$job) {
            // return redirect()->back()->with('error', 'Job not found.');
            session()->flash('error', 'Job not found.');
            return response()->json([
                'status' => false,
                'errors' => "Job not found."
            ]);
        }

        if (JobApplication::where('user_id', Auth::user()->id)->where('job_id', $job->id)->exists()) {
            // return redirect()->back()->with('error', 'You have already applied for this job.');
            session()->flash('error', 'You have already applied for this job.');
            return response()->json([
                'status' => false,
                'errors' => "You have already applied for this job."
            ]);
        }

        if ($job->user_id == Auth::user()->id) {
            // return redirect()->back()->with('error', 'You cannot apply for your own job.');
            session()->flash('error', 'You cannot apply for your own job.');
            return response()->json([
                'status' => false,
                'errors' => "You cannot apply for your own job."
            ]);
        }

        JobApplication::create([
            "user_id" => Auth::user()->id,
            "job_id" => $job->id,
            "employer_id" => $job->user_id,
            "applied_at" => Carbon::now()
        ]);

        $employer = User::findOrFail($job->user_id);
        SendJobApplicationEmail::dispatch($employer, Auth::user(), $job);

        // return redirect()->back()->with('success', 'Applied for job successfully.');
        session()->flash('success', 'Applied for job successfully.');
        return response()->json([
            'status' => true,
            'message' => "Applied for job successfully."
        ]);
    }

    public function myJobApplications()
    {
        $user = Auth::user();
        $jobs = JobApplication::where('user_id', Auth::user()->id)->paginate(5);
        return view('front.job.my-applied-jobs', [
            'user' => $user,
            'jobs' => $jobs
        ]);
    }

    // public function myJobApplicationDetails($id){
    //     $id = base64_decode($id);
    //     $job = JobApplication::findorFail($id);
    //     return view('front.job.my-applied-job-details', compact('job'));
    // }

    public function removeAppliedJobs(Request $request)
    {
        $id = base64_decode($request->id);
        $jobApplication = JobApplication::findorFail($id);
        $jobApplication->delete();

        session()->flash('success', 'Job application removed successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
