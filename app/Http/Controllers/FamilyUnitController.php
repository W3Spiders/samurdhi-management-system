<?php

namespace App\Http\Controllers;

use App\Models\FamilyUnit;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class FamilyUnitController extends Controller
{
    /**
     * View family unit list
     */
    public function index() {

        $family_units = [];
        // $family_units = FamilyUnit::with('primary_member')->get();

        $user = Auth::user();
        //return $user->id;
        $user = User::with('gn_division.family_units.primary_member')->get()->find($user->id);

        if (isset($user['gn_division']) && isset($user['gn_division']['family_units']) && !is_null($user['gn_division']['family_units'])) {
            $family_units = $user['gn_division']['family_units'];
        }

        // if ($user['user_type'] != 'admin' && $user['user_type'] != 'ds' && !is_null($gn_division_id)) {
        //     $family_units = FamilyUnit::with('primary_member')->where('gn_division_id', $gn_division_id)->get();
        // }

        //return $family_units;
        return Inertia::render('FamilyUnits/Index', [
            'filters' => Request::all('search', 'trashed'),
            'family_units' => $family_units,
        ]);
    }   

    /**
     * Create family unit
     */
    public function create() {

        return Inertia::render('FamilyUnits/Create');
    }  

    /**
     * View single family unit
     */
    public function show($id) {

        $family_unit = FamilyUnit::with(['primary_member.occupation_type','members.occupation_type',])->withCount('members')->find($id);
        $family_unit = $family_unit->append('has_met_samurdhi_eligible_criteria');

        return Inertia::render('FamilyUnits/Show', [
            'family_unit' => $family_unit
        ]);
    }   
}