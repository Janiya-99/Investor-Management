@extends('layouts.main')

@section('title', isset($investment) ? 'Edit Investment' : 'Create Investment')
@section('breadcrumb-item', 'Investments')
@section('breadcrumb-item-active', isset($investment) ? 'Edit' : 'Create')

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 offset-lg-1">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ isset($investment) ? 'Edit Investment' : 'New Investment' }}</h5>
            </div>
            <div class="card-body">
                <form id="investmentForm" method="POST"
                    action="{{ isset($investment) ? route('investments.update', $investment) : route('investments.store') }}">
                    @csrf
                    @isset($investment)
                        @method('PUT')
                    @endisset

                    <div class="row g-3">

                        {{-- Investor --}}
                        <div class="col-md-6">
                            <label class="form-label">Investor <span class="text-danger">*</span></label>
                            <select name="investor_id" class="form-select js-choice-search @error('investor_id') is-invalid @enderror"
                                    data-placeholder="Search investor" required>
                                <option value="" disabled selected>Search investor</option>
                                @foreach ($investors as $investor)
                                    <option value="{{ $investor->id }}"
                                        @selected(old('investor_id', $investment->investor_id ?? '') == $investor->id)>
                                        {{ $investor->full_name }} ({{ $investor->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('investor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Product --}}
                        <div class="col-md-6">
                            <label class="form-label">Product</label>
                            <select name="product_id" id="productSelect"
                                    class="form-select js-choice-search @error('product_id') is-invalid @enderror"
                                    data-placeholder="Search product">
                                <option value="">Search product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        data-investment-amount="{{ $product->default_investment ?? '' }}"
                                        data-interest-rate="{{ $product->interest_rate ?? '' }}"
                                        data-period="{{ $product->period ?? '' }}"
                                        data-period-type="{{ $product->period_type ?? '' }}">
                                        {{ $product->name }} ({{ $product->period }} {{ $product->period_type }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Investment Amount --}}
                        <div class="col-md-4">
                            <label class="form-label">Investment Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="investment_amount"
                                   value="{{ old('investment_amount', $investment->investment_amount ?? '') }}"
                                   class="form-control @error('investment_amount') is-invalid @enderror" required>
                            @error('investment_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Interest Rate --}}
                        <div class="col-md-4">
                            <label class="form-label">Interest Rate (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.0001" name="interest_rate"
                                   value="{{ old('interest_rate', $investment->interest_rate ?? '') }}"
                                   class="form-control @error('interest_rate') is-invalid @enderror" required>
                            @error('interest_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Period --}}
                        <div class="col-md-2">
                            <label class="form-label">Period <span class="text-danger">*</span></label>
                            <input type="number" name="period"
                                   value="{{ old('period', $investment->period ?? '') }}"
                                   class="form-control @error('period') is-invalid @enderror" required>
                            @error('period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Period Type --}}
                        <div class="col-md-2">
                            <label class="form-label">Period Type <span class="text-danger">*</span></label>
                            <input type="text" name="period_type"
                                   value="{{ old('period_type', $investment->period_type ?? '') }}"
                                   class="form-control @error('period_type') is-invalid @enderror" placeholder="Months / Years" required>
                            @error('period_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Start Date --}}
                      <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Registration Date</label>
                                <input type="date" class="form-control" id="registration_date"
                                    name="registration_date" placeholder="Enter Registration Date">
                            </div>

                        {{-- Maturity Date --}}
                        <div class="col-md-4">
                            <label class="form-label">Maturity Date</label>
                            <input type="text" name="maturity_date"
                                   value="{{ old('maturity_date', optional($investment->maturity_date ?? null)?->format('Y-m-d')) }}"
                                   class="form-control datepicker @error('maturity_date') is-invalid @enderror">
                            @error('maturity_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Capital Withdrawal Notice --}}
                        <div class="col-md-4">
                            <label class="form-label">Capital Withdrawal Notice (days) <span class="text-danger">*</span></label>
                            <input type="number" name="capital_withdrawal_notice_period"
                                   value="{{ old('capital_withdrawal_notice_period', $investment->capital_withdrawal_notice_period ?? 0) }}"
                                   class="form-control @error('capital_withdrawal_notice_period') is-invalid @enderror" required>
                            @error('capital_withdrawal_notice_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select js-choice-search @error('status') is-invalid @enderror" required>
                                @php
                                    $statuses = ['draft'=>'Draft','active'=>'Active','closed'=>'Closed','cancelled'=>'Cancelled'];
                                @endphp
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $investment->status ?? 'active') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" rows="3" class="form-control" placeholder="Internal note (optional)">{{ old('notes', $investment->notes ?? '') }}</textarea>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('investments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ isset($investment) ? 'Update Investment' : 'Create Investment' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>


<script>
$(document).ready(function() {
    // flatpickr('.datepicker', { dateFormat: 'Y-m-d', disableMobile: true });

    $('.js-choice-search').each(function() {
        new Choices(this, { searchEnabled: true, shouldSort: false, placeholder: true, itemSelectText: '' });
    });

    // Auto-fill fields based on product selection
    $('#productSelect').on('change', function() {
        const selected = $(this).find(':selected');
        const investmentAmount = selected.data('investment-amount') || '';
        const interestRate = selected.data('interest-rate') || '';
        const period = selected.data('period') || '';
        const periodType = selected.data('period-type') || '';

        $('input[name="investment_amount"]').val(investmentAmount);
        $('input[name="interest_rate"]').val(interestRate);
        $('input[name="period"]').val(period);
        $('input[name="period_type"]').val(periodType);
    });
});
</script>
@endsection
