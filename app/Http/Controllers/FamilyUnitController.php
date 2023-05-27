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
     * View single family unit
     */
    public function show($id) {

        $family_unit = FamilyUnit::with('members')->find($id);

        return Inertia::render('FamilyUnits/View', [
            'family_unit' => $family_unit
        ]);
    }   
}