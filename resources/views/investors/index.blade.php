@extends('layouts.main')

@section('title', 'Investors')
@section('breadcrumb-item', 'Investors')

@section('breadcrumb-item-active', 'Investors')

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
                        Investor</button>
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

    <div id="varyingcontentModalLabel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="investorModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="investorModalTitle">Create Investor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="submitForm" action="{{ route('investors.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- PERSONAL DETAILS -->
                            <fieldset class="border p-3 mb-3">
                                <legend class="float-none w-auto px-2">Personal Details</legend>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Title:</label>
                                           <select name="title" id="title" class="form-select">
                                               <option value="">Select Title</option>
                                               <option value="Mr">Mr</option>
                                               <option value="Mrs">Mrs</option>
                                               <option value="Miss">Miss</option>
                                           </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">First Name:</label>
                                            <input type="text" name="first_name" class="form-control"
                                                placeholder="Enter first name">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Last Name:</label>
                                            <input type="text" name="last_name" class="form-control"
                                                placeholder="Enter last name">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Full Name:</label>
                                            <input type="text" name="full_name" class="form-control"
                                                placeholder="Enter full name">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Email:</label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Enter email">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">NIC:</label>
                                            <input type="text" name="nic" class="form-control"
                                                placeholder="Enter NIC">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Contact No:</label>
                                            <input type="text" name="contact_no" class="form-control"
                                                placeholder="Enter contact number">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Profile Photo:</label>
                                            <input type="file" name="profile_photo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- ADDRESS DETAILS -->
                            <fieldset class="border p-3 mb-3">
                                <legend class="float-none w-auto px-2">Address Details</legend>

                                <div class="mb-3 form-group">
                                    <label class="form-label">Address Line 1:</label>
                                    <textarea name="address_line_1" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="mb-3 form-group">
                                    <label class="form-label">Address Line 2:</label>
                                    <textarea name="address_line_2" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="mb-3 form-group">
                                    <label class="form-label">Address Line 3:</label>
                                    <textarea name="address_line_3" class="form-control" rows="2"></textarea>
                                </div>
                            </fieldset>

                            <!-- BENEFICIARY DETAILS -->
                            <fieldset class="border p-3 mb-3">
                                <legend class="float-none w-auto px-2">Beneficiary Details</legend>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Beneficiary Full Name:</label>
                                            <input type="text" name="beneficiary_full_name" class="form-control"
                                                placeholder="Enter full name">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Beneficiary NIC:</label>
                                            <input type="text" name="beneficiary_nic" class="form-control"
                                                placeholder="Enter NIC">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Beneficiary Contact No:</label>
                                            <input type="text" name="beneficiary_contact_no" class="form-control"
                                                placeholder="Enter contact no">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">Relation:</label>
                                            <input type="text" name="beneficiary_relation" class="form-control"
                                                placeholder="e.g., Mother, Brother">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- OTHER INFORMATION -->
                            <fieldset class="border p-3 mb-3">
                                <legend class="float-none w-auto px-2">Other Information</legend>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group ">
                                            <label class="form-label">Registration Date:</label>
                                            <input type="date" name="registration_date" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group ">
                                            <label class="form-label">Tax Status:</label>
                                            <input type="text" name="tax_status" class="form-control"
                                                placeholder="Enter tax status">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3 form-group ">
                                            <label class="form-label">Tax No:</label>
                                            <input type="text" name="tax_no" class="form-control"
                                                placeholder="Enter tax number">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-check form-switch mt-4">
                                            <input type="checkbox" class="form-check-input" name="status"
                                                value="1" checked>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Save Investor</button>
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
                ajax: "{{ route('investors.index') }}",
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
                url: '/investors/' + userId + '/edit',
                type: 'GET',
                success: function(response) {

                    // Populate the form fields with the fetched data
                    $('#investorModalTitle').text('Edit User');
                    $('#fullName').val(response.data.name);
                    $('#email').val(response.data.email);
                    $('#nic').val(response.data.nic);

                    if (response.data.status == 1) {
                        $('#status').prop('checked', true);
                    } else {
                        $('#status').prop('checked', false);
                    }

                    $('#submitForm').attr('action', '/investors/' + userId);
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
