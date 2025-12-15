@extends('layouts.main')

@section('title', 'Investor Documents')
@section('breadcrumb-item', 'Investors')
@section('breadcrumb-item-active', 'Documents')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="eyebrow text-muted small text-uppercase mb-1">Documents</div>
                        <h4 class="mb-0">Select investor & manage documents</h4>
                        <small class="text-muted">Accepted formats: pdf, jpg, jpeg, png. Max 2MB each.</small>
                    </div>
                    <a href="{{ route('investors.index') }}" class="btn btn-light">
                        <i class="ph-duotone ph-arrow-left"></i> Back to list
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-3 mb-4" method="GET" action="{{ route('investors.documents.edit') }}">
                        <div class="col-md-6 form-group">
                            <label class="form-label required" data-bs-toggle="tooltip" title="Required">Select
                                Investor</label>
                            <select name="investor_id" class="form-select investor-select" onchange="this.form.submit()"
                                required>
                                <option value="">Choose investor</option>
                                @foreach ($investors as $item)
                                    <option value="{{ $item->id }}" @selected(optional($investor)->id == $item->id)>
                                        {{ $item->full_name }} ({{ $item->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($investor)
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="text-muted">Currently editing: <strong>{{ $investor->full_name }}</strong></div>
                            </div>
                        @endif
                    </form>

                    @if ($investor)
                        @if ($investor->documents->count())
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Existing Documents</h6>
                                <div class="row g-3">
                                    @foreach ($investor->documents as $doc)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="border rounded p-3 h-100">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <div class="avatar avatar-sm bg-light-primary text-primary">
                                                        <i class="ph-duotone ph-file-text"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $doc->description ?? 'No description' }}
                                                        </div>
                                                        <small class="text-muted">{{ $doc->document_path }}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        Uploaded
                                                        {{ optional($doc->uploaded_at)->format('Y-m-d') ?? $doc->created_at->format('Y-m-d') }}
                                                    </small>

                                                    <a class="btn btn-sm btn-outline-primary"
                                                        href="{{ route('documents.returnDocument', $doc->id) }}" target="_blank">
                                                        <i class="ph-duotone ph-download-simple"></i> View
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('investors.documents.update') }}" method="POST"
                            enctype="multipart/form-data" id="submitForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="investor_id" value="{{ $investor->id }}">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Add New Documents</h6>
                                <button type="button" class="btn btn-outline-primary" id="addDocument">
                                    <i class="ph-duotone ph-plus-square"></i> Add Document
                                </button>
                            </div>

                            <div id="documentsWrapper">
                                <div class="document-item border rounded p-3 mb-3">
                                    <div class="row align-items-end">
                                        <div class="mb-3 col-md-6 form-group">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="documents[0][description]" placeholder="Enter description"></textarea>
                                        </div>
                                        <div class="mb-3 col-md-5 form-group">
                                            <label class="form-label">Upload Document</label>
                                            <input type="file" class="form-control" name="documents[0][document_path]"
                                                accept=".jpg,.jpeg,.png,.pdf">
                                        </div>
                                        <div class="mb-3 col-md-1 d-flex justify-content-end">
                                            <button type="button" class="btn btn-danger remove-document mt-md-4 mt-2">
                                                <i class="ph-duotone ph-minus-square"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-primary" id="submitFormBtn">
                                    <i class="ph-duotone ph-cloud-arrow-up"></i> Save Documents
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info mb-0">Select an investor to view and upload documents.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let docIndex = 1;
            const wrapper = document.getElementById('documentsWrapper');
            const investorSelect = document.querySelector('.investor-select');

            if (investorSelect) {
                new Choices(investorSelect, {
                    searchEnabled: true,
                    itemSelectText: '',
                    shouldSort: false
                });
            }

            document.getElementById('addDocument').addEventListener('click', function() {
                const first = wrapper.querySelector('.document-item');
                const clone = first.cloneNode(true);

                clone.querySelectorAll('input, textarea').forEach(function(el) {
                    el.value = '';
                    const name = el.getAttribute('name');
                    if (name) {
                        el.setAttribute('name', name.replace(/\d+/, docIndex));
                    }
                });

                wrapper.appendChild(clone);
                docIndex++;
            });

            wrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-document')) {
                    const items = wrapper.querySelectorAll('.document-item');
                    if (items.length > 1) {
                        e.target.closest('.document-item').remove();
                    }
                }
            });
        });
    </script>
@endsection
