<?php

namespace App\Http\Controllers;

use App\Models\GnDivision;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function showLogin()
    {
        if (Auth::user()) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    public function showDashboard()
    {
        return view('dashboard');
    }

    public function showWardManage() {

        $wards = Ward::all();

        return view('settings.wardManage', ['wards' => $wards]);
    }

    public function showGnDivisionManage() {

        $gnDivisions = GnDivision::all();

        return view('settings.gnDivisionManage', ['gnDivisions' => $gnDivisions]);
    }
}