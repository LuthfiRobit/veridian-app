@extends('layouts.backend')

@section('title', 'Projects')

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
                        <h5 class="m-b-10">Project Management</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Content Management</li>
                        <li class="breadcrumb-item">Projects</li>
                    </ul>
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Add New Project
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="projects-table" class="table table-hover mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>

                            <th>Project Title</th>
                            <th>Category</th>
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

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function () {
            var table = $('#projects-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.projects.index') }}",
                responsive: true,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category.name' }, // Assuming relationship is eager loaded
                    { data: 'status', name: 'is_active' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Delete Action
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/projects') }}/" + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                table.ajax.reload();
                                toastr.success(response.success);
                            },
                            error: function (xhr) {
                                toastr.error('Error deleting project');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush