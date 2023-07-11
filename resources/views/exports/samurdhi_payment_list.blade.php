<h1>{{ $heading }}</h1>

<table border="1" cellspacing="0" cellpadding="10" style="margin-bottom: 50px">
    <tr>
        <th>GN Division No</th>
        <td>{{ $gn_division->gn_division_no }}</td>
    </tr>
    <tr>
        <th>GN Division Name</th>
        <td>{{ $gn_division->gn_division_name }}</td>
    </tr>
    <tr>
        <th>Total Amount</th>
        <td>Rs. {{ number_format($total_amount, 2) }}</td>
    </tr>
</table>

<table border="1" cellspacing="0" cellpadding="10">
    <thead>
        <tr>
            <th>Family Unit Ref</th>
            <th>Amount</th>
            <th>Account Holder's Name</th>
            <th>Bank Name</th>
            <th>Bank Branch</th>
            <th>Bank Account Number</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            @php
                
                $bank_account = isset($item->family_unit->primary_member) ? $item->family_unit->primary_member->bank_account : null;
                
            @endphp

            <tr>
                <td>{{ $item->family_unit->family_unit_ref }}</td>
                <td>Rs. {{ number_format($amount, 2) }}</td>
                <td>{{ isset($bank_account) ? $bank_account->holder_name : '' }}</td>
                <td>{{ isset($bank_account) ? $bank_account->name : '' }}</td>
                <td>{{ isset($bank_account) ? $bank_account->branch : '' }}</td>
                <td>{{ isset($bank_account) ? $bank_account->account_number : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
