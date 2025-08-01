@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Reseller</h4>
                    {{-- <a href="" class="btn btn-dark">Cash Book</a> --}}
                    <hr>
                </div>
                <div class="card-datatable table-responsive">
                    <x-alert></x-alert>
                    <div class="treeview w-20 border">
                        <ul class="mb-1 pl-3 pb-2">

                            <form action="{{ route('reports.reseller') }}" method="POST" class="mt-3">
                                @csrf
                                <section>

                                    <div style="float:left;margin-right:20px; width:90%">
                                        <label for="">Customer:</label>
                                        <select name="customer" class="form-control select2" id="">
                                            {{-- <option selected value="all">All</option> --}}
                                            @foreach ($customers as $customer)
                                                <option {{ $request->customer == $customer->id ? 'selected' : '' }}
                                                    value="{{ $customer->id }}">
                                                    {{ $customer->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div style="float:left;margin-right:20px; width:40%">
                                        <label for="">Month:</label>
                                        <input type="month" value="{{ $request->month }}" class="form-control"
                                            name="month">
                                    </div> --}}

                                    <div style="float:left;margin:20px 0px 0px 10px;">

                                        <input type="submit" value="Find" class="form-control">
                                    </div>
                                    <br style="clear:both;" />

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
                                            <td width="10%"><strong>Customer</strong></td>
                                            <td width="10%"><strong>Date</strong></td>
                                            <td width="10%"><strong>Invoice No</strong></td>
                                            <td width="12%"><strong>Head Name</strong></td>
                                            <td width="20%"><strong>Remark</strong></td>
                                            <td width="10%" align="right">
                                                <strong>Credit</strong>
                                            </td>
                                            <td width="10%" align="right">
                                                <strong>Debit</strong>
                                            </td>
                                            <td width="10%" align="right">
                                                <strong>Discount</strong>
                                            </td>
                                            <td width="10%" align="right">
                                                <strong>Balance</strong>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                            $credit = 0;
                                            $debit = 0;
                                            $total = 0;
                                            $date = '';
                                            $discount = 0;
                                        @endphp

                                        @if (isset($reseller))
                                            @foreach ($reseller as $monthl)
                                                @if ($monthl->account_id !== 5)
                                                    @php($count++)
                                                    <tr class="table_data">
                                                        <td align="right">
                                                            <strong>{{ $count }}</strong>
                                                        </td>
                                                        {{-- <td>
                                                            <strong>{{ date('m-Y', strtotime($monthl->billing->date_)) }}</strong>
                                                        </td> --}}
                                                        <td>
                                                            {{ $monthl->resellerCustomer->company_name }}
                                                        </td>
                                                        <td>
                                                            {{ $monthl->created_at }}
                                                        </td>
                                                        <td align="right">
                                                            <strong>{{ $monthl->invoice }}</strong>
                                                        </td>
                                                        <td align="right">
                                                            <strong>{{ $monthl->account->account_name ?? "" }}</strong>
                                                        </td>
                                                        <td align="right">
                                                            <strong>{{ $monthl->remark }}
                                                                {{ empty($monthl->debit) ? 'Month: ' . $monthl->resellerBill->billing_month : '' }}</strong>
                                                        </td>
                                                        <?php
                                                        $credit += $monthl->credit;
                                                        $debit += $monthl->account_id == 14 ? 0 : $monthl->debit;
                                                        $total += $monthl->credit;
                                                        $total -= $monthl->account_id == 14 ? 0 : $monthl->debit;
                                                        $discount += $monthl->account_id == 14 ? $monthl->debit : 0 ;
                                                        ?>
                                                        <td align="right">
                                                            {{ $monthl->credit }}
                                                        </td>
                                                        <td align="right">
                                                            {{ $monthl->account_id == 14 ? 0 : $monthl->debit }}
                                                        </td>
                                                        <td align="right">
                                                            {{ $monthl->account_id == 14 ? $monthl->debit : 0 }}
                                                        </td>
                                                        <td align="right">
                                                            {{ $total }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="table_data">
                                            <td colspan="6" align="right">
                                            </td>
                                            {{-- <td align="right">
                                                <strong>tk&nbsp;</strong>
                                            </td>
                                            <td align="right">
                                                <strong>tk&nbsp;</strong>
                                            </td> --}}
                                            <td align="right">
                                                <strong>{{ $credit ?? '00' }}</strong>
                                            </td>
                                            <td align="right">
                                                <strong>{{ $debit ?? '00' }}</strong>
                                            </td>
                                            <td align="right">
                                                <strong>{{ $discount ?? '00' }}</strong>
                                            </td>
                                            <td align="right">
                                                {{ ($total - $discount) ?? '00' }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
