<?php

namespace App\Http\Controllers;

use App\Models\GnDivision;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class GnDivisionController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $gn_divisions = GnDivision::with('ward')->where(function (Builder $query) use ($search) {
            return $query->where('gn_division_no', 'like', "%{$search}%")
                ->orWhere('gn_division_name', 'like', "%{$search}%");
        })->paginate(10);

        return Inertia::render('GnDivisions/Index', ['filters' => $request->all('search', 'trashed'), 'gn_divisions' => $gn_divisions]);
    }

    public function show($id)
    {
        $gn_division = GnDivision::with(['ward', 'gn_user', 'sn_user'])->find($id);

        return Inertia::render('GnDivisions/Show', ['gn_division' => $gn_division]);
    }

    public function create()
    {
        $wards = Ward::all();
        $gn_users = User::where('user_type', 'gn')->get();
        $sn_users = User::where('user_type', 'sn')->get();

        return Inertia::render('GnDivisions/Create', ['wards' => $wards, 'gn_users' => $gn_users, 'sn_users' => $sn_users]);
    }

    public function store(Request $request)
    {

        // Validate inputs
        $validator = Validator::make($request->all(), [
            'ward_no' => 'required',
            'gn_division_no' => 'required|max:5',
            'gn_division_name' => 'required',
            'gn_user_id' => 'unique:gn_divisions',
            'sn_user_id' => 'unique:gn_divisions'
        ], [
            'gn_user_id.unique' => 'User is already assigned to another GN division.',
            'sn_user_id.unique' => 'User is already assigned to another GN division.'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Check if division already exists
        $gn_division = GnDivision::where('gn_division_no', $request->gn_division_no)->first();

        if ($gn_division) {
            return Redirect::back()->withErrors(['message' => 'A division already exists with the given GN No.'])->withInput();
        }

        // Create new GN division
        $gn_division = new GnDivision();
        $gn_division->ward_no = $request->ward_no;
        $gn_division->gn_division_no = $request->gn_division_no;
        $gn_division->gn_division_name = $request->gn_division_name;
        $gn_division->gn_user_id = $request->gn_user_id;
        $gn_division->sn_user_id = $request->sn_user_id;

        $result = $gn_division->save();

        if ($result) {
            return Redirect::route('gn_divisions.index')->with('success', 'GN division created successfully');
        }
    }

    public function edit($id)
    {
        $wards = Ward::all();
        $gn_users = User::where('user_type', 'gn')->get();
        $sn_users = User::where('user_type', 'sn')->get();
        $gn_division = GnDivision::with('ward')->findOrFail($id);

        return Inertia::render('GnDivisions/Create', ['gn_division' => $gn_division, 'wards' => $wards, 'gn_users' => $gn_users, 'sn_users' => $sn_users]);
    }

    public function update($id, Request $request)
    {
        $gn_division = GnDivision::find($id);

        if (!$gn_division) {
            return Redirect::back()->with('error', 'GN Division doesn\'t exist');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'gn_division_no' => 'required|max:5',
                'gn_division_name' => 'required',
                'ward_no' => 'required',
                'gn_user_id' => 'required|unique:gn_divisions',
                'sn_user_id' => 'required|unique:gn_divisions'
            ],
            [
                'gn_user_id.required' => 'Grama Niladhari is required.',
                'sn_user_id.required' => 'Samurdhi Niladhari is required.',
                'gn_user_id.unique' => 'User is already assigned to another GN division.',
                'sn_user_id.unique' => 'User is already assigned to another GN division.'
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $gn_division->gn_division_no = $request['gn_division_no'];
        $gn_division->gn_division_name = $request['gn_division_name'];
        $gn_division->ward_no = $request['ward_no'];
        $gn_division->gn_user_id = $request->gn_user_id;
        $gn_division->sn_user_id = $request->sn_user_id;

        $result = $gn_division->save();

        if ($result) {
            return Redirect::route('gn_divisions.show', $gn_division->id)->with('success', 'GN division was updated successfully');
        }
    }
}
