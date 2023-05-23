@extends('layouts.app')

@section('title', 'Family Unit')

@section('content')

    <!-- Family Unit Info -->
    <h2>Family Unit Details</h2>
    <div class="card mb-5">
        <div class="card-body">

            @include('pages.parts.familyUnitForm')

        </div>
    </div>

    <!-- Members List -->
    <h2>Members List</h2>
    <div class="card">
        <div class="card-body">

            @include('pages.parts.membersListTable')

        </div>
    </div>

@endsection
