{{-- @dd($columns) --}}
@extends('admin.master')

@section('content')

    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                        @if(has_route('bandwidthsaleinvoice.pay'))
                        <a href="{{ route('bandwidthsaleinvoice.pay') }}" class="btn btn-rounded btn-info text-right">
                            <span class="btn-icon-start text-white">
                                <i class="fa fa-plus"></i>
                            </span>
                            Payment
                        </a>
                        @endif
                        @if (isset($create_url) && $create_url)
                            <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                                <span class="btn-icon-start text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                                Add
                            </a>
                        @endif
                    </div>
                    <div class="card-datatable table-responsive">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="buttons">
                                </div>
                            </div>
                        </div>
                        <table id="server_side_lode" class="table">
                            <thead>
                                <tr>
                                    @if (isset($columns) && $columns)
                                        @foreach ($columns as $column)
                                            <th>{{ $column['label'] }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-light" id="printModalLabel">Invoice Preview</h5>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="printModalContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Fetching invoice...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('datatablescripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function openPrintModal(invoiceId) {
            $('#printModalContent').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <div class="mt-2">Fetching invoice...</div>
                </div>
            `);

            var modal = new bootstrap.Modal(document.getElementById('printModal'), {});
            modal.show();

            $.ajax({
                url: '/admin/bandwidthsaleinvoice/invoices/print/' + invoiceId,
                type: 'GET',
                success: function(data) {
                    $('#printModalContent').html(data);
                },
                error: function() {
                    $('#printModalContent').html('<div class="text-danger text-center py-5">Failed to load invoice!</div>');
                }
            });
        }

        function printModalContent() {
            var printContents = document.getElementById('printModalContent').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }


    </script>





    <!-- Datatable -->
    <script type="text/javascript">
        let table = $('#server_side_lode').dataTable({
            order: [
                [0, 'desc']
            ],
            dom: '<"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            "processing": true,
            "serverSide": true,
            retrieve: true,
            "ajax": {
                "url": "{{ $ajax_url ?? '' }}",
                "dataType": "json",
                "type": "GET",
            },
            pageLength: 100,
            aLengthMenu: [
                [10, 25, 50, 100, 200, 100000],
                [10, 25, 50, 100, 200, "All"]
            ],
            "columns": {{ \Illuminate\Support\Js::from($columns) }}
        })

        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'print',
            ]
        }).container().appendTo($('#buttons'));
    </script>
@endsection
