@extends('layouts.main')

@section('title', 'Products')
@section('breadcrumb-item', 'Products')

@section('breadcrumb-item-active', 'Products')

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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header table-card-header text-end">
                    <button type="button" class="btn btn-primary add-new" data-bs-toggle="modal"
                        data-bs-target="#varyingcontentModalLabel">Add Product</button>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered nowrap data-table ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Period Type</th>
                                    <th>Period</th>
                                    <th>Interest Rate</th>
                                    <th>Amount Range</th>
                                    <th>Interest Calculation</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Period Type</th>
                                    <th>Period</th>
                                    <th>Interest Rate</th>
                                    <th>Amount Range</th>
                                    <th>Interest Calculation</th>
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

    <div id="varyingcontentModalLabel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="productModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalTitle">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="submitForm" action="{{ route('products.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 mb-3 form-group">
                                    <label class="form-label">Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter product name" required>
                                </div>

                                <div class="col-lg-6 mb-3 form-group">
                                    <label class="form-label">Period Type: <span class="text-danger">*</span></label>
                                    <select class="form-control" id="period_type" name="period_type" required>
                                        <option value="">Select Period Type</option>
                                        <option value="days">Days</option>
                                        <option value="weeks">Weeks</option>
                                        <option value="months">Months</option>
                                        <option value="years">Years</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 mb-3 form-group">
                                    <label class="form-label">Period: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="period" name="period"
                                        placeholder="Enter period" required>
                                </div>

                                <div class="col-lg-6 mb-3 ">
                                    <label class="form-label">Interest Rate: <span class="text-danger">*</span></label>
                                    <div class="input-group form-group">
                                        <input type="number" step="0.01" class="form-control" id="min_interest_rate"
                                            name="min_interest_rate" placeholder="Min rate" required>
                                        <input type="number" step="0.01" class="form-control" id="max_interest_rate"
                                            name="max_interest_rate" placeholder="Max rate" required>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 mb-3 ">
                                    <label class="form-label">Amount Range: <span class="text-danger">*</span></label>
                                    <div class="input-group form-group">
                                        <input type="number" step="0.01" class="form-control" id="min_amount"
                                            name="min_amount" placeholder="Min amount" required>
                                        <input type="number" step="0.01" class="form-control" id="max_amount"
                                            name="max_amount" placeholder="Max amount" required>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 form-group">
                                    <label class="form-label">Interest Calculation Type: <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="interest_calculation_type"
                                        name="interest_calculation_type" required>
                                        <option value="">Select Type</option>
                                        <option value="simple">Simple</option>
                                        <option value="compound">Compound</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 mb-3 form-group">
                                    <label class="form-label">Capital Withdrawal Notice Period (days):</label>
                                    <input type="number" class="form-control" id="capital_withdrawal_notice_period"
                                        name="capital_withdrawal_notice_period" placeholder="Enter notice period">
                                </div>

                                <div class="col-lg-6 mb-3 form-group">
                                    <label class="form-label">Penalty Type:</label>
                                    <select class="form-control" id="penalty_type" name="penalty_type">
                                        <option value="">Select Penalty Type</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Penalty Rate:</label>
                                    <div class="input-group form-group">
                                        <input type="number" step="0.01" class="form-control" id="penalty_min_rate"
                                            name="penalty_min_rate" placeholder="Min rate">
                                        <input type="number" step="0.01" class="form-control" id="penalty_max_rate"
                                            name="penalty_max_rate" placeholder="Max rate">
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 form-group">
                                    <div class="form-check form-switch mt-4">
                                        <input type="checkbox" class="form-check-input" id="status" name="status"
                                            value="1" checked>
                                        <label class="form-check-label" for="status">Active</label>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Save Product</button>
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
                ajax: "{{ route('products.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'period_type',
                        name: 'period_type'
                    },
                    {
                        data: 'period',
                        name: 'period'
                    },
                    {
                        data: 'interest_rate',
                        name: 'interest_rate',
                        render: function(data, type, row) {
                            return row.min_interest_rate + ' - ' + row.max_interest_rate + '%';
                        }
                    },
                    {
                        data: 'amount_range',
                        name: 'amount_range',
                        render: function(data, type, row) {
                            return row.min_amount + ' - ' + row.max_amount;
                        }
                    },
                    {
                        data: 'interest_calculation_type',
                        name: 'interest_calculation_type'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            return data == 1 ? '<span class="badge bg-success">Active</span>' :
                                '<span class="badge bg-danger">Inactive</span>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],

            });
        });

        $(document).on('click', '.btn-edit', function() {

            var productId = $(this).data('id');

            $.ajax({
                url: '/products/' + productId + '/edit',
                type: 'GET',
                success: function(response) {

                    let d = response.data;

                    // Change modal title
                    $('#productModalTitle').text('Edit Product');

                    // Fill input fields
                    $('#name').val(d.name);
                    $('#period_type').val(d.period_type);
                    $('#period').val(d.period);
                    $('#min_interest_rate').val(d.min_interest_rate);
                    $('#max_interest_rate').val(d.max_interest_rate);
                    $('#min_amount').val(d.min_amount);
                    $('#max_amount').val(d.max_amount);
                    $('#interest_calculation_type').val(d.interest_calculation_type);
                    $('#capital_withdrawal_notice_period').val(d.capital_withdrawal_notice_period);
                    $('#penalty_type').val(d.penalty_type);
                    $('#penalty_min_rate').val(d.penalty_min_rate);
                    $('#penalty_max_rate').val(d.penalty_max_rate);

                    // Status switch
                    if (d.status == 1) {
                        $('#status').prop('checked', true);
                    } else {
                        $('#status').prop('checked', false);
                    }

                    // Update form action
                    $('#submitProductForm').attr('action', '/products/' + productId);

                    // Remove old _method
                    $('#submitProductForm input[name="_method"]').remove();

                    // Add PUT method
                    $('#submitProductForm').append('<input type="hidden" name="_method" value="PUT">');

                    // Show modal
                    $('#varyingcontentModalLabel').modal('show');
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
