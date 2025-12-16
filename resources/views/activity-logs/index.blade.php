@extends('layouts.main')

@section('title', 'Activity Logs')
@section('breadcrumb-item', 'Activity Logs')
@section('breadcrumb-item-active', 'System Activity Logs')

@section('css')
    <!-- [Page specific CSS] start -->
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/buttons.bootstrap5.min.css') }}">
    <style>
        .filter-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .changes-preview {
            font-size: 0.875rem;
        }
        .change-preview-item {
            padding: 4px 0;
            color: #495057;
        }
        .change-preview-item strong {
            color: #212529;
            font-weight: 600;
        }
        .change-detail-item {
            padding: 12px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #0dcaf0;
        }
        .change-detail-item.created {
            border-left-color: #198754;
        }
        .change-detail-item.deleted {
            border-left-color: #dc3545;
        }
        .value-old {
            background: #fff5f5;
            padding: 4px 8px;
            border-radius: 4px;
            text-decoration: line-through;
            color: #dc3545;
            display: inline-block;
            margin-right: 8px;
        }
        .value-new {
            background: #f0fdf4;
            padding: 4px 8px;
            border-radius: 4px;
            color: #198754;
            display: inline-block;
            font-weight: 500;
        }
        .value-single {
            background: #f0fdf4;
            padding: 4px 8px;
            border-radius: 4px;
            color: #198754;
            display: inline-block;
            font-weight: 500;
        }
        .info-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 1rem;
            color: #212529;
            font-weight: 500;
        }
        .activity-timeline {
            position: relative;
            padding-left: 30px;
        }
        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }
        .activity-item {
            position: relative;
            margin-bottom: 20px;
        }
        .activity-item::before {
            content: '';
            position: absolute;
            left: -24px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #0d6efd;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #0d6efd;
        }
        .activity-item.created::before {
            background: #198754;
            box-shadow: 0 0 0 2px #198754;
        }
        .activity-item.updated::before {
            background: #0dcaf0;
            box-shadow: 0 0 0 2px #0dcaf0;
        }
        .activity-item.deleted::before {
            background: #dc3545;
            box-shadow: 0 0 0 2px #dc3545;
        }
        .detail-modal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
        .json-viewer {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    <!-- [Page specific CSS] end -->
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- Filters Card -->
        <div class="col-sm-12">
            <div class="card filter-card">
                <div class="card-header">
                    <h5><i class="ti ti-filter"></i> Filters</h5>
                </div>
                <div class="card-body">
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Subject Type</label>
                            <select name="subject_type" id="subject_type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($subjectTypes as $type)
                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Event</label>
                            <select name="event" id="event" class="form-select">
                                <option value="">All Events</option>
                                <option value="created">Created</option>
                                <option value="updated">Updated</option>
                                <option value="deleted">Deleted</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">User</label>
                            <select name="causer_id" id="causer_id" class="form-select">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date From</label>
                            <input type="date" name="date_from" id="date_from" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date To</label>
                            <input type="date" name="date_to" id="date_to" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" id="applyFilters">
                                <i class="ti ti-search"></i> Apply Filters
                            </button>
                            <button type="button" class="btn btn-secondary" id="resetFilters">
                                <i class="ti ti-refresh"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Activity Logs Table -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-history"></i> Activity Logs</h5>
                </div>
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="activity-logs-table" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="12%">Date & Time</th>
                                    <th width="10%">User</th>
                                    <th width="8%">Event</th>
                                    <th width="10%">Subject Type</th>
                                    <th width="8%">Subject ID</th>
                                    <th width="15%">Description</th>
                                    <th width="22%">Changes</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Activity Detail Modal -->
    <div class="modal fade" id="activityDetailModal" tabindex="-1" aria-labelledby="activityDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityDetailModalLabel">
                        <i class="ti ti-info-circle"></i> Activity Log Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body detail-modal">
                    <div id="activityDetails">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            let table = $('#activity-logs-table').DataTable({
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('activity-logs.index') }}",
                    data: function(d) {
                        d.subject_type = $('#subject_type').val();
                        d.event = $('#event').val();
                        d.causer_id = $('#causer_id').val();
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                    { data: 'created_at_formatted', name: 'created_at', width: '12%' },
                    { data: 'causer_name', name: 'causer.name', width: '10%' },
                    { data: 'event_badge', name: 'event', width: '8%' },
                    { data: 'subject_type_name', name: 'subject_type', width: '10%' },
                    { data: 'subject_id', name: 'subject_id', width: '8%' },
                    { data: 'description', name: 'description', width: '15%' },
                    { data: 'changes', name: 'changes', orderable: false, searchable: false, width: '22%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '10%' },
                ],
                order: [[1, 'desc']],
                pageLength: 25,
                scrollX: true,
                responsive: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
                }
            });

            // Use ResizeObserver to ensure table columns adjust when container size changes
            var tableContainer = document.querySelector('#activity-logs-table_wrapper');
            if (tableContainer) {
                var resizeObserver = new ResizeObserver(function() {
                    table.columns.adjust();
                });
                resizeObserver.observe(tableContainer);
            }

            // Apply filters
            $('#applyFilters').on('click', function() {
                table.draw();
            });

            // Reset filters
            $('#resetFilters').on('click', function() {
                $('#filterForm')[0].reset();
                table.draw();
            });

            // View details
            $(document).on('click', '.view-details', function() {
                const activityId = $(this).data('id');
                const modal = $('#activityDetailModal');
                const detailsContainer = $('#activityDetails');

                detailsContainer.html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

                $.ajax({
                    url: '/activity-logs/' + activityId,
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            
                            // Determine badge color based on event
                            let eventBadgeClass = 'bg-info';
                            if (data.event === 'created') eventBadgeClass = 'bg-success';
                            if (data.event === 'deleted') eventBadgeClass = 'bg-danger';
                            
                            let html = `
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-label">Description</div>
                                            <div class="info-value">${data.description}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-label">Event Type</div>
                                            <div class="info-value">
                                                <span class="badge ${eventBadgeClass}">${data.event.charAt(0).toUpperCase() + data.event.slice(1)}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-label">Subject Type</div>
                                            <div class="info-value">${data.subject_type}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-label">Subject ID</div>
                                            <div class="info-value">#${data.subject_id}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-label">Performed By</div>
                                            <div class="info-value">
                                                <i class="ti ti-user"></i> ${data.causer}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-card">
                                            <div class="info-label">Date & Time</div>
                                            <div class="info-value">
                                                <i class="ti ti-clock"></i> ${data.created_at}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            // Display formatted changes
                            if (data.formatted_changes && data.formatted_changes.length > 0) {
                                html += `
                                    <div class="mb-3">
                                        <h6 class="mb-3"><i class="ti ti-edit"></i> Changes Made</h6>
                                `;
                                
                                data.formatted_changes.forEach(function(change) {
                                    if (change.old !== undefined && change.new !== undefined) {
                                        // Updated field
                                        html += `
                                            <div class="change-detail-item updated">
                                                <div class="mb-2"><strong>${change.field}</strong></div>
                                                <div>
                                                    <span class="value-old">${change.old}</span>
                                                    <i class="ti ti-arrow-right text-muted"></i>
                                                    <span class="value-new">${change.new}</span>
                                                </div>
                                            </div>
                                        `;
                                    } else {
                                        // Created field
                                        html += `
                                            <div class="change-detail-item created">
                                                <div class="mb-2"><strong>${change.field}</strong></div>
                                                <div>
                                                    <span class="value-single">${change.value}</span>
                                                </div>
                                            </div>
                                        `;
                                    }
                                });
                                
                                html += `</div>`;
                            } else {
                                html += `
                                    <div class="alert alert-info">
                                        <i class="ti ti-info-circle"></i> No field changes recorded for this activity.
                                    </div>
                                `;
                            }

                            detailsContainer.html(html);
                        }
                    },
                    error: function(xhr) {
                        detailsContainer.html('<div class="alert alert-danger"><i class="ti ti-alert-circle"></i> Failed to load activity details. Please try again.</div>');
                    }
                });
            });
        });
    </script>
@endsection
