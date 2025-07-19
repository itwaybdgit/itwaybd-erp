<script type="text/javascript">
    let table = $('#systemDatatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('hrm.position.dataProcessingPosition') }}",
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
                "data": "name",
                "orderable": true
            },
            {
                "data": "details",
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
