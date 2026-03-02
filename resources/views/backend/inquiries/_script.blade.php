<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        var table = $('#inquiries-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.inquiries.index') }}",
            responsive: true,
            order: [[5, 'desc']],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'sender', name: 'name' },
                { data: 'subject', name: 'subject' },
                { data: 'service', name: 'service', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'date', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('body').on('click', '.btn-delete', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This inquiry will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.inquiries.index') }}" + '/' + id,
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (r) {
                            table.draw();
                            Swal.fire('Deleted!', r.message, 'success');
                        },
                        error: function (r) {
                            Swal.fire('Error!', r.responseJSON?.message, 'error');
                        }
                    });
                }
            });
        });
    });
</script>