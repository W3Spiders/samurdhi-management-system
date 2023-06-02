<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
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

        return Inertia::render('Dashboard/Index', ['payment_requests' => $payment_requests]);
    }
}