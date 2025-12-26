@extends('app')
@section('title', 'Update City')

@section('content')
    <div class="justify-content-between">
        <h4 class="mb-4">Update City</h4>
        <div class="card-body">

            <form id="city">
                @csrf
                @method('PUT')

                <input type="hidden" name="city_id" value="{{ $cities->city_id }}">

                <div class="mb-3">
                    <label class="form-label">City Name</label>
                    <input type="text" class="form-control" name="city_name" value="{{ $cities->city_name }}">
                    <span class="text-danger error-text city_name_err"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Country name</label>
                    <select class="form-select" name="country_id">
                        <option value="">-- Select Country --</option>
                        @foreach ($countries as $row)
                            <option value="{{ $row->country_id }}"
                                {{ $cities->country_id == $row->country_id ? 'selected' : '' }}>
                                {{ $row->country_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text country_id_err"></span>
                </div>

                <button class="btn btn-primary" type="submit">Update</button>
            </form>

        </div>
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

            
            $('#city').on('submit', function(e) {
                e.preventDefault();
                
                $('.error-text').text('');

                ajaxCall('{{ route('update.city') }}', 'POST', new FormData(this), function(response) {
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
