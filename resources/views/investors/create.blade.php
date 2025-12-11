@extends('layouts.main')

@section('title', 'Investors')
@section('breadcrumb-item', 'Investors')

@section('breadcrumb-item-active', 'Investors')

@section('css')
    <!-- [Page specific CSS] start -->
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
    <!-- Choices.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- [Page specific CSS] end -->
    <style>
        .required:after {
            content: " *";
            color: red;
            font-weight: bold;
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
                            <h4>Investor Registration</h4>
                            <small class="text-muted">
                                <span class="text-danger">*</span> Required fields. Missing information may delay
                                registration.
                            </small>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <button type="button" id="submitFormBtn" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-light-secondary btnClose">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="submitForm" enctype="multipart/form-data" action="{{ route('investors.store') }}" method="POST">
            @csrf

            <!-- Investor Information -->
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Investor Information</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-2 form-group">
                                <label class="form-label required">Title</label>
                                <select name="title" id="title" class="form-select">
                                    <option value="">Select Title</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Prof">Prof</option>
                                    <option value="Rev">Rev</option>
                                    <option value="Hon">Hon</option>
                                    <option value="Sir">Sir</option>
                                    <option value="Madam">Madam</option>
                                    <option value="Mx">Mx</option>
                                    <option value="Eng">Eng</option>
                                    <option value="Capt">Capt</option>
                                    <option value="Lt">Lt</option>
                                    <option value="Col">Col</option>
                                    <option value="Gen">Gen</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-5 form-group">
                                <label class="form-label required">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Enter First Name">
                            </div>

                            <div class="mb-3 col-md-5 form-group">
                                <label class="form-label required">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Enter Last Name">
                            </div>

                            <div class="mb-3 col-md-6 form-group">
                                <label class="form-label required">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    placeholder="Enter Full Name">
                            </div>

                            <div class="mb-3 col-md-6 form-group">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic"
                                    placeholder="Enter NIC">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no"
                                    placeholder="Enter Contact No">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Address Line 1</label>
                                <input type="text" class="form-control" id="address_line_1" name="address_line_1"
                                    placeholder="Enter Address Line 1">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Address Line 2</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2"
                                    placeholder="Enter Address Line 2">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Address Line 3</label>
                                <input type="text" class="form-control" id="address_line_3" name="address_line_3"
                                    placeholder="Enter Address Line 3">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter Password">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Beneficiary Information -->
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Beneficiary Information</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-6 form-group">
                                <label class="form-label required">Full Name</label>
                                <input type="text" class="form-control" id="beneficiary_full_name"
                                    name="beneficiary_full_name" placeholder="Enter Full Name">
                            </div>

                            <div class="mb-3 col-md-3 form-group">
                                <label class="form-label required">NIC</label>
                                <input type="text" class="form-control" id="beneficiary_nic" name="beneficiary_nic"
                                    placeholder="Enter NIC">
                            </div>

                            <div class="mb-3 col-md-3 form-group">
                                <label class="form-label required">Contact No</label>
                                <input type="text" class="form-control" id="beneficiary_contact_no"
                                    name="beneficiary_contact_no" placeholder="Enter Contact No">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Relation</label>
                                <select class="form-select" id="beneficiary_relation" name="beneficiary_relation">
                                    <option value="">Select Relation</option>
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Husband">Husband</option>
                                    <option value="Wife">Wife</option>
                                    <option value="Guardian">Guardian</option>
                                    <option value="Friend">Friend</option>
                                    {{-- <option value="Other">Other</option> --}}
                                </select>
                            </div>

                            {{-- <!-- Hidden custom input -->
                            <div class="mb-3 col-md-4 form-group d-none" id="customRelationWrapper">
                                <label class="form-label required">Specify Relation</label>
                                <input type="text" class="form-control" id="custom_relation" name="custom_relation"
                                    placeholder="Enter custom relation">
                            </div> --}}


                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration & Tax -->
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Registration & Tax</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Registration Date</label>
                                <input type="date" class="form-control" id="registration_date"
                                    name="registration_date">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Tax Status</label>
                                <input type="text" class="form-control" id="tax_status" name="tax_status"
                                    placeholder="Enter Tax Status">
                            </div>

                            <div class="mb-3 col-md-4 form-group">
                                <label class="form-label required">Tax No</label>
                                <input type="text" class="form-control" id="tax_no" name="tax_no"
                                    placeholder="Enter Tax No">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h5>Documents</h5>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <button type="button" class="btn btn-outline-primary text-end" id="addDocument">+ Add
                                    Document</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div id="documentsWrapper">

                            <div class="document-item border rounded p-3 mb-3">
                                <div class="row align-items-end">

                                    <div class="mb-3 col-md-5 form-group">
                                        <label class="form-label required">Description</label>
                                        <textarea class="form-control" id="documents_0_description" name="documents[0][description]"
                                            placeholder="Enter description"></textarea>
                                    </div>

                                    <div class="mb-3 col-md-5 form-group">
                                        <label class="form-label required">Upload Document</label>
                                        <input type="file" class="form-control" id="documents_0_document_path"
                                            name="documents[0][document_path]">
                                    </div>

                                    <div class="mb-3 col-md-2 d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger remove-document mt-md-4 mt-2">
                                            <i class="ph-duotone ph-minus-square"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Bank Details -->
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <h5>Bank Details</h5>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <button type="button" class="btn btn-outline-primary" id="addBank">+ Add Bank</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div id="banksWrapper">

                            <div class="bank-item border rounded p-3 mb-3">
                                <div class="row align-items-end">

                                    <div class="mb-3 col-md-3 form-group">
                                        <label class="form-label required">Bank</label>
                                        <select class="form-select bank-select" id="banks_0_bank_id" name="banks[0][bank_id]">
                                            <option value="">Select Bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-3 form-group">
                                        <label class="form-label required">Branch</label>
                                        <select class="form-select branch-select" id="banks_0_bank_branch_id"
                                            name="banks[0][bank_branch_id]">
                                            <option value="">Select Branch</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-3 form-group">
                                        <label class="form-label required">Account Number</label>
                                        <input type="text" class="form-control" id="banks_0_account_number"
                                            name="banks[0][account_number]" placeholder="Enter Account Number">
                                    </div>

                                    <div class="mb-3 col-md-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger remove-bank mt-md-4 mt-2">
                                            <i class="ph-duotone ph-minus-square"></i>
                                        </button>
                                    </div>

                                    <div class="mb-3 col-md-6 form-group">
                                        <label class="form-label required">Account Name</label>
                                        <input type="text" class="form-control" id="banks_0_account_name"
                                            name="banks[0][account_name]" placeholder="Enter Account Name">
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </form>


    </div>
@endsection


@section('scripts')
    <!-- Choices.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>

    <script>
        $(document).ready(function() {
            // Store Choices.js instances
            const choicesInstances = new Map();

            // Function to destroy Choices.js instance if exists
            function destroyChoices(selectElement) {
                const selectId = selectElement.id;
                if (choicesInstances.has(selectId)) {
                    try {
                        choicesInstances.get(selectId).destroy();
                    } catch (e) {
                        console.warn('Error destroying Choices instance:', e);
                    }
                    choicesInstances.delete(selectId);
                }
                
                // Remove Choices.js wrapper if exists
                const $select = $(selectElement);
                if ($select.parent().hasClass('choices')) {
                    $select.unwrap();
                    $select.siblings('.choices__inner, .choices__list').remove();
                }
                $select.removeClass('choices__input').show();
            }

            // Function to initialize Choices.js for a select element
            function initChoices(selectElement) {
                if (!selectElement || !selectElement.id) {
                    console.warn('Cannot initialize Choices: element or ID missing');
                    return null;
                }
                
                // Destroy existing instance if any
                destroyChoices(selectElement);
                
                // Skip if already wrapped by Choices.js
                if ($(selectElement).closest('.choices').length > 0) {
                    return null;
                }
                
                try {
                    const choices = new Choices(selectElement, {
                        searchEnabled: true,
                        itemSelectText: '',
                        removeItemButton: false,
                        shouldSort: false
                    });
                    choicesInstances.set(selectElement.id, choices);
                    return choices;
                } catch (e) {
                    console.error('Error initializing Choices:', e);
                    return null;
                }
            }

            // Function to load branches for a bank
            function loadBranches(bankId, branchSelectId) {
                if (!bankId) {
                    // Clear branches if no bank selected
                    const branchSelect = document.getElementById(branchSelectId);
                    if (branchSelect) {
                        const choices = choicesInstances.get(branchSelectId);
                        if (choices) {
                            choices.clearChoices();
                            choices.setChoices([{ value: '', label: 'Select Branch', selected: true, disabled: true }], 'value', 'label', false);
                        } else {
                            branchSelect.innerHTML = '<option value="">Select Branch</option>';
                        }
                    }
                    return;
                }

                $.ajax({
                    url: "{{ route('investors.branches', ':bankId') }}".replace(':bankId', bankId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success' && response.branches) {
                            const branchSelect = document.getElementById(branchSelectId);
                            if (branchSelect) {
                                const choices = choicesInstances.get(branchSelectId);
                                
                                // Prepare branch options
                                const branchOptions = response.branches.map(function(branch) {
                                    return {
                                        value: branch.id,
                                        label: branch.bank_branch_name + ' (' + branch.bank_branch_code + ')'
                                    };
                                });

                                if (choices) {
                                    // Update Choices.js instance
                                    choices.clearChoices();
                                    choices.setChoices(
                                        [{ value: '', label: 'Select Branch', selected: true, disabled: true }, ...branchOptions],
                                        'value',
                                        'label',
                                        false
                                    );
                                } else {
                                    // Fallback if Choices.js not initialized
                                    branchSelect.innerHTML = '<option value="">Select Branch</option>';
                                    branchOptions.forEach(function(option) {
                                        const optionElement = document.createElement('option');
                                        optionElement.value = option.value;
                                        optionElement.textContent = option.label;
                                        branchSelect.appendChild(optionElement);
                                    });
                                }
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading branches:', error);
                        const branchSelect = document.getElementById(branchSelectId);
                        if (branchSelect) {
                            const choices = choicesInstances.get(branchSelectId);
                            if (choices) {
                                choices.clearChoices();
                                choices.setChoices([{ value: '', label: 'Error loading branches', selected: true, disabled: true }], 'value', 'label', false);
                            }
                        }
                    }
                });
            }

            // Initialize Choices.js for all select elements
            const selectElements = document.querySelectorAll('select.form-select');
            selectElements.forEach(function(select) {
                const choices = initChoices(select);
                
                // Add event listener for bank selects using Choices.js event
                if ($(select).hasClass('bank-select') && choices) {
                    select.addEventListener('choice', function(event) {
                        const bankId = event.detail.choice.value;
                        const bankItem = $(select).closest('.bank-item');
                        const branchSelect = bankItem.find('.branch-select');
                        const branchSelectId = branchSelect.attr('id');
                        
                        // Clear branch selection
                        const branchChoices = choicesInstances.get(branchSelectId);
                        if (branchChoices) {
                            branchChoices.setValue(['']);
                        } else {
                            branchSelect.val('');
                        }
                        
                        // Load branches for selected bank
                        loadBranches(bankId, branchSelectId);
                    });
                }
            });

            // Handle bank selection change (fallback for jQuery change event)
            // This works with both regular selects and Choices.js
            $(document).on('change', '.bank-select', function() {
                const bankId = $(this).val();
                if (!bankId) return;
                
                const bankItem = $(this).closest('.bank-item');
                const branchSelect = bankItem.find('.branch-select');
                const branchSelectId = branchSelect.attr('id');
                
                // Clear branch selection
                const choices = choicesInstances.get(branchSelectId);
                if (choices) {
                    choices.setValue(['']);
                } else {
                    branchSelect.val('');
                }
                
                // Load branches for selected bank
                loadBranches(bankId, branchSelectId);
            });

            // Initialize Flatpickr for date inputs
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(function(input) {
                // Skip if already initialized
                if (input._flatpickr) {
                    return;
                }
                flatpickr(input, {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    clickOpens: true,
                    altInput: false,
                    maxDate: "today" // Optional: prevent future dates
                });
            });

            $('#beneficiary_relation').on('change', function() {
                if ($(this).val() === 'Other') {
                    $('#customRelationWrapper').removeClass('d-none');
                } else {
                    $('#customRelationWrapper').addClass('d-none');
                    $('#custom_relation').val('');
                }
            });

            let docIndex = 1;
            let bankIndex = 1;

            // Add Document
            $("#addDocument").click(function() {
                let newDoc = $(".document-item:first").clone();
                newDoc.find("input, textarea").each(function() {
                    $(this).val("");
                    let name = $(this).attr("name");
                    $(this).attr("name", name.replace(/\d+/, docIndex));
                });
                $("#documentsWrapper").append(newDoc);
                docIndex++;
            });

            // Remove Document
            $("#documentsWrapper").on("click", ".remove-document", function() {
                if ($(".document-item").length > 1) {
                    $(this).closest(".document-item").remove();
                }
            });

            // Add Bank
            $("#addBank").click(function() {
                let originalBank = $(".bank-item:first");
                
                // Clone without data and events to avoid Choices.js issues
                let newBank = originalBank.clone(false, false);
                
                // Clean up any Choices.js wrappers from cloned elements
                newBank.find("select").each(function() {
                    const selectElement = this;
                    destroyChoices(selectElement);
                });
                
                // Update IDs and names for the new bank item
                newBank.find("input, select").each(function() {
                    $(this).val("");
                    let name = $(this).attr("name");
                    let id = $(this).attr("id");
                    if (name) {
                        $(this).attr("name", name.replace(/\d+/, bankIndex));
                    }
                    if (id) {
                        $(this).attr("id", id.replace(/\d+/, bankIndex));
                    }
                });
                
                // Populate bank options for the new bank select
                const newBankSelect = newBank.find('.bank-select');
                if (newBankSelect.length) {
                    const bankOptions = @json($banks);
                    newBankSelect.html('<option value="">Select Bank</option>');
                    bankOptions.forEach(function(bank) {
                        newBankSelect.append($('<option></option>').attr('value', bank.id).text(bank.bank_name));
                    });
                }
                
                // Clear branch select
                newBank.find('.branch-select').html('<option value="">Select Branch</option>');
                
                // Append to DOM first
                $("#banksWrapper").append(newBank);
                
                // Now initialize Choices.js for newly added select elements
                newBank.find("select.form-select").each(function() {
                    const selectElement = this;
                    const choices = initChoices(selectElement);
                    
                    // Add event listener for bank selects
                    if ($(selectElement).hasClass('bank-select') && choices) {
                        // Use Choices.js event
                        selectElement.addEventListener('choice', function(event) {
                            // Get value from the select element itself (more reliable)
                            const bankId = $(selectElement).val();
                            if (!bankId) return;
                            
                            const bankItem = $(selectElement).closest('.bank-item');
                            const branchSelect = bankItem.find('.branch-select');
                            const branchSelectId = branchSelect.attr('id');
                            
                            // Clear branch selection
                            const branchChoices = choicesInstances.get(branchSelectId);
                            if (branchChoices) {
                                branchChoices.setValue(['']);
                            } else {
                                branchSelect.val('');
                            }
                            
                            // Load branches for selected bank
                            loadBranches(bankId, branchSelectId);
                        });
                    }
                });
                
                // The jQuery change event handler above (line 530) will handle this via event delegation
                // No need to bind separately as it's already bound to all .bank-select elements
                
                bankIndex++;
            });

            // Remove Bank
            $("#banksWrapper").on("click", ".remove-bank", function() {
                if ($(".bank-item").length > 1) {
                    const bankItem = $(this).closest(".bank-item");
                    
                    // Clean up Choices.js instances before removing
                    bankItem.find("select").each(function() {
                        destroyChoices(this);
                    });
                    
                    bankItem.remove();
                }
            });
        });
    </script>
@endsection
