<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index() {

        $gn_wise_samurdhi_registered_family_data = [
            [   'id' => 1,
                'gn_division_no' => '606A',
                'gn_division' => 'Welmilla',
                'family_unit_count' => 42
            ],
            [   'id' => 2,
                'gn_division_no' => '606C',
                'gn_division' => 'Halapitiya',
                'family_unit_count' => 55
            ],
            [   'id' => 3,
                'gn_division_no' => '606',
                'gn_division' => 'Godigamuwa West',
                'family_unit_count' => 72
            ],
            [   'id' => 4,
                'gn_division_no' => '606B',
                'gn_division' => 'Godigamuwa East',
                'family_unit_count' => 35
            ],
            [   'id' => 5,
                'gn_division_no' => '604',
                'gn_division' => 'Palannoruwa',
                'family_unit_count' => 58
            ],
            [   'id' => 6,
                'gn_division_no' => '604A',
                'gn_division' => 'Koreleima',
                'family_unit_count' => 65
            ],
            [   'id' => 7,
                'gn_division_no' => '605',
                'gn_division' => 'Olaboduwa South',
                'family_unit_count' => 43
            ]
        ];

        $gn_wise_elder_allowance_registered_member_data = [
            [
                'gn_division_no' => '606A',
                'gn_division' => 'Welmilla',
                'member_count' => 25
            ],
            [
                'gn_division_no' => '606C',
                'gn_division' => 'Halapitiya',
                'member_count' => 27
            ],
            [
                'gn_division_no' => '606',
                'gn_division' => 'Godigamuwa West',
                'member_count' => 36
            ],
            [
                'gn_division_no' => '606B',
                'gn_division' => 'Godigamuwa East',
                'member_count' => 20
            ],
            [
                'gn_division_no' => '604',
                'gn_division' => 'Palannoruwa',
                'member_count' => 32
            ],
            [
                'gn_division_no' => '604A',
                'gn_division' => 'Koreleima',
                'member_count' => 28
            ],
            [
                'gn_division_no' => '605',
                'gn_division' => 'Olaboduwa South',
                'member_count' => 31
            ]
        ];

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

        return Inertia::render('Reports/Index', [
            'gn_wise_samurdhi_registered_family_data' => $gn_wise_samurdhi_registered_family_data, 
            'gn_wise_elder_allowance_registered_member_data' => $gn_wise_elder_allowance_registered_member_data,
            'gn_wise_samurdhi_payment_allocation_last_month' => $gn_wise_samurdhi_payment_allocation_last_month,
            'gn_wise_elder_allowance_payment_allocation_last_month' => $gn_wise_elder_allowance_payment_allocation_last_month
        ]);
    }
}