<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'index')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <style>
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
    </style> --}}
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
        <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    @yield('style')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

    {{-- <div class="container-fluid">
        <div class="row align-items-start">
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Users</a>
                </div>
            </nav>
        </div>
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <a href="{{ route('showUsers') }}" class="@if (request()->routeIs('showUsers')) active @endif">Users</a>
                <a href="{{ route('showCountrieslist') }}" class="@if (request()->routeIs('showCountrieslist')) active @endif">Countries</a>
                <a href="{{ route('showCitieslist') }}" class="@if (request()->routeIs('showCitieslist')) active @endif">City</a>
                <a href="{{ route('logout') }}" class="@if (request()->routeIs('logout')) active @endif">Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                @yield('content')
            </div>
        </div>
    </div> --}}

    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                @if (Auth::user()->photo) 
                    <img
                    src="{{ asset('images/' . Auth::user()->photo) }}"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                @else
                <img src="{{ asset('images/default.jpg') }}"
                    class="rounded-circle shadow"
                    alt="User Image"/>
                @endif
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                    @if (Auth::user()->photo) 
                        <img
                        src="{{ asset('images/' . Auth::user()->photo) }}"
                        class="rounded-circle shadow"
                        alt="User Image"
                      />
                    @else
                    <img src="{{ asset('images/default.jpg') }}"
                        class="rounded-circle shadow"
                        alt="User Image"/>
                    @endif
                  {{-- <img
                    src="./assets/img/user2-160x160.jpg"
                    class="rounded-circle shadow"
                    alt="User Image"
                  /> --}}
                  <p>{{ Auth::user()->name }}</p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="javascript:void(0)" class="btn btn-default btn-flat float-end" id="logout">Sign out</a>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
          </ul>
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="./assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Admin</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item">
                <a href="{{ route('showUsers') }}" class="nav-link @if (request()->routeIs('showUsers')) active @endif">
                  <p>Users</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('showCountrieslist') }}" class="nav-link @if (request()->routeIs('showCountrieslist')) active @endif">
                  <p>Countries</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('showCitieslist') }}" class="nav-link @if (request()->routeIs('showCitieslist')) active @endif">
                   <p>City</p>
                </a>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <div class="row">
                @yield('content')
            </div>
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>

    @yield('script')
    <script>
        $(document).ready(function () {
            $('#logout').on('click', function () {
                $.ajax({
                    type: "POST",
                    url: "{{ route('logout') }}",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });
        });
    </script>
</body>

</html>
