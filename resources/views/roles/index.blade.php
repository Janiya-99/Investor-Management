@extends('layouts.main')

@section('title', 'Roles')
@section('breadcrumb-item', 'Roles')

@section('breadcrumb-item-active', 'Roles')

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
                        Role</button>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered nowrap data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
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

    <div id="varyingcontentModalLabel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="roleModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalTitle">Create Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="submitForm" action="{{ route('roles.store') }}" method="POST">
                            @csrf

                            <div class="mb-3 form-group">
                                <label class="form-label">Role Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter role name"
                                    name="name" id="roleName" required>
                            </div>

                            <div class="mb-3 form-group">
                                <label class="form-label">Permissions: <span class="text-danger">*</span></label>
                                <div id="permissionsContainer" style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px;">
                                    <!-- Permissions will be loaded here -->
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Save Role</button>
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
                ajax: "{{ route('roles.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'name',
                        name: 'name'
                    }, {
                        data: 'permissions',
                        name: 'permissions'
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

            // Load permissions when modal opens for create
            $('.add-new').on('click', function() {
                $('#roleModalTitle').text('Create Role');
                $('#submitForm').attr('action', '{{ route('roles.store') }}');
                $('#submitForm').find('input[name="_method"]').remove();
                $('#roleName').val('');
                loadPermissions();
            });

            // Load permissions for edit
            $(document).on('click', '.btn-edit', function() {
                var roleId = $(this).data('id');
                $.ajax({
                    url: '/roles/' + roleId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#roleModalTitle').text('Edit Role');
                        $('#roleName').val(response.data.name);
                        $('#submitForm').attr('action', '/roles/' + roleId);
                        if ($('#submitForm').find('input[name="_method"]').length === 0) {
                            $('#submitForm').append('<input type="hidden" name="_method" value="PUT">');
                        }
                        loadPermissions(response.data.permissions);
                        $('#varyingcontentModalLabel').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            function loadPermissions(selectedPermissions = []) {
                $.ajax({
                    url: '{{ route('roles.create') }}',
                    type: 'GET',
                    success: function(response) {
                        var container = $('#permissionsContainer');
                        container.html('');
                        
                        var selectedIds = selectedPermissions.map(p => p.id);
                        
                        $.each(response.permissions, function(module, permissions) {
                            var moduleDiv = $('<div class="mb-3"></div>');
                            var moduleHeader = $('<h6 class="text-primary mb-2">' + module.toUpperCase() + '</h6>');
                            moduleDiv.append(moduleHeader);
                            
                            var permissionsDiv = $('<div class="row"></div>');
                            
                            $.each(permissions, function(index, permission) {
                                var col = $('<div class="col-md-4 mb-2"></div>');
                                var checkbox = $('<div class="form-check"></div>');
                                var input = $('<input class="form-check-input" type="checkbox" name="permissions[]" value="' + permission.id + '" id="perm_' + permission.id + '">');
                                var label = $('<label class="form-check-label" for="perm_' + permission.id + '">' + permission.name.split('.')[1] + '</label>');
                                
                                if (selectedIds.includes(permission.id)) {
                                    input.prop('checked', true);
                                }
                                
                                checkbox.append(input).append(label);
                                col.append(checkbox);
                                permissionsDiv.append(col);
                            });
                            
                            moduleDiv.append(permissionsDiv);
                            container.append(moduleDiv);
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

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

