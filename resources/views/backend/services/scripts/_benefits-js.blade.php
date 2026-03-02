<script>
    $(function () {
        // 1. Benefits Module Logic

        // Ensure variables from blade are available
        if (typeof serviceId === 'undefined') {
            console.error('serviceId is not defined. Benefits script requires it.');
            return;
        }

        const benefitsTable = $('#benefitsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.services.benefits.index', $service->id_service) }}",
            columns: [
                { data: 'sort_order', name: 'sort_order' },
                { data: 'icon_display', name: 'icon_display' },
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

        // Init TomSelect for Icon in Modal
        let benefitIconSelect;
        $('#benefitModal').on('shown.bs.modal', function () {
            if (!benefitIconSelect && typeof iconOptions !== 'undefined') {
                benefitIconSelect = new TomSelect("#benefit_icon", {
                    maxOptions: null,
                    options: iconOptions,
                    create: true,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Select Bootstrap Icon...",
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

        // Reset form and errors when modal is closed
        $('#benefitModal').on('hidden.bs.modal', function () {
            $('#benefitForm')[0].reset();
            clearValidationErrors('#benefitForm');
            if (benefitIconSelect) benefitIconSelect.clear();
        });

        $('#btnAddBenefit').click(function () {
            // Form is reset by hidden.bs.modal, just set title and show
            $('#benefit_id').val('');
            $('#benefitModalLabel').text('Add Benefit');
            $('#benefitModal').modal('show');
        });

        $('#benefitForm').submit(function (e) {
            e.preventDefault();
            const id = $('#benefit_id').val();
            const url = id
                ? "{{ route('admin.services.benefits.index', $service->id_service) }}/" + id
                : "{{ route('admin.services.benefits.store', $service->id_service) }}";

            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function (res) {
                    $('#benefitModal').modal('hide');
                    benefitsTable.ajax.reload();
                    toastr.success(res.success);
                },
                error: function (xhr) {
                    handleAjaxValidationErrors('#benefitForm', xhr);
                }
            });
        });

        $(document).on('click', '.edit-benefit', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.services.benefits.index', $service->id_service) }}/" + id;

            $.get(url, function (data) {
                $('#benefit_id').val(data.id_service_benefit);
                $('#benefit_sort_order').val(data.sort_order);
                $('#benefit_is_active').prop('checked', data.is_active);
                if (benefitIconSelect) {
                    benefitIconSelect.setValue(data.icon_class);
                } else {
                    setTimeout(() => benefitIconSelect && benefitIconSelect.setValue(data.icon_class), 500);
                }

                // Populate Translations
                data.translations.forEach(trans => {
                    $(`#benefitModal input[name="translations[${trans.locale}][title]"]`).val(trans.title);
                    $(`#benefitModal textarea[name="translations[${trans.locale}][description]"]`).val(trans.description);
                });

                $('#benefitModalLabel').text('Edit Benefit');
                $('#benefitModal').modal('show');
            });
        });

        $(document).on('click', '.delete-benefit', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.services.benefits.index', $service->id_service) }}/" + id;

            if (confirm('Are you sure?')) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: { _token: csrfToken },
                    success: function (res) {
                        benefitsTable.ajax.reload();
                        toastr.success(res.success);
                    }
                });
            }
        });
    });
</script>