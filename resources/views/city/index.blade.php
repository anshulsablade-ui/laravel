@extends('app')
@section('title', 'City')

@section('style')
    <link href="https://cdn.datatables.net/v/bs5/dt-2.3.5/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row justify-content-between">
        <div class="col-4">
            <h4 class="mb-4">City</h4>
        </div>
        <div class="col-2">
            <a href="{{ route('showCityForm') }}" class="btn btn-primary">Add City</a>
        </div>
    </div>

    <div class="card-body">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>City Name</th>
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
                ajax: "{{ route('showCitieslist') }}",
                columns: [{
                        data: 'city_id',
                        name: 'city_id'
                    },
                    {
                        data: 'city_name',
                        name: 'city_name'
                    },
                    {
                        data: 'country.country_name',
                        name: 'country.country_name'
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

                var city_id = $(this).attr("data-id");
                confirm("Are You sure want to delete?");
                if (!confirm) {
                    return false;
                }

                $.ajax({
                    type: "delete",
                    url: '/cities/delete/' + city_id,
                    data: city_id,
                    success: function(response) {
                        window.location.href = "{{ route('showCitieslist') }}";
                    }
                });
            });

        });
    </script>
@endsection
