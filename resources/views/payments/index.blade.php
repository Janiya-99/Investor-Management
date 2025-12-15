@extends('layouts.main')

@section('title', 'Payments')
@section('breadcrumb-item', 'Payments')
@section('breadcrumb-item-active', 'List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payments</h5>
                    <a href="{{ route('payments.create') }}" class="btn btn-primary">Record Payment</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Investment</th>
                                <th>Investor</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>#{{ $payment->investment?->id ?? 'N/A' }}</td>
                                    <td>{{ $payment->investment?->investor?->full_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td class="text-capitalize">{{ $payment->type }}</td>
                                    <td>{{ optional($payment->payment_date)->format('Y-m-d') }}</td>
                                    <td><span class="badge bg-light text-uppercase text-dark">{{ $payment->status }}</span></td>
                                    <td class="text-end">
                                        <a href="{{ route('payments.edit', $payment) }}"
                                            class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete this payment?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No payments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
