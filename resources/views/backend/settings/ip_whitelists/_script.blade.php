<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.ip-whitelists.index') }}",
                error: function (xhr, error, code) {
                    console.log(xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to load data. Check console for details.',
                    });
                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'ip_address',
                name: 'ip_address'
            },
            {
                data: 'label',
                name: 'label'
            },
            {
                data: 'status',
                name: 'is_active'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            ],
            drawCallback: function (settings) {
                console.log("DataTable drawn!");
            }
        });

        $('#createNewIp').click(function () {
            $('#saveBtn').val("create-ip");
            $('#id_ip_whitelist').val('');
            $('#ipForm').trigger("reset");
            $('#modelHeading').html("Add IP to Blocklist");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.edit', function () {
            var id = $(this).data('id');
            $.get("{{ route('admin.ip-whitelists.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit Blocked IP");
                $('#saveBtn').val("edit-ip");
                $('#ajaxModel').modal('show');
                $('#id_ip_whitelist').val(data.id_ip_whitelist);
                $('#ip_address').val(data.ip_address);
                $('#label').val(data.label);
                $('#is_active').prop('checked', data.is_active == 1);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            var id = $('#id_ip_whitelist').val();
            var url = id ? "{{ route('admin.ip-whitelists.index') }}" + '/' + id : "{{ route('admin.ip-whitelists.store') }}";
            var method = id ? "PUT" : "POST";

            $.ajax({
                data: $('#ipForm').serialize(),
                url: url,
                type: method,
                dataType: 'json',
                success: function (data) {
                    $('#ipForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                    $('#saveBtn').html('Save Changes');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.success,
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                    var errors = data.responseJSON.error || data.responseJSON.message;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errors,
                    });
                }
            });
        });

        $('body').on('click', '.btn-delete', function () {
            var id = $(this).data("id");

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
                        url: "{{ route('admin.ip-whitelists.store') }}" + '/' + id,
                        success: function (data) {
                            table.draw();
                            Swal.fire(
                                'Deleted!',
                                'The IP has been removed from the blocklist.',
                                'success'
                            )
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.responseJSON.error,
                            });
                        }
                    });
                }
            })
        });
    });
</script>