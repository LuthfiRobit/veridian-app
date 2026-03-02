@extends('layouts.backend')

@section('title', 'User Management')

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
                        <h5 class="m-b-10">User Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">RBAC</li>
                        <li class="breadcrumb-item">Users</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-primary" id="createNewUser">
                        <i class="ti ti-plus me-1"></i> Add User
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
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
                <h5 class="alert-heading"><i class="ti ti-users me-2"></i>User Management - Overview
                </h5>
                <hr>
                <p class="mb-2"><strong>Manage system access and profiles:</strong></p>
                <ul class="mb-3">
                    <li class="mb-2"><strong>Create Users:</strong> Add new administrators, editors, or viewers to the
                        system.</li>
                    <li class="mb-2"><strong>Role Assignment:</strong> Assign one or more roles to control what users can
                        see and do.</li>
                    <li class="mb-2"><strong>Status Control:</strong> Deactivate users instantly without deleting their
                        history.</li>
                    <li class="mb-2"><strong>Actions:</strong> Use <button class="btn btn-icon btn-light-primary btn-sm"><i
                                class="ti ti-edit"></i></button> to edit profile/roles or <button
                            class="btn btn-icon btn-light-danger btn-sm"><i class="ti ti-trash"></i></button> to remove
                        users.</li>
                </ul>
                <p class="mb-0"><i class="ti ti-shield me-1"></i><strong>Security:</strong> All password changes are
                    automatically hashed. Use complex passwords for better security.</p>
            </div>
        </div>
    </div>

    @include('backend.settings.users._modal')

@endsection

@push('scripts')
    @include('backend.settings.users._script')
@endpush