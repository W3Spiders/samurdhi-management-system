<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\FamilyUnit;
use App\Models\Member;
use App\Models\OccupationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MemberController extends Controller
{

    /**
     * Create member
     */
    public function create(Request $request)
    {

        $occupation_types = OccupationType::all();
        $family_unit = FamilyUnit::find($request->family_unit_id);

        return Inertia::render('Members/Create', ['family_unit' => $family_unit, 'family_unit_id' => $request->family_unit_id, 'occupation_types' => $occupation_types]);
    }

    /**
     * View single member
     */
    public function show($member_id)
    {
        $member = Member::with(['family_unit', 'occupation_type', 'bank_account'])->find($member_id);

        return Inertia::render('Members/Show', ['member' => $member]);
    }

    public function edit($id)
    {
        $member = Member::with('bank_account')->find($id);
        $family_unit = FamilyUnit::find($member->family_unit_id);
        $occupation_types = OccupationType::all();

        return Inertia::render('Members/Create', ['member' => $member, 'family_unit' => $family_unit, 'occupation_types' => $occupation_types]);
    }

    /**
     * Validate form request and store member
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'nic' => ['unique:members', 'nullable', 'min:10', 'max:12', "regex:/(?:19|20)?\d{2}[0-9]{10}|[0-9]{9}[x|X|v|V]/"],
            'marital_status' => 'required',
            'monthly_income' => 'max:10000000',
            'phone' => 'unique:members|min:10|max:10',
            'email' => 'unique:members|nullable|email|max:50',
            'birthday' => 'required|before:today',
            'gender' => 'required'
        ], [
            'monthly_income.required_if' => 'Required when has monthly income selected',
            'nic.regex' => 'Invalid ID number',
            'nic.unique' => 'A member has been registered with this national id',
            'phone.unique' => 'This phone number is used for another member',
            'email.unique' => 'This email is used for another member'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $bank_account = null;

        if ($request['bank_account'] && $request['bank_account_number']) {
            // Create a bank account if provided
            $bank_account = new BankAccount();
            $bank_account->account_number = $request['bank_account']['account_number'];
            $bank_account->holder_name = $request['bank_account']['holder_name'];
            $bank_account->name = $request['bank_account']['name'];
            $bank_account->branch = $request['bank_account']['branch'];
            $bank_account->save();
        }

        // Create new member
        $new_member = new Member();

        $new_member->family_unit_id = $request->family_unit_id;
        $new_member->first_name = $request->first_name;
        $new_member->last_name = $request->last_name;
        $new_member->middle_name = $request->middle_name;
        $new_member->phone = $request->phone;
        $new_member->email = $request->email;
        $new_member->nic = $request->nic;
        $new_member->birthday = $request->birthday;
        $new_member->monthly_income = $request->monthly_income;
        $new_member->gender = $request->gender;
        $new_member->marital_status = $request->marital_status;
        $new_member->occupation_type_id = $request->occupation_type;
        $new_member->occupation = $request->occupation;

        if ($bank_account) {
            $new_member->bank_account_id = $bank_account->id;
        }

        $result = $new_member->save();

        if ($result) {
            return Redirect::route('family_units.show', ['id' => $new_member->family_unit_id])->with('success', 'Member added successfully');
        }
    }

    /**
     * Validate form request, check whether member exists and update member
     */
    public function update($id, Request $request)
    {

        $member = Member::find($id);

        if (!$member) {
            return Redirect::back()->with('error', 'Member doesn\'t exist');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'nic' => ['nullable', 'min:10', 'max:12', "regex:/r'^(?:19|20)?\d{2}[0-9]{10}|[0-9]{9}[x|X|v|V]/"],
            'marital_status' => 'required',
            'monthly_income' => 'max:10000000',
            'phone' => 'min:10|max:10',
            'email' => 'nullable|email|max:50',
            'birthday' => 'required|before:today',
            'gender' => 'required'
        ], [
            'monthly_income.required_if' => 'Required when has monthly income selected',
            'nic.regex' => 'Invalid ID number',
            'nic.unique' => 'A member has been registered with this national id',
            'phone.unique' => 'This phone number is used for another member',
            'email.unique' => 'This email is used for another member'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $bank_account = null;

        if ($member->bank_account_id) {
            // Update existing account
            $bank_account = BankAccount::find($member->bank_account_id);

        } else if ($request['bank_account'] && $request['bank_account']['account_number']) {
            // Create new account
            $bank_account = new BankAccount();
        }

        if ($bank_account) {
            $bank_account->account_number = $request['bank_account']['account_number'];
            $bank_account->holder_name = $request['bank_account']['holder_name'];
            $bank_account->name = $request['bank_account']['name'];
            $bank_account->branch = $request['bank_account']['branch'];
            $bank_account->save();
        }


        $member->family_unit_id = $request->family_unit_id;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->middle_name = $request->middle_name;
        $member->phone = $request->phone;
        $member->email = $request->email;
        $member->nic = $request->nic;
        $member->birthday = $request->birthday;
        $member->monthly_income = $request->monthly_income;
        $member->gender = $request->gender;
        $member->marital_status = $request->marital_status;
        $member->occupation_type_id = $request->occupation_type;
        $member->occupation = $request->occupation;

        if ($bank_account) {
            $member->bank_account_id = $bank_account->id;
        }

        $result = $member->save();

        if ($result) {
            return Redirect::route('members.show', $member->id)->with('success', 'Member updated successfully');
        }
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        $family_unit_id = $member->family_unit_id;

        if (!$member) {
            return Redirect::back()->with('error', 'Member doesn\'t exist');
        }

        $member->delete();

        return Redirect::route('family_units.show', $family_unit_id)->with('success', 'Member deleted.');
    }
}