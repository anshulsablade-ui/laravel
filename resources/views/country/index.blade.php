@extends('app')
@section('title', 'Country')

@section('style')
    <link href="https://cdn.datatables.net/v/bs5/dt-2.3.5/r-3.0.7/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row justify-content-between">
        <div class="col-6">
            <h4 class="mb-4">Countries</h4>
        </div>
        <div class="col-6 text-end p-0">
            <a href="{{ route('showCountryForm') }}" class="btn btn-primary">Add Country</a>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-striped data-table w-100">
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
    <script src="https://cdn.datatables.net/v/bs5/dt-2.3.5/r-3.0.7/datatables.min.js"></script>
    <script>
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
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

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "delete",
                            url: '/countries/delete/' + country_id,

                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.success,
                                    'success'
                                )
                                table.ajax.reload();
                            }
                        });
                    }
                })
            });

        });
    </script>
@endsection
