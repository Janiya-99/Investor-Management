@extends('layouts.main')

@section('title', isset($interestSchedule) ? 'Edit Interest Schedule' : 'Create Interest Schedule')
@section('breadcrumb-item', 'Interest Schedules')
@section('breadcrumb-item-active', isset($interestSchedule) ? 'Edit' : 'Create')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ isset($interestSchedule) ? 'Edit Schedule' : 'New Interest Schedule' }}</h5>
                        <small class="text-muted">Plan and track expected interest payouts</small>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($interestSchedule) ? route('interest-schedules.update', $interestSchedule) : route('interest-schedules.store') }}">
                        @csrf
                        @isset($interestSchedule)
                            @method('PUT')
                        @endisset
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Investment <span class="text-danger">*</span></label>
                                <select name="investment_id"
                                    class="form-select js-choice-search @error('investment_id') is-invalid @enderror"
                                    data-placeholder="Search investment" required>
                                    <option value="" selected disabled>Search investment</option>
                                    @foreach ($investments as $investment)
                                        <option value="{{ $investment->id }}"
                                            @selected(old('investment_id', $interestSchedule->investment_id ?? '') == $investment->id)>
                                            #{{ $investment->id }} - {{ $investment->investor->full_name ?? 'Investor' }}
                                            ({{ $investment->product->name ?? 'Product' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('investment_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Due Date <span class="text-danger">*</span></label>
                                <input type="text" name="due_date"
                                    value="{{ old('due_date', optional($interestSchedule->due_date ?? now())->format('Y-m-d')) }}"
                                    class="form-control datepicker @error('due_date') is-invalid @enderror" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status"
                                    class="form-select js-choice-search @error('status') is-invalid @enderror"
                                    data-placeholder="Select status" required>
                                    @php
                                        $statuses = [
                                            'pending' => 'Pending',
                                            'scheduled' => 'Scheduled',
                                            'paid' => 'Paid',
                                            'overdue' => 'Overdue',
                                            'cancelled' => 'Cancelled',
                                        ];
                                    @endphp
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected(old('status', $interestSchedule->status ?? 'pending') === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Interest Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="interest_amount"
                                    value="{{ old('interest_amount', $interestSchedule->interest_amount ?? '') }}"
                                    class="form-control @error('interest_amount') is-invalid @enderror" required>
                                @error('interest_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Capital Amount</label>
                                <input type="number" step="0.01" name="capital_amount"
                                    value="{{ old('capital_amount', $interestSchedule->capital_amount ?? '') }}"
                                    class="form-control @error('capital_amount') is-invalid @enderror"
                                    placeholder="0.00">
                                @error('capital_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Paid Amount</label>
                                <input type="number" step="0.01" name="paid_amount"
                                    value="{{ old('paid_amount', $interestSchedule->paid_amount ?? '') }}"
                                    class="form-control @error('paid_amount') is-invalid @enderror"
                                    placeholder="0.00">
                                @error('paid_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Paid Date</label>
                                <input type="text" name="paid_at"
                                    value="{{ old('paid_at', optional($interestSchedule->paid_at ?? null)?->format('Y-m-d')) }}"
                                    class="form-control datepicker @error('paid_at') is-invalid @enderror"
                                    placeholder="YYYY-MM-DD">
                                @error('paid_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Note</label>
                                <textarea name="note" rows="3" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="Internal note (optional)">{{ old('note', $interestSchedule->note ?? '') }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('interest-schedules.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($interestSchedule) ? 'Update Schedule' : 'Create Schedule' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        .choices__inner {
            min-height: 48px;
            border-radius: 12px;
            border-color: #e0e6ed;
        }

        .choices__list--dropdown .choices__item--selectable {
            padding: 10px 12px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.datepicker', { dateFormat: 'Y-m-d', disableMobile: true });

            document.querySelectorAll('.js-choice-search').forEach((select) => {
                new Choices(select, {
                    searchEnabled: true,
                    shouldSort: false,
                    placeholder: true,
                    itemSelectText: '',
                });
            });
        });
    </script>
@endsection

