<?php

namespace App\Http\Controllers;

use App\Models\FamilyUnit;
use App\Models\GnDivision;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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

    public function showFamilyUnits() {

        $loggedInUser = Auth::user();

        $userForeignKey = '';

        switch($loggedInUser->user_type) {
            case 'gn':
                $userForeignKey = 'gn_user_id';
                break;
            case 'sn':
                $userForeignKey = 'sn_user_id';
                break;
            default:
                break;
        }

        $familyUnits = [];

        if($userForeignKey) {

            // Get the gn division that logged in user owns
            $gnDivision = GnDivision::where($userForeignKey, $loggedInUser->id)->first();

            // Get family units that belongs to the above gn division
            $familyUnits = FamilyUnit::where('gn_division_id', $gnDivision[$userForeignKey])->get();

        } else {
            $familyUnits = FamilyUnit::all();
        }

        //return view('familyUnits', ['familyUnits' => $familyUnits]);
        return Inertia::render('FamilyUnit/FamilyUnitIndex', ['familyUnits' => $familyUnits]);
    }

    public function showFamilyUnit(string $id) {

        $familyUnit = FamilyUnit::with('members', 'adult_members')->find($id);

        return view('familyUnit', ['familyUnit' => $familyUnit]);
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