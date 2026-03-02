<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        var table = $('#services-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.services.index') }}",
            responsive: true,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'sort_order', name: 'sort_order' },
                { data: 'status', name: 'status' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Delete Service
        $('body').on('click', '.btn-delete', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.services.store') }}" + '/' + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            table.draw();
                            Swal.fire(
                                'Deleted!',
                                response.success,
                                'success'
                            )
                        },
                        error: function (response) {
                            Swal.fire(
                                'Error!',
                                response.responseJSON.error,
                                'error'
                            )
                        }
                    });
                }
            });
        });
    });
</script>