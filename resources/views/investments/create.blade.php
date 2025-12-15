@extends('layouts.main')

@section('title', isset($investment) ? 'Edit Investment' : 'Create Investment')
@section('breadcrumb-item', 'Investments')
@section('breadcrumb-item-active', isset($investment) ? 'Edit' : 'Create')

@section('content')
    <div class="row">
        <div class="col-12 px-lg-4">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ isset($investment) ? 'Edit Investment' : 'New Investment' }}</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        {{-- LEFT COLUMN : FORM --}}
                        <div class="col-lg-8 border-end">

                            <form id="investmentForm" method="POST"
                                  action="{{ isset($investment) ? route('investments.update', $investment) : route('investments.store') }}">
                                @csrf
                                @isset($investment)
                                    @method('PUT')
                                @endisset

                                <div class="row g-3">

                                    {{-- Investor --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Investor *</label>
                                        <select name="investor_id" class="form-select js-choice-search" required>
                                            <option value="">Search investor</option>
                                            @foreach ($investors as $investor)
                                                <option value="{{ $investor->id }}"
                                                        @selected(old('investor_id', $investment->investor_id ?? '') == $investor->id)>
                                                    {{ $investor->full_name }} ({{ $investor->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Product --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Product</label>
                                        <select name="product_id" id="productSelect"
                                                class="form-select js-choice-search">
                                            <option value="">Search product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                        data-investment-amount="{{ $product->default_investment }}"
                                                        data-interest-rate="{{ $product->interest_rate }}"
                                                        data-period="{{ $product->period }}"
                                                        data-period-type="{{ $product->period_type }}"
                                                        data-interest-calculation-type="{{ $product->interest_calculation_type }}">
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Amount --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Investment Amount *</label>
                                        <input type="number" step="0.01" name="investment_amount"
                                               class="form-control" required>
                                    </div>

                                    {{-- Rate --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Interest Rate (%) *</label>
                                        <input type="number" step="0.0001" name="interest_rate"
                                               class="form-control" required>
                                    </div>

                                    {{-- Period --}}
                                    <div class="col-md-2">
                                        <label class="form-label">Period *</label>
                                        <input type="number" name="period"
                                               class="form-control" required>
                                    </div>

                                    {{-- Period Type --}}
                                    <div class="col-md-2">
                                        <label class="form-label">Type *</label>
                                        <select name="period_type" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="days">Days</option>
                                            <option value="weeks">Weeks</option>
                                            <option value="months">Months</option>
                                            <option value="years">Years</option>
                                        </select>
                                    </div>

                                    {{-- Interest Calculation --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Interest Calculation *</label>
                                        <select name="interest_calculation_type"
                                                class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="simple">Simple</option>
                                            <option value="compound">Compound</option>
                                        </select>
                                    </div>

                                    {{-- Registration Date --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Registration Date</label>
                                        <input type="date" name="registration_date"
                                               class="form-control">
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Status *</label>
                                        <select name="status" class="form-control">
                                            <option value="active">Active</option>
                                            <option value="draft">Draft</option>
                                            <option value="closed">Closed</option>
                                        </select>
                                    </div>

                                    {{-- Notes --}}
                                    <div class="col-12">
                                        <label class="form-label">Notes</label>
                                        <textarea name="notes" class="form-control" rows="3"></textarea>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-end mt-4 gap-2">
                                    <a href="{{ route('investments.index') }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Save Investment
                                    </button>
                                </div>

                            </form>
                        </div>

                        {{-- RIGHT COLUMN : SCHEDULE --}}
                        <div class="col-lg-4 ps-lg-4">

                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-dark text-white d-flex justify-content-between">
                                    <span>Schedule Plan</span>
                                    <span id="scheduleType" class="badge bg-secondary">—</span>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Amount</th>
                                            <th>Interest</th>
                                        </tr>
                                        </thead>
                                        <tbody id="scheduleTable">
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                Enter details to generate schedule
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        $(document).ready(function () {

            $('.js-choice-search').each(function () {
                new Choices(this, {
                    searchEnabled: true,
                    shouldSort: false,
                    itemSelectText: ''
                });
            });

            function generateSchedule() {

                const amount = parseFloat($('input[name="investment_amount"]').val());
                const rate = parseFloat($('input[name="interest_rate"]').val()) / 100;
                const period = parseInt($('input[name="period"]').val());
                const type = $('select[name="interest_calculation_type"]').val();

                if (!amount || !rate || !period || !type) return;

                let tbody = $('#scheduleTable');
                tbody.empty();

                let currentAmount = amount;
                $('#scheduleType').text(type.toUpperCase());

                for (let i = 1; i <= period; i++) {

                    let interest;
                    let displayAmount;

                    if (type === 'simple') {
                        interest = amount * rate;
                        displayAmount = amount;
                    } else {
                        interest = currentAmount * rate;
                        currentAmount += interest;
                        displayAmount = currentAmount;
                    }

                    tbody.append(`
                <tr>
                    <td>${i}</td>
                    <td>${displayAmount.toFixed(2)}</td>
                    <td>${interest.toFixed(2)}</td>
                </tr>
            `);
                }
            }

            $(document).on('input change',
                'input[name="investment_amount"], input[name="interest_rate"], input[name="period"], select[name="interest_calculation_type"]',
                generateSchedule
            );

            $('#productSelect').on('change', function () {
                const selected = $(this).find(':selected');

                $('input[name="investment_amount"]').val(selected.data('investment-amount'));
                $('input[name="interest_rate"]').val(selected.data('interest-rate'));
                $('input[name="period"]').val(selected.data('period'));
                $('select[name="period_type"]').val(selected.data('period-type'));
                $('select[name="interest_calculation_type"]').val(selected.data('interest-calculation-type'));

                setTimeout(generateSchedule, 200);
            });

        });
    </script>
@endsection
