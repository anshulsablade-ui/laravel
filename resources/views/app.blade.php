<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'index')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

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

    <div class="app-wrapper">
      
      <nav class="app-header navbar navbar-expand bg-body">
        
        <div class="container-fluid">
                    <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
      
                  <img src="{{ asset('images/' . (auth()->user()->photo ? auth()->user()->photo : 'default.jpg')) }}"
                       class="user-image rounded-circle shadow"
                       alt="User Image"/>

                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                
                <li class="user-header text-bg-primary">

                    <img src="{{ asset('images/' . (auth()->user()->photo ? auth()->user()->photo : 'default.jpg')) }}"
                         class="user-image rounded-circle shadow"
                         alt="User Image"/>

                  <p>{{ auth()->user()->name }}</p>
                </li>
                
                <li class="user-footer">
                  <a href="{{ route('show.user', auth()->user()->id) }}" class="btn btn-default btn-flat">Profile</a>
                  <a href="javascript:void(0)" class="btn btn-default btn-flat float-end" id="logout">Sign out</a>
                </li>
                
              </ul>
            </li>
          </ul>
        </div>
        
      </nav>
      
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        
        <div class="sidebar-brand">
          
          <a href="{{ route('showUsers') }}" class="brand-link">
            
            <img
              src="{{ asset('/assets/img/AdminLTELogo.png') }}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            
            <span class="brand-text fw-light">Admin</span>
            
          </a>
          
        </div>
        
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            
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
              </li>
              <li class="nav-item">
                <a href="{{ route('multistep.form') }}" class="nav-link @if (request()->routeIs('multistep.form')) active @endif">
                   <p>Multi Step Form</p>
                </a>
              </li>
            </ul>
            
          </nav>
        </div>
        
      </aside>

      <main class="app-main">

        <div class="app-content pt-3">
          
          <div class="container-fluid">
                @yield('content')
          </div>
          
        </div>
        
      </main>
      
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>

    @yield('script')
    
    <script>
      $('#logout').click(function () {
        $.post("/logout", { _token: "{{ csrf_token() }}" }, function () {
          window.location.href = "/login";
        });
      });

      $(document).ready(function () {
        @if (session('message'))
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              }
            });
            Toast.fire({
              icon: "success",
              title: "{{ session('message') }}"
            });
        @endif
      });
    </script>
</body>

</html>
