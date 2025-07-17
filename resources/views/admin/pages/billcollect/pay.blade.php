@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $billing->getCustomer->name }}({{ $billing->getCustomer->username }})
                        {{ $page_heading ?? 'Payment Information' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <hr>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">

                        <div class="col-lg-12">
                            <h4 class="card-title">
                                Due
                                Information</h4>

                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive-sm">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Invoice</th>
                                            {{-- <th scope="col">Address</th> --}}
                                            <th scope="col">Mobile No</th>
                                            <th scope="col">Speed</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Due</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $setPartial = 0;
                                        @endphp
                                        @foreach ($customerDetails as $key => $customer)
                                            @php
                                                $setPartial += $customer->partial;
                                            @endphp
                                            <tr>
                                                <th>{{ $key + 1 }}</th>
                                                <td>{{ $customer->getCustomer->name ?? 'N/A' }}</td>
                                                <td>{{ $customer->invoice_name ?? 'N/A' }}</td>
                                                {{-- <td>{{ $customer->getCustomer->address ?? 'N/A' }}</td> --}}
                                                <td>{{ $customer->getCustomer->phone ?? 'N/A' }}</td>
                                                <td>{{ $customer->getCustomer->speed ?? 'N/A' }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($customer->date_)->format('F-Y') }}
                                                </td>
                                                <td class="bill_amount">{{ $customer->customer_billing_amount }}</td>
                                                <td>{{ $customer->partial ?? $customer->customer_billing_amount - $customer->pay_amount }}
                                                </td>
                                                @if ($customer->status == 'unpaid')
                                                    <td><a href="{{ route('billcollect.duepay', $customer->id) }}"
                                                            type="button" data-toggle='modal' data-target='#default'
                                                            class="btn-info  btn-sm paymodel">Pay</a>
                                                    </td>
                                                @elseif($customer->status == 'partial')
                                                    <td><a href="{{ route('billcollect.partial', $customer->id) }}"
                                                            type="button" data-toggle='modal' data-target='#default'
                                                            class="btn-info  btn-sm paymodel">Partial</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <hr>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="">Service Amount</label>
                                <input type="text" class="form-control" id="service_amount" readonly
                                    value="{{ $data->getCustomer->bill_amount }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="">Payment Type</label>
                                <select name="pay_type" onchange="payType(this.value)" class="form-control">
                                    <option selected disabled>Select Type</option>
                                    <option value="full_pay">Full Payment</option>
                                    <option value="partial">Due Payment</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3 payMonth" style="display: none;">
                                <label for="">Payment Month</label>
                                <select name="month" class="form-control select2" onchange="payMonth()"
                                    id="paymentMonth">
                                    <option selected disabled>Select Month</option>
                                    @foreach ($customerDetails as $customer)
                                    <option amount="{{$customer->customer_billing_amount}}"
                                        payamount="{{$customer->pay_amount}}" value="{{$customer->id}}">
                                        {{Carbon\Carbon::parse($customer->date_)->format('F-Y')}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 ">
                                <label for="">Payment Method</label>
                                <select name="payment_method_id" class="form-control">
                                    <option value="">Select Method</option>
                                    @foreach ($paymentMethods as $payment)
                                    <option value="{{$payment->id}}">
                                        {{$payment->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="">Pay Amount</label>
                                <input type="text" class="form-control" readonly disabled
                                    value="{{$data->getCustomer->total_paid ?? '0'}}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="">Due</label>
                                <input type="number" class="form-control dueInpute" readonly disabled
                                    value="{{$data->getCustomer->due ?? '0'}}">
                            </div>

                            <div class="col-md-3 mb-3 payAmount" style="display: none;">
                                <label for="">Payment Amount</label>
                                <input type="number" name="pay_amount" class="form-control ">
                            </div>
                            <div class="col-md-3 mb-3 discountfile" style="display: none;">
                                <label for="">Discount(optional)</label>
                                <input type="number" class="form-control discounts_val"
                                    max="{{$data->getCustomer->bill_amount}}" onkeyup="discounts(this.value)"
                                    name="discount">
                            </div>
                            <div class="col-md-3 mb-3 ">
                                <label for="">Go next Month</label>
                                <select class="form-control" name="next_month">
                                    <option disabled selected>Selected</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 extendDate" style="display: none;">
                                <label for="">Extend date</label>
                                <input type="number" name="extend_date" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Payment Description</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form> --}}

                        <hr>
                        <div class="col-lg-12">
                            <h4 class="card-title">Paid Bill</h4>
                            <table class="table table-bordered table-responsive">
                                <thead class="thead-primary">
                                    <tr>
                                        <th scope="col-2">#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Month</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Pay Amount</th>
                                        <th scope="col">Billing By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalpay = 0;
                                    @endphp
                                    @foreach ($customerPaymentDetails as $key => $customer)
                                        @php
                                            $totalpay += $customer->pay_amount;
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ Carbon\Carbon::parse($customer->updated_at)->format('h:i d,M,Y') }}
                                            </td>
                                            <td>{{ $customer->invoice_name ?? 'N/A' }}</td>
                                            <td>{{ Carbon\Carbon::parse($customer->date_)->format('F') }}</td>
                                            <td>
                                                @if ($customer->payment_method_id == 500)
                                                    <p>Advance Payed
                                                    </p>
                                                @else
                                                    <p>{{ $customer->PaymentMethod->head_code }}-{{ $customer->PaymentMethod->account_name }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>{!! $customer->description !!}</td>
                                            <td>{{ $customer->discount ?? '00' }}</td>
                                            <td>{{ $customer->pay_amount ?? '00' }}
                                            </td>
                                            <td>{{ $customer->getBillinfBy->name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @if ($customerPaymentDetails->isNotEmpty())
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-right">Total:</td>
                                            <td>{{ $totalpay }} TK</td>
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
    <div class="basic-modal">
        <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel1">Payment Bill</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Select Method</h5>
                                    <select name="payment_method_id" class="select2" id="payment_method">
                                        <option disabled selected>Select Payment</option>
                                        @foreach ($paymentMethods as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                            @if ($account->subAccount->isNotEmpty())
                                                @foreach ($account->subAccount as $subaccount)
                                                    <option value="{{ $subaccount->id }}">
                                                        -{{ $subaccount->account_name }}
                                                    </option>
                                                    @if ($subaccount->subAccount->isNotEmpty())
                                                        @foreach ($subaccount->subAccount as $subaccount2)
                                                            <option value="{{ $subaccount2->id }}">
                                                                --{{ $subaccount2->account_name }}</option>
                                                            @if ($subaccount2->subAccount->isNotEmpty())
                                                                @foreach ($subaccount2->subAccount as $subaccount3)
                                                                    <option value="{{ $subaccount3->id }}" disabled>
                                                                        ---{{ $subaccount3->account_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <h5>Invoice Name</h5>
                                    <input type="text" name="invoice_name" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <h5>Bill Amount</h5>
                                    <input type="number" name="amount" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <h5>Discount</h5>
                                    <input type="number" name="discount" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <h5>Remarks</h5>
                                    <textarea name="remarks" class="form-control" id="" cols="20" rows="5"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" name="extend" type="checkbox" value="yes"
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Extend Date ?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Pay Bill</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.paymodel', function() {
            let url = $(this).attr('href');
            $('form').attr('action', url);
        })

        function discounts(e) {
            let amount = "{{ $data->getCustomer->bill_amount }}";
            if (Number(amount) < e) {
                return $('.discounts_val').val('');
            }
            let total = amount - e;
            document.getElementById('service_amount').value = total;
        }

        function payMonth() {
            let pay = $('#paymentMonth option:selected').attr('payamount');
            let amount = $('#paymentMonth option:selected').attr('amount');
            let total = Number(amount) - (pay ? Number(pay) : 0);
            $('.dueInpute').val(total);
        }

        function payType(e) {
            if (e == "full_pay") {
                $(".payMonth").hide();
                $(".payAmount").hide();
                $(".discountfile").hide();
                $(".extendDate").hide();
            } else if (e == "partial") {
                $(".payMonth").show();
                $(".payAmount").show();
                $(".discountfile").show();
                $(".extendDate").show();

            }
        }
    </script>
@endpush
