<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        return view('front.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'mobile' => 'nullable|numeric|min_digits:10|max_digits:15',
            'designation' => 'nullable|min:8'
        ]);

        if ($validator->passes()) {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'destination' => $request->designation
            ]);
            // dd($user);
            session()->flash('success', 'Profile updated successfully.');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function updateProfilePic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6144'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $image->move(public_path('images/profile_pic'), $imageName);

        File::delete(public_path('images/profile_pic/' . Auth::user()->image));
        $user->update([
            'image' => $imageName
        ]);
        session()->flash('success', 'Profile picture updated successfully.');
        return response()->json([
            'status' => true,
            'errors' => []
        ]);
    }


    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        session()->flash('success', 'Password updated successfully.');
        return redirect()->route('logout');
    }
}
