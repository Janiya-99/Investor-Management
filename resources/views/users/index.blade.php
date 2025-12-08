@extends('layouts.main')

@section('title', 'Users')
@section('breadcrumb-item', 'Users')

@section('breadcrumb-item-active', 'Users')

@section('css')
    <!-- [Page specific CSS] start -->
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
    <!-- [Page specific CSS] end -->
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- HTML5 Export Buttons table start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header table-card-header text-end">
                    <button type="button" class="btn btn-primary add-new" data-bs-toggle="modal"
                        data-bs-target="#varyingcontentModalLabel">Add
                        User</button>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered nowrap data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>NIC</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>NIC</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <div id="varyingcontentModalLabel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="userModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="submitForm" action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Full Name:</label>
                                        <input type="text" class="form-control" placeholder="Enter full name"
                                            name="name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-control" placeholder="Enter email" name="email">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">NIC:</label>
                                        <input type="text" class="form-control" placeholder="Enter NIC" name="nic">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Profile Picture:</label>
                                        <input type="file" class="form-control" name="profile_photo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password:</label>
                                        <div class="input-group search-form form-group">
                                            <input type="Password" class="form-control"
                                                placeholder="Please enter your Password" name="password">
                                            <span class="input-group-text bg-transparent"><i
                                                    class="feather icon-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password:</label>
                                        <div class="input-group search-form form-group">
                                            <input type="Password" class="form-control"
                                                placeholder="Please enter your Confirm Password"
                                                name="password_confirmation">
                                            <span class="input-group-text bg-transparent"><i
                                                    class="feather icon-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch custom-switch-v1 form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary" id="customCheckinl1" name="status"
                                        checked value="1">
                                    <label class="form-check-label" for="customCheckinl1">Active</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Save User</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>
    <!-- [Page Specific JS] start -->
    <!-- datatable Js -->

    {{-- <script>
        // [ HTML5 Export Buttons ]
        $('#basic-btn').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'print']
        });

        // [ Column Selectors ]
        $('#cbtn-selectors').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });

        // [ Excel - Cell Background ]
        $('#excel-bg').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c[r^="F"]', sheet).each(function() {
                        if ($('is t', this).text().replace(/[^\d]/g, '') * 1 >= 500000) {
                            $(this).attr('s', '20');
                        }
                    });
                }
            }]
        });

        // [ Custom File (JSON) ]
        $('#pdf-json').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                text: 'JSON',
                action: function(e, dt, button, config) {
                    var data = dt.buttons.exportData();
                    $.fn.dataTable.fileSave(new Blob([JSON.stringify(data)]), 'Export.json');
                }
            }]
        });
    </script>
    <!-- [Page Specific JS] end --> --}}
    <script>
        function resetFormAndErrors(modalId, saveBtnId) {
            $('#submitForm')[0].reset();
            $('#submitForm').find('.is-invalid').removeClass('is-invalid');
            $('#submitForm').find('.invalid-feedback').remove();
            $(saveBtnId).removeClass('btn-success').text('Add');
            $(modalId).modal('hide');
            $(modalId).modal('show');
            $('.modal-title').removeClass('modelTitle');
        }

        $(document).on('click', '.add-new', function(e) {

            let modal = $('#varyingcontentModalLabel');
            let currentText = modal.text();

            if (currentText.includes('Edit')) {
                modal.text(currentText.replace('Edit', 'Create'));
            }
            if (currentText.includes('Show')) {
                modal.text(currentText.replace('Show', 'Create'));
            }
            $('#submitForm')[0].reset();
            $('#submitForm').find('.is-invalid').removeClass('is-invalid');
            $('#submitForm').find('.invalid-feedback').remove();
            $('.modal-footer').show();
            resetFormAndErrors('.createModel', '.save-button');
        });

        $('.btn-close').click(function() {
            resetFormAndErrors('.createModel', '.save-button');
        });

        $("#submitFormBtn").click(function() {

            $('.spinner-border').show();
            $('#submitFormBtn').hide();
            // Clear previous error messages and styling
            // $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Get the native DOM element using document.getElementById
            var formData = new FormData(document.getElementById('submitForm'));

            $.ajax({
                type: 'POST',
                url: $('#submitForm').attr('action'),
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.cashier_closed) {
                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px">' +
                                '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' +
                                '<h4>Well done !</h4>' +
                                '<p class="text-muted mx-4 mb-0">' + response.message +
                                '!</p>' +
                                '</div>' +
                                '</div>',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonClass: 'btn btn-primary w-xs mb-1',
                            cancelButtonText: 'OK',
                            buttonsStyling: false,
                            showCloseButton: true
                        }).then(() => {
                            $('.spinner-border').hide();
                            window.location.href = response.next_path;
                        });
                    } else if (response.next) {
                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px">' +
                                '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' +
                                '<h4>Well done !</h4>' +
                                '<p class="text-muted mx-4 mb-0">' + response.message +
                                '!</p>' +
                                '</div>' +
                                '</div>',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonClass: 'btn btn-primary w-xs mb-1',
                            cancelButtonText: 'OK',
                            buttonsStyling: false,
                            showCloseButton: true,
                            footer: '<a href="' + response.next_path + '?' + response
                                .next_param_name + '=' + response.next_param_value + '" ' +
                                response.next_attribute + '="' + response.next_value +
                                '">Next Process - ' + response.next_process_name + '</a>'
                        }).then(() => {
                            $('.spinner-border').hide();
                            location.reload();
                        });

                    } else {
                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px">' +
                                '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' +
                                '<h4>Well done !</h4>' +
                                '<p class="text-muted mx-4 mb-0">' + response.message +
                                '!</p>' +
                                '</div>' +
                                '</div>',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonClass: 'btn btn-primary w-xs mb-1',
                            cancelButtonText: 'OK',
                            buttonsStyling: false,
                            showCloseButton: true
                        }).then(() => {
                            $('.spinner-border').hide();
                            location.reload();
                        });
                    }

                },
                error: function(xhr, status, error) {
                    $('.spinner-border').hide();
                    $('#submitFormBtn').show();
                    if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                // Check if the key is an array field
                                if (key.includes('.')) {
                                    var parts = key.split('.');
                                    var fieldName = parts[0] + '[]';
                                    var index = parts[1];

                                    console.log(fieldName);

                                    var inputField = $('[name="' + fieldName + '"]').eq(
                                        index);
                                    inputField.addClass('is-invalid');
                                    inputField.closest('.form-group').append(
                                        '<div class="invalid-feedback">' + value[0] +
                                        '</div>'
                                    );
                                } else {
                                    // For non-array fields
                                    var inputField = $('[name="' + key + '"]');
                                    inputField.addClass('is-invalid');
                                    inputField.closest('.form-group').append(
                                        '<div class="invalid-feedback">' + value[0] +
                                        '</div>'
                                    );
                                }
                            });
                        }
                    } else if (xhr.status === 500) {
                        var errorMessage = xhr.responseJSON
                            .message; // Assuming the server sends an error message in the response
                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                                'trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px">' +
                                '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' + '<h4>' +
                                errorMessage + ' !</h4>' + '</div>' + '</div>',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonClass: 'btn btn-primary',
                            cancelButtonText: 'Dismiss',
                            buttonsStyling: false,
                            showCloseButton: true
                        }).then(() => {
                            // location.reload();
                        });
                    }
                },
                complete: function() {

                }
            });
        });

        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'name',
                        name: 'name'
                    }, {
                        data: 'email',
                        name: 'email'
                    }, {
                        data: 'nic',
                        name: 'nic'
                    }, {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            if (data === 1) {
                                return '<span class="badge bg-success">Active</span>';
                            } else {
                                return '<span class="badge bg-danger">Inactive</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '120px',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endsection
