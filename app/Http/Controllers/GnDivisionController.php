<?php

namespace App\Http\Controllers;

use App\Models\GnDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GnDivisionController extends Controller
{
    public function store(Request $request) {

        // Validate inputs
        $validator = Validator::make($request->all(), [
            'ward_no' => 'required',
            'gn_division_no' => 'required|max:5',
            'gn_division_name' => 'required'
        ], [], [
            'ward_no' => 'Ward No',
            'gn_division_no' => 'GN No',
            'gn_division_name' => 'GN Name'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Check if division already exists
        $gnDivision = GnDivision::where('gn_division_no', $request->gn_division_no)->first();

        if ($gnDivision) {
            return Redirect::back()->withErrors(['message' => 'A division already exists with the given GN No.'])->withInput();
        }

        // Create new GN division
        $newGnDivision = new GnDivision();
        $newGnDivision->ward_no = $request->ward_no;
        $newGnDivision->gn_division_no = $request->gn_division_no;
        $newGnDivision->gn_division_name = $request->gn_division_name;

        $result = $newGnDivision->save();

        if ($result) {
            return Redirect::back()->with('success', 'GN division created successfully');
        }
        
    }
}