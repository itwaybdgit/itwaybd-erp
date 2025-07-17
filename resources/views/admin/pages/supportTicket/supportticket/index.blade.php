{{-- @dd($columns) --}}
@extends('admin.master')

@section('style')
    <link href="{{ asset('admin_assets/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/nouislider/nouislider.min.css') }}">
    <style>
        .card_color {
            background-color: #10245A;
            /* border-radius: 30px; */
            color: #fff;
        }

        .gr_1_color a,
        .gr_2_color a {
            color: #fff;
        }

        .gr_1_color {
            background: linear-gradient(135deg, #830000, #bd4857);
            color: #fff;
        }

        .gr_2_color {
            background: linear-gradient(135deg, #f0e000, #b9a706);
            color: #fff;
        }

        .gr_3_color {
            background: linear-gradient(135deg, #038b1a, #047225);
            color: #fff;
        }

        .gr_4_color {
            background: linear-gradient(150deg, #8f0d8b, #5821de 100%);
            color: #fff;
        }

        .h3_title {
            color: #fff;
        }

        .table:not(.table-dark):not(.table-light) thead:not(.thead-dark) th,
        .table:not(.table-dark):not(.table-light) tfoot:not(.thead-dark) th {
            background-color: #1872a6;
            color: #FFF;
        }
    </style>
    <style>
        .zoom-hover {
            transition: transform 0.3s;
            display: inline-block;
            cursor: pointer;
        }

        .zoom-hover:hover {
            transform: scale(2.1);
            z-index: 10;
            position: relative;
            background: #fffbe6;
            color: #000;
            padding: 5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
@endsection
@section('content')
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <a href="{{ route('supportticket.total') }}">
                                <div class="card shadow border-0"
                                    style="background: linear-gradient(135deg, #110d2e, #0faeb8)">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <!-- Left Side: Amount -->
                                            <div>
                                                <span class="h6 font-semibold text-sm d-block mb-2"
                                                    style="color:#fff !important; white-space: nowrap;">
                                                    Total Ticket
                                                </span>
                                                <span class="h3 font-bold mb-0"
                                                    style="color:#fff !important; white-space: nowrap;">
                                                    {{ ticket_count() }}
                                                </span>
                                            </div>
                                            <!-- Right Side: Icon -->
                                            <div>
                                                <i class="fas fa-receipt fa-3x" style="color: #fff;"></i>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @foreach ($supportstatus as $value)
                            <div class="col-md-3">
                                <a href="{{ route('supportticket.index', $value->id) }}">
                                    <div
                                        class="card shadow border-0 {{ $value->id == 1 ? 'gr_1_color' : ($value->id == 2 ? 'gr_2_color' : 'gr_3_color') }} gr_1_color">
                                        <div class="card-body text-white">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <!-- Left Side: Amount -->
                                                <div>
                                                    <span class="h6 font-semibold text-sm d-block mb-2"
                                                        style="color:#fff !important; white-space: nowrap;">
                                                        {{ $value->name }}
                                                    </span>
                                                    <span class="h3 font-bold mb-0"
                                                        style="color:#fff !important; white-space: nowrap;">
                                                        {{ ticket_count($value->id) }}
                                                    </span>
                                                </div>
                                                <!-- Right Side: Icon -->
                                                <div>
                                                    <i class="fas fa-receipt fa-3x" style="color: #fff;"></i>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-6 ml-2">
                            @if (isset($create_url) && $create_url)
                                <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-success text-right">
                                    <span class="btn-icon-start text-white">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Create New Ticket
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <x-alert></x-alert>
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

@endsection

@section('datatablescripts')
    <!-- Datatable -->
    {{-- <script type="text/javascript">
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
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            var ajax_url = @json($ajax_url);
            var columns = @json($columns);

            // note কলামের জন্য render যোগ করুন
            columns = columns.map(function(col) {
                if (col.data === 'note') {
                    col.render = function(data, type, row, meta) {
                        if (data) {
                            return '<span class="zoom-hover">' + data + '</span>';
                        }
                        return '';
                    };
                }
                return col;
            });

            let table = $('#server_side_lode').DataTable({
                processing: true,
                serverSide: true,
                ajax: ajax_url,
                columns: columns,
                pageLength: 100,
                lengthMenu: [
                    [10, 25, 50, 100, 200, 500, 1000],
                    [10, 25, 50, 100, 200, 500, 1000]
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ],
                order: [
                    [1, 'desc']
                ],
            });

            // Export buttons
            new $.fn.dataTable.Buttons(table, {
                buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'print',
                ]
            }).container().appendTo($('#buttons'));
        });
    </script>
@endsection
