<?php

namespace App\Http\Controllers;

use App\Models\GnDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ward;

class AdminController extends Controller
{
    

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('username', $request->username)->first();

        if (!($user && $user->user_type == 'admin')) {
            return Redirect::back()->withErrors(['message' => 'Admin username doesn\'t exist'])->withInput();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Redirect::intended(route('admin.dashboard'));
        }

        return Redirect::back()->withErrors(['message' => "Wrong password"]);
    }

  
}