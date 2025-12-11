@extends('layouts.main')

@section('title', 'Investor Bank Details')
@section('breadcrumb-item', 'Investors')
@section('breadcrumb-item-active', 'Bank Details')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="eyebrow text-muted small text-uppercase mb-1">Payments</div>
                        <h4 class="mb-0">Select investor & manage bank details</h4>
                        <small class="text-muted">Add at least one bank account for payouts.</small>
                    </div>
                    <a href="{{ route('investors.index') }}" class="btn btn-light">
                        <i class="ph-duotone ph-arrow-left"></i> Back to list
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-3 mb-4" method="GET" action="{{ route('investors.banks.edit') }}">
                        <div class="col-md-6 form-group">
                            <label class="form-label required" data-bs-toggle="tooltip" title="Required">Select Investor</label>
                            <select name="investor_id" class="form-select investor-select" onchange="this.form.submit()" required>
                                <option value="">Choose investor</option>
                                @foreach($investors as $item)
                                    <option value="{{ $item->id }}" @selected(optional($investor)->id == $item->id)>
                                        {{ $item->full_name }} ({{ $item->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if($investor)
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="text-muted">Currently editing: <strong>{{ $investor->full_name }}</strong></div>
                            </div>
                        @endif
                    </form>

                    @if($investor)
                        <form action="{{ route('investors.banks.update') }}" method="POST" id="banksForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="investor_id" value="{{ $investor->id }}">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Bank Accounts</h6>
                                <button type="button" class="btn btn-outline-primary" id="addBank">
                                    <i class="ph-duotone ph-plus-square"></i> Add Bank
                                </button>
                            </div>

                            <div id="banksWrapper">
                                @forelse($investor->bankDetails as $i => $bankDetail)
                                    <div class="bank-item border rounded p-3 mb-3">
                                        <div class="row align-items-end">
                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">Bank</label>
                                                <select class="form-select bank-select" name="banks[{{ $i }}][bank_id]" data-branch-select="banks_{{ $i }}_bank_branch_id">
                                                    <option value="">Select Bank</option>
                                                    @foreach($banks as $bank)
                                                        <option value="{{ $bank->id }}" @selected($bankDetail->bank_id == $bank->id)>{{ $bank->bank_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">Branch</label>
                                                <select class="form-select branch-select" id="banks_{{ $i }}_bank_branch_id" name="banks[{{ $i }}][bank_branch_id]">
                                                    <option value="">Select Branch</option>
                                                    @if($bankDetail->branch)
                                                        <option value="{{ $bankDetail->branch->id }}" selected>
                                                            {{ $bankDetail->branch->bank_branch_name }} ({{ $bankDetail->branch->bank_branch_code }})
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">Account Number</label>
                                                <input type="text" class="form-control" name="banks[{{ $i }}][account_number]" value="{{ $bankDetail->account_number }}" placeholder="Enter Account Number">
                                            </div>

                                            <div class="mb-3 col-md-3 d-flex justify-content-end">
                                                <button type="button" class="btn btn-danger remove-bank mt-md-4 mt-2">
                                                    <i class="ph-duotone ph-minus-square"></i>
                                                </button>
                                            </div>

                                            <div class="mb-3 col-md-6 form-group">
                                                <label class="form-label required">Account Name</label>
                                                <input type="text" class="form-control" name="banks[{{ $i }}][account_name]" value="{{ $bankDetail->account_name }}" placeholder="Enter Account Name">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bank-item border rounded p-3 mb-3">
                                        <div class="row align-items-end">
                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">Bank</label>
                                                <select class="form-select bank-select" name="banks[0][bank_id]" data-branch-select="banks_0_bank_branch_id">
                                                    <option value="">Select Bank</option>
                                                    @foreach($banks as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">Branch</label>
                                                <select class="form-select branch-select" id="banks_0_bank_branch_id" name="banks[0][bank_branch_id]">
                                                    <option value="">Select Branch</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-3 form-group">
                                                <label class="form-label required">Account Number</label>
                                                <input type="text" class="form-control" name="banks[0][account_number]" placeholder="Enter Account Number">
                                            </div>

                                            <div class="mb-3 col-md-3 d-flex justify-content-end">
                                                <button type="button" class="btn btn-danger remove-bank mt-md-4 mt-2">
                                                    <i class="ph-duotone ph-minus-square"></i>
                                                </button>
                                            </div>

                                            <div class="mb-3 col-md-6 form-group">
                                                <label class="form-label required">Account Name</label>
                                                <input type="text" class="form-control" name="banks[0][account_name]" placeholder="Enter Account Name">
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-primary" id="submitFormBtn">
                                    <i class="ph-duotone ph-floppy-disk"></i> Save Bank Details
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info mb-0">Select an investor to view and update bank details.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('banksWrapper');
            let bankIndex = wrapper.querySelectorAll('.bank-item').length || 1;
            const investorSelect = document.querySelector('.investor-select');

            // init choices
            const choicesInstances = new Map();
            function initChoices(select) {
                const id = select.id || select.name.replace(/\W+/g, '_') + '_' + Math.random();
                select.id = id;
                const choices = new Choices(select, { searchEnabled: true, itemSelectText: '', shouldSort: false });
                choicesInstances.set(id, choices);
                return choices;
            }

            function destroyChoices(select) {
                if (choicesInstances.has(select.id)) {
                    choicesInstances.get(select.id).destroy();
                    choicesInstances.delete(select.id);
                }
            }

            function loadBranches(bankId, branchSelect) {
                if (!bankId || !branchSelect) {
                    branchSelect.innerHTML = '<option value=\"\">Select Branch</option>';
                    return;
                }
                fetch(`{{ route('investors.branches', ':bankId') }}`.replace(':bankId', bankId))
                    .then(resp => resp.json())
                    .then(data => {
                        const { branches } = data;
                        const current = branchSelect.value;
                        branchSelect.innerHTML = '<option value=\"\">Select Branch</option>';
                        branches.forEach(branch => {
                            const opt = document.createElement('option');
                            opt.value = branch.id;
                            opt.textContent = `${branch.bank_branch_name} (${branch.bank_branch_code})`;
                            branchSelect.appendChild(opt);
                        });
                        if (current) {
                            branchSelect.value = current;
                        }
                        const instance = choicesInstances.get(branchSelect.id);
                        if (instance) {
                            instance.setChoices([...branchSelect.options].map(o => ({ value: o.value, label: o.text, selected: o.selected })), 'value', 'label', true);
                        }
                    })
                    .catch(() => {
                        branchSelect.innerHTML = '<option value=\"\">Select Branch</option>';
                    });
            }

            function bindBankSelect(select) {
                const branchId = select.dataset.branchSelect;
                const branchSelect = document.getElementById(branchId);
                select.addEventListener('change', function () {
                    branchSelect.value = '';
                    loadBranches(this.value, branchSelect);
                });
                loadBranches(select.value, branchSelect);
            }

            // initialize existing selects
            wrapper.querySelectorAll('select.form-select').forEach(function (select) {
                initChoices(select);
            });
            wrapper.querySelectorAll('.bank-select').forEach(bindBankSelect);
            if (investorSelect) {
                initChoices(investorSelect);
            }

            document.getElementById('addBank').addEventListener('click', function () {
                const first = wrapper.querySelector('.bank-item');
                const clone = first.cloneNode(true);

                clone.querySelectorAll('input, select').forEach(function (el) {
                    if (el.tagName === 'SELECT') {
                        destroyChoices(el);
                        el.innerHTML = '<option value=\"\">Select</option>';
                    } else {
                        el.value = '';
                    }
                    const name = el.getAttribute('name');
                    const id = el.getAttribute('id');
                    if (name) el.setAttribute('name', name.replace(/\d+/, bankIndex));
                    if (id) el.setAttribute('id', id.replace(/\d+/, bankIndex));
                });

                wrapper.appendChild(clone);

                clone.querySelectorAll('select.form-select').forEach(function (select) {
                    initChoices(select);
                });
                clone.querySelectorAll('.bank-select').forEach(function (select) {
                    bindBankSelect(select);
                });

                bankIndex++;
            });

            wrapper.addEventListener('click', function (e) {
                if (e.target.closest('.remove-bank')) {
                    const items = wrapper.querySelectorAll('.bank-item');
                    if (items.length > 1) {
                        e.target.closest('.bank-item').remove();
                    }
                }
            });
        });
    </script>
@endsection

