@extends('layouts.backend')

@section('title', 'Role Management')

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush

@section('content')

    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Role Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">RBAC</li>
                        <li class="breadcrumb-item">Roles</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-primary" id="createNewRole">
                        <i class="ti ti-plus me-1"></i> Add Role
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
                            <th width="5%">No</th>
                            <th width="20%">Role Name</th>
                            <th width="60%">Permissions</th>
                            <th width="15%">Action</th>
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
                <h5 class="alert-heading"><i class="ti ti-shield-lock me-2"></i>Role Management - Overview
                </h5>
                <hr>
                <p class="mb-2"><strong>Define who can do what:</strong></p>
                <ul class="mb-3">
                    <li class="mb-2"><strong>Roles:</strong> Groups of permissions (e.g., Administrator, Editor, Viewer).
                    </li>
                    <li class="mb-2"><strong>Permissions:</strong> Specific actions users can perform (e.g., create-post,
                        delete-user).</li>
                    <li class="mb-2"><strong>Assignment:</strong> You can assign multiple permissions to a single role.</li>
                    <li class="mb-2"><strong>Management:</strong> easily <button
                            class="btn btn-icon btn-light-primary btn-sm"><i class="ti ti-edit"></i></button> modify or
                        <button class="btn btn-icon btn-light-danger btn-sm"><i class="ti ti-trash"></i></button> delete
                        roles.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @include('backend.settings.roles._modal')

@endsection

@push('scripts')
    @include('backend.settings.roles._script')
@endpush