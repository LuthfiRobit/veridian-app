<script>
    $(function () {
        // 3. Pricing Module Logic

        if (typeof serviceId === 'undefined') return;

        const pricingsTable = $('#pricingsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.services.pricings.index', $service->id_service) }}",
            columns: [
                { data: 'sort_order', name: 'sort_order' },
                {
                    data: 'translations',
                    name: 'translations.name',
                    defaultContent: '-',
                    render: function (data, type, row) {
                        if (!data || !Array.isArray(data)) return '-';
                        let trans = data.find(t => t.locale === defaultLangCode);
                        return trans ? trans.name : '-';
                    }
                },
                {
                    data: 'translations',
                    name: 'translations.price_label',
                    defaultContent: '-',
                    render: function (data, type, row) {
                        if (!data || !Array.isArray(data)) return '-';
                        let trans = data.find(t => t.locale === defaultLangCode);
                        return trans ? trans.price_label : '-';
                    }
                },
                { data: 'is_featured', name: 'is_featured' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });



        // Reset form and errors when modal is closed
        $('#pricingModal').on('hidden.bs.modal', function () {
            $('#pricingForm')[0].reset();
            clearValidationErrors('#pricingForm');
        });

        $('#btnAddPricing').click(function () {
            $('#pricing_id').val('');
            $('#pricingModalLabel').text('Add Package');
            $('#pricingModal').modal('show');
        });

        $('#pricingForm').submit(function (e) {
            e.preventDefault();
            const id = $('#pricing_id').val();
            const url = id
                ? "{{ route('admin.services.pricings.index', $service->id_service) }}/" + id
                : "{{ route('admin.services.pricings.store', $service->id_service) }}";
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function (res) {
                    $('#pricingModal').modal('hide');
                    pricingsTable.ajax.reload();
                    toastr.success(res.success);
                },
                error: function (xhr) {
                    handleAjaxValidationErrors('#pricingForm', xhr);
                }
            });
        });

        $(document).on('click', '.edit-pricing', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.services.pricings.index', $service->id_service) }}/" + id;

            $.get(url, function (data) {
                $('#pricing_id').val(data.id_service_pricing);
                $('#pricing_sort_order').val(data.sort_order);
                $('#pricing_is_active').prop('checked', data.is_active);
                $('#pricing_is_featured').prop('checked', data.is_featured);

                data.translations.forEach(trans => {
                    $(`#pricingModal input[name="translations[${trans.locale}][name]"]`).val(trans.name);
                    $(`#pricingModal input[name="translations[${trans.locale}][price_label]"]`).val(trans.price_label);
                    $(`#pricingModal input[name="translations[${trans.locale}][unit_label]"]`).val(trans.unit_label);

                    // Handle Features List (Array -> String with newlines)
                    if (trans.features_list && Array.isArray(trans.features_list)) {
                        $(`#pricingModal textarea[name="translations[${trans.locale}][features_raw]"]`).val(trans.features_list.join('\n'));
                    } else {
                        $(`#pricingModal textarea[name="translations[${trans.locale}][features_raw]"]`).val('');
                    }
                });

                $('#pricingModalLabel').text('Edit Package');
                $('#pricingModal').modal('show');
            });
        });

        $(document).on('click', '.delete-pricing', function () {
            const id = $(this).data('id');
            const url = "{{ route('admin.services.pricings.index', $service->id_service) }}/" + id;

            if (confirm('Delete this package?')) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: { _token: csrfToken },
                    success: function (res) {
                        pricingsTable.ajax.reload();
                        toastr.success(res.success);
                    }
                });
            }
        });
    });
</script>