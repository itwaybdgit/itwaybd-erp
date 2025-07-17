{{-- @dd($columns) --}}
@extends('customer.master')

@section('style')
    <link href="{{ asset('admin_assets/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/nouislider/nouislider.min.css') }}">
    <style>
        .card_color {
            background-color: #10245A;
            /* border-radius: 30px; */
            color: #fff;
        }

        .gr_1_color a, .gr_2_color a{
            color: #fff;
        }

        .gr_1_color {
            background: red;
            color: #fff;
        }

        .gr_2_color {
            background: orange;
            color: #fff;
        }

        .gr_3_color {
            background: green;
            color: #fff;
        }

        .gr_4_color {
            background: linear-gradient(150deg, #8f0d8b, #5821de 100%);
            color: #fff;
        }

        .h3_title {
            color: #fff;
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
                        @if (isset($create_url) && $create_url)
                            <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                                <span class="btn-icon-start text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                                Add
                            </a>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card  gr_4_color">
                                <a class="text-white" href="{{route("bandwidthcustomer.supportticket.index")}}">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text">All</p>
                                        <h3 class="font-weight-bolder mb-0 h3_title">{{customer_ticket_count(null,auth()->guard("bandwidthcustomer")->id())}}</h3>
                                    </div>
                                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                                        <div class="avatar-content">
                                            <i data-feather="bell" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>
                        @foreach ($supportstatus as $value)
                        <div class="col-md-4">
                            <div class="card {{$value->id == 1 ? "gr_1_color": ($value->id == 2 ? "gr_2_color" : "gr_3_color") }} gr_1_color">
                                <a href="{{route("bandwidthcustomer.supportticket.index",$value->id)}}">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text">{{$value->name}}</p>
                                        <h3 class="font-weight-bolder mb-0 h3_title">{{customer_ticket_count($value->id,auth()->guard("bandwidthcustomer")->id())}}</h3>
                                    </div>
                                    <div class="avatar bg-light-primary p-50 m-0" style="color:#fff !important">
                                        <div class="avatar-content">
                                            <i data-feather="bell" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>
                        @endforeach
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
