<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('username', $request->username)->first();

        if (!($user && $user->user_type == 'admin')) {
            return Redirect::back()->withErrors(['message' => 'Invalid user'])->withInput();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Redirect::intended(route('admin.dashboard'));
        }

        return Redirect::back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function showDashboard()
    {
        return view('admin.dashboard');
    }
}
