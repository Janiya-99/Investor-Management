@extends('layouts.main')

@section('title', 'Investments')
@section('breadcrumb-item', 'Investments')
@section('breadcrumb-item-active', 'List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Investments</h5>
                    <a href="{{ route('investments.create') }}" class="btn btn-primary">Add Investment</a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Investor</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Rate (%)</th>
                                <th>Start</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($investments as $investment)
                                <tr>
                                    <td>{{ $investment->id }}</td>
                                    <td>{{ $investment->investor->full_name ?? 'N/A' }}</td>
                                    <td>{{ $investment->product->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($investment->investment_amount, 2) }}</td>
                                    <td>{{ number_format($investment->interest_rate, 4) }}</td>
                                    <td>{{ optional($investment->start_date)->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge bg-light text-uppercase text-dark">{{ $investment->status }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('investments.edit', $investment) }}"
                                            class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('investments.destroy', $investment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Delete this investment?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No investments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $investments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
