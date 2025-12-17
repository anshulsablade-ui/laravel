<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="mt-5">

    <div class="container col-md-4 ">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Login</h1>
            </div>
        </div>

        <form id="loginForm">
            @csrf

            <div class="mb-2">
                <label>Email:</label>
                <input type="email" class="form-control" name="email">
                <span class="text-danger error-text email_err"></span>
            </div>

            <div class="mb-2">
                <label>Password:</label>
                <input type="password" class="form-control" name="password">
            </div>

            <button type="submit" id="btnLogin" class="btn btn-primary w-100">
                Login
            </button>

        </form>
        <div class="mb-2">
            <span>Don't have an account ?</span>
            <a href="{{ route('register') }}" class=" w-100">
                Register
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#loginForm").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "post",
                    url: "{{ route('login') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == "success") {
                            alert(response.success);
                            window.location.href = "{{ route('showUsers') }}";
                        }

                        if (response.status === "errors") {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                console.log(key, value);
                                $('.' + key + '_err').text(value[0]);
                            });
                        }
                    },
                });
            });
        });
    </script>
</body>

</html>
