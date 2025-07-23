<script type="text/javascript">
    let table = $('#systemDatatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('hrm.leaveapprove.dataProcessingApproveLeaveApplication') }}",
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
                "data": "branch_id",
                "orderable": true
            },
            {
                "data": "apply_date",
                "orderable": true
            },
            {
                "data": "end_date",
                "orderable": true
            },
            {
                "data": "reason",
                "orderable": true
            },
            {
                "data": "payment_status",
                "orderable": true
            },
            {
                "data": "status",
                "orderable": true
            },

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
