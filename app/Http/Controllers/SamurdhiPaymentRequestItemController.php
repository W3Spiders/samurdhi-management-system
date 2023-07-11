<?php

namespace App\Http\Controllers;

use App\Models\SamurdhiPaymentRequestItem;
use Illuminate\Http\Request;

class SamurdhiPaymentRequestItemController extends Controller
{
    public function store(Request $request) {
            $new_item = new SamurdhiPaymentRequestItem();
            $new_item->samurdhi_payment_request_id = $request['samurdhi_payment_request_id'];
            $new_item->family_unit_id = $request['family_unit_id'];
            $new_item->amount = $request['amount'];

            $new_item->save();
    }

    public function update($id, Request $request) {

        $item = SamurdhiPaymentRequestItem::findOrFail($id);

        $item->samurdhi_payment_request_id = $request['samurdhi_payment_request_id'];
        $item->family_unit_id = $request['family_unit_id'];
        $item->amount = $request['amount'];

        $item->save();
}
}