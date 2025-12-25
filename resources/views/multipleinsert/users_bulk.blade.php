@extends('app')

@section('title', 'Bulk Add Users')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4>Users</h4>

        <div class="card-body">
            <form id="usersForm" enctype="multipart/form-data">
                @csrf
                <div id="rowContainer">

                    <div class="bulk-row" data-row="0">
                        <div class="row g-2 d-flex pt-3">
                            <div class="col-md-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name[]" class="form-control" placeholder="Name">
                                <span class="text-danger error-text name_err" data-index="0"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email[]" class="form-control" placeholder="Email">
                                <span class="text-danger error-text email_err" data-index="0"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password[]" class="form-control" placeholder="Password">
                                <span class="text-danger error-text password_err" data-index="0"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address[]" class="form-control" placeholder="Address">
                                <span class="text-danger error-text address_err" data-index="0"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Country</label>
                                <select class="form-select country-select" name="country_id[]" id="country">
                                    <option value="">Country</option>
                                    @foreach ($countries as $row)
                                        <option value="{{ $row->country_id }}">{{ $row->country_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text country_id_err" data-index="0"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <select class="form-select city-select" name="city_id[]" id="city">
                                    <option value="">City</option>
                                </select>
                                <span class="text-danger error-text city_id_err" data-index="0"></span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender[]">
                                    <option value="">Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="text-danger error-text gender_err" data-index="0"></span>
                            </div>
                            <div class="col-md-3 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-danger removeRow d-none">Remove</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-3">
                    <button type="button" id="addRow" class="btn btn-primary">Add More</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

                {{-- <div id="message" class="mt-3"></div> --}}
            </form>

        </div>
@endsection

@section('script')

    <script>
        $(document).ready(function () {

            let rowIndex = 1;

            $('#addRow').click(function () {

                let row = `
                <div class="bulk-row" data-row="${rowIndex}">
                    <div class="row g-2 d-flex pt-3">
                        <div class="col-md-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name[]" class="form-control" placeholder="Name">
                            <span class="text-danger error-text name_err" data-index="${rowIndex}"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email[]" class="form-control" placeholder="Email">
                            <span class="text-danger error-text email_err" data-index="${rowIndex}"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password[]" class="form-control" placeholder="Password">
                            <span class="text-danger error-text password_err" data-index="${rowIndex}"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address[]" class="form-control" placeholder="Address">
                            <span class="text-danger error-text address_err" data-index="${rowIndex}"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Country</label>
                            <select class="form-select country-select" name="country_id[]" id="country">
                                <option value="">Country</option>
                                @foreach ($countries as $row)
                                    <option value="{{ $row->country_id }}">{{ $row->country_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text country_id_err" data-index="${rowIndex}"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">City</label>
                            <select class="form-select city-select" name="city_id[]" id="city">
                                <option value="">City</option>
                            </select>
                            <span class="text-danger error-text city_id_err" data-index="${rowIndex}"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender[]">
                                <option value="">Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <span class="text-danger error-text gender_err" data-index="${rowIndex}"></span>
                        </div>
                        <div class="col-md-3 d-flex align-items-end justify-content-end">
                            <button type="button" class="btn btn-danger removeRow d-none">Remove</button>
                        </div>
                    </div>

                </div>`;

                $('#rowContainer').append(row);
                $('.removeRow').removeClass('d-none');

                rowIndex++;
            });


            // remove row
            $(document).on('click', '.removeRow', function () {
                $(this).closest('.bulk-row').remove();
                $.each($('.bulk-row'), function (index, row) {
                    $(row).attr('data-row', index);
                    $(row).find('span.error-text').attr('data-index', index);
                    rowIndex = index + 1;
                })
                if ($('.bulk-row').length === 1) {
                    $('.removeRow').addClass('d-none');
                }
            });



            $(document).on('change', '.country-select', function () {
                let country_id = $(this).val();
                let citySelect = $(this).closest('.bulk-row').find('.city-select');
            
                if (country_id) {
                    $.ajax({
                        url: "{{ route('getCities') }}",
                        type: "GET",
                        data: { country_id },
                        success: function (response) {
                            let options = '<option value="">Select City</option>';
                            $.each(response, function (i, city) {
                                options += `<option value="${city.city_id}">${city.city_name}</option>`;
                            });
                            citySelect.html(options);
                        }
                    });
                } else {
                    citySelect.html('<option value="">Select Country first</option>');
                }
            });


            $('#usersForm').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                $('.error-text').text('');

                $.ajax({
                    url: "{{ route('bulk.store') }}",
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
                                let parts = key.split('.');
                                let field = parts[0];      
                                let index = parts[1];      
                            
                                $(`.bulk-row[data-row="${index}"] .${field}_err`).text(value[0]);
                            });

                        }
                    }
                });
            });

        });
    </script>
@endsection