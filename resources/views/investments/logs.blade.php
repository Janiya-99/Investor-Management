@extends('layouts.main')

@section('title', 'Investment Logs')
@section('breadcrumb-item', 'Investments')
@section('breadcrumb-item-active', 'Logs')

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
                    <h5 class="mb-0">Investment Logs</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="logs-table" class="table table-striped align-middle table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Investment</th>
                                <th>Investor</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Investment</th>
                                <th>Investor</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Description</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#logs-table').DataTable({
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                processing: true,
                serverSide: true,
                ajax: "{{ route('investment-logs.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'investment_id', name: 'investment_id' },
                    { data: 'investor_name', name: 'investment.investor.full_name' },
                    { data: 'type', name: 'type' },
                    { data: 'amount', name: 'amount' },
                    { data: 'log_date', name: 'log_date' },
                    { data: 'description', name: 'description' }
                ],
                order: [[5, 'desc']] // Sort by Date desc by default
            });
        });
    </script>
@endsection
