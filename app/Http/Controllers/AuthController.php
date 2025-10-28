<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration()
    {
        return view('auth.registration');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->passes()) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            session()->flash('success', 'Registration successful');
            return response()->json(['status' => true]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        // dd($request->all());
        if ($validator->passes()) {
            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect()->route('home');
            } else {
                return redirect()->route('login')->with('error', 'Invalid email or password')->withInput($request->only('email'));
            }
        } else {
            return redirect()->route('login')->withErrors($validator->errors())->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
