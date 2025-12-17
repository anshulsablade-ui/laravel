@extends('app')

@section('title', 'Profile')

@section('style')

@endsection

@section('content')
    <div class="row justify-content-between">
        <h4 class="mb-4 col-md-12">Profile update</h4>
        <div class="card-body col-md-12">
            <form id="profile" class="row g-3">
                @csrf
                @method('put')

                <input type="hidden" name="profile_id" value="{{ $user->id }}">

                <div class="col-md-6 mb-2">
                    <label class="form-label">Name</label>
                    <input class="form-control" type="text" name="name" value="{{ $user->name }}">
                    <span class="text-danger error-text name_err"></span>
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ $user->email }}">
                    <span class="text-danger error-text email_err"></span>
                </div>

                <div class="col-md-12 mb-2">
                    <label class="form-label">Address</label>
                    <input class="form-control" type="text" name="address" value="{{ $user->address }}">
                    <span class="text-danger error-text address_err"></span>
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label">Country</label>
                    <select class="form-select" name="country_id" id="country">
                        <option value="">Select</option>
                        @foreach ($countries as $row)
                            <option value="{{ $row->country_id }}" {{ $user->country_id == $row->country_id ? 'selected' : '' }}>{{ $row->country_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text country_id_err"></span>
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label">City</label>
                    <select class="form-select" name="city_id" id="city">
                        <option value="">Select</option>
                        @foreach ($cities as $row)
                            <option value="{{ $row->city_id }}" {{ $user->city_id == $row->city_id ? 'selected' : '' }}>{{ $row->city_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text city_id_err"></span>
                </div>

                <div class="col-md-6 mb-2">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender">
                        <option value="">Select</option>
                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    <span class="text-danger error-text gender_err"></span>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" name="profile_picture" accept="image/*">
                    <span class="text-danger error-text photo_err"></span>
                </div>
                <button class="btn btn-primary mt-3 col-md-12" type="submit">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#country').on('change', function() {
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

            $('#profile').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                $('.error-text').text('');

                $.ajax({
                    url: "{{ route('update.user') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.success);
                            window.location.href = "{{ route('showUsers') }}";
                        }
                        if (response.status === 'errors') {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
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
