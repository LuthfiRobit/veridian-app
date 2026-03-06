<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Tom Select -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Common Render Function for Icons
        var renderTemplate = function (data, escape) {
            if (data.value && data.value.indexOf('flag-icon') !== -1) {
                return '<div><i class="' + escape(data.value) + '"></i> ' + escape(data.text) + '</div>';
            }
            return '<div>' + escape(data.text) + '</div>';
        };

        // Init Tom Select for Code
        var codeSelect = new TomSelect("#code", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            plugins: ['dropdown_input'],
            maxItems: 1
        });

        // Init Tom Select for Icon
        var iconSelect = new TomSelect("#icon", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            },
            valueField: 'value',
            labelField: 'text',
            searchField: 'text',
            plugins: ['dropdown_input'],
            maxItems: 1,
            render: {
                option: renderTemplate,
                item: renderTemplate
            }
        });

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.languages.index') }}",
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
                data: 'code',
                name: 'code'
            },
            {
                data: 'icon_display',
                name: 'icon'
            },
            {
                data: 'status',
                name: 'is_active',
                className: 'text-center'
            },
            {
                data: 'is_default',
                name: 'is_default',
                className: 'text-center'
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

        $('#createNewLanguage').click(function () {
            $('#saveBtn').val("create-language");
            $('#id_language').val('');
            $('#languageForm').trigger("reset");
            codeSelect.clear();
            iconSelect.clear();
            $('#modelHeading').html("Create New Language");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.edit', function () {
            var id_language = $(this).data('id');
            $.get("{{ route('admin.languages.index') }}" + '/' + id_language + '/edit', function (data) {
                $('#modelHeading').html("Edit Language");
                $('#saveBtn').val("edit-language");
                $('#ajaxModel').modal('show');
                $('#id_language').val(data.id_language);
                $('#name').val(data.name);

                // Set Tom Select values
                codeSelect.setValue(data.code);
                iconSelect.setValue(data.icon);

                $('#is_active').prop('checked', data.is_active == 1);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            var id = $('#id_language').val();
            var url = id ? "{{ route('admin.languages.index') }}" + '/' + id : "{{ route('admin.languages.store') }}";
            var method = id ? "PUT" : "POST";

            $.ajax({
                data: $('#languageForm').serialize(),
                url: url,
                type: method,
                dataType: 'json',
                success: function (data) {
                    $('#languageForm').trigger("reset");
                    codeSelect.clear();
                    iconSelect.clear();
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
            var id_language = $(this).data("id");

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
                        url: "{{ route('admin.languages.store') }}" + '/' + id_language,
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

        $('body').on('change', '.set-default-btn', function () {
            var el = $(this);
            var id_language = el.data("id");
            // Revert visually immediately so it only stays checked if confirmed & success
            el.prop('checked', false);

            Swal.fire({
                title: 'Set as Default?',
                text: "This language will become the default language for the site.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, set it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/languages') }}/" + id_language + "/set-default",
                        success: function (data) {
                            table.draw(false);
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.responseJSON.error || 'Failed to set default language.',
                            });
                        }
                    });
                }
            })
        });
    });
</script>