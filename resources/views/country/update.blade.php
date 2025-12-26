@extends('app')
@section('title', 'Update Country')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4 class="mb-4">Update Country</h4>

        <div class="card-body">
            <form id="country">
                @csrf
                @method('put')

                <input type="hidden" name="country_id" value="{{ $countries->country_id }}">

                <div>
                    <label class="form-label" for="country">Country Name</label>
                    <input class="form-control" type="text" id="country" name="country_name" value="{{ $countries->country_name }}">
                    <span class="text-danger error-text country_name_err"></span>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Update</button>
            </form>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {

                $('#country').submit(function(e) {
                    e.preventDefault();

                    $('.error-text').text('');
                    
                    ajaxCall('{{ route('update.country') }}', 'POST', new FormData(this), function(response) {
                        if (response.status === 'success') {
                            window.location.href = "{{ route('showCountrieslist') }}";
                        }
                        if (response.status === 'errors') {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('.' + key + '_err').text(value[0]);
                            });
                        }
                    })

                });
            });
        </script>
    @endsection
