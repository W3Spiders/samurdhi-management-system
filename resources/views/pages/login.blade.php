@extends('layouts.app')

@section('layoutClass', 'login-page')

@section('title', 'Login')

@section('content')

    <div>
        {{ Auth::user() }}
    </div>

    <div class="auth-page-wrapper bg-light">



        <div class="login-form-container border border-secondary shadow rounded">
            <h1 class="bg-primary text-center mb-3 py-3 text-white h3">Admin Login</h1>

            <div class="p-4">
                <form method="POST" action="{{ route('login.attempt') }}" class="mb-4">
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username') }}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
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
    </div>

@endsection
