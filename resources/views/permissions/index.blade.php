@extends('layouts.main')

@section('title', 'Permissions')
@section('breadcrumb-item', 'Permissions')

@section('breadcrumb-item-active', 'Permissions')

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
                        Permission</button>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered nowrap data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Module</th>
                                    <th>Action</th>
                                    <th>Full Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Module</th>
                                    <th>Action</th>
                                    <th>Full Name</th>
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

    <div id="varyingcontentModalLabel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="permissionModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModalTitle">Create Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="submitForm" action="{{ route('permissions.store') }}" method="POST">
                            @csrf

                            <div class="mb-3 form-group">
                                <label class="form-label">Permission Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="e.g., users.create, users.edit"
                                    name="name" id="permissionName" required>
                                <small class="form-text text-muted">Format: module.action (e.g., users.create, investors.view)</small>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Save Permission</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>

    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('permissions.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'module',
                        name: 'module'
                    }, {
                        data: 'action',
                        name: 'action'
                    }, {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action_buttons',
                        name: 'action_buttons',
                        width: '120px',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Reset form when modal opens for create
            $('.add-new').on('click', function() {
                $('#permissionModalTitle').text('Create Permission');
                $('#submitForm').attr('action', '{{ route('permissions.store') }}');
                $('#submitForm').find('input[name="_method"]').remove();
                $('#permissionName').val('');
            });

            // Load data for edit
            $(document).on('click', '.btn-edit', function() {
                var permissionId = $(this).data('id');
                $.ajax({
                    url: '/permissions/' + permissionId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#permissionModalTitle').text('Edit Permission');
                        $('#permissionName').val(response.data.name);
                        $('#submitForm').attr('action', '/permissions/' + permissionId);
                        if ($('#submitForm').find('input[name="_method"]').length === 0) {
                            $('#submitForm').append('<input type="hidden" name="_method" value="PUT">');
                        }
                        $('#varyingcontentModalLabel').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Submit form
            $('#submitFormBtn').on('click', function() {
                $('#submitForm').submit();
            });

            // Handle form submission
            $('#submitForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = $(this).find('input[name="_method"]').val() || 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message
                            }).then(() => {
                                $('#varyingcontentModalLabel').modal('hide');
                                table.ajax.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON?.errors || {};
                        var errorMessages = [];
                        $.each(errors, function(key, value) {
                            errorMessages.push(value[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessages.length > 0 ? errorMessages.join('\n') : 'An error occurred'
                        });
                    }
                });
            });
        });
    </script>
@endsection


