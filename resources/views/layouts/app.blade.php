<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Samurdhi and Beneficiary Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body class="antialiased">

    <div class="app-layout @yield('layoutClass')">

        <div class="app-layout-column-1">

            <div class="app-layout-sidebar">
                @section('sidebar')
                    @include('components.navigation')
                @show
            </div>

        </div>

        <div class="app-layout-column-2">

            @if (auth()->user())
                <div class="app-layout-header">

                    @include('components.header')

                </div>
            @endif

            <div class="app-layout-content">

                {{-- <h1 class="app-layout-title border-bottom">@yield('title')</h1> --}}

                <div class="app-layout-content-inner container">
                    @yield('content')
                </div>

            </div>
        </div>

    </div>


    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
