<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multiple Insert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <form id="bulkForm">
                    @csrf

                    <div id="rowContainer">
                        <div class="row g-2 align-items-center bulk-row">
                            <div class="col-md-5">
                                <input type="text" name="name[]" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="col-md-5">
                                <input type="email" name="email[]" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger removeRow d-none">Remove</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="button" id="addRow" class="btn btn-primary">Add More</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <div id="message" class="mt-3"></div>
                </form>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>
$(document).ready(function () {

    // Add Row
    $('#addRow').click(function () {
        let row = `
        <div class="row g-2 align-items-center bulk-row mt-2">
            <div class="col-md-5">
                <input type="text" name="name[]" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-5">
                <input type="email" name="email[]" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger removeRow">Remove</button>
            </div>
        </div>`;
        $('#rowContainer').append(row);
        $('.removeRow').removeClass('d-none');
    });

    // Remove Row
    $(document).on('click', '.removeRow', function () {
        $(this).closest('.bulk-row').remove();
        if ($('.bulk-row').length === 1) {
            $('.removeRow').addClass('d-none');
        }
    });

    // Submit AJAX
    $('#bulkForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('bulk.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                $('#message').html(
                    `<div class="alert alert-success">${res.message}</div>`
                );
                $('#bulkForm')[0].reset();
                $('.bulk-row').not(':first').remove();
                $('.removeRow').addClass('d-none');
            },
            error: function (xhr) {
                $('#message').html(
                    `<div class="alert alert-danger">Something went wrong</div>`
                );
            }
        });
    });
});
</script>


</body>

</html>
