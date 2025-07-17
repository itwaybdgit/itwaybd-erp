@extends('admin.master')

<style>
    /* .custom-style {
        margin-left: 260px;
    } */
    @media screen and (min-width: 1200px) {
        .custom-style {
            margin-left: -260px;
        }
    }

    .main-body {
        padding: 15px;
    }

    .card {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col,
    .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }

    .mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }

    .h-100 {
        height: 100% !important;
    }

    .shadow-none {
        box-shadow: none !important;
    }

    th {
        padding: 10 5 !important;
    }
</style>

@section('content')
    <div class="row">
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('General Information') }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-striped" style="font-size: 0.8rem;">
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Company Name') }}</th>
                                        <td class="col-8 px-1">{{ $customer->company_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Name Of Client') }}</th>
                                        <td class="col-8 px-1">
                                            <span>{{ $customer->company_owner_name ?? 'N/A' }} :
                                                {{ $customer->company_owner_phone ?? 'N/A' }}</span>
                                            {{-- <span>|</span>
                                    <span></span> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Contact Info') }}</th>
                                        <td class="col-8 px-1">
                                            @php
                                                $contactname = explode(',', $customer->contact_person_name);
                                                $contactnumber = explode(',', $customer->contact_person_phone);
                                            @endphp
                                            @foreach ($contactname as $key => $name)
                                                @if ($name)
                                                    <p class="py-0 my-0">{{ $name }} : {{ $contactnumber[$key] }}
                                                    </p>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Email Info') }}</th>
                                        <td class="col-8 px-1">
                                            @php
                                                $contactname = explode(',', $customer->contact_person_name);
                                                $contactemail = explode(',', $customer->contact_person_email);
                                            @endphp
                                            @foreach ($contactname as $key => $name)
                                                @if ($name)
                                                    <p class="py-0 my-0">{{ $name }} : {{ $contactemail[$key] ?? "" }}
                                                    </p>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1 mt-0 pt-0">{{ __('Registered Address') }}</th>
                                        <td class="col-8 px-1">
                                            <span>House: {{ $customer->house }}, Road: {{ $customer->road }},
                                                {{ $customer->customer_address }}</span>
                                            <br>
                                            <span>Upazilla: {{ $customer->upazilla->upozilla_name ?? '' }}, District:
                                                {{ $customer->district->district_name ?? '' }}, Division:
                                                {{ $customer->division->name ?? '' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('License') }}</th>
                                        <td class="col-8 px-1">{{ $customer->licensetype->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Provider') }}</th>
                                        <td class="col-8 px-1">{{ $customer->provider ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-1">
                        <form action="{{ route('bandwidthsaleinvoice.update', $banseidthsaleinvoice->id) }}" method="post">
                            @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="padding: 10 5 !important;" width="20%"> Company</th>
                                        <th style="padding: 10 5 !important;" width="12%"> Item</th>
                                        <th style="padding: 10 5 !important;" width="8%"> Quantity</th>
                                        <th style="padding: 10 5 !important;" width="8%"> Rate</th>
                                        <th style="padding: 10 5 !important;" width="5%"> VAT(%)</th>
                                        <th style="padding: 10 5 !important;" width="12%"> From Date</th>
                                        <th style="padding: 10 5 !important;" width="12%"> To Date</th>
                                        <th style="padding: 10 5 !important;" width="20%"> Total</th>
                                        <th style="padding: 10 5 !important;" width="20%"> Total</th>
                                    </tr>
                                </thead>

                                <tbody class="package-table">
                                    @foreach ($banseidthsaleinvoice->detaile as $value)
                                        <tr>
                                            <td>
                                                <select name="business_id[]" class="form-control">
                                                    @foreach ($businesses as $item)
                                                        <option {{$value->business_id == $item->id ? "selected":""}} value="{{ $item->id }}">{{ $item->business_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th>
                                                <select name="item_id[]" class="form-control d-none item_id">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                        <option {{ $value->item_id == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }} </option>
                                                    @endforeach
                                                </select>
                                                {{ $value->getItem->name ?? '' }}
                                            </th>

                                            <th>
                                                <input type="text" value="{{ $value->qty ?? '' }}" name="qty[]"
                                                    class="form-control  qty calculation">
                                            </th>
                                            <th>
                                                <input type="text" value="{{ $value->rate ?? '' }}" name="rate[]"
                                                    class="form-control  rate calculation">
                                            </th>
                                            <th>
                                                {{ $value->vat ?? '' }}
                                                <input type="text" value="{{ $value->vat ?? '' }}" name="vat[]"
                                                    class="form-control d-none vat calculation">
                                            </th>
                                            <th>
                                                <input type="date"
                                                    value="{{ $value->from_date }}"
                                                    name="from_date[]" class="form-control from_date calculation">
                                            </th>
                                            <th>
                                                <input type="date"
                                                    value="{{ $value->to_date }}"
                                                    name="to_date[]" class="form-control to_date calculation">
                                            </th>
                                            <th>
                                                <input type="text" value="{{$value->total}}" readonly name="total[]"
                                                    class="form-control total">
                                            </th>
                                            <th>
                                                <button type="button" class="btn btn-danger remove-row">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10" style="text-align: right;">
                                            <button type="button" class="btn btn-success aligh-right" id="addrow">
                                                Add New
                                            </button>
                                        </td>
                                    </tr>
                                    <tr style="background-color: rgb(194, 194, 194);">
                                        <td colspan="7"><span>Total</span></td>
                                        <td><input type="text" value="0" id="GrandTotal" class="form-control"
                                                disabled=""></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="row mt-3 mb-3">
                                <div class="col-12">
                                    <label for="">Remark</label>
                                    <textarea name="remarks" class="form-control"  id="" cols="30" rows="5">{{ $banseidthsaleinvoice->remark}}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info text-right">Submit</button>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
            $(document).on('click', '.remove-row', function() {
    $(this).closest('tr').remove();
});

        $('#addrow').on('click', function() {
            const addrow = `
            <tr>
                                            <td>
                                                <select name="business_id[]" class="form-control">
                                                    @foreach ($businesses as $item)
                                                        <option value="{{ $item->id }}">{{ $item->business_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th>

                                                <select name="item_id[]" class="form-control  item_id">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                        <option
                                                            value="{{ $item->id }}">{{ $item->name }} </option>
                                                    @endforeach
                                                </select>

                                            </th>

                                            <th>

                                                <input type="text" value="" name="qty[]"
                                                    class="form-control  qty calculation">
                                            </th>
                                            <th>

                                                <input type="text" value="" name="rate[]"
                                                    class="form-control  rate calculation">
                                            </th>
                                            <th>

                                                <input type="text" value="" name="vat[]"
                                                    class="form-control  vat calculation">
                                            </th>
                                            <th>
                                                <input type="date"
                                                    value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}"
                                                    name="from_date[]" class="form-control from_date calculation">
                                            </th>
                                            <th>
                                                <input type="date"
                                                    value="{{ Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d') }}"
                                                    name="to_date[]" class="form-control to_date calculation">
                                            </th>
                                            <th>
                                                <input type="text" value="0" readonly name="total[]"
                                                    class="form-control total">
                                            </th>
                                            <th>
                                                <button type="button" class="btn btn-danger remove-row">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </th>
                                        </tr>
              `;

            $('.package-table').append(addrow);
        })

        function totalvalue() {
            let grandtotal = 0;
            $.each($('.total'), function(index, item) {
                total = Number($(item).val());
                grandtotal += total;
                $('#GrandTotal').val(grandtotal.toFixed(2));
            });
        }

        function getLong(formday, today) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(formday);
            const secondDate = new Date(today);
            let diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)) + 1;
            if(diffDays >= 30){
                diffDays = 30
            }else{
                diffDays = 31
            }

            return diffDays;
        }

        function getDay(formday, today) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(formday);
            const secondDate = new Date(today);
            let diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)) + 1;
            if(diffDays >= 30){
                diffDays = 30
            }

            return diffDays;
        }

        $.each($('.item_id'), function() {
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
           let onedaysalary = sum / getLong(from_date,to_date);
           let daySum = onedaysalary * countDay;
           let vat = vatVal / 100 * (daySum);
           let total = (daySum) + vat;
           $(this).closest('tr').find('.total').val(total.toFixed(1));
           totalvalue();
        });
        // totalvalue();

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
           let onedaysalary = sum / getLong(from_date,to_date);
           let daySum = onedaysalary * countDay;
           let vat = vatVal / 100 * (daySum);
           let total = (daySum) + vat;
           $(this).closest('tr').find('.total').val(total.toFixed(1));
           totalvalue();
         })
    </script>
@endsection
