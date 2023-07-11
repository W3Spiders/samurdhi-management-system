<?php

namespace App\Http\Controllers;

use App\Exports\ElderAllowancePaymentListExport;
use App\Models\ElderAllowancePaymentRequest;
use App\Models\Member;
use App\Models\MemberStatus;
use App\Models\PaymentRequestStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ElderAllowancePaymentRequestController extends Controller
{

    public function index(Request $request)
    {

        function search_query($query, $search)
        {
            return $query->where('ref', 'like', "%{$search}%");
        }

        $search = $request->input('search');

        $user = Auth::user();
        $user = User::with('gn_division')->find($user->id);

        $pending_payment_status = PaymentRequestStatus::where('status_code', 'pending_approval')->first();
        $approved_payment_status = PaymentRequestStatus::where('status_code', 'pending_approval')->first();

        $elder_allowance_payment_requests = [];

        if ($user->user_type === 'ds') {
            $elder_allowance_payment_requests = ElderAllowancePaymentRequest::where('status_id', $pending_payment_status->id)
                ->where(function (Builder $query) use ($search) {
                    return search_query($query, $search);
                })
                ->orderBy('status_id', 'asc')
                ->paginate(10);
        }

        if ($user->user_type === 'sn' || $user->user_type === 'gn') {
            $elder_allowance_payment_requests = ElderAllowancePaymentRequest::orderBy('status_id', 'asc')
                ->where(function (Builder $query) use ($search) {
                    return search_query($query, $search);
                })
                ->paginate(10);
        }



        return Inertia::render('ElderAllowancePaymentRequest/Index', [
            'filters' => $request->all('search', 'trashed'),
            'elder_allowance_payment_requests' => $elder_allowance_payment_requests
        ]);
    }

    public function create()
    {

        $user = Auth::user();
        $user = User::with('gn_division')->find($user->id);

        // Get 'approved' status item
        $approved_status = MemberStatus::where('status_code', 'approved')->first();

        // Find all approved members
        $elder_allowance_approved_members = Member::with(['occupation_type'])
        ->whereHas('family_unit', function($query) use ($user) {
            $query->where('gn_division_id', $user->gn_division->id);
        })
        ->where('status_id', $approved_status->id)->get();

        return Inertia::render('ElderAllowancePaymentRequest/Create', [
            'gn_division' => $user->gn_division,
            'elder_allowance_approved_members' => $elder_allowance_approved_members
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_date' => 'required',
            'payment_amount' => 'required|min:1|max:20000',
            'total_amount' => 'required|min:0',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $latest_request = ElderAllowancePaymentRequest::orderBy('created_at', 'DESC')->first();

        $ref_id = 0;

        if ($latest_request) {
            $ref_id = $latest_request->id;
        }

        $new_request = new ElderAllowancePaymentRequest();

        $new_request->gn_division_id = $request['gn_division_id'];
        $new_request->payment_amount = $request['payment_amount'];
        $new_request->payment_date = $request['payment_date'];
        $new_request->total_amount = $request['total_amount'];
        $new_request->ref = 'EAPR_' . str_pad($ref_id + 1, 8, '0', STR_PAD_LEFT);

        $result = $new_request->save();

        $request_item_controller = new ElderAllowancePaymentRequestItemController();

        // Save payment request items individually in the related table
        foreach ($request['items'] as $item) {
            $item['elder_allowance_payment_request_id'] = $new_request->id;
            $request_item_controller->store(new Request($item));
        }

        if ($result) {
            return Redirect::route('elder_allowance_payment_requests.index')->with('success', 'Elder allowance payment request was created successfully.');
        }
    }

    public function show($id)
    {
        $elder_allowance_payment_request = ElderAllowancePaymentRequest::with(['gn_division', 'items.member.occupation_type', 'status'])->findOrFail($id);

        return Inertia::render('ElderAllowancePaymentRequest/Show', [
            'elder_allowance_payment_request' => $elder_allowance_payment_request,
            'status_list' => PaymentRequestStatus::all()
        ]);
    }

    public function edit($id)
    {
        $elder_allowance_payment_request = ElderAllowancePaymentRequest::with(['gn_division', 'items.members.occupation_type', 'status'])->findOrFail($id);

        return Inertia::render('ElderAllowancePaymentRequest/Create', [
            'elder_allowance_payment_request' => $elder_allowance_payment_request,
            'gn_division' => $elder_allowance_payment_request->gn_division
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_date' => 'required',
            'payment_amount' => 'required|min:1|max:20000',
            'status_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $payment_request = ElderAllowancePaymentRequest::findOrFail($id);

        $payment_request->payment_amount = $request['payment_amount'];
        $payment_request->payment_date = $request['payment_date'];
        $payment_request->total_amount = $request['total_amount'];
        $payment_request->status_id = $request['status_id'];

        $result = $payment_request->save();

        if ($result) {
            return Redirect::route('elder_allowance_payment_requests.show', $payment_request->id)->with('success', 'Elder allowance payment request was updated successfully');
        }
    }

    public function export_payment_list($id)
    {
        return Excel::download(new ElderAllowancePaymentListExport(['payment_request_id' => $id]), 'elder_allowance_payment_list.xlsx');
    }

    public function print_payment_list($id)
    {
        $payment_request = ElderAllowancePaymentRequest::with('gn_division','items.member.bank_account')->findOrFail($id);

        $date = Carbon::create($payment_request->payment_date);
        $date_string =  $date->format('F Y');

        $data = [
            'heading' => 'Elder Allowance Payment List for ' . $date_string,
            'amount' => $payment_request->payment_amount,
            'total_amount' => $payment_request->total_amount,
            'items' => $payment_request->items,
            'gn_division' => $payment_request->gn_division
        ];

        $pdf = Pdf::loadView('exports.elder_allowance_payment_list', $data)->setPaper('a4', 'landscape');
        return $pdf->download('samurdhi_payment_list.pdf');
    }
}