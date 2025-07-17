{{-- @dd($columns) --}}
@extends('admin.master')

<style>
    #general_data_tables_filter{
        display: none;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                    @if (isset($create_url) && $create_url)
                        <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                            <span class="btn-icon-start text-info">
                                <i class="fa fa-plus color-info"></i>
                            </span>
                            Add
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <x-alert></x-alert>
                    <div class="row justify-content-center">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Team Head:</label>
                                <select name="team" id="team" class="form-control select2" id="">
                                    @foreach ($teams as $team)
                                        <option 
                                            value="{{ $team->id }}">
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">From Date:</label>
                               <input type="date" name="from_date" id="from_team" value="{{date('Y-m-d')}}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="">To Date:</label>
                               <input type="date" name="to_date" id="to_team" value="{{date('Y-m-d')}}" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <button id="submit" class="btn btn-info mt-2">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                            <div id="buttons" class="mt-3">
                            </div>
                        <table id="general_data_tables" class="display table-bordered" style="min-width: 845px">
                            <thead>
                                <tr>
                                    @if (isset($is_show_checkbox) && $is_show_checkbox)
                                        <th>
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input" id="checkAll"
                                                    required="">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                    @endif

                                    @if (isset($columns) && $columns)
                                        @foreach ($columns as $column)
                                            <th>{{ $column['label'] }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="table-danger">
                                    <th colspan="4" class="text-right">Total</th>
                                    @foreach($extracolumn as $val)
                                        <th  class="text-right" id="{{$val['data']}}"></th>
                                    @endforeach
                                    <th  class="text-right"></th>
                                    <th class="text-right" id="totalamount"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade showing_page_modal_area" id="data_modal" tabindex="-1" role="dialog"
                aria-hidden="true">
            </div>
        </div>
    </div>

@endsection

@section('datatablescripts')
    <!-- Datatable -->
    <script src="{{ asset('admin_assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/plugins-init/datatables.init.js') }}"></script>
    <script type="text/javascript">
        let table = $('#general_data_tables').DataTable({
            language: {
                'paginate': {
                    'previous': '<i class="fa fa-chevron-left"></i>',
                    'next': '<i class="fa fa-chevron-right"></i>'
                }
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ $ajax_url ?? '' }}",
                "dataType": "json",
                "type": "GET",
                "data": {
                    "_token": "<?= csrf_token() ?>"
                }
            },
            pageLength: 100,
            aLengthMenu: [
                [10, 25, 50, 100, 200, 100000],
                [10, 25, 50, 100, 200, "All"]
            ],
            "columns": {{ Illuminate\Support\Js::from($columns) }},
            "rowCallback": function(row, data, index) {
                if (index == 0) {
                    sum = 0;
                    count_bandwidth = 0;
                    markers = [];
                }
                var obj = {
                     "id":"",
                     "created_at":"",
                     "company_name":"",
                     "company_owner_name":"",
                     "kam_name":"",
                     "amount":"",
                     "name":"",
                 };

                $.each(data, function( index, value ) {
                    if(index in obj){
                    }else{
                        if(index in markers){
                            markers[index] += Number(value);
                            $('#'+index).text(markers[index]);
                        }else{
                            markers[index] = Number(value);
                            $('#'+index).text(markers[index]);
                        }
                    }
                });

                let amount = parseFloat(data.amount);
                let bandwidth = parseFloat(data.bandwidth);
                sum += amount;
                count_bandwidth += bandwidth;
        
                
                $('#totalamount').text(sum);
                $('#totalbandwidth').text(count_bandwidth);
            }
        });


        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [{
                    extend: 'print',
                    exportOptions: {
                        // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
                    }

                },
                {
                    extend: 'excel',
                    exportOptions: {
                        // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
                    }
                }
            ]
        }).container().appendTo($('#buttons'));

           $('#submit').click(function(){
            footer = `
              <tr class="table-danger">
                                    <th colspan="4" class="text-right">Total</th>
                                    @foreach($extracolumn as $val)
                                        <th  class="text-right" id="{{$val['data']}}"></th>
                                    @endforeach
                                    <th  class="text-right"></th>
                                    <th class="text-right" id="totalamount"></th>
                                </tr>
              `;   
             $('tfoot').html(footer);

            let val1 = $("#team option:selected").val();
            table.columns(1).search(val1).draw();
            
            let val2 = $("#from_team").val();
            table.columns(2).search(val2).draw();

            let val3 = $("#to_team").val();
            table.columns(3).search(val3).draw();
          })


        $(document).on('click', '.showdetails', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                    $('.modal').modal('show');
                    $('#view_details').html(data);
                }
            })
        })
    </script>
@endsection
