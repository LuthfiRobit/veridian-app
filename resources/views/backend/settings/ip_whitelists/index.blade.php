@extends('layouts.backend')

@section('title', 'IP Whitelists')

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header-title">
                        <h5 class="m-b-10">IP Whitelist Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Global Settings</li>
                        <li class="breadcrumb-item">IP Whitelists</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-primary" id="createNewIp">
                        <i class="ti ti-plus me-1"></i> Add IP
                    </button>
                </div>
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
                            <th>IP Address</th>
                            <th>Label</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Feature Information Section -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" role="alert">
                <h5 class="alert-heading"><i class="ti ti-lock me-2"></i>IP Whitelist - Security Overview
                </h5>
                <hr>
                <p class="mb-2"><strong>Why use this feature?</strong></p>
                <ul class="mb-3">
                    <li class="mb-2"><strong>Access Control:</strong> Restrict admin panel access to specific IP addresses
                        (e.g., Office, Home).</li>
                    <li class="mb-2"><strong>Security Layer:</strong> Prevent unauthorized login attempts even if
                        credentials are compromised.</li>
                    <li class="mb-2"><strong>Real-time Protection:</strong> Changes to the whitelist take effect immediately
                        via the middleware cache clearing.</li>
                    <li class="mb-2"><strong>Management:</strong> easily <button
                            class="btn btn-icon btn-light-primary btn-sm"><i class="ti ti-edit"></i></button> update or
                        <button class="btn btn-icon btn-light-danger btn-sm"><i class="ti ti-trash"></i></button> revoke
                        access.
                    </li>
                </ul>
                <p class="mb-0"><i class="ti ti-alert-triangle me-1"></i><strong>Warning:</strong> Ensure your current IP is
                    whitelisted before enabling strict mode to avoid locking yourself out!</p>
            </div>
        </div>
    </div>

    @include('backend.settings.ip_whitelists._modal')

@endsection

@push('scripts')
    @include('backend.settings.ip_whitelists._script')
@endpush