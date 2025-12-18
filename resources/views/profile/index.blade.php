@extends('app')

@section('style')
    <link href="https://cdn.datatables.net/v/bs5/dt-2.3.5/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
    <h4 class="mb-4">Users</h4>
    <div class="card-body">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
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
                ajax: "{{ route('showUsers') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'photo', name: 'photo', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'gender', name: 'gender'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.delete', function() {

                var user_id = $(this).attr("data-id");
                confirm("Are You sure want to delete?");
                if (!confirm) {
                    return false;
                }

                $.ajax({
                    type: "delete",
                    url: '/users/delete/' + user_id,

                    success: function(response) {
                        alert(response.success);
                        window.location.href = "{{ route('showUsers') }}";
                    }
                });
            });

        });
    </script>
@endsection
