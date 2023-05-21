@extends('layouts.app')

@section('layoutClass', 'welcome-page')

@section('title', 'Welcome')

@section('content')

    <a href="{{ route('login') }}" class="btn btn-info">Login</a>

@endsection
