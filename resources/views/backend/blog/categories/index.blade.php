@extends('layouts.backend')

@section('title', 'Blog Categories')

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
@endpush

@section('content')

    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Blog Categories</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item">Blog Categories</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-primary" id="btnCreateCategory">
                        <i class="ti ti-plus me-1"></i> Add New Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="categories-table" class="table table-hover mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Category Name</th>
                            <th>Badge Color</th>
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

    @include('backend.blog.categories._modal')

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    @include('backend.blog.categories._script')
@endpush