@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="auth-page-wrapper bg-light">
        <div class="p-4">
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

            @if ($errors->any())
                <div class="alert alert-danger">
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
