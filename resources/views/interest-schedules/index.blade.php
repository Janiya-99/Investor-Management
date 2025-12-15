@extends('layouts.main')

@section('title', 'Interest Schedules')
@section('breadcrumb-item', 'Interest Schedules')
@section('breadcrumb-item-active', 'List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Interest Schedules</h5>
                        <small class="text-muted">Track upcoming and paid interest events</small>
                    </div>
                    <a href="{{ route('interest-schedules.create') }}" class="btn btn-primary">
                        <i class="ph-duotone ph-plus me-1"></i> Add Schedule
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Investment</th>
                                    <th>Due Date</th>
                                    <th>Interest</th>
                                    <th>Capital</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Paid</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schedules as $schedule)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold mb-1">#{{ $schedule->investment_id }}</div>
                                            <div class="text-muted small">
                                                {{ $schedule->investment->investor->full_name ?? 'Investor' }}
                                                @if($schedule->investment->product)
                                                    • {{ $schedule->investment->product->name }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ optional($schedule->due_date)->format('Y-m-d') }}</div>
                                            <div class="text-muted small">Created: {{ optional($schedule->created_at)->format('Y-m-d') }}</div>
                                        </td>
                                        <td>Rs. {{ number_format($schedule->interest_amount, 2) }}</td>
                                        <td>Rs. {{ number_format($schedule->capital_amount, 2) }}</td>
                                        <td class="fw-semibold">Rs. {{ number_format($schedule->total_amount, 2) }}</td>
                                        <td>
                                            @php
                                                $statusClass = match ($schedule->status) {
                                                    'paid' => 'bg-success-subtle text-success',
                                                    'overdue' => 'bg-danger-subtle text-danger',
                                                    'scheduled' => 'bg-info-subtle text-info',
                                                    'cancelled' => 'bg-secondary-subtle text-secondary',
                                                    default => 'bg-warning-subtle text-warning',
                                                };
                                            @endphp
                                            <span class="badge rounded-pill {{ $statusClass }}">{{ ucfirst($schedule->status) }}</span>
                                        </td>
                                        <td>
                                            @if($schedule->paid_amount)
                                                <div>Rs. {{ number_format($schedule->paid_amount, 2) }}</div>
                                                <div class="text-muted small">{{ optional($schedule->paid_at)->format('Y-m-d') }}</div>
                                            @else
                                                <span class="text-muted small">Not paid</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('interest-schedules.edit', $schedule) }}" class="btn btn-outline-primary">
                                                    Edit
                                                </a>
                                                <form action="{{ route('interest-schedules.destroy', $schedule) }}" method="POST"
                                                    onsubmit="return confirm('Delete this schedule?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No interest schedules yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $schedules->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

