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
                                            name="name" id="fullName">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Email:</label>
                                        <input type="email" class="form-control" placeholder="Enter email" name="email" id="email">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">NIC:</label>
                                        <input type="text" class="form-control" placeholder="Enter NIC" name="nic" id="nic">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Profile Picture:</label>
                                        <input type="file" class="form-control" name="profile_photo" id="profilePhoto">
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
                                    <input type="checkbox" class="form-check-input input-primary" id="status"
                                        name="status" checked value="1">
                                    <label class="form-check-label" for="status">Active</label>
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
  
    <script>
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

        $(document).on('click', '.btn-edit', function() {

            var userId = $(this).data('id');

            // Fetch user data via AJAX
            $.ajax({
                url: '/users/' + userId + '/edit',
                type: 'GET',
                success: function(response) {
                  
                    // Populate the form fields with the fetched data
                    $('#userModalTitle').text('Edit User');
                    $('#fullName').val(response.data.name);
                    $('#email').val(response.data.email);
                    $('#nic').val(response.data.nic);

                    if(response.data.status == 1){
                        $('#status').prop('checked', true);
                    }else{
                        $('#status').prop('checked', false);
                    }

                    $('#submitForm').attr('action', '/users/' + userId);
                    $('#submitForm').append('<input type="hidden" name="_method" value="PUT">');

                    // Show the modal
                    $('#varyingcontentModalLabel').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
