<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
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
</head>

<body class="register-page bg-body-secondary">

    <div class="register-box">
      <!-- /.register-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1 class="mb-0">Register</h1>
        </div>
        <div class="card-body register-card-body">
            
          <form id="register">

            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="registerFullName" type="text" name="name" class="form-control" placeholder="" />
                <label for="registerFullName">Full Name</label>
              </div>
              <div class="input-group-text"><span class="bi bi-person"></span></div>
            </div>
            <span class="text-danger error-text name_err"></span>

            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="registerEmail" type="email" name="email" class="form-control" placeholder="" />
                <label for="registerEmail">Email</label>
              </div>
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            <span class="text-danger error-text email_err"></span>

            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="registerPassword" type="password" name="password" class="form-control" placeholder="" />
                <label for="registerPassword">Password</label>
              </div>
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <span class="text-danger error-text password_err"></span>

            <div class="row">

              {{-- <div class="col-8 d-inline-flex align-items-center">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree to the <a href="#">terms</a>
                  </label>
                </div>
              </div> --}}
              
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
              </div>
              
            </div>
            
          </form>

          <!-- /.social-auth-links -->
          <p class="mb-0">
            Already have an account ?
            <a href="{{ route('showLoginForm') }}" class="link-primary text-center">Login</a>
          </p>
        </div>
        <!-- /.register-card-body -->
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#register").submit(function(e) {
                e.preventDefault();

                ajaxCall('{{ route('register') }}', 'POST', new FormData(this), function(response) {
                    if (response.status == "success") {
                        window.location.href = "{{ route('showLoginForm') }}";
                    }

                    if (response.status === "errors") {
                        let errors = response.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_err').text(value[0]);
                        });
                    }
                })
            });
        });
    </script>
</body>

</html>
