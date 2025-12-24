@extends('app')

@section('title', 'Bulk Add Country')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4>Countries</h4>

        <div class="card-body">
            <form id="bulkForm">
                @csrf
                <div id="rowContainer">
                    <div class="bulk-row" data-row="0">
                        <div class="row g-2 pt-3">
                            <div class="col-md-12 d-flex">
                                <input type="text" name="country_names[]" class="form-control" placeholder="Country Name">
                                <button type="button" class="btn btn-danger removeRow d-none ms-2">Remove</button>
                            </div>
                        </div>
                        <span class="text-danger error-text country_name_err" data-index="0"></span>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" id="addRow" class="btn btn-primary">Add More</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>

                <div id="message" class="mt-3"></div>
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
                        <div class="row g-2 pt-3">
                            <div class="col-md-12 d-flex">
                                <input type="text" name="country_names[]" class="form-control" placeholder="Country Name">
                                <button type="button" class="btn btn-danger removeRow d-none ms-2">Remove</button>
                            </div>
                        </div>
                        <span class="text-danger error-text country_name_err" data-index="${rowIndex}"></span>
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


                // submit
                $('#bulkForm').submit(function (e) {
                    e.preventDefault();

                    $('.error-text').text(''); // clear old errors

                    $.ajax({
                        type: "post",
                        url: "{{ route('bulkStore.countries') }}",
                        data: $(this).serialize(),

                        success: function (response) {

                            if (response.status === "success") {
                                window.location.href = "{{ route('showCountrieslist') }}";
                            }

                            if (response.status === "errors") {

                                $.each(response.errors, function (key, value) {

                                    let index = key.split('.')[1];

                                    $(`span[data-index="${index}"]`).text(value[0]);
                                });
                            }

                        }
                    });
                });

            });
        </script>
    @endsection