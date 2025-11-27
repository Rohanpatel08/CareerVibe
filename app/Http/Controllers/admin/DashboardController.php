<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CareerJob;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.dashboard.users', compact('users'));
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.dashboard.users-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'mobile' => 'nullable|numeric|min_digits:10|max_digits:15',
            'designation' => 'nullable|min:8',
        ]);
        $user = User::findOrFail($request->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->destination = $request->designation;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        session()->flash('success', 'User deleted successfully');

        return response()->json([
            'status' => true,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'status' => true,
            'userStatus' => $user->status,
        ]);
    }

    // Jobs
    public function jobs()
    {
        $jobs = CareerJob::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.dashboard.jobs.jobs', [
            'jobs' => $jobs,
        ]);
    }

    public function editJobs($id)
    {
        $id = base64_decode($id);
        $job = CareerJob::findOrFail($id);
        $categories = JobCategory::where('status', 1)->get();
        $job_types = JobType::where('status', 1)->get();

        return view('admin.dashboard.jobs.edit', [
            'job' => $job,
            'categories' => $categories,
            'job_types' => $job_types,
        ]);
    }

    public function updateJob(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required',
            'experience' => 'required',
            'salary' => 'required',
            'location' => 'required|min:3',
            'description' => 'required',
            'benefits' => 'required|max:200',
            'responsibility' => 'required|max:200',
            'qualifications' => 'required|max:200',
            'keywords' => 'required|max:150',
            'company_name' => 'required',
            'company_location' => 'required',
            'company_website' => 'required',

        ]);
        if ($validator->passes()) {
            $id = base64_decode($id);
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

            return redirect()->route('admin.jobs')->with('success', 'Job updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function deleteJob(Request $request)
    {
        $job = CareerJob::findOrFail($request->id);
        $job->delete();

        return response()->json([
            'status' => true,
        ]);
    }
}
