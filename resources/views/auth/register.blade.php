<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4 pb-4 pt-4">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="row">
            <form id="register">
                <div>
                    <label class="form-label" for="name">Name:</label>
                    <input class="form-control" type="text" id="name" name="name">
                </div>
                <div>
                    <label class="form-label" for="email">Email:</label>
                    <input class="form-control" type="email" id="email" name="email">
                </div>
                <div>
                    <label class="form-label" for="password">Password:</label>
                    <input class="form-control" type="password" id="password" name="password">
                </div>

                <div>
                    <label class="form-label" for="address">Address:</label>
                    <input class="form-control" type="text" id="address" name="address">
                </div>
                <div>
                    <label class="form-label" for="city">City:</label>
                    <input class="form-control" type="text" id="city" name="city">
                </div>
                <div>
                    <label class="form-label" for="country">Country:</label>
                    <input class="form-control" type="text" id="country" name="country">
                </div>
                <div>
                    <label class="form-label" for="gender">Gender:</label>
                    <select class="form-select mb-3" id="gender" name="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="photo">Photo:</label>
                    <input class="form-control" type="file" id="photo" name="profile_picture" accept="image/*">
                </div>
                <button class="btn btn-primary mt-3" type="submit">Register</button>
            </form>
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
            $("#register").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: "post",
                    url: "{{ route('register') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        alert('Registration successful!');
                        window.location.href = "{{ route('showLoginForm') }}";
                    }
                    // error: function(xhr, status, error) {
                    //     var err = JSON.parse(xhr.responseText);
                    //     alert(err.message);
                    // }
                });
            });
        });
    </script>
</body>

</html>
