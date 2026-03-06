@extends('layouts.backend')

@section('title', 'Languages')

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
                        <h5 class="m-b-10">Language Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Global Settings</li>
                        <li class="breadcrumb-item">Languages</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-primary" id="createNewLanguage">
                        <i class="ti ti-plus me-1"></i> Add Language
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
                            <th>Code</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Default</th>
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
                <h5 class="alert-heading"><i class="ti ti-info-circle me-2"></i>Language Settings - Features Overview
                </h5>
                <hr>
                <p class="mb-2"><strong>What you can do on this page:</strong></p>
                <ul class="mb-3">
                    <li class="mb-2"><strong>Manage Languages:</strong> Add or configure multiple languages for your
                        bilingual website content.</li>
                    <li class="mb-2"><strong>Set Default:</strong> Choose which language serves as the primary default for
                        the frontend.</li>
                    <li class="mb-2"><strong>Visual Icons:</strong> Assign flag icons to languages for better user
                        experience in the language switcher.</li>
                    <li class="mb-2"><strong>Status Control:</strong> Enable or disable languages instantly without deleting
                        records.</li>
                    <li class="mb-2"><strong>Quick Actions:</strong> Use <button
                            class="btn btn-icon btn-light-primary btn-sm"><i class="ti ti-edit"></i></button> to update and
                        <button class="btn btn-icon btn-light-danger btn-sm"><i class="ti ti-trash"></i></button> to remove
                        entries.
                    </li>
                </ul>
                <p class="mb-0"><i class="ti ti-bulb me-1"></i><strong>Tip:</strong> Always ensure you have at least one
                    active and default language for your site to function correctly!</p>
            </div>
        </div>
    </div>

    @include('backend.settings.languages._modal')

@endsection

@push('scripts')
    @include('backend.settings.languages._script')
@endpush