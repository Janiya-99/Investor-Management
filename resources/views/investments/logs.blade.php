@extends('layouts.main')

@section('title', 'Investment Logs')
@section('breadcrumb-item', 'Investments')
@section('breadcrumb-item-active', 'Logs')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Investment Logs</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
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
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>#{{ $log->investment?->id ?? 'N/A' }}</td>
                                    <td>{{ $log->investment?->investor?->full_name ?? 'N/A' }}</td>
                                    <td class="text-capitalize">{{ $log->type }}</td>
                                    <td>{{ number_format($log->amount, 2) }}</td>
                                    <td>{{ optional($log->log_date)->format('Y-m-d') }}</td>
                                    <td>{{ $log->description ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
