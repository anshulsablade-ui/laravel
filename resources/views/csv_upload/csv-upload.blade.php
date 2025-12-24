@extends('app')
@section('title', 'CSV Upload')

@section('style')

@endsection

@section('content')
    <div class="justify-content-between">
        <h4 class="mb-4">CSV Upload</h4>

        <div class="card-body">
            <form id="country">
                @csrf
                <div>
                    <label class="form-label" for="csv_file">Csv File</label>
                    <input class="form-control" type="file" id="csv_file" name="csv_file"/>
                    <span class="text-danger error-text csv_file_err"></span>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Submit</button>
            </form>
        </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            $('.error-text').text('');

            $('#country').submit(function (e) {
                e.preventDefault();

                ajaxCall('{{ route('csv.import') }}', 'POST', new FormData(this), function (response) {
                    if (response.status === "success") {
                        window.location.href = "{{ route('showUsers') }}";
                    }

                    if (response.status === "errors") {
                        let errors = response.errors;
                        $.each(errors, function (key, value) {
                            $('.' + key + '_err').text(value[0]);
                        });
                    }
                });

            });
        });
    </script>
@endsection