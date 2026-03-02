<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<!-- Tom Select -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Init TomSelect for Roles
        var roleSelect = new TomSelect("#roles", {
            plugins: ['remove_button'],
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.users.index') }}",
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
                data: 'email',
                name: 'email'
            },
            {
                data: 'roles',
                name: 'roles',
                orderable: false,
                searchable: false
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

        $('#createNewUser').click(function () {
            $('#saveBtn').val("create-user");
            $('#id_user').val('');
            $('#userForm').trigger("reset");
            $('#modelHeading').html("Add New User");
            roleSelect.clear();
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.edit', function () {
            var id = $(this).data('id');
            $.get("{{ route('admin.users.index') }}" + '/' + id + '/edit', function (data) {
                $('#modelHeading').html("Edit User");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#id_user').val(data.user.id_user);
                $('#name').val(data.user.name);
                $('#email').val(data.user.email);
                $('#password').val(''); // Don't show password
                $('#confirm-password').val('');
                $('#is_active').prop('checked', data.user.is_active == 1);

                // Set Roles
                roleSelect.setValue(data.userRoles);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            var id = $('#id_user').val();
            var url = id ? "{{ route('admin.users.index') }}" + '/' + id : "{{ route('admin.users.store') }}";
            var method = id ? "PUT" : "POST";

            $.ajax({
                data: $('#userForm').serialize(),
                url: url,
                type: method,
                dataType: 'json',
                success: function (data) {
                    $('#userForm').trigger("reset");
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
                        url: "{{ route('admin.users.store') }}" + '/' + id,
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