@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Collected Bill' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li class="font-weight-bold">Name: {{ $billcollected->name }}
                                    ({{ $billcollected->username }})
                                </li>
                                <li class="font-weight-bold">Phone: {{ $billcollected->phone }}</li>
                                <li class="font-weight-bold">Address: {{ $billcollected->address }}</li>
                                <li class="font-weight-bold">Advance: {{ $billcollected->advanced_payment ?? '0.00' }}</li>
                                <li class="font-weight-bold">Expire Date: {{ $billcollected->exp_date }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            @if (isset($billcollected->nid_front))
                                <img src="{{ asset('/storage/' . $billcollected->nid_front) }}" alt="nid front image"
                                    width="200" height="100">
                            @endif
                            @if (isset($billcollected->nid_back))
                                <img src="{{ asset('/storage/' . $billcollected->nid_back) }}" alt="nid front image"
                                    width="200" height="100">
                            @endif
                        </div>
                    </div>

                    <div class="basic-form">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Invoice</th>
                                            <th scope="col">Bill Generate Date</th>
                                            <th scope="col">Month</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Pay</th>
                                            <th scope="col">Billing By</th>
                                        </tr>
                                    </thead>
                                    @if ($customerPaymentDetails)
                                        <tbody>
                                            @php
                                                $totalpay = 0;
                                            @endphp
                                            @if ($customerPaymentDetails->isEmpty())
                                                <tr>
                                                    <td colspan="9" class="text-center">No Data Found</td>
                                                </tr>
                                            @else
                                                @foreach ($customerPaymentDetails as $key => $customer)
                                                    @php
                                                        $totalpay += $customer->pay_amount;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{$customer->invoice_name}}</td>
                                                        <td>{{ Carbon\Carbon::parse($customer->updated_at)->format('d,M,Y') }}
                                                        </td>
                                                        <td>{{ Carbon\Carbon::parse($customer->date_)->format('F-Y') }}
                                                        </td>
                                                        <td>
                                                            @if ($customer->payment_method_id == 500)
                                                                <p>Advance Payed
                                                                </p>
                                                            @elseif($customer->PaymentMethod)
                                                                <p>{{ $customer->PaymentMethod->account_name }}</p>
                                                            @else
                                                                <p class='text-danger'>Not Payed</p>
                                                            @endif
                                                        </td>
                                                        <td>{!! $customer->description ?? 'N/A' !!}</td>
                                                        <td>{{ $customer->discount ?? 0.0 }}</td>
                                                        <td>{{ (int) $customer->customer_billing_amount }}
                                                        <td>{{ (int) $customer->pay_amount ?? 0 }}
                                                        </td>
                                                        </td>
                                                        <td>{{ $customer->getBillinfBy->name ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    @endif
                                    @if ($customerPaymentDetails->isNotEmpty())
                                        <tfoot>
                                            <tr class="bg-secondary">
                                                <td colspan="8" class="text-right text-white">Total</td>
                                                <td class="text-white">{{ $totalpay }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
