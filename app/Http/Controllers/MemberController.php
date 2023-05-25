<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class MemberController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'nic' => 'nullable|min:10|max:12',
            'race' => 'required',
            'maritalStatus' => 'required',
            'monthlyIncome' => 'required_if:hasIncome,1|max:10000000',
            'phone' => 'min:10|max:10',
            'email' => 'nullable|email|max:50',
            'birthday' => 'required|before:today',
            'gender' => 'required'
        ], [
            'monthlyIncome.required_if' => 'Required when has monthly income selected'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Create new member
        $newMember = new Member();

        $newMember->family_unit_id = $request->familyUnitId;
        $newMember->first_name = $request->firstName;
        $newMember->last_name = $request->lastName;
        $newMember->middle_name = $request->middleName;
        $newMember->phone = $request->phone;
        $newMember->email = $request->email;
        $newMember->nic = $request->nic;
        $newMember->birthday = $request->birthday;
        $newMember->has_income = $request->hasIncome;
        $newMember->monthly_income = $request->monthlyIncome;
        $newMember->gender = $request->gender;
        $newMember->race = $request->race;
        $newMember->marital_status = $request->maritalStatus;

        $result = $newMember->save();

        if ($result) {
            return Redirect::back()->with('success', 'Member created successfully');
        }
    }
}