@extends('layouts.app')

@section('title', 'Manage Wards')

@section('content')

    <div class="p-4" style="max-width: 600px">

        <div>
            <table class="table table-bordered">
                <thead>
                    <th>Ward No</th>
                    <th>Ward Name</th>
                </thead>

                <tbody>
                    @foreach ($wards as $ward)
                        <tr>
                            <td>{{ $ward['ward_no'] }}</td>
                            <td>{{ $ward['ward_name'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <form method="POST" action="{{ route('ward') }}" class="mb-4">
                @csrf

                <div class="mb-3">
                    <label for="ward_no" class="form-label">Ward No</label>
                    <input type="number" min="1" max="99" class="form-control" id="ward_no" name="ward_no"
                        value="{{ old('ward_no') }}">
                </div>

                <div class="mb-3">
                    <label for="ward_name" class="form-label">Ward Name</label>
                    <input type="text" class="form-control" id="ward_name" name="ward_name">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        {{ session('success') }}
                    </ul>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif
        </div>

    </div>

@endsection
