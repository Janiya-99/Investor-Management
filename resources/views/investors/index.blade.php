@extends('layouts.main')

@section('title', 'Investors')
@section('breadcrumb-item', 'Investors')

@section('breadcrumb-item-active', 'Investors')

@section('css')
    <!-- [Page specific CSS] start -->
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
    <!-- [Page specific CSS] end -->

@endsection

@section('content')
    <div class="row">

        <!-- Sticky Header -->
        <div id="sticky-action" class="sticky-action mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4>Investor Information</h4>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <button type="reset" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-light-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form>

            <!-- Investor Information -->
            <div class="col-12 mb-3">
                <div class="card">

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-2">
                                <label class="form-label">Title</label>
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

                            <div class="mb-3 col-md-5">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Enter First Name">
                            </div>

                            <div class="mb-3 col-md-5">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Enter Last Name">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    placeholder="Enter Full Name">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic"
                                    placeholder="Enter NIC">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no"
                                    placeholder="Enter Contact No">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="address_line_1" name="address_line_1"
                                    placeholder="Enter Address Line 1">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2"
                                    placeholder="Enter Address Line 2">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Address Line 3</label>
                                <input type="text" class="form-control" id="address_line_3" name="address_line_3"
                                    placeholder="Enter Address Line 3">
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

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="beneficiary_full_name"
                                    name="beneficiary_full_name" placeholder="Enter Full Name">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">NIC</label>
                                <input type="text" class="form-control" id="beneficiary_nic" name="beneficiary_nic"
                                    placeholder="Enter NIC">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="beneficiary_contact_no"
                                    name="beneficiary_contact_no" placeholder="Enter Contact No">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Relation</label>
                                <input type="text" class="form-control" id="beneficiary_relation"
                                    name="beneficiary_relation" placeholder="Enter Relation">
                            </div>

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

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Registration Date</label>
                                <input type="date" class="form-control" id="registration_date"
                                    name="registration_date">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Tax Status</label>
                                <input type="text" class="form-control" id="tax_status" name="tax_status"
                                    placeholder="Enter Tax Status">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Tax No</label>
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
                                <button type="button" class="btn btn-outline-primary text-end" id="addDocument">
                                    + Add Document
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="documentsWrapper">
                            <div class="document-item border rounded p-3 mb-3">
                                <div class="row align-items-end">

                                    <!-- Description -->
                                    <div class="mb-3 col-md-5">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" id="documents_0_description" name="documents[0][description]"
                                            placeholder="Enter description"></textarea>
                                    </div>

                                    <!-- Upload Document -->
                                    <div class="mb-3 col-md-5">
                                        <label class="form-label">Upload Document</label>
                                        <input type="file" class="form-control" id="documents_0_document_path"
                                            name="documents[0][document_path]">
                                    </div>

                                    <!-- Remove Button -->
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
                                <button type="button" class="btn btn-outline-primary" id="addBank">
                                    + Add Bank
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="banksWrapper">

                            <div class="bank-item border rounded p-3 mb-3">
                                <div class="row align-items-end">

                                    <!-- Bank -->
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Bank</label>
                                        <select class="form-select" id="banks_0_bank_id" name="banks[0][bank_id]">
                                            <option>Select Bank</option>
                                        </select>
                                    </div>

                                    <!-- Branch -->
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Branch</label>
                                        <select class="form-select" id="banks_0_bank_branch_id"
                                            name="banks[0][bank_branch_id]">
                                            <option>Select Branch</option>
                                        </select>
                                    </div>

                                    <!-- Account Number -->
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="banks_0_account_number"
                                            name="banks[0][account_number]" placeholder="Enter Account Number">
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="mb-3 col-md-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger remove-bank mt-md-4 mt-2">
                                             <i class="ph-duotone ph-minus-square"></i>
                                        </button>
                                    </div>

                                    <!-- Account Name (full row) -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Account Name</label>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Include SweetAlert from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" aria-hidden="true"></script>

    <script>
        $(document).ready(function() {
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
                let newBank = $(".bank-item:first").clone();
                newBank.find("input, select").each(function() {
                    $(this).val("");
                    let name = $(this).attr("name");
                    $(this).attr("name", name.replace(/\d+/, bankIndex));
                });
                $("#banksWrapper").append(newBank);
                bankIndex++;
            });

            // Remove Bank
            $("#banksWrapper").on("click", ".remove-bank", function() {
                if ($(".bank-item").length > 1) {
                    $(this).closest(".bank-item").remove();
                }
            });
        });
    </script>
@endsection
