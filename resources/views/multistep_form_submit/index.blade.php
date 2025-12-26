@extends('app')

@section('title', 'Profile Add')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4 class="mb-4"><b>Add User</b></h4>
        <div class="card-body">
            <form id="user" class="row justify-content-center g-3">
                @csrf

                <div class="col-md-12 tab">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Name</label>
                            <input class="form-control" type="text" name="name">
                            <span class="text-danger error-text name_err"></span>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email">
                            <span class="text-danger error-text email_err"></span>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Password</label>
                            <input class="form-control" type="password" name="password">
                            <span class="text-danger error-text password_err"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 tab d-none">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <input class="form-control" type="text" name="address">
                            <span class="text-danger error-text address_err"></span>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Country</label>
                            <select class="form-select" name="country_id" id="country">
                                <option value="">Select</option>
                                @foreach ($countries as $row)
                                    <option value="{{ $row->country_id }}">{{ $row->country_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text country_id_err"></span>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city_id" id="city">
                                <option value="">Select</option>
                            </select>
                            <span class="text-danger error-text city_id_err"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 tab d-none">
                    <div class="row g-3"></div>
                    <div class="col-md-12">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span class="text-danger error-text gender_err"></span>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Profile Picture</label>
                        <input class="form-control" type="file" name="profile_picture" accept="image/*">
                        <span class="text-danger error-text photo_err"></span>
                    </div>
                </div>
                <div class="col-md-12 text-end">

                    <button class="btn btn-primary px-5 d-none" type="button" id="prevBtn">Previous</button>
                    <button class="btn btn-primary px-5" type="button" id="nextBtn">Next</button>
                    <button class="btn btn-primary px-5 d-none" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Next Button Click
        $(document).on('click', '#nextBtn', function () {
            var tabs = $('.tab');
            var currentTab = tabs.filter(':not(.d-none)');
            var nextTab = currentTab.next('.tab');

            // add validation
            if (!validateForm()) {
                return false;
            }

            if (nextTab.length) {
                currentTab.addClass('d-none');
                nextTab.removeClass('d-none');
                $('#prevBtn').removeClass('d-none');
                if (nextTab.is(tabs.last())) {
                    $('#nextBtn').addClass('d-none');
                    $('button[type="submit"]').removeClass('d-none');
                }
            }
        });

        // Previous Button Click
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
                if (currentTab.is(tabs.last())) {
                    $('#nextBtn').removeClass('d-none');
                    $('button[type="submit"]').addClass('d-none');
                }
            }
        });

        // add validation
        const fieldNames = {
            name: 'Name',
            email: 'Email',
            password: 'Password',
            address: 'Address',
            country_id: 'Country',
            city_id: 'City',
            gender: 'Gender',
            profile_picture: 'Profile Picture'
        };

        function validateForm() {
            let valid = true;
            let currentTab = $('.tab:not(.d-none)');

            // clear old errors
            currentTab.find('.error-text').text('');

            currentTab.find('input, select').each(function () {
                // console.log(this);
                let name = $(this).attr('name');
                let type = $(this).attr('type');
                let value = $(this).val();
                let label = fieldNames[name];

                if (['profile_picture'].includes(name)) {
                    return true;
                }

                // email validation
                if (name === 'email') {
                    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
                        $('.' + name + '_err').text('Please enter a valid email address');
                        valid = false;
                    }
                }

                // file validation
                if (type === 'file') {
                    console.log("file");
                    if (this.files.length === 0) {
                        $('.' + name + '_err').text(label + ' is required');
                        valid = false;
                    }
                }
                else {
                    if (!value) {
                        $('.' + name + '_err').text(label + ' is required');
                        valid = false;
                    }
                }
            });

            return valid;
        }


        $(document).ready(function () {

            // get city
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
                                data += `<option value="${city.city_id}">${city.city_name}</option>`;
                            });
                            $('#city').html(data);
                        }
                    });
                } else {
                    $('#city').html('<option value="">Select Country first</option>');
                }
            });

            // form submit
            $('#user').submit(function (e) {
                e.preventDefault();
                if (!validateForm()) {
                    return false;
                }

                $('.error-text').text('');

                ajaxCall('{{ route('store.user') }}', 'POST', new FormData(this), function (response) {
                    if (response.status === 'success') {
                        window.location.href = "{{ route('showUsers') }}";
                    }
                    if (response.status === 'errors') {
                        let errors = response.errors;
                        $.each(errors, function (key, value) {
                            $('.' + key + '_err').text(value[0]);
                        });

                        var errorsTabsfind = $(':input[name="' + Object.keys(errors)[0] + '"]').closest('.tab');
                        $('.tab').addClass('d-none');
                        errorsTabsfind.removeClass('d-none');

                        if (errorsTabsfind.is($('.tab').first())) {
                            $('#prevBtn').addClass('d-none');
                            $('#nextBtn').removeClass('d-none');
                            $('button[type="submit"]').addClass('d-none');
                        } else if (errorsTabsfind.is($('.tab').last())) {
                            $('#nextBtn').addClass('d-none');
                            $('button[type="submit"]').removeClass('d-none');
                            $('#prevBtn').removeClass('d-none');
                        } else {
                            $('#prevBtn').removeClass('d-none');
                            $('#nextBtn').removeClass('d-none');
                            $('button[type="submit"]').addClass('d-none');
                        }
                    }
                })

            });

        });
    </script>
@endsection