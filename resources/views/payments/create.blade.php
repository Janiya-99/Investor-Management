@extends('layouts.main')

@section('title', isset($payment) ? 'Edit Payment' : 'Record Payment')
@section('breadcrumb-item', 'Payments')
@section('breadcrumb-item-active', isset($payment) ? 'Edit' : 'Create')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ isset($payment) ? 'Edit Payment' : 'New Payment' }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($payment) ? route('payments.update', $payment) : route('payments.store') }}">
                        @csrf
                        @isset($payment)
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
                                            @selected(old('investment_id', $payment->investment_id ?? '') == $investment->id)>
                                            #{{ $investment->id }} - {{ $investment->investor->full_name ?? 'Investor' }}
                                            ({{ $investment->product->name ?? 'Product' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('investment_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Payable Bank</label>
                                <select name="investor_bank_details_id"
                                    class="form-select js-choice-search @error('investor_bank_details_id') is-invalid @enderror"
                                    data-placeholder="Search bank account">
                                    <option value="">Search bank account (optional)</option>
                                    @foreach ($bankDetails as $bankDetail)
                                        <option value="{{ $bankDetail->id }}"
                                            @selected(old('investor_bank_details_id', $payment->investor_bank_details_id ?? '') == $bankDetail->id)>
                                            {{ $bankDetail->investor->full_name ?? 'Investor' }} -
                                            {{ $bankDetail->bank->bank_name ?? 'Bank' }}
                                            ({{ $bankDetail->account_number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('investor_bank_details_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                                <input type="text" name="payment_date"
                                    value="{{ old('payment_date', optional($payment->payment_date ?? now())->format('Y-m-d')) }}"
                                    class="form-control datepicker @error('payment_date') is-invalid @enderror" required>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount"
                                    value="{{ old('amount', $payment->amount ?? '') }}"
                                    class="form-control @error('amount') is-invalid @enderror" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select js-choice-search @error('type') is-invalid @enderror"
                                    data-placeholder="Select type" required>
                                    @php
                                        $types = ['capital' => 'Capital', 'interest' => 'Interest', 'penalty' => 'Penalty', 'other' => 'Other'];
                                    @endphp
                                    @foreach ($types as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected(old('type', $payment->type ?? 'interest') === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status"
                                    class="form-select js-choice-search @error('status') is-invalid @enderror"
                                    data-placeholder="Select status" required>
                                    @php
                                        $statuses = ['pending' => 'Pending', 'posted' => 'Posted', 'void' => 'Void'];
                                    @endphp
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected(old('status', $payment->status ?? 'posted') === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Note</label>
                                <textarea name="note" rows="3" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="Payment note (optional)">{{ old('note', $payment->note ?? '') }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($payment) ? 'Update Payment' : 'Save Payment' }}
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
