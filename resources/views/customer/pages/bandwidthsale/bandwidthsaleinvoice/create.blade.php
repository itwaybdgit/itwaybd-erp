@extends('admin.master')


@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Create' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">
                        <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <label>Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" class="form-control">
                                        <option selected disabled>Select</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label>Invoice No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control input-rounded" name="invoice_no"
                                        value="{{ $invoice_no }}">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label>Billing Month <span class="text-danger">*</span></label>
                                    <input type="month" class="form-control input-rounded" name="billing_month"
                                        value="{{ old('billing_month') ?? '' }}">
                                </div>

                                <div class="col-md-3 col-12 mb-1">
                                    <div class="form-group">
                                        <label for="email-id-column">Account Head</label>
                                        <select class="select2 form-control " name="account_id">
                                            <option selected disabled> Selecte Account </option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">({{ $account->head_code }})
                                                    {{ $account->account_name }}</option>
                                                @if ($account->subAccount->isNotEmpty())
                                                    @foreach ($account->subAccount as $subaccount)
                                                        <option value="{{ $subaccount->id }}">
                                                            - ({{ $subaccount->head_code }})
                                                            {{ $subaccount->account_name }}
                                                        </option>
                                                        @if ($subaccount->subAccount->isNotEmpty())
                                                            @foreach ($subaccount->subAccount as $subaccount2)
                                                                <option value="{{ $subaccount2->id }}">
                                                                    -- ({{ $subaccount2->head_code }})
                                                                    {{ $subaccount2->account_name }}</option>
                                                                @if ($subaccount2->subAccount->isNotEmpty())
                                                                    @foreach ($subaccount2->subAccount as $subaccount3)
                                                                        <option value="{{ $subaccount3->id }}" disabled>
                                                                            --- ({{ $subaccount3->head_code }})
                                                                            {{ $subaccount3->account_name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="text-success account-message"></span>
                                    </div>
                                </div>


                                {{-- <div class="col-md-3 mb-1">
                                    <label>Payment Due <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control input-rounded" name="payment_due"
                                        value="{{ old('payment_due') ?? '' }}">
                                </div> --}}


                                <div class="col-md-12 mb-1">
                                    <table class="">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="15%"> Item</th>
                                                <th scope="col"> Description</th>
                                                <th scope="col"> Unit</th>
                                                <th scope="col"> Quantity</th>
                                                <th scope="col"> Rate</th>
                                                <th scope="col"> VAT(%)</th>
                                                <th scope="col"> From Date</th>
                                                <th scope="col"> To Date</th>
                                                <th scope="col"> Total</th>
                                                <th scope="col"> Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <select name="item_id[]" class="form-control item_id">
                                                        <option value="">Select</option>
                                                        @foreach ($items as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="text" name="description[]" class="form-control">
                                                </th>
                                                <th>
                                                    <input type="text" value="0" name="unit[]"
                                                        class="form-control unit" readonly>
                                                </th>
                                                <th>
                                                    <input type="text" value="0" name="qty[]"
                                                        class="form-control qty calculation">
                                                </th>
                                                <th>
                                                    <input type="text" value="0" name="rate[]"
                                                        class="form-control rate calculation">
                                                </th>
                                                <th>
                                                    <input type="text" name="vat[]"
                                                        class="form-control vat calculation">
                                                </th>
                                                <th>
                                                    <input type="date" name="from_date[]"
                                                        class="form-control from_date calculation">
                                                </th>
                                                <th>
                                                    <input type="date" name="to_date[]"
                                                        class="form-control to_date calculation">
                                                </th>
                                                <th>
                                                    <input type="text" value="0" readonly name="total[]"
                                                        class="form-control total">
                                                </th>
                                                <th>
                                                    <button class="btn btn-danger remove">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10" style="text-align: right;">
                                                    <button type="button" class="btn btn-success aligh-right"
                                                        id="addrow">
                                                        Add New
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr style="background-color: darkblue;">
                                                <td colspan="8" style="padding: 15px;"><span>Total</span></td>
                                                <td colspan="2"><input type="text" value="0" id="GrandTotal"
                                                        class="form-control" disabled=""></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" style="font-size: 16px">Remarks/Note</label>
                                <textarea class="form-control" name="remark" id="exampleFormControlTextarea1" rows="3"
                                    placeholder="Remarks"></textarea>
                            </div>

                            <!-- Basic Textarea end -->
                            <div class="mb-1 form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#addrow').on('click', function() {
            const addrow = `
    <tr>
                                            <th>
                                                <select name="item_id[]" class="form-control item_id">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th>
                                                <input type="text" name="description[]" class="form-control">
                                            </th>
                                            <th>
                                                <input type="text" value="0" name="unit[]" class="form-control unit"
                                                    readonly>
                                            </th>
                                            <th>
                                                <input type="text" value="0" name="qty[]" class="form-control qty calculation">
                                            </th>
                                            <th>
                                                <input type="text" value="0" name="rate[]" class="form-control rate calculation">
                                            </th>
                                            <th>
                                                <input type="text" name="vat[]" class="form-control vat calculation">
                                            </th>
                                            <th>
                                                <input type="date" name="from_date[]" class="form-control from_date calculation">
                                            </th>
                                            <th>
                                                <input type="date" name="to_date[]" class="form-control to_date calculation">
                                            </th>
                                            <th>
                                                <input type="text" readonly name="total[]" class="form-control total">
                                            </th>
                                            <th>
                                                <button class="btn btn-danger remove">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </th>
                                        </tr>
              `;

            $('tbody').append(addrow);
        })

        $(document).on('change', '.item_id', function() {
            let thisval = $(this);
            $.ajax({
                'url': "{{ route('bandwidthsaleinvoice.getItemVal') }}",
                'method': "get",
                'dataType': "JSON",
                'data': {
                    item_id: thisval.val()
                },
                success: (data) => {
                    thisval.closest('tr').find('.unit').val(data.unit);
                    thisval.closest('tr').find('.vat').val(data.vat);
                }
            })
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        })

        function totalvalue() {
            let grandtotal = 0;
            $.each($('.total'), function(index, item) {
                total = Number($(item).val());
                grandtotal += total;
                $('#GrandTotal').val(grandtotal);
            });
        }

        function getDay(formday, today) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(formday);
            const secondDate = new Date(today);
            const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)) + 1;
            return diffDays;
        }

        $(document).on('input', '.calculation', function() {
            let unitVal = Number($(this).closest('tr').find('.unit').val());
            let qtyVal = Number($(this).closest('tr').find('.qty').val());
            let rateVal = Number($(this).closest('tr').find('.rate').val());
            let vatVal = Number($(this).closest('tr').find('.vat').val());
            let from_date = $(this).closest('tr').find('.from_date').val() ? $(this).closest('tr').find(
                '.from_date').val() : '2022-12-1';
            let to_date = $(this).closest('tr').find('.to_date').val() ? $(this).closest('tr').find('.to_date')
                .val() : '2022-12-30';
            let countDay = getDay(from_date, to_date);
            let sum = qtyVal * rateVal
            let onedaysalary = sum / 30;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('tr').find('.total').val(total.toFixed(1));

            totalvalue();

        })
    </script>
@endsection
