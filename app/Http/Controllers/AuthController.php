<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLogin;
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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            Auth::login($user);

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
        if ($validator->passes()) {
            $remember = $request->filled('remember');
            if (Auth::attempt($request->only('email', 'password'), $remember)) {
                UserLogin::create([
                    'user_id' => Auth::user()->id,
                    'ip_address' => $request->ip(),
                    'last_login' => now(),
                    'user_agent' => $request->header('User-Agent')
                ]);
                $request->session()->regenerate();
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
