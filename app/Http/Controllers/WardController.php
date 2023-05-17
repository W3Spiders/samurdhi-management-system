<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WardController extends Controller
{

    public function get() {
        return Ward::all();
    }

    public function store(Request $request) {

        // Validate inputs
        $validator = Validator::make($request->all(), [
            'ward_no' => 'required',
            'ward_name' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Check if Ward already exists
        $ward = Ward::where('ward_no', $request->ward_no)->first();

        if ($ward) {
            return Redirect::back()->withErrors(['message' => 'Ward no already exists'])->withInput();
        }

        // Create new Ward
        $newWard = new Ward();
        $newWard->ward_no = $request->ward_no;
        $newWard->ward_name = $request->ward_name;

        $result = $newWard->save();

        if ($result) {
            return Redirect::back()->with('success', 'Ward created successfully');
        }
        
    }
}