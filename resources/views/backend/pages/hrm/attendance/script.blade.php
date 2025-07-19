<script type="text/javascript">
    let table = $('#systemDatatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('hrm.attendance.dataProcessingattendance') }}",
            "dataType": "json",
            "type": "GET",
            "data": {
                "_token": "<?= csrf_token() ?>"
            }
        },
        "pageLength": 100,
        "columns": [{
                "data": "id",
                "orderable": true
            },
            {
                "data": "id_cart",
                "orderable": true
            },
            {
                "data": "emplyee_id",
                "orderable": true
            },
            {
                "data": "date",
                "orderable": true
            },
            {
                "data": "sign_in",
                "orderable": true
            },
            {
                "data": "location_in",
                "orderable": true
            },
            {
                "data": "sign_out",
                "orderable": true
            },
            {
                "data": "location_out",
                "orderable": true
            },
            // {
            // "data": "status",
            // "orderable": true
            // },

            {
                "data": "action",
                "class": 'text-nowrap',
                "searchable": false,
                "orderable": false
            },
        ],
        "order": [
            [0, "desc"]
        ],
        drawCallback: function() {
            $("[name='my-checkbox']").each(function() {
                if ($(this).data('bootstrap-switch')) {
                    $(this).bootstrapSwitch('destroy');
                }
                $(this).bootstrapSwitch({
                    size: "small",
                    onColor: "success",
                    offColor: "danger"
                });
            });
        }

    });

    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print',
        ]
    }).container().appendTo($('#buttons'));
</script>
