<script>
    $(function () {
        // 2. Process Module Logic

        if (typeof serviceId === 'undefined') return;

        const pricingsTable = $('#pricingsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.services.pricings.index', $service->id_service) }}",
            columns: [
                { data: 'step_number', name: 'step_number' },
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
                {
                    data: 'translations',
                    name: 'translations.description',
                    defaultContent: '-',
                    render: function (data, type, row) {
                        if (!data || !Array.isArray(data)) return '-';
                        let trans = data.find(t => t.locale === defaultLangCode);
                        return (trans && trans.description) ? trans.description.substring(0, 50) + '...' : '-';
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        const processesTable = $('#processesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.services.processes.index', $service->id_service) }}",
            columns: [
                { data: 'step_number', name: 'step_number' },
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
                {
                    data: 'translations',
                    name: 'translations.description',
                    defaultContent: '-',
                    render: function (data, type, row) {
                        if (!data || !Array.isArray(data)) return '-';
                        let trans = data.find(t => t.locale === defaultLangCode);
                        return (trans && trans.description) ? trans.description.substring(0, 50) + '...' : '-';
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });



        // Reset form and errors when modal is closed
        $('#processModal').on('hidden.bs.modal', function () {
            $('#processForm')[0].reset();
            clearValidationErrors('#processForm');
        });

        $('#btnAddProcess').click(function () {
            $('#process_id').val('');
            $('#processModalLabel').text('Add Step');
            $('#processModal').modal('show');
        });

        $('#processForm').submit(function (e) {
            e.preventDefault();
            const id = $('#process_id').val();
            const url = id
                ? "{{ route('admin.services.processes.index', $service->id_service) }}/" + id
                : "{{ route('admin.services.processes.store', $service->id_service) }}";
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function (res) {
                    $('#processModal').modal('hide');
                    processesTable.ajax.reload();
                    toastr.success(res.success);
                },
                error: function (xhr) {
                    handleAjaxValidationErrors('#processForm', xhr);
                }
            });
        });

        $(document).on('click', '.edit-process', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.services.processes.index', $service->id_service) }}/" + id;

            $.get(url, function (data) {
                $('#process_id').val(data.id_service_process);
                $('#process_step_number').val(data.step_number);
                $('#process_is_active').prop('checked', data.is_active);

                data.translations.forEach(trans => {
                    $(`#processModal input[name="translations[${trans.locale}][title]"]`).val(trans.title);
                    $(`#processModal textarea[name="translations[${trans.locale}][description]"]`).val(trans.description);
                });

                $('#processModalLabel').text('Edit Step');
                $('#processModal').modal('show');
            });
        });

        $(document).on('click', '.delete-process', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.services.processes.index', $service->id_service) }}/" + id;

            if (confirm('Delete this step?')) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: { _token: csrfToken },
                    success: function (res) {
                        processesTable.ajax.reload();
                        toastr.success(res.success);
                    }
                });
            }
        });
    });
</script>