<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MemberController extends Controller
{

    public function create(Request $request) {
        
        return Inertia::render('Members/Create', ['family_unit_id' => $request->family_unit_id]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'nic' => ['nullable', 'min:10', 'max:12', "regex:/r'^(?:19|20)?\d{2}[0-9]{10}|[0-9]{9}[x|X|v|V]/"],
            'marital_status' => 'required',
            'monthly_income' => 'required_if:has_income,1|max:10000000',
            'phone' => 'min:10|max:10',
            'email' => 'nullable|email|max:50',
            'birthday' => 'required|before:today',
            'gender' => 'required'
        ], [
            'monthly_income.required_if' => 'Required when has monthly income selected',
            'nix.regex' => 'Invalid ID number'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Create new member
        $newMember = new Member();

        $newMember->family_unit_id = $request->family_unit_id;
        $newMember->first_name = $request->first_name;
        $newMember->last_name = $request->last_name;
        $newMember->middle_name = $request->middle_name;
        $newMember->phone = $request->phone;
        $newMember->email = $request->email;
        $newMember->nic = $request->nic;
        $newMember->birthday = $request->birthday;
        $newMember->has_income = $request->has_income;
        $newMember->monthly_income = $request->monthly_income;
        $newMember->gender = $request->gender;
        $newMember->marital_status = $request->marital_status;

        $result = $newMember->save();

        if ($result) {
            return Redirect::back()->with('success', 'Member created successfully');
        }
    }
}