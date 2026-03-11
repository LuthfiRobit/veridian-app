@extends('layouts.backend')

@section('title', 'Activity Logs')

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <style>
        .json-viewer { 
            background-color: #f8f9fa; 
            padding: 15px; 
            border-radius: 5px; 
            font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace; 
            overflow-x: auto; 
            white-space: pre-wrap; 
            font-size: 14px;
            border: 1px solid #e9ecef;
        }
    </style>
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Activity Log Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Global Settings</li>
                        <li class="breadcrumb-item">Activity Logs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Information Section -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" role="alert">
                <h5 class="alert-heading"><i class="ti ti-activity me-2"></i>Activity Logs - System Audit Trail
                </h5>
                <hr>
                <p class="mb-2"><strong>Why use this feature?</strong></p>
                <ul class="mb-0">
                    <li class="mb-2"><strong>Audit Trail:</strong> Keep track of all important actions performed on the system.</li>
                    <li class="mb-2"><strong>Accountability:</strong> Track who performed what action, when, and on which module.</li>
                    <li class="mb-0"><strong>Troubleshooting:</strong> View the specific properties changed during record updates to help diagnose issues.</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Log Name</th>
                            <th>Description</th>
                            <th>Causer</th>
                            <th>Date & Time</th>
                            <th>Properties</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('backend.settings.activity_logs._modal')
@endsection

@push('scripts')
    @include('backend.settings.activity_logs._script')
@endpush
