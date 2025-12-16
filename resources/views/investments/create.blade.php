@extends('layouts.main')

@section('title', isset($investment) ? 'Edit Investment' : 'Create Investment')
@section('breadcrumb-item', 'Investments')
@section('breadcrumb-item-active', isset($investment) ? 'Edit' : 'Create')

@section('css')
    <!-- [Page specific CSS] start -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
        .required:after {
            content: " *";
            color: red;
            font-weight: bold;
        }

        .card-header .eyebrow {
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #64748b;
        }
    </style>
@endsection

@section('content')
    <div class="row">

        <!-- Sticky Header -->
        <div id="sticky-action" class="sticky-action mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>{{ isset($investment) ? 'Edit Investment' : 'New Investment' }}</h4>
                            <small class="text-muted">
                                <span class="text-danger">*</span> Required fields.
                            </small>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <button type="button" id="submitFormBtn" class="btn btn-success">
                                {{ isset($investment) ? 'Update' : 'Submit' }}
                            </button>
                            <a href="{{ route('investments.index') }}" class="btn btn-light-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <form id="submitForm" method="POST"
                  action="{{ isset($investment) ? route('investments.update', $investment) : route('investments.store') }}">
                @csrf
                @isset($investment)
                    @method('PUT')
                @endisset

                <div class="card shadow-sm">
                    <div class="card-header">
                        <div class="eyebrow">Details</div>
                        <h5 class="mb-0">Investment Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Investor --}}
                            <div class="col-md-6 mb-3 form-group">
                                <label class="form-label required">Investor</label>
                                <select name="investor_id" class="form-select js-choice-search">
                                    <option value="">Search investor</option>
                                    @foreach ($investors as $investor)
                                        <option value="{{ $investor->id }}"
                                                @selected(old('investor_id', $investment->investor_id ?? '') == $investor->id)>
                                            {{ $investor->full_name }} ({{ $investor->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Investor Bank Details --}}
                            <div class="col-md-6 mb-3 form-group">
                                <label class="form-label">Payout Bank Account</label>
                                <select name="investor_bank_details_id" class="form-select js-choice-search">
                                    <option value="">Select Bank Account</option>
                                    @foreach ($bankDetails as $detail)
                                        <option value="{{ $detail->id }}"
                                                @selected(old('investor_bank_details_id', $investment->investor_bank_details_id ?? '') == $detail->id)>
                                            {{ $detail->bank_name }} - {{ $detail->account_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Product --}}
                            <div class="col-md-6 mb-3 form-group">
                                <label class="form-label">Product</label>
                                <select name="product_id" id="productSelect" class="form-select js-choice-search">
                                    <option value="">Search product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                                @selected(old('product_id', $investment->product_id ?? '') == $product->id)
                                                data-investment-amount="{{ $product->default_investment }}"
                                                data-interest-rate="{{ $product->interest_rate }}"
                                                data-period="{{ $product->period }}"
                                                data-period-type="{{ $product->period_type }}"
                                                data-interest-calculation-type="{{ $product->interest_calculation_type }}"
                                                data-capital-withdrawal-notice-period="{{$product->capital_withdrawal_notice_period}}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Amount --}}
                            <div class="col-md-4 mb-3 form-group">
                                <label class="form-label required">Investment Amount</label>
                                <input type="number" step="0.01" name="investment_amount" class="form-control"
                                       value="{{ old('investment_amount', $investment->investment_amount ?? '') }}"
                                       >
                            </div>

                            {{-- Capital Withdrawal Notice Period --}}
                            <div class="col-md-4 mb-3 form-group">
                                <label class="form-label required">Withdrawal Notice (Days)</label>
                                <input type="number" name="capital_withdrawal_notice_period" class="form-control"
                                       value="{{ old('capital_withdrawal_notice_period', $investment->capital_withdrawal_notice_period ?? '0') }}" required>
                            </div>

                            {{-- Rate --}}
                            <div class="col-md-4 mb-3 form-group">
                                <label class="form-label required">Interest Rate (%)</label>
                                <input type="number" step="0.0001" name="interest_rate" class="form-control"
                                       value="{{ old('interest_rate', $investment->interest_rate ?? '') }}" required>
                            </div>

                            {{-- Interest Calculation --}}
                            <div class="col-md-4 mb-3 form-group">
                                <label class="form-label required">Interest Calculation</label>
                                <select name="interest_calculation_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="simple" @selected(old('interest_calculation_type', $investment->interest_calculation_type ?? '') == 'simple')>
                                        Simple
                                    </option>
                                    <option value="compound" @selected(old('interest_calculation_type', $investment->interest_calculation_type ?? '') == 'compound')>
                                        Compound
                                    </option>
                                </select>
                            </div>

                            {{-- Period --}}
                            <div class="col-md-6 mb-3 form-group">
                                <label class="form-label required">Period</label>
                                <div class="input-group">
                                    <input type="number" name="period" class="form-control"
                                           value="{{ old('period', $investment->period ?? '') }}" required>
                                    <select name="period_type" class="form-control" style="max-width: 120px;" required>
                                        <option value="">Type</option>
                                        <option value="days" @selected(old('period_type', $investment->period_type ?? '') == 'days')>
                                            Days
                                        </option>
                                        <option value="weeks" @selected(old('period_type', $investment->period_type ?? '') == 'weeks')>
                                            Weeks
                                        </option>
                                        <option value="months" @selected(old('period_type', $investment->period_type ?? '') == 'months')>
                                            Months
                                        </option>
                                        <option value="years" @selected(old('period_type', $investment->period_type ?? '') == 'years')>
                                            Years
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- Start Date --}}
                            <div class="col-md-6 mb-3 form-group">
                                <label class="form-label required">Start Date</label>
                                <input type="date" name="start_date" class="form-control"
                                       value="{{ old('start_date', isset($investment) && $investment->start_date ? $investment->start_date->format('Y-m-d') : date('Y-m-d')) }}" required>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-12 mb-3 form-group">
                                <label class="form-label required">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" @selected(old('status', $investment->status ?? '') == 'active')>
                                        Active
                                    </option>
                                    <option value="draft" @selected(old('status', $investment->status ?? '') == 'draft')>
                                        Draft
                                    </option>
                                    <option value="closed" @selected(old('status', $investment->status ?? '') == 'closed')>
                                        Closed
                                    </option>
                                </select>
                            </div>

                            {{-- Notes --}}
                            <div class="col-12 mb-3 form-group">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control"
                                          rows="3">{{ old('notes', $investment->notes ?? '') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Schedule Plan --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span class="mb-0">Schedule Plan</span>
                    <span id="scheduleType" class="badge bg-secondary">—</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Capital Amount</th>
                            <th>Interest</th>
                        </tr>
                        </thead>
                        <tbody id="scheduleTable">
                        <tr>
                            <td colspan="3" class="text-center text-muted p-4">
                                Enter details to generate schedule
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>

    <script>
        $(document).ready(function () {
            // Init Choices
            $('.js-choice-search').each(function () {
                new Choices(this, {
                    searchEnabled: true,
                    shouldSort: false,
                    itemSelectText: ''
                });
            });

            // Schedule Calculation Logic
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
                        displayAmount = amount;
                        interest = amount * rate;
                    } else {
                        displayAmount = currentAmount;
                        interest = currentAmount * rate;
                        currentAmount = currentAmount + interest;
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

            // Trigger on load if values exist (edit mode)
            if ($('input[name="investment_amount"]').val()) {
                generateSchedule();
            }

            // Listen for form reset event from footerjs
            $(document).on('form:reset', function() {
                $('#scheduleTable').html(`
                        <tr>
                            <td colspan="3" class="text-center text-muted p-4">
                                Enter details to generate schedule
                            </td>
                        </tr>
                    `);
                $('#scheduleType').text('—');
                // Also reset choices.js instances if any (the .js-choice-search elements)
                // Choices.js doesn't auto-reset with form reset perfectly sometimes, but let's see.
                // Assuming simple reset for now.
            });

            $('#productSelect').on('change', function () {
                const selectedValue = $(this).val();
                // Find option by value explicitly to ensure we get the correct DOM element with data attributes
                // This is necessary because Choices.js hides the original select and manipulates the DOM
                const selected = $(this).find(`option[value="${selectedValue}"]`);
                
                if (!selectedValue || !selected.length) return;

                // Update input fields
                if (selected.data('investment-amount')) {
                    $('input[name="investment_amount"]').val(selected.data('investment-amount'));
                }
                if (selected.data('interest-rate')) {
                    $('input[name="interest_rate"]').val(selected.data('interest-rate'));
                }
                if (selected.data('period')) {
                    $('input[name="period"]').val(selected.data('period'));
                }
                if (selected.data('period-type')) {
                    $('select[name="period_type"]').val(selected.data('period-type'));
                }
                if (selected.data('interest-calculation-type')) {
                    $('select[name="interest_calculation_type"]').val(selected.data('interest-calculation-type'));
                }
                if (selected.data('capital-withdrawal-notice-period') !== undefined) {
                    $('input[name="capital_withdrawal_notice_period"]').val(
                        selected.data('capital-withdrawal-notice-period')
                    );
                }

                setTimeout(generateSchedule, 200);
            });

        });
    </script>
@endsection
