<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'mobile' => 'nullable|numeric|min_digits:10|max_digits:15',
            'designation' => 'nullable|min:8'
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
            'userStatus' => $user->status
        ]);
    }
}
