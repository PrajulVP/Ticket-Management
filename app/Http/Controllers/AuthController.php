<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('staff.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'password.min' => 'The password must be at least 8 characters.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Reject inactive staff accounts
            if (Auth::user()->status === 'inactive') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is inactive. Please contact system admin.']);
            }

            $request->session()->regenerate();
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('staff.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password entered.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}