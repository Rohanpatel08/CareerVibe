<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('front.job.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|min:3",
            "category" => "required",
            "vacancy" => "required",
            "salary" => "required",
            "location" => "required|min:3",
            "description" => "required",
            "benefits" => "required",
            "responsibility" => "required",
            "qualifications" => "required",
            "keywords" => "required",
            "company_name" => "required",
            "company_location" => "required",
            "company_website" => "required"
        ]);

        if ($validator->passes()) {
            //
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
