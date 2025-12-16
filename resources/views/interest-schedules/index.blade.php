@extends('layouts.main')

@section('title', 'Interest Schedules')
@section('breadcrumb-item', 'Interest Schedules')
@section('breadcrumb-item-active', 'List')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
    <style>
        td.details-control {
            background: url("{{ URL::asset('build/images/details_open.png') }}") no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url("{{ URL::asset('build/images/details_close.png') }}") no-repeat center center;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Interest Schedules</h5>
                        <small class="text-muted">Filtered by Investors</small>
                    </div>
                    <a href="{{ route('interest-schedules.create') }}" class="btn btn-primary">
                        <i class="ph-duotone ph-plus me-1"></i> Add Schedule
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table id="investors-table" class="table table-striped align-middle table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Investor Name</th>
                                <th>NIC</th>
                                <th>Total Schedules</th>
                                <th>Pending Amount (Rs.)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
            var table = $('#investors-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('interest-schedules.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'nic', name: 'nic' },
                    { data: 'total_schedules_count', name: 'total_schedules_count', searchable: false },
                    { data: 'total_pending_amount', name: 'total_pending_amount', searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                scrollX: true,
                responsive: true
            });

            // Use ResizeObserver to ensure table columns adjust when container size changes
            var tableContainer = document.querySelector('#investors-table_wrapper');
            if (tableContainer) {
                var resizeObserver = new ResizeObserver(function() {
                    table.columns.adjust();
                });
                resizeObserver.observe(tableContainer);
            }

            // Add event listener for opening and closing details
            $('#investors-table tbody').on('click', 'button.btn-details', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var investorId = $(this).data('id');

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(investorId)).show();
                    tr.addClass('shown');
                    
                    // Initialize Child Table
                    var childTableId = '#child-table-' + investorId;
                    $(childTableId).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "/interest-schedules/investor/" + investorId,
                        columns: [
                            { data: 'investment_id', title: 'Investment #' },
                            { data: 'product_name', title: 'Product' },
                            { data: 'due_date', title: 'Due Date' },
                            { data: 'interest_amount', title: 'Interest' },
                            { data: 'capital_amount', title: 'Capital' },
                            { data: 'total_amount', title: 'Total' },
                            { data: 'status', title: 'Status' },
                            { data: 'action', title: 'Action', orderable: false, searchable: false }
                        ],
                        dom: 't', // Only show table, no pagination/search for child
                        paging: false
                    });
                }
            });

            function format(investorId) {
                return '<div class="card card-body bg-light m-2">' +
                        '<h6 class="card-title">Interest Schedules</h6>' +
                        '<table id="child-table-' + investorId + '" class="table table-sm table-bordered" style="width:100%">' +
                        '</table>' +
                        '</div>';
            }
        });
    </script>
@endsection
