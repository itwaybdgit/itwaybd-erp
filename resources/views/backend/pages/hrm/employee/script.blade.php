<script type="text/javascript">
    let table = $('#systemDatatable').DataTable({
        "processing": true,
        "serverSide": true,
        pageLength: 100, // 👈 This sets the default number of rows per page
        lengthMenu: [
            [10, 25, 50, 100, 200],
            [10, 25, 50, 100, 200]
        ],
        "ajax": {
            "url": "{{ route('hrm.employee.dataProcessingEmployee') }}",
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
                "data": "dob",
                "render": function(data, type, row) {
                    return `<span style="display: block; font-weight: bold;width:70px">${data}</span>`;
                },
                "orderable": true
            },
            {
                "data": "gender",
                "orderable": true
            },
            {
                "data": "personal_phone",
                "orderable": true
            },
            {
                "data": "office_phone",
                "orderable": true
            },
            {
                "data": "nid",
                "orderable": true
            },
            {
                "data": "email",
                "orderable": true
            },
            {
                "data": "department",
                "orderable": true
            },
            {
                "data": "present_address",
                "orderable": true
            },
            {
                "data": "salary",
                "orderable": true
            },
            {
                "data": "over_time_is",
                "orderable": true
            },
            {
                "data": "join_date",
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
