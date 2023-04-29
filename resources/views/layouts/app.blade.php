<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Samurdhi and Beneficiary Management System - @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body class="antialiased">

    <div class="app-layout">

        <div class="app-layout-column-1">
            <div class="app-layout-sidebar">
                @section('sidebar')
                    <ul>
                        <li>Link 1</li>
                        <li>Link 2</li>
                        <li>Link 3</li>
                    </ul>
                @show
            </div>
        </div>

        <div class="app-layout-column-2">
            <div class="app-layout-header">
                @section('header')
                    <p>This is the app header</p>
                @show
            </div>
    
            <div class="app-layout-content">
                @yield('content')
            </div>
        </div>

    </div>


    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>

