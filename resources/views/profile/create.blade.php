@extends('app')

@section('title', 'Profile Add')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4 class="mb-4">Add User</h4>
        <div class="card-body">
            <form id="user" class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input class="form-control" type="text" name="name">
                    <span class="text-danger error-text name_err"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email">
                    <span class="text-danger error-text email_err"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password">
                    <span class="text-danger error-text password_err"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input class="form-control" type="text" name="address">
                    <span class="text-danger error-text address_err"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <select class="form-select" name="country_id" id="country">
                        <option value="">Select</option>
                        @foreach ($countries as $row)
                            <option value="{{ $row->country_id }}">{{ $row->country_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text country_id_err"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <select class="form-select" name="city_id" id="city">
                        <option value="">Select</option>
                    </select>
                    <span class="text-danger error-text city_id_err"></span>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender">
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <span class="text-danger error-text gender_err"></span>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" name="profile_picture" accept="image/*">
                    <span class="text-danger error-text photo_err"></span>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#country').on('change', function() {

                // ajaxCall('{{ route('getCities') }}', 'POST', {
                //     country_id: $(this).val()
                // }, function(response) {
                //     var data = '<option value="">Select City</option>';
                //     $.each(response, function(index, city) {
                //         data +=
                //             `<option value="${city.city_id}">${city.city_name}</option>`;
                //     });
                //     $('#city').html(data);
                // }, function() {
                //     console.log('An error occurred while fetching cities');
                // });
                
                var country_id = $(this).val();
                if (country_id) {
                    $.ajax({
                        url: "{{ route('getCities') }}",
                        type: "GET",
                        data: {
                            country_id: country_id
                        },
                        success: function(response) {

                            var data = '<option value="">Select City</option>';
                            $.each(response, function(index, city) {
                                data +=
                                    `<option value="${city.city_id}">${city.city_name}</option>`;
                            });
                            $('#city').html(data);
                        }
                    });
                } else {
                    $('#city').html('<option value="">Select Country first</option>');
                }
            });

            // ajaxCall function usage
            $('#user').submit(function (e) {
                e.preventDefault();

                $('.error-text').text('');
                ajaxCall('{{ route('store.user') }}', 'POST', new FormData(this), function(response) {
                    if (response.status === 'success') {
                        window.location.href = "{{ route('showUsers') }}";
                    }
                    if (response.status === 'errors') {
                        let errors = response.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_err').text(value[0]);
                        });
                    }
                }, function() {
                    console.log('An error occurred');
                });
            });

        });
    </script>
@endsection
