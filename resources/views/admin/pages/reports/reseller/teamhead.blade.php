@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Team Report</h4>
                    {{-- <a href="" class="btn btn-dark">Cash Book</a> --}}
                    <hr>
                </div>
                <div class="card-datatable table-responsive">
                    <x-alert></x-alert>
                    <div class="treeview  border">
                            <form action="{{ route('reports.teamhead') }}" method="POST" class="mt-3">
                                @csrf
                                <section>
                                     <div class="row">
                                         <div class="col-md-4">
                                             <label for="">Team Head:</label>
                                             <select name="team" class="form-control select2" id="">
                                                 @foreach ($teams as $team)
                                                     <option {{ $request->team == $team->id ? 'selected' : '' }}
                                                         value="{{ $team->id }}">
                                                         {{ $team->name }}
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </div>
                                         <div class="col-md-3">
                                             <label for="">From Date:</label>
                                            <input type="date" name="from_date" value="{{date('Y-m-d')}}" class="form-control">
                                         </div>
                                         <div class="col-md-3">
                                             <label for="">To Date:</label>
                                            <input type="date" name="to_date" value="{{date('Y-m-d')}}" class="form-control">
                                         </div>
                                         <div class="col-md-2">
                                             <input type="submit" value="Find" class="form-control mt-2">
                                         </div>
                                     </div>
                                </section>
                            </form>

                            {{-- table --}}
                            <div class="table-responsive mt-2">
                                @if ($request->customer)

                                <form action="{{route('reports.reseller.invoice')}}" method="get">
                                <div class="row">
                                    <div class="col-md-6 mt-3 mb-3">
                                        <select name="business_id" class="form-control" id="">
                                            @foreach ($business as $value)
                                            <option value="{{$value->id}}">{{$value->business_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <input type="hidden" value="{{$request->customer}}" name="customer">
                                    <div class="col-md-6 mt-3 mb-3">
                                       <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                 </div>
                               </form>
                               @endif

                                <table width="100%" class="table table-bordered table-stripped print-font-size"
                                    cellpadding="6" cellspacing="1">
                                    <thead>
                                        <tr>
                                            <td height="25" width="5%"><strong>SL.</strong></td>
                                            <td width="10%"><strong>Company</strong></td>
                                            <td width="10%"><strong>Owner name</strong></td>
                                            <td width="10%"><strong>Bandwidth</strong></td> 
                                            <td width="10%"><strong>Kam</strong></td> 
                                            <td width="10%"><strong>Amount</strong></td> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                            $total = 0;
                                        @endphp
                                        @if (isset($bandwidthcustomer))
                                            @foreach ($bandwidthcustomer as $customer)
                                            @php
                                                $amount = ($customer->package->sum('qty') ?? 0) * ($customer->package->sum('rate') ?? 0);
                                                $total +=$amount;
                                            @endphp
                                                    @php($count++)
                                                    <tr class="table_data">
                                                        <td align="right">{{ $count }}</td>
                                                        <td align="right">{{ $customer->company_name }}</td>
                                                        <td align="right">{{ $customer->company_owner_name }}</td>
                                                        <td align="right">{{ $customer->package->sum('qty') ?? 0 }}</td>
                                                        <td align="right">{{ $customer->kam->name ?? "" }}</td>
                                                        <td align="right">{{  $amount  }}</td>
                                                    </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="table_data">
                                            <td colspan="5" align="right">
                                               Total :
                                            </td>
                                            <td  align="right">
                                                {{$total}}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
