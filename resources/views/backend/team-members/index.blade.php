@extends('layouts.backend')

@section('title', 'Our Team')

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
                        <h5 class="m-b-10">Our Team Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item">Our Team</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary" id="btn-add-member">
                        <i class="ti ti-plus me-1"></i> Add New Member
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-info-circle me-2 fs-4"></i>
                <div>
                    <strong>Translatable Content:</strong> Member position, department, and bio are available in multiple
                    languages using the tabs in the form.
                </div>
            </div>

            <div class="table-responsive">
                <table id="team-members-table" class="table table-hover mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Member</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Last Updated</th>
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
                <h5 class="alert-heading"><i class="ti ti-info-circle me-2"></i>Our Team Management - Features Overview</h5>
                <hr>
                <p class="mb-2"><strong>What you can do on this page:</strong></p>
                <ul class="mb-3">
                    <li class="mb-2"><strong>Manage Team Members:</strong> Add, edit, and remove team members displayed on
                        your website.</li>
                    <li class="mb-2"><strong>Multi-language Support:</strong> Define position, department, and biography in
                        all active languages.</li>
                    <li class="mb-2"><strong>Social Links:</strong> Optionally add LinkedIn, Twitter, and GitHub profile
                        links.</li>
                    <li class="mb-2"><strong>Status Control:</strong> Temporarily hide members from public view by setting
                        them to Inactive.</li>
                </ul>
                <p class="mb-0"><i class="ti ti-bulb me-1"></i><strong>Tip:</strong> Use Sort Order to control which member
                    appears first on the website.</p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @include('backend.team-members._script')
@endpush