<script>
    $(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        var table = $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.blog-categories.index') }}",
            responsive: true,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'badge_color', name: 'badge_color' },
                { data: 'status', name: 'is_active' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Add
        $('#btnCreateCategory').click(function () {
            $('#categoryForm')[0].reset();
            $('#category_id').val('');
            $('.invalid-feedback').text('').hide();
            $('.is-invalid').removeClass('is-invalid');
            $('#categoryModalLabel').text('Add New Category');
            $('#categoryModal').modal('show');
        });

        // Edit
        $(document).on('click', '.btn-edit', function () {
            var id = $(this).data('id');
            $('.invalid-feedback').text('').hide();
            $('.is-invalid').removeClass('is-invalid');

            $.get("{{ url('admin/blog-categories') }}/" + id + "/edit", function (data) {
                $('#categoryModalLabel').text('Edit Category');
                $('#category_id').val(data.id_blog_category);
                $('#badge_color').val(data.badge_color);
                $('#is_active').val(data.is_active ? 1 : 0);

                // Translations
                if (data.translations) {
                    data.translations.forEach(trans => {
                        $(`#name_${trans.locale}`).val(trans.name);
                        $(`#slug_${trans.locale}`).val(trans.slug);
                    });
                }

                $('#categoryModal').modal('show');
            });
        });

        // Store / Update
        $('#categoryForm').submit(function (e) {
            e.preventDefault();
            var id = $('#category_id').val();
            var url = id ? "{{ url('admin/blog-categories') }}/" + id : "{{ route('admin.blog-categories.store') }}";
            var method = id ? "PUT" : "POST";
            $('#saveBtn').text('Saving...').prop('disabled', true);

            $.ajax({
                url: url,
                type: method,
                data: $(this).serialize(),
                success: function (res) {
                    $('#categoryModal').modal('hide');
                    table.ajax.reload();
                    toastr.success(res.success);
                    $('#saveBtn').text('Save Category').prop('disabled', false);
                },
                error: function (xhr) {
                    $('#saveBtn').text('Save Category').prop('disabled', false);
                    handleAjaxValidationErrors('#categoryForm', xhr);
                }
            });
        });

        function handleAjaxValidationErrors(formSelector, xhr) {
            $(formSelector + ' .is-invalid').removeClass('is-invalid');
            $(formSelector + ' .invalid-feedback').text('').hide();

            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                for (const field in errors) {
                    // Convert dot notation (translations.en.name) to element name (translations[en][name])
                    const nameParts = field.split('.');
                    let errorName = nameParts.shift();
                    nameParts.forEach(part => { errorName += `[${part}]`; });

                    const input = $(formSelector + ` [name="${errorName}"]`);
                    if (input.length) {
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').text(errors[field][0]).show();
                    } else {
                        toastr.error(errors[field][0]);
                    }
                }
            } else {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
            }
        }

        // Delete
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
                        url: "{{ url('admin/blog-categories') }}/" + id,
                        type: 'DELETE',
                        success: function (response) {
                            table.ajax.reload();
                            toastr.success(response.success);
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Error deleting category');
                        }
                    });
                }
            });
        });
    });
</script>