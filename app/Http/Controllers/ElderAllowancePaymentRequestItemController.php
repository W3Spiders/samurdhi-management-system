<?php

namespace App\Http\Controllers;

use App\Models\ElderAllowancePaymentRequestItem;
use Illuminate\Http\Request;

class ElderAllowancePaymentRequestItemController extends Controller
{
    public function store(Request $request) {
        $new_item = new ElderAllowancePaymentRequestItem();
        $new_item->elder_allowance_payment_request_id = $request['elder_allowance_payment_request_id'];
        $new_item->member_id = $request['member_id'];
        $new_item->amount = $request['amount'];

        $new_item->save();
}

public function update($id, Request $request) {

    $item = ElderAllowancePaymentRequestItem::findOrFail($id);

    $item->elder_allowance_payment_request_id = $request['elder_allowance_payment_request_id'];
    $item->member_id = $request['member_id'];
    $item->amount = $request['amount'];

    $item->save();
}
}