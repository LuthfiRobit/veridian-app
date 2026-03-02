<script>
    $(function () {
        if (typeof projectId === 'undefined') {
            return;
        }

        const statsTable = $('#statsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.projects.stats.index', $project->id_project) }}",
            columns: [
                { data: 'sort_order', name: 'sort_order' },
                {
                    data: 'icon_class',
                    name: 'icon_class',
                    render: function (data) {
                        return data ? `<i class="${data} fs-4"></i>` : '-';
                    }
                },
                { data: 'value', name: 'value' },
                {
                    data: 'translations',
                    name: 'translations.label',
                    defaultContent: '-',
                    render: function (data, type, row) {
                        if (!data || !Array.isArray(data)) return '-';
                        let trans = data.find(t => t.locale === defaultLangCode);
                        return trans ? trans.label : '-';
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Init TomSelect
        let statIconSelect;
        $('#statModal').on('shown.bs.modal', function () {
            if (!statIconSelect && typeof iconOptions !== 'undefined') {
                statIconSelect = new TomSelect("#stat_icon", {
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

        $('#statModal').on('hidden.bs.modal', function () {
            $('#statForm')[0].reset();
            clearValidationErrors('#statForm');
            if (statIconSelect) statIconSelect.clear();
        });

        $('#btnAddStat').click(function () {
            $('#stat_id').val('');
            $('#statModalLabel').text('Add Stat');
            $('#statModal').modal('show');
        });

        $('#statForm').submit(function (e) {
            e.preventDefault();
            const id = $('#stat_id').val();
            const url = id
                ? "{{ route('admin.projects.stats.index', $project->id_project) }}/" + id
                : "{{ route('admin.projects.stats.store', $project->id_project) }}";
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function (res) {
                    $('#statModal').modal('hide');
                    statsTable.ajax.reload();
                    toastr.success(res.success);
                },
                error: function (xhr) {
                    handleAjaxValidationErrors('#statForm', xhr);
                }
            });
        });

        $(document).on('click', '.edit-stat', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.projects.stats.index', $project->id_project) }}/" + id;

            $.get(url, function (data) {
                $('#stat_id').val(data.id_project_stat);
                $('#stat_sort_order').val(data.sort_order);
                $('#stat_value').val(data.value);

                if (statIconSelect) {
                    statIconSelect.setValue(data.icon_class);
                } else {
                    setTimeout(() => statIconSelect && statIconSelect.setValue(data.icon_class), 500);
                }

                if (data.translations) {
                    data.translations.forEach(trans => {
                        $(`#statModal input[name="translations[${trans.locale}][label]"]`).val(trans.label);
                    });
                }

                $('#statModalLabel').text('Edit Stat');
                $('#statModal').modal('show');
            });
        });

        $(document).on('click', '.delete-stat', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.projects.stats.index', $project->id_project) }}/" + id;

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
                            statsTable.ajax.reload();
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