<?php

namespace App\Http\Controllers;

use App\Models\FamilyUnitStatus;
use App\Models\GnDivision;
use App\Models\MemberStatus;
use App\Models\PaymentRequestStatus;
use App\Models\SamurdhiPaymentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index() {


        $gn_wise_samurdhi_payment_allocation_last_month = [
            [
                'gn_division_no' => '606A',
                'gn_division' => 'Welmilla',
                'member_count' => 'Rs.147 000'
            ],
            [
                'gn_division_no' => '606C',
                'gn_division' => 'Halapitiya',
                'member_count' => 'Rs.192 500'
            ],
            [
                'gn_division_no' => '606',
                'gn_division' => 'Godigamuwa West',
                'member_count' => 'Rs. 252 000'
            ],
            [
                'gn_division_no' => '606B',
                'gn_division' => 'Godigamuwa East',
                'member_count' => 'Rs. 155 000'
            ],
            [
                'gn_division_no' => '604',
                'gn_division' => 'Palannoruwa',
                'member_count' => 'Rs. 135 000'
            ],
            [
                'gn_division_no' => '604A',
                'gn_division' => 'Koreleima',
                'member_count' => 'Rs. 164 000'
            ],
            [
                'gn_division_no' => '605',
                'gn_division' => 'Olaboduwa South',
                'member_count' => 'Rs. 156 000'
            ]
        ];

        $gn_wise_elder_allowance_payment_allocation_last_month = [
            [
                'gn_division_no' => '606A',
                'gn_division' => 'Welmilla',
                'member_count' => 'Rs. 67 500'
            ],
            [
                'gn_division_no' => '606C',
                'gn_division' => 'Halapitiya',
                'member_count' => 'Rs. 62 000'
            ],
            [
                'gn_division_no' => '606',
                'gn_division' => 'Godigamuwa West',
                'member_count' => 'Rs. 90 000'
            ],
            [
                'gn_division_no' => '606B',
                'gn_division' => 'Godigamuwa East',
                'member_count' => 'Rs. 54 000'
            ],
            [
                'gn_division_no' => '604',
                'gn_division' => 'Palannoruwa',
                'member_count' => 'Rs. 62 500'
            ],
            [
                'gn_division_no' => '604A',
                'gn_division' => 'Koreleima',
                'member_count' => 'Rs. 50 000'
            ],
            [
                'gn_division_no' => '605',
                'gn_division' => 'Olaboduwa South',
                'member_count' => 'Rs. 72 000'
            ]
        ];

        $samurdhi_approved_status = FamilyUnitStatus::where('status_code', 'approved')->first();
        $elder_allowance_approved_status = MemberStatus::where('status_code', 'approved')->first();
        $payment_approved_status = PaymentRequestStatus::where('status_code', 'approved')->first();

        $gn_wise_samurdhi_registered_family_data = GnDivision::with(['family_units'])->whereHas('family_units', function($query) use($samurdhi_approved_status) {
            $query->where('status_id', $samurdhi_approved_status->id);
        })->get();

        $gn_wise_elder_allowance_registered_member_data = GnDivision::with(['family_units.members'])->whereHas('family_units', function($query) use($elder_allowance_approved_status) {
            $query->where('status_id', $elder_allowance_approved_status->id);
        })->get();

        $last_month_start = Carbon::now()->subMonth()->startOfMonth();
        $last_month_end = Carbon::now()->subMonth()->endOfMonth();

        $gn_wise_samurdhi_payment_allocation_last_month = GnDivision::with('samurdhi_payment_requests')->whereHas('samurdhi_payment_requests', function($query) use($last_month_start, $last_month_end, $payment_approved_status) {
            $query->whereBetween('payment_date', [$last_month_start, $last_month_end])
            ->where('status_id', $payment_approved_status->id);
        })->get();

        return Inertia::render('Reports/Index', [
            'gn_wise_samurdhi_registered_family_data' => $gn_wise_samurdhi_registered_family_data, 
            'gn_wise_elder_allowance_registered_member_data' => $gn_wise_elder_allowance_registered_member_data,
            'gn_wise_samurdhi_payment_allocation_last_month' => $gn_wise_samurdhi_payment_allocation_last_month,
            'gn_wise_elder_allowance_payment_allocation_last_month' => $gn_wise_elder_allowance_payment_allocation_last_month
        ]);
    }
}