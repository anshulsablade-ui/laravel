@extends('app')
@section('title', 'Add City')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4 class="mb-4">Cities</h4>

        <div class="card-body">
            <form id="city">
                <div>
                    <label class="form-label" for="city">City Name</label>
                    <input class="form-control" type="text" id="city" name="city_name">
                    <span class="text-danger error-text city_name_err"></span>
                </div>
                <div>
                    <label class="form-label" for="city">Country Name</label>
                    <select class="form-select mb-3" id="gender" name="country_id">
                        <option value="">-- select country --</option>
                        @foreach ($countries as $row)
                            <option value="{{ $row->country_id }}">{{ $row->country_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text country_id_err"></span>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
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

                
                $('#city').submit(function(e) {
                    e.preventDefault();
                    
                    $('.error-text').text('');

                    ajaxCall('{{ route('store.city') }}', 'POST', new FormData(this), function(response) {
                        if (response.status === 'success') {
                            window.location.href = "{{ route('showCitieslist') }}";
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
