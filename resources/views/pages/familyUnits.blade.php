@extends('layouts.app')

@section('title', 'Family Units')

@section('content')

    <table class="table table-bordered">
        <thead>
            <th>Family Unit Id</th>
            <th>Primary Member Id</th>
            <th>Address</th>
        </thead>
        <tbody>

            @foreach ($familyUnits as $familyUnit)
                <tr>
                    <td>{{ $familyUnit->id }}</td>
                    <td>{{ $familyUnit->primary_member_id }}</td>
                    <td>
                        {{ $familyUnit->address_line_1 }}<br />
                        {{ $familyUnit->address_line_2 }}<br />
                        {{ $familyUnit->city }} {{ $familyUnit->postal_code }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endsection
