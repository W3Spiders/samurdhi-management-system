<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return Redirect::back()->withErrors(['message' => 'Username doesn\'t exist'])->withInput();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Redirect::intended(route('dashboard.index'));
        }

        return Redirect::back()->withErrors(['message' => "Incorrect password"]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}