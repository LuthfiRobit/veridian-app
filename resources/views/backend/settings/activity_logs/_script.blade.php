<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

<script>
    $(function () {
        // Handle CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize DataTable
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[4, 'desc']], // Sort by Date & Time descending initially
            ajax: {
                url: "{{ route('admin.activity-logs.index') }}",
                error: function (xhr, error, code) {
                    console.error("AJAX Error:", error, code, xhr);
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false,
                    width: '5%'
                },
                {
                    data: 'log_name', 
                    name: 'log_name',
                    width: '10%'
                },
                {
                    data: 'description', 
                    name: 'description',
                    width: '30%'
                },
                {
                    data: 'causer', 
                    name: 'causer', 
                    orderable: false, 
                    searchable: false,
                    width: '20%'
                },
                {
                    data: 'created_at', 
                    name: 'created_at',
                    width: '15%'
                },
                {
                    data: 'properties', 
                    name: 'properties', 
                    orderable: false, 
                    searchable: false,
                    width: '10%',
                    className: 'text-center'
                },
            ]
        });

        // Handle View Properties Button Click
        $('body').on('click', '.view-properties', function () {
            var rawProps = $(this).attr('data-properties');
            var parsedProps = JSON.parse(rawProps);
            var formattedJson = JSON.stringify(parsedProps, null, 4);

            if (formattedJson === '{}' || formattedJson === '[]' || !formattedJson) {
                $('#propertiesContent').html('<i>No additional properties.</i>');
            } else {
                $('#propertiesContent').text(formattedJson);
            }
            
            $('#propertiesModal').modal('show');
        });
    });
</script>
