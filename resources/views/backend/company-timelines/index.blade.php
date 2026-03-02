@extends('layouts.backend')

@section('title', 'Company Timeline')

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
                        <h5 class="m-b-10">Company Timeline Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Company</li>
                        <li class="breadcrumb-item">Timeline</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('admin.company-timelines.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Add Milestone
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="section-hint mb-3"
                style="background:#f0f4ff;border-left:3px solid #4680ff;padding:8px 12px;border-radius:0 6px 6px 0;font-size:13px;color:#5a6270;">
                <i class="ti ti-info-circle" style="color:#4680ff;margin-right:5px;"></i>
                Ditampilkan di: <strong style="color:#333;">About Page → Company Timeline Section</strong> (milestones)
            </div>
            <div class="table-responsive">
                <table id="timelines-table" class="table table-hover mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Year</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('backend.company-timelines._script')
@endpush