@extends('layouts.main')

@section('title', 'Investments')
@section('breadcrumb-item', 'Investments')
@section('breadcrumb-item-active', 'List')

@section('css')
    <!-- [Page specific CSS] start -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
    <!-- [Page specific CSS] end -->
@endsection

@section('content')
    <!-- [ Main Content ] start -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">

            <!-- Card Header (Right-aligned button like the other table) -->
            <div class="card-header table-card-header text-end">
                <a href="{{ route('investments.create') }}" class="btn btn-primary add-new">
                    Add Investment
                </a>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="dt-responsive table-responsive">

                    <table id="basic-btn"
                           class="table table-striped table-bordered nowrap data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Investor</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Rate (%)</th>
                                <th>Start</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Investor</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Rate (%)</th>
                                <th>Start</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>
    <script>
        $(document).ready(function() {
            var table = $('#basic-btn').DataTable({
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                processing: true,
                serverSide: true,
                ajax: "{{ route('investments.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'investor_name', name: 'investor.full_name' },
                    { data: 'product_name', name: 'product.name' },
                    { data: 'investment_amount', name: 'investment_amount' },
                    { data: 'interest_rate', name: 'interest_rate' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                scrollX: true,
                responsive: true
            });

            // Use ResizeObserver to ensure table columns adjust when container size changes
            var tableContainer = document.querySelector('#basic-btn_wrapper');
            if (tableContainer) {
                var resizeObserver = new ResizeObserver(function() {
                    table.columns.adjust();
                });
                resizeObserver.observe(tableContainer);
            }
        });
    </script>
@endsection
