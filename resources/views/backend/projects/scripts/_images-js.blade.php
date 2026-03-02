<script>
    $(function () {
        if (typeof projectId === 'undefined') {
            console.error('projectId is not defined. Images script requires it.');
            return;
        }

        const imagesTable = $('#imagesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.projects.images.index', $project->id_project) }}",
            columns: [
                { data: 'sort_order', name: 'sort_order' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                {
                    data: 'translations',
                    name: 'translations.caption',
                    defaultContent: '-',
                    render: function (data, type, row) {
                        if (!data || !Array.isArray(data)) return '-';
                        let trans = data.find(t => t.locale === defaultLangCode);
                        return trans ? trans.caption : '-';
                    }
                },
                {
                    data: 'is_hero',
                    name: 'is_hero',
                    render: function (data) {
                        return data ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>';
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#imageModal').on('hidden.bs.modal', function () {
            $('#imageForm')[0].reset();
            $('#current_image_preview').addClass('d-none');
            clearValidationErrors('#imageForm');
        });

        $('#btnAddImage').click(function () {
            $('#image_id').val('');
            $('#imageModalLabel').text('Add Image');
            $('#imageModal').modal('show');
        });

        $('#imageForm').submit(function (e) {
            e.preventDefault();

            // Use FormData for file upload
            let formData = new FormData(this);
            const id = $('#image_id').val();

            // Fix for PUT method with FormData (Laravel requires _method field)
            if (id) {
                formData.append('_method', 'PUT');
            }

            const url = id
                ? "{{ route('admin.projects.images.index', $project->id_project) }}/" + id
                : "{{ route('admin.projects.images.store', $project->id_project) }}";

            $.ajax({
                url: url,
                method: 'POST', // Always POST when using FormData, even for PUT (simulated)
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    $('#imageModal').modal('hide');
                    imagesTable.ajax.reload();
                    toastr.success(res.success);
                },
                error: function (xhr) {
                    handleAjaxValidationErrors('#imageForm', xhr);
                }
            });
        });

        $(document).on('click', '.edit-image', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.projects.images.index', $project->id_project) }}/" + id;

            $.get(url, function (data) {
                $('#image_id').val(data.id_project_image);
                $('#image_sort_order').val(data.sort_order);
                $('#image_is_hero').prop('checked', data.is_hero == 1);

                if (data.image_path) {
                    $('#current_image_preview img').attr('src', "{{ asset('') }}" + data.image_path);
                    $('#current_image_preview').removeClass('d-none');
                }

                // Populate Translations
                if (data.translations) {
                    data.translations.forEach(trans => {
                        $(`#imageModal input[name="translations[${trans.locale}][caption]"]`).val(trans.caption);
                    });
                }

                $('#imageModalLabel').text('Edit Image');
                $('#imageModal').modal('show');
            });
        });

        $(document).on('click', '.delete-image', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.projects.images.index', $project->id_project) }}/" + id;

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
                        url: url,
                        method: 'DELETE',
                        data: { _token: csrfToken },
                        success: function (res) {
                            imagesTable.ajax.reload();
                            Swal.fire('Deleted!', res.success, 'success');
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.error || xhr.statusText || 'An error occurred during deletion.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>