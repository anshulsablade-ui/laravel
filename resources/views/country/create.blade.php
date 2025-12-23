@extends('app')
@section('title', 'Add Country')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4 class="mb-4">Countries</h4>

        <div class="card-body">
            <form id="country">
                @csrf
                <div>
                    <label class="form-label" for="country">Country Name</label>
                    <input class="form-control" type="text" id="country" name="country_name">
                    <span class="text-danger error-text country_name_err"></span>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Submit</button>
            </form>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.error-text').text('');

                $('#country').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        type: "post",
                        url: "{{ route('store.country') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == "success") {
                                window.location.href = "{{ route('showCountrieslist') }}";
                            }
                            
                            if (response.status === "errors") {
                                let errors = response.errors;
                                $.each(errors, function(key, value) {
                                    $('.' + key + '_err').text(value[0]);
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endsection
