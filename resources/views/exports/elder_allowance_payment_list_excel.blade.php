<table>
    <thead>
        <tr>
            <th>Member Name</th>
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
                
                $bank_account = isset($item->member) ? $item->member->bank_account : null;
                
            @endphp

            <tr>
                <td>{{ $item->member->full_name }}</td>
                <td>Rs. {{ number_format($amount, 2) }}</td>
                <td>{{ isset($bank_account) ? $bank_account->holder_name : '' }}</td>
                <td>{{ isset($bank_account) ? $bank_account->name : '' }}</td>
                <td>{{ isset($bank_account) ? $bank_account->branch : '' }}</td>
                <td>{{ isset($bank_account) ? $bank_account->account_number : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
