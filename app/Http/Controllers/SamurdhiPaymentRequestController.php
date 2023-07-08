<?php

namespace App\Http\Controllers;

use App\Models\FamilyUnit;
use App\Models\FamilyUnitStatus;
use App\Models\PaymentRequestStatus;
use App\Models\SamurdhiPaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SamurdhiPaymentRequestController extends Controller
{

    public function index(Request $request)
    {

        $user = Auth::user();
        $user = User::with('gn_division')->find($user->id);

        if ($user->user_type === 'gn' || $user->user_type === 'sn') {
            $samurdhi_payment_requests = SamurdhiPaymentRequest::with(['items', 'status'])->where('gn_division_id', $user->gn_division->id)->get();
        } else {
            $samurdhi_payment_requests = SamurdhiPaymentRequest::with(['items', 'status'])->get();
        }



        return Inertia::render('SamurdhiPaymentRequest/Index', [
            'filters' => $request->all('search', 'trashed'),
            'samurdhi_payment_requests' => $samurdhi_payment_requests
        ]);
    }

    public function create()
    {

        $user = Auth::user();
        $user = User::with('gn_division')->find($user->id);

        // Get 'approved' status item
        $approved_status = FamilyUnitStatus::where('status_code', 'approved')->first();

        // Find all samurdhi approved family units
        $samurdhi_approved_family_units = FamilyUnit::with(['primary_member'])->where('gn_division_id', $user->gn_division->id)->where('status_id', $approved_status->id)->get();

        return Inertia::render('SamurdhiPaymentRequest/Create', [
            'gn_division' => $user->gn_division,
            'samurdhi_approved_family_units' => $samurdhi_approved_family_units
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_date' => 'required',
            'total_amount' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $latest_request = SamurdhiPaymentRequest::orderBy('created_at', 'DESC')->first();

        $ref_id = 0;

        if ($latest_request) {
            $ref_id = $latest_request->id;
        }

        $new_request = new SamurdhiPaymentRequest();

        $new_request->gn_division_id = $request['gn_division_id'];
        $new_request->payment_date = $request['payment_date'];
        $new_request->total_amount = $request['total_amount'];
        $new_request->ref = 'SPR_' . str_pad($ref_id + 1, 8, '0', STR_PAD_LEFT);

        $result = $new_request->save();

        $request_item_controller = new SamurdhiPaymentRequestItemController();

        // Save payment request items individually in the related table
        foreach ($request['items'] as $item) {
            $item['samurdhi_payment_request_id'] = $new_request->id;
            $request_item_controller->store(new Request($item));
        }

        if ($result) {
            return Redirect::route('samurdhi_payment_requests.index')->with('success', 'Samurdhi payment request was created successfully.');
        }
    }

    public function show($id)
    {
        $samurdhi_payment_request = SamurdhiPaymentRequest::with(['gn_division', 'items.family_unit.primary_member', 'status'])->find($id);

        return Inertia::render('SamurdhiPaymentRequest/Show', [
            'samurdhi_payment_request' => $samurdhi_payment_request,
            'status_list' => PaymentRequestStatus::all()
        ]);
    }

    public function edit($id)
    {
        $samurdhi_payment_request = SamurdhiPaymentRequest::with(['gn_division'])->findOrFail($id);

        return Inertia::render('SamurdhiPaymentRequest/Create', [
            'samurdhi_payment_request' => $samurdhi_payment_request,
            'gn_division' => $samurdhi_payment_request->gn_division
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_date' => 'required',
            'status_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $samurdhi_payment_request = SamurdhiPaymentRequest::findOrFail($id);

        $samurdhi_payment_request->payment_date = $request['payment_date'];
        $samurdhi_payment_request->status_id = $request['status_id'];

        $result = $samurdhi_payment_request->save();

        if ($result) {
            return Redirect::route('samurdhi_payment_requests.show', $samurdhi_payment_request->id)->with('success', 'Samurdhi payment request was updated successfully');
        }
    }
}
