<?php

namespace App\Http\Controllers;

use App\Models\PaymentRequestStatus;
use App\Models\SamurdhiPaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $family_units = [];
        // $family_units = FamilyUnit::with('primary_member')->get();

        $user = Auth::user();
        $user = User::with(['gn_division.sn_user', 'gn_division.gn_user', 'gn_division.family_units.primary_member'])->get()->find($user->id);

        if (isset($user['gn_division']) && isset($user['gn_division']['family_units']) && !is_null($user['gn_division']['family_units'])) {
            $family_units = $user['gn_division']['family_units'];
        }

        $samurdhi_approved_count = 0;

        foreach ($family_units as $family_unit) {
            if ($family_unit['status']['status_code'] === 'approved') {
                $samurdhi_approved_count++;
            }
        }

        $payment_requests = [
            [
                'family_unit_ref' => '606A47558',
                'house_holder_name' => 'Kamal De Silva',
                'amount' => 10000,
                'status' => 1,
                'status_string' => 'New',
            ],
            [
                'family_unit_ref' => '606A47582',
                'house_holder_name' => 'Sunimal Perera',
                'amount' => 10000,
                'status' => 2,
                'status_string' => 'Pending Approval',
            ],
            [
                'family_unit_ref' => '606A47574',
                'house_holder_name' => 'Pushpa De Mel',
                'amount' => 10000,
                'status' => 3,
                'status_string' => 'Approved',
            ],
            [
                'family_unit_ref' => '606A47558',
                'house_holder_name' => 'Wimal Gamlath',
                'amount' => 10000,
                'status' => 5,
                'status_string' => 'Paid',
            ],
            [
                'family_unit_ref' => '606A47585',
                'house_holder_name' => 'Nimal Premathilaka',
                'amount' => 10000,
                'status' => 4,
                'status_string' => 'Rejected',
            ]
        ];

        $pending_payment_status = PaymentRequestStatus::where('status_code', 'pending_approval')->first();
        $approved_payment_status = PaymentRequestStatus::where('status_code', 'approved')->first();

        $pending_samurdhi_payment_requests = [];
        $approved_samurdhi_payment_requests = [];

        if ($user->user_type === 'ds') {
            $pending_samurdhi_payment_requests = SamurdhiPaymentRequest::where('status_id', $pending_payment_status->id)->get();
        }

        if ($user->user_type === 'sn') {
            $approved_samurdhi_payment_requests = SamurdhiPaymentRequest::where('status_id', $approved_payment_status->id)->get();
        }

        return Inertia::render('Dashboard/Index', [
            'payment_requests' => $payment_requests,
            'pending_samurdhi_payment_requests' => $pending_samurdhi_payment_requests,
            'approved_samurdhi_payment_requests' => $approved_samurdhi_payment_requests,
            'family_units_count' => count($family_units),
            'samurdhi_approved_count' => $samurdhi_approved_count,
            'gn_division' => $user['gn_division']
        ]);
    }
}
