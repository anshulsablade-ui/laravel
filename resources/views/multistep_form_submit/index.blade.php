@extends('app')

@section('title', 'Profile Add')

@section('style')

@endsection

@section('content')
    <div class="row justify-content-between">
        <h4 class="mb-4 col-md-12"><b>Add User</b></h4>
        <div class="card-body col-md-12">
            <form id="user" class="row justify-content-center g-3">
                @csrf

                <div class="col-md-12 mb-2 tab">
                    <label class="form-label">Name</label>
                    <input class="form-control" type="text" name="name">
                    <span class="text-danger error-text name_err"></span>
                </div>

                <div class="col-md-12 mb-2 tab d-none">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email">
                    <span class="text-danger error-text email_err"></span>
                </div>

                <div class="col-md-12 mb-2 tab d-none">
                    <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password">
                    <span class="text-danger error-text password_err"></span>
                </div>

                <div class="col-md-12 mb-2 tab d-none">
                    <label class="form-label">Address</label>
                    <input class="form-control" type="text" name="address">
                    <span class="text-danger error-text address_err"></span>
                </div>

                <div class="col-md-12 mb-2 tab d-none">
                    <div class="row g-3">
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Country</label>
                            <select class="form-select" name="country_id" id="country">
                                <option value="">Select</option>
                                @foreach ($countries as $row)
                                    <option value="{{ $row->country_id }}">{{ $row->country_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text country_id_err"></span>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city_id" id="city">
                                <option value="">Select</option>
                            </select>
                            <span class="text-danger error-text city_id_err"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-2 tab d-none">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender">
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <span class="text-danger error-text gender_err"></span>
                </div>

                <div class="col-md-12 mb-3 tab d-none">
                    <label class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" name="profile_picture" accept="image/*">
                    <span class="text-danger error-text photo_err"></span>
                </div>
                <div class="col-md-12 text-end mb-2">
                    <button class="btn btn-primary mt-3 d-none" type="button" id="prevBtn">Previous</button>
                    <button class="btn btn-primary mt-3" type="button" id="nextBtn">Next</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#nextBtn', function () {
            var tabs = $('.tab');
            var currentTab = tabs.filter(':not(.d-none)');
            var nextTab = currentTab.next('.tab');

            if (nextTab.length) {
                currentTab.addClass('d-none');
                nextTab.removeClass('d-none');
                $('#prevBtn').removeClass('d-none');
                if (nextTab.is(tabs.last())) {
                    $('#nextBtn').attr('type', 'submit').text('Submit');
                }
            }
        });
        $(document).on('click', '#prevBtn', function () {
            var tabs = $('.tab');
            var currentTab = tabs.filter(':not(.d-none)');
            var prevTab = currentTab.prev('.tab');

            if (prevTab.length) {
                currentTab.addClass('d-none');
                prevTab.removeClass('d-none');
                if (prevTab.is(tabs.first())) {
                    $('#prevBtn').addClass('d-none');
                }
                $('#nextBtn').attr('type', 'button').text('Next');
            }
        });


    </script>


    <script>
        $(document).ready(function () {

            $('#country').on('change', function () {
                var country_id = $(this).val();
                if (country_id) {
                    $.ajax({
                        url: "{{ route('getCities') }}",
                        type: "GET",
                        data: {
                            country_id: country_id
                        },
                        success: function (response) {

                            var data = '<option value="">Select City</option>';
                            $.each(response, function (index, city) {
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

            $('#user').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                $('.error-text').text('');

                $.ajax({
                    url: "{{ route('store.user') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function (response) {
                        if (response.status === 'success') {
                            window.location.href = "{{ route('showUsers') }}";
                        }
                        if (response.status === 'errors') {
                            let errors = response.errors;
                            $.each(errors, function (key, value) {
                                console.log(key, value);
                                $('.' + key + '_err').text(value[0]);
                            });
                        }
                    }
                });
            });

        });
    </script>
@endsection