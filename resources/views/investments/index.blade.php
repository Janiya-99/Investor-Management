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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Investments</h5>
                    <a href="{{ route('investments.create') }}" class="btn btn-primary">Add Investment</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="investments-table" class="table table-striped align-middle table-bordered nowrap">
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
@endsection

@section('scripts')
    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>
    <script>
        $(document).ready(function() {
            var table = $('#investments-table').DataTable({
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
                ]
            });
        });
    </script>
@endsection
