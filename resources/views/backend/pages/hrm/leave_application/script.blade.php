<script type="text/javascript">
    let table = $('#systemDatatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('hrm.leave.dataProcessingLeaveApplication') }}",
            "dataType": "json",
            "type": "GET",
            "data": {
                "_token": "<?= csrf_token() ?>"
            }
        },
        "columns": [{
                "data": "id",
                "orderable": true
            },
            {
                "data": "employee_id",
                "orderable": true
            },
            {
                "data": "employee_name",
                "orderable": true
            },
            {
                "data": "department_id",
                "orderable": false
            },
            {
                "data": "days",
                "orderable": false
            },
            {
                "data": "apply_date",
                "orderable": false
            },
            {
                "data": "end_date",
                "orderable": false
            },
            {
                "data": "reason",
                "orderable": false
            },
            // {
            //     "data": "payment_status",
            //     "orderable": false
            // },
            // {
            //     "data": "status",
            //     "orderable": false
            // },

            {
                "data": "action",
                "class": 'text-nowrap',
                "searchable": false,
                "orderable": false
            },
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
