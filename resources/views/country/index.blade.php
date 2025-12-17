@extends('app')
@section('title', 'Country')

@section('style')
    <link href="https://cdn.datatables.net/v/bs5/dt-2.3.5/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row justify-content-between">
        <div class="col-4">
            <h4 class="mb-4">Countries</h4>
        </div>
        <div class="col-2">
            <a href="{{ route('showCountryForm') }}" class="btn btn-primary">Add Country</a>
        </div>
    </div>

    <div class="card-body">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Country Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/v/bs5/dt-2.3.5/datatables.min.js"></script>
    <script>
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('showCountrieslist') }}",
                columns: [{
                        data: 'country_id',
                        name: 'country_id'
                    },
                    {
                        data: 'country_name',
                        name: 'country_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.delete', function() {

                var country_id = $(this).attr("data-id");
                confirm("Are You sure want to delete?");
                if (!confirm) {
                    return false;
                }

                $.ajax({
                    type: "delete",
                    url: '/countries/delete/' + country_id,
                    data: country_id,
                    success: function(response) {
                        alert(response.success);
                        window.location.href = "{{ route('showCountrieslist') }}";
                    }
                });
            });

        });
    </script>
@endsection
