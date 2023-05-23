<table class="table table-bordered">

    <thead>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Birthday</th>
    </thead>

    @foreach ($familyUnit->members as $member)
        <tr>
            <td>{{ $member->first_name }}</td>
            <td>{{ $member->last_name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->phone }}</td>
            <td>{{ $member->birthday }}</td>
        </tr>
    @endforeach

</table>
