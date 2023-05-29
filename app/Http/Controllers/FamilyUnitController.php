<?php

namespace App\Http\Controllers;

use App\Models\FamilyUnit;
use App\Models\Member;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class FamilyUnitController extends Controller
{
    /**
     * View family unit list
     */
    public function index() {

        $family_units = FamilyUnit::with('primary_member')->get();

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

        $family_unit = FamilyUnit::with(['primary_member.occupation_type','members',])->withCount('members')->find($id);
        $family_unit = $family_unit->append('has_met_samurdhi_eligible_criteria');

        return Inertia::render('FamilyUnits/Show', [
            'family_unit' => $family_unit
        ]);
    }   
}