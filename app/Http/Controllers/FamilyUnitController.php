<?php

namespace App\Http\Controllers;

use App\Models\FamilyUnit;
use App\Models\FamilyUnitStatus;
use App\Models\GnDivision;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\generate_family_unit_ref;
use function App\Http\Controllers\search_query as ControllersSearch_query;

class FamilyUnitController extends Controller
{
    /**
     * View family unit list
     */
    public function index(Request $request)
    {

        function search_query($query, $search)
        {
            return $query->where('family_unit_ref', 'like', "%{$search}%")
                ->orWhereHas('primary_member', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
        }

        $search = $request->input('search');

        $family_units = [];

        $user = Auth::user();
        $user = User::with('gn_division.family_units.primary_member')->get()->find($user->id);

        $pending_approval_status = FamilyUnitStatus::where('status_code', 'pending_approval')->first();

        if (isset($user['gn_division']) && isset($user['gn_division']['family_units']) && !is_null($user['gn_division']['family_units'])) {
            $family_units = FamilyUnit::with(['primary_member'])
                ->where('gn_division_id', $user['gn_division']->id)
                ->where(function (Builder $query) use ($search) {
                    return search_query($query, $search);
                })
                ->orderBy('status_id', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else if ($user['user_type'] === 'ds') {
            $family_units = FamilyUnit::with(['primary_member'])
                ->where('status_id', $pending_approval_status->id)
                ->where(function (Builder $query) use ($search) {
                    return search_query($query, $search);
                })
                ->orderBy('status_id', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Don't show family units for other user types
            $family_units = FamilyUnit::with(['primary_member'])->where('gn_division_id', -1)->paginate(10);
        }

        return Inertia::render('FamilyUnits/Index', [
            'filters' => $request->all('search', 'trashed'),
            'family_units' => $family_units,
        ]);
    }

    /**
     * Create family unit
     */
    public function create()
    {

        $user = Auth::user();
        $user = User::with('gn_division')->find($user->id);

        return Inertia::render('FamilyUnits/Create', [
            'gn_division' => $user->gn_division,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'house_no' => 'unique:family_units|required|max:8',
            'address_line_1' => 'required',
            'city' => 'required',
            'postal_code' => 'required|max:5',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Generate family_unit_ref here
        $family_unit_ref = generate_family_unit_ref($request['gn_division_no'], $request['house_no']);

        // Create new family unit
        $new_family_unit = new FamilyUnit();

        $new_family_unit->house_no = $request['house_no'];
        $new_family_unit->family_unit_ref = $family_unit_ref;
        $new_family_unit->gn_division_id = $request['gn_division_id'];
        $new_family_unit->address_line_1 = $request['address_line_1'];
        $new_family_unit->address_line_2 = $request['address_line_2'];
        $new_family_unit->city = $request['city'];
        $new_family_unit->postal_code = $request['postal_code'];

        $result = $new_family_unit->save();

        if ($result) {
            return Redirect::route('family_units.index')->with('success', 'Family unit was created successfully');
        }
    }

    /**
     * View single family unit
     */
    public function show($id)
    {

        $family_unit = FamilyUnit::with(['primary_eligible_members', 'status', 'gn_division', 'primary_member.occupation_type', 'members.occupation_type',])->withCount('members')->find($id);
        $family_unit = $family_unit->append('has_met_samurdhi_eligible_criteria');

        $status_list = FamilyUnitStatus::all();

        return Inertia::render('FamilyUnits/Show', [
            'family_unit' => $family_unit, 'status_list' => $status_list
        ]);
    }

    /** View Family Unit Edit Form */
    public function edit($id)
    {
        $family_unit = FamilyUnit::with('primary_member')->find($id);
        $gn_division = GnDivision::find($family_unit->gn_division_id);

        return Inertia::render('FamilyUnits/Create', ['family_unit' => $family_unit, 'gn_division' => $gn_division]);
    }

    public function update($id, Request $request)
    {
        $family_unit = FamilyUnit::find($id);

        if (!$family_unit) {
            return Redirect::back()->with('error', 'Family unit doesn\'t exist');
        }

        $validator = Validator::make($request->all(), [
            'house_no' => 'required|max:8',
            'address_line_1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        //$family_unit->gn_division_id = $request['gn_division_id'];
        $family_unit->address_line_1 = $request['address_line_1'];
        $family_unit->address_line_2 = $request['address_line_2'];
        $family_unit->city = $request['city'];
        $family_unit->postal_code = $request['postal_code'];
        $family_unit->primary_member_id = $request['primary_member_id'];

        if (isset($request['status_id'])) {
            $family_unit->status_id = $request['status_id'];
        }

        $result = $family_unit->save();

        if ($result) {
            return Redirect::route('family_units.show', $family_unit->id)->with('success', 'Family unit was updated successfully');
        }
    }

    public function destroy($id)
    {
        $family_unit = FamilyUnit::findOrFail($id);

        $family_unit->delete();

        return Redirect::route('family_units.index')->with('success', 'Family unit was deleted successfully.');
    }
}