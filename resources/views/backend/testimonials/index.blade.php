@extends('layouts.backend')

@section('title', 'Testimonials')

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
                        <h5 class="m-b-10">Testimonial Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item">Testimonials</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary" id="btn-add-testimonial">
                        <i class="ti ti-plus me-1"></i> Add New Testimonial
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
                    <strong>Translatable Content:</strong> You can add client reviews in multiple languages using the
                    tabs in the form.
                </div>
            </div>

            <div class="table-responsive">
                <table id="testimonials-table" class="table table-hover mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Client</th>
                            <th>Rating</th>
                            <th>Project</th>
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
                <h5 class="alert-heading"><i class="ti ti-info-circle me-2"></i>Testimonial Management - Features Overview
                </h5>
                <hr>
                <p class="mb-2"><strong>What you can do on this page:</strong></p>
                <ul class="mb-3">
                    <li class="mb-2"><strong>Manage Testimonials:</strong> Add, edit, and remove client testimonials
                        displayed on your website.</li>
                    <li class="mb-2"><strong>Multi-language Support:</strong> Define client reviews in all active languages
                        via the tabbed interface.</li>
                    <li class="mb-2"><strong>Project Linking:</strong> Optionally associate a testimonial with a specific
                        portfolio project.</li>
                    <li class="mb-2"><strong>Status Control:</strong> Temporarily hide testimonials from public view by
                        setting them to Inactive.</li>
                </ul>
                <p class="mb-0"><i class="ti ti-bulb me-1"></i><strong>Tip:</strong> Ensure you provide translations for all
                    active languages to maintain a consistent user experience.</p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @include('backend.testimonials._script')
@endpush