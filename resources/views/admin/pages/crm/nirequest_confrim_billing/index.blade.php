@extends('admin.master')

@section('content')
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                        <div class="d-flex align-items-center">
                            <label for="billing_month" class="me-2 mb-0">Billing Month:</label>
                            <input type="month" name="billing_month" id="billing_month" class="form-control me-3" style="width: 160px;" value="{{ date('Y-m') }}">

                            @if (isset($create_url) && $create_url)
                                <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info">
                                <span class="btn-icon-start text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                                    Add
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="card-datatable table-responsive">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="buttons"></div>
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
@endsection

@section('datatablescripts')
    <script type="text/javascript">
        let table = $('#server_side_lode').DataTable({
            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center mx-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            processing: true,
            serverSide: true,
            pageLength: 100,
            aLengthMenu: [[10, 25, 50, 100, 200, 100000], [10, 25, 50, 100, 200, "All"]],
            ajax: {
                url: "{{ $ajax_url ?? '' }}",
                dataType: "json",
                type: "GET",
                data: function (d) {
                    d.billing_month = $('#billing_month').val();
                }
            },
            columns: {!! \Illuminate\Support\Js::from($columns) !!}
        });

        // Reload DataTable on month change
        $('#billing_month').on('change', function () {
            table.ajax.reload();
        });

        // DataTables export buttons
        new $.fn.dataTable.Buttons(table, {
            buttons: ['excelHtml5', 'csvHtml5', 'print']
        }).container().appendTo($('#buttons'));
    </script>
@endsection
