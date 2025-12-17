<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "index")</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f6fa;
        }

        .sidebar {
            min-height: 100vh;
            background: aliceblue;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #b1b6bb;
            color: #fff;
        }
    </style>
    @yield('style')
</head>

<body>

    <div class="container-fluid">
        <div class="row align-items-start">
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Users</a>
                </div>
            </nav>
        </div>
        <div class="container-fluid">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-md-2 sidebar p-0">
                    <a href="{{ route('showUsers') }}" class="@if (request()->routeIs('showUsers')) active @endif">Users</a>
                    <a href="{{ route('showCountrieslist') }}" class="@if (request()->routeIs('showCountrieslist')) active @endif">Countries</a>
                    <a href="{{ route('showCitieslist') }}" class="@if (request()->routeIs('showCitieslist')) active @endif">City</a>
                    <a href="{{ route('showRegisterForm') }}" class="@if (request()->routeIs('showRegisterForm')) active @endif">Register</a>
                    <a href="{{ route('showLoginForm') }}" class="@if (request()->routeIs('showLoginForm')) active @endif">Login</a>
                </div>

                <!-- Main Content -->
                <div class="col-md-10 p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    @yield('script')
</body>

</html>
