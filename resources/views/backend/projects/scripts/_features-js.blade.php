<script>
    $(function () {
        if (typeof projectId === 'undefined') {
            return;
        }

        const featuresTable = $('#featuresTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.projects.features.index', $project->id_project) }}",
            columns: [
                { data: 'sort_order', name: 'sort_order' },
                {
                    data: 'icon_class',
                    name: 'icon_class',
                    render: function (data) {
                        return data ? `<i class="${data} fs-4"></i>` : '-';
                    }
                },
                {
                    data: 'translations',
                    name: 'translations.title',
                    defaultContent: '-',
                    render: function (data, type, row) {
                        if (!data || !Array.isArray(data)) return '-';
                        let trans = data.find(t => t.locale === defaultLangCode);
                        return trans ? trans.title : '-';
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Init TomSelect
        let featureIconSelect;
        $('#featureModal').on('shown.bs.modal', function () {
            if (!featureIconSelect && typeof iconOptions !== 'undefined') {
                featureIconSelect = new TomSelect("#feature_icon", {
                    maxOptions: null,
                    options: iconOptions,
                    create: true,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Select Icon...",
                    render: {
                        option: function (data, escape) {
                            return '<div><i class="' + escape(data.value) + '"></i> ' + escape(data.text) + '</div>';
                        },
                        item: function (data, escape) {
                            return '<div><i class="' + escape(data.value) + '"></i> ' + escape(data.text) + '</div>';
                        }
                    }
                });
            }
        });

        $('#featureModal').on('hidden.bs.modal', function () {
            $('#featureForm')[0].reset();
            clearValidationErrors('#featureForm');
            if (featureIconSelect) featureIconSelect.clear();
        });

        $('#btnAddFeature').click(function () {
            $('#feature_id').val('');
            $('#featureModalLabel').text('Add Feature');
            $('#featureModal').modal('show');
        });

        $('#featureForm').submit(function (e) {
            e.preventDefault();
            const id = $('#feature_id').val();
            const url = id
                ? "{{ route('admin.projects.features.index', $project->id_project) }}/" + id
                : "{{ route('admin.projects.features.store', $project->id_project) }}";
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function (res) {
                    $('#featureModal').modal('hide');
                    featuresTable.ajax.reload();
                    toastr.success(res.success);
                },
                error: function (xhr) {
                    handleAjaxValidationErrors('#featureForm', xhr);
                }
            });
        });

        $(document).on('click', '.edit-feature', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.projects.features.index', $project->id_project) }}/" + id;

            $.get(url, function (data) {
                $('#feature_id').val(data.id_project_feature);
                $('#feature_sort_order').val(data.sort_order);

                if (featureIconSelect) {
                    featureIconSelect.setValue(data.icon_class);
                } else {
                    setTimeout(() => featureIconSelect && featureIconSelect.setValue(data.icon_class), 500);
                }

                if (data.translations) {
                    data.translations.forEach(trans => {
                        $(`#featureModal input[name="translations[${trans.locale}][title]"]`).val(trans.title);
                    });
                }

                $('#featureModalLabel').text('Edit Feature');
                $('#featureModal').modal('show');
            });
        });

        $(document).on('click', '.delete-feature', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.projects.features.index', $project->id_project) }}/" + id;

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
                            featuresTable.ajax.reload();
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