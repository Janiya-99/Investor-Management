@extends('layouts.main')

@section('title', 'Investors')
@section('breadcrumb-item', 'Investors')

@section('breadcrumb-item-active', 'Investors List')

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
                    <a href="{{ route('investors.create') }}" class="btn btn-primary add-new">
                        Add Investor
                    </a>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered nowrap data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>NIC</th>
                                    <th>Contact No</th>
                                    <th>Address</th>
                                    <th>Tax Status</th>
                                    <th>Tax No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody></tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>NIC</th>
                                    <th>Contact No</th>
                                    <th>Address</th>
                                    <th>Tax Status</th>
                                    <th>Tax No</th>
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
                        <form id="submitForm" action="{{ route('investors.store') }}" method="POST">
                            @csrf

                            <!-- Investor Information -->
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Investor Information</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="mb-3 col-md-2 form-group">
                                                <label class="form-label required">Title</label>
                                                <select name="title" id="title" class="form-select">
                                                    <option value="">Select Title</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Ms">Ms</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Dr">Dr</option>
                                                    <option value="Prof">Prof</option>
                                                    <option value="Rev">Rev</option>
                                                    <option value="Hon">Hon</option>
                                                    <option value="Sir">Sir</option>
                                                    <option value="Madam">Madam</option>
                                                    <option value="Mx">Mx</option>
                                                    <option value="Eng">Eng</option>
                                                    <option value="Capt">Capt</option>
                                                    <option value="Lt">Lt</option>
                                                    <option value="Col">Col</option>
                                                    <option value="Gen">Gen</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-5 form-group">
                                                <label class="form-label required">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name"
                                                    placeholder="Enter First Name">
                                            </div>

                                            <div class="mb-3 col-md-5 form-group">
                                                <label class="form-label required">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    placeholder="Enter Last Name">
                                            </div>

                                            <div class="mb-3 col-md-6 form-group">
                                                <label class="form-label required">Full Name</label>
                                                <input type="text" class="form-control" id="full_name" name="full_name"
                                                    placeholder="Enter Full Name">
                                            </div>

                                            <div class="mb-3 col-md-6 form-group">
                                                <label class="form-label required">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Enter Email">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">NIC</label>
                                                <input type="text" class="form-control" id="nic" name="nic"
                                                    placeholder="Enter NIC">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Contact No</label>
                                                <input type="text" class="form-control" id="contact_no"
                                                    name="contact_no" placeholder="Enter Contact No">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Address Line 1</label>
                                                <input type="text" class="form-control" id="address_line_1"
                                                    name="address_line_1" placeholder="Enter Address Line 1">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Address Line 2</label>
                                                <input type="text" class="form-control" id="address_line_2"
                                                    name="address_line_2" placeholder="Enter Address Line 2">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Address Line 3</label>
                                                <input type="text" class="form-control" id="address_line_3"
                                                    name="address_line_3" placeholder="Enter Address Line 3">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Enter Password">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Beneficiary Information -->
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Beneficiary Information</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="mb-3 col-md-6 form-group">
                                                <label class="form-label required">Full Name</label>
                                                <input type="text" class="form-control" id="beneficiary_full_name"
                                                    name="beneficiary_full_name" placeholder="Enter Full Name">
                                            </div>

                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">NIC</label>
                                                <input type="text" class="form-control" id="beneficiary_nic"
                                                    name="beneficiary_nic" placeholder="Enter NIC">
                                            </div>

                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">Contact No</label>
                                                <input type="text" class="form-control" id="beneficiary_contact_no"
                                                    name="beneficiary_contact_no" placeholder="Enter Contact No">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Relation</label>
                                                <select class="form-select" id="beneficiary_relation"
                                                    name="beneficiary_relation">
                                                    <option value="">Select Relation</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Son">Son</option>
                                                    <option value="Daughter">Daughter</option>
                                                    <option value="Husband">Husband</option>
                                                    <option value="Wife">Wife</option>
                                                    <option value="Guardian">Guardian</option>
                                                    <option value="Friend">Friend</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Registration & Tax -->
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Registration & Tax</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Registration Date</label>
                                                <input type="date" class="form-control" id="registration_date"
                                                    name="registration_date">
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Tax Status</label>
                                                <select class="form-select" id="tax_status" name="tax_status">
                                                    <option value="">Select Status</option>
                                                    <option value="payable">Payable</option>
                                                    <option value="non_payable">Non Payable</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-4 form-group">
                                                <label class="form-label required">Tax No</label>
                                                <input type="text" class="form-control" id="tax_no" name="tax_no"
                                                    placeholder="Enter Tax No">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

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
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                processing: true,
                serverSide: true,
                ajax: "{{ route('investors.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'nic',
                        name: 'nic'
                    },
                    {
                        data: 'contact_no',
                        name: 'contact_no'
                    },
                    {
                        data: null,
                        name: 'address',
                        render: function(data, type, row) {
                            // Combine line 1, 2, 3 with commas, skip empty lines
                            let address = [row.address_line_1, row.address_line_2, row
                                    .address_line_3
                                ]
                                .filter(line => line)
                                .join(', ');
                            return address;
                        }
                    },
                    {
                        data: 'tax_status',
                        name: 'tax_status',
                        render: function(data) {
                            if (data !== 'payable') {
                                return '<span class="badge bg-primary">Payable</span>';
                            } else {
                                return '<span class="badge bg-secondary">Non Payable</span>';
                            }
                        }
                    },
                    {
                        data: 'tax_no',
                        name: 'tax_no'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '120px',
                        orderable: false,
                        searchable: false
                    },
                ],
                scrollX: true,
                responsive: true
            });
        });


     $(document).on('click', '.btn-edit', function() {

    var investorId = $(this).data('id');

    $.ajax({
        url: '/investors/' + investorId + '/edit',
        type: 'GET',
        success: function(response) {

            $('#submitForm')[0].reset();
            $('#submitForm').find('input[name="_method"]').remove();

            // Fill form fields normally
            $('#title').val(response.data.title);
            $('#first_name').val(response.data.first_name);
            $('#last_name').val(response.data.last_name);
            $('#full_name').val(response.data.full_name);
            $('#email').val(response.data.email);
            $('#nic').val(response.data.nic);
            $('#contact_no').val(response.data.contact_no);

            $('#address_line_1').val(response.data.address_line_1);
            $('#address_line_2').val(response.data.address_line_2);
            $('#address_line_3').val(response.data.address_line_3);

            $('#beneficiary_full_name').val(response.data.beneficiary_full_name);
            $('#beneficiary_nic').val(response.data.beneficiary_nic);
            $('#beneficiary_contact_no').val(response.data.beneficiary_contact_no);
            $('#beneficiary_relation').val(response.data.beneficiary_relation);

            $('#registration_date').val(response.data.registration_date);
            $('#tax_status').val(response.data.tax_status);
            $('#tax_no').val(response.data.tax_no);

            $('#submitForm').attr('action', '/investors/' + investorId);
            $('#submitForm').append('<input type="hidden" name="_method" value="PUT">');

            $('#varyingcontentModalLabel').modal('show');
        }
    });
});

    </script>
@endsection
