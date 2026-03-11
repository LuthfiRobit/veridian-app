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
                url: "{{ route('admin.roles.index') }}",
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'permissions',
                name: 'permissions',
                orderable: false,
                searchable: false
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

        $('#createNewRole').click(function () {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#saveBtn').val("create-role");
            $('#id').val('');
            $('#roleForm').trigger("reset");
            $('#modelHeading').html("Add New Role");
            $('#ajaxModel').modal('show');
            $('.permission-checkbox').prop('checked', false); // Uncheck all
        });

        $('body').on('click', '.edit', function () {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            var id = $(this).data('id');
            $.get("{{ route('admin.roles.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit Role");
                $('#saveBtn').val("edit-role");
                $('#ajaxModel').modal('show');
                $('#id').val(data.role.id);
                $('#name').val(data.role.name);

                // Reset checkboxes
                $('.permission-checkbox').prop('checked', false);

                // Check permissions
                $.each(data.rolePermissions, function (key, permissionId) {
                    $('#perm_' + permissionId).prop('checked', true);
                });
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(this).html('Sending..');

            var id = $('#id').val();
            var url = id ? "{{ route('admin.roles.index') }}" + '/' + id : "{{ route('admin.roles.store') }}";
            var method = id ? "PUT" : "POST";

            $.ajax({
                data: $('#roleForm').serialize(),
                url: url,
                type: method,
                dataType: 'json',
                success: function (data) {
                    $('#roleForm').trigger("reset");
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
                    
                    if (data.status === 422) {
                        var errors = data.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            var input = $('[name="' + key + '"]');
                            if (key.includes('.')) {
                                // Handle array names like permissions[]
                                key = key.split('.')[0] + '[]';
                                input = $('[name="' + key + '"]');
                            }
                            
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                        });
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please check the form for errors.',
                        });
                    } else {
                        var errors = data.responseJSON.error || data.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errors,
                        });
                    }
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
                        url: "{{ route('admin.roles.store') }}" + '/' + id,
                        success: function (data) {
                            table.draw();
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
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