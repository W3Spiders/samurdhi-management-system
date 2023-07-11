<?php

namespace App\Exports;

use App\Models\SamurdhiPaymentRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SamurdhiPaymentListExport implements FromView
{

    protected $payment_request_id;

    public function __construct($args)
    {
        $this->payment_request_id = $args['payment_request_id'];
    }

    public function view(): View
    {

        $payment_request = SamurdhiPaymentRequest::with('items.family_unit.primary_member.bank_account')->findOrFail($this->payment_request_id);

        return view('exports.samurdhi_payment_list_excel', [
            'amount' => $payment_request->payment_amount,
            'items' => $payment_request->items
        ]);
    }
}