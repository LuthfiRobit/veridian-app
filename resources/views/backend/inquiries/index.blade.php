@extends('layouts.backend')
@section('title', 'Inquiry Management')

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Inquiry Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Inquiries</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-info-circle me-2 fs-4"></i>
                <div><strong>Contact Inquiries:</strong> Submissions from the contact form on the website. Click <i
                        class="ti ti-eye"></i> to view details.</div>
            </div>
            <div class="table-responsive">
                <table id="inquiries-table" class="table table-hover mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th width="4%">No</th>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('backend.inquiries._script')
@endpush