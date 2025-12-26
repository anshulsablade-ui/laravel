<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
    onload="this.media='all'" />
</head>

<body class="login-page bg-body-secondary">

  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h1 class="mb-0">Login</h1>
      </div>
      <div class="card-body login-card-body">

        <form id="loginForm">

          <div class="input-group mb-1">
            <div class="form-floating">
              <input id="loginEmail" type="email" name="email" class="form-control" value="" placeholder="" />
              <label for="loginEmail">Email</label>
            </div>
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
          </div>
          <span class="text-danger error-text email_err"></span>

          <div class="input-group mb-1">
            <div class="form-floating">
              <input id="loginPassword" type="password" name="password" class="form-control" placeholder="" />
              <label for="loginPassword">Password</label>
            </div>
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
          </div>
          <span class="text-danger error-text password_err"></span>

          <!--begin::Row-->
          <div class="row">

            <!-- /.col -->
            <div class="col-4">
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Sign In</button>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!--end::Row-->
        </form>
        <!-- /.social-auth-links -->
        {{-- <p class="mb-1"><a href="forgot-password.html" class="">I forgot my password</a></p> --}}
        <p class="mb-0">
          Don't have an account ?
          <a href="{{ route('showRegisterForm') }}" class="text-center">Register</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="{{ asset('js/adminlte.js') }}"></script>
  <script src="{{ asset('js/ajax.js') }}"></script>

  <script>
    $("#loginForm").submit(function (e) {
      e.preventDefault();

      $('.error-text').text('');

      ajaxCall('{{ route('login') }}', 'POST', new FormData(this), function (response) {
        if (response.status == "success") {
          window.location.href = "{{ route('showUsers') }}";
        }
        console.log(response.message);
        if (response.status === "errors") {
          $('.email_err').text(response.message);
        }
      }, function (response) {
        let errors = response.responseJSON.errors;
        $.each(errors, function (key, value) {
          $('.' + key + '_err').text(value[0]);
        });
      });
    });

  </script>
</body>

</html>