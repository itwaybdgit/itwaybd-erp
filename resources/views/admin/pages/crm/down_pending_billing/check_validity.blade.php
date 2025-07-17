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
        {{-- <div class="col-xl-12 col-lg-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Show' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <form action="{{$store_url}}" method="post" enctype=multipart/form-data>
                    @csrf
                <div class="card-body">

                </div>
               </form>
            </div>
        </div> --}}
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
                                        <td class="col-8 px-1">{{ $customerDetail->company_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Name Of Client') }}</th>
                                        <td class="col-8 px-1">
                                            <span>{{ $customerDetail->company_owner_name ?? 'N/A' }} :
                                                {{ $customerDetail->company_owner_phone ?? 'N/A' }}</span>
                                            {{-- <span>|</span>
                                    <span></span> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Contact Info') }}</th>
                                        <td class="col-8 px-1">
                                            @php
                                                $contactname = explode(',', $customerDetail->contact_person_name);
                                                $contactnumber = explode(',', $customerDetail->contact_person_phone);
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
                                        <th class="col-4 px-1 mt-0 pt-0">{{ __('Registered Address') }}</th>
                                        <td class="col-8 px-1">
                                            <span>House: {{ $customerDetail->house }}, Road: {{ $customerDetail->road }},
                                                {{ $customerDetail->customer_address }}</span>
                                            <br>
                                            <span>Upazilla: {{ $customerDetail->upazilla->upozilla_name ?? '' }}, District:
                                                {{ $customerDetail->district->district_name ?? '' }}, Division:
                                                {{ $customerDetail->division->name ?? '' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('License') }}</th>
                                        <td class="col-8 px-1">{{ $customerDetail->licensetype->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Provider') }}</th>
                                        <td class="col-8 px-1">{{ $customerDetail->provider ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-1">
                        <form action="{{ route('upgradtion_pending_billing.confirm', $customerDetail->id) }}"
                            method="post">
                            @csrf
                            <h4>Current Package</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        {{-- <th style="padding: 10 5 !important;" width="20%"> Company</th> --}}
                                        <th style="padding: 10 5 !important;" width="12%"> Item</th>
                                        <th style="padding: 10 5 !important;" width="8%"> Quantity</th>
                                        <th style="padding: 10 5 !important;" width="8%"> Rate</th>
                                        <th style="padding: 10 5 !important;" width="5%"> VAT(%)</th>
                                        <th style="padding: 10 5 !important;" width="12%"> From Date</th>
                                        <th style="padding: 10 5 !important;" width="12%"> To Date</th>
                                        <th style="padding: 10 5 !important;" width="20%"> Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($customerDetail->package as $value)
                                        <tr>
                                            {{-- <td >
                                        <select name="business_id[]" class="form-control">
                                            @foreach ($businesses as $item)
                                            <option value="{{$item->id}}">{{$item->business_name}}</option>
                                            @endforeach
                                        </select>
                                    </td> --}}
                                            <th>
                                                <select name="item_id[]" class="form-control d-none item_id">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                        <option {{ $value->item_id == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }} </option>
                                                    @endforeach
                                                </select>
                                                {{ $value->item->name ?? '' }}
                                            </th>

                                            <th>
                                                {{ $value->qty ?? '' }}
                                                <input type="text" value="{{ $value->qty ?? '' }}" name="qty[]"
                                                    class="form-control d-none qty calculation">
                                            </th>
                                            <th>
                                                {{ $value->rate ?? '' }}
                                                <input type="text" value="{{ $value->rate ?? '' }}" name="rate[]"
                                                    class="form-control d-none rate calculation">
                                            </th>
                                            <th>
                                                {{ $value->vat ?? '' }}
                                                <input type="text" value="{{ $value->vat ?? '' }}" name="vat[]"
                                                    class="form-control d-none vat calculation">
                                            </th>
                                            <th>

                                                <input type="date"
                                                    value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}"
                                                    name="from_date[]" class="form-control from_date calculation">
                                            </th>
                                            <th>
                                                <input type="date" value="{{ date('Y-m-d', strtotime('-1 day')) }}"
                                                    name="to_date[]" class="form-control to_date calculation">
                                            </th>
                                            <th>
                                                <input type="text" value="0" readonly name="total[]"
                                                    class="form-control total">
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: rgb(194, 194, 194);">
                                        <td colspan="6"><span>Total</span></td>
                                        <td><input type="text" value="0" id="GrandTotalold" class="form-control"
                                                disabled=""></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <h4 class="mt-3">New Package</h4>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($package->item_id as $key => $value)
                                        @php
                                            $iteml = App\Models\Item::find($package->item_id[$key]);
                                        @endphp
                                        <tr>
                                            <td>
                                                <select name="business_idnew[]" class="form-control">
                                                    @foreach ($businesses as $item)
                                                        <option value="{{ $item->id }}">{{ $item->business_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th>
                                                <select name="item_idnew[]" class="form-control d-none item_idnew">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                        <option {{ $iteml->id == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }} </option>
                                                    @endforeach
                                                </select>
                                                {{ $iteml->name ?? '' }}
                                            </th>

                                            <th>
                                                {{ $package->old_quantity[$key] + $package->quantity[$key] ?? '' }}
                                                <input type="text"
                                                    value="{{ $package->old_quantity[$key] - $package->quantity[$key] ?? '' }}"
                                                    name="qtynew[]" class="form-control d-none qtynew calculationnew">
                                            </th>
                                            <th>
                                                {{ $package->asking_price[$key] ?? '' }}
                                                <input type="text" value="{{ $package->asking_price[$key] ?? '' }}"
                                                    name="ratenew[]" class="form-control d-none ratenew calculationnew">
                                            </th>
                                            <th>
                                                0
                                                <input type="text" value="{{ $value->vat ?? 0 }}" name="vatnew[]"
                                                    class="form-control d-none vatnew calculationnew">
                                            </th>
                                            <th>

                                                <input type="date" value="{{ date('Y-m-d') }}" name="from_datenew[]"
                                                    class="form-control from_datenew calculationnew">
                                            </th>
                                            <th>
                                                <input type="date"
                                                    value="{{ Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d') }}"
                                                    name="to_datenew[]" class="form-control to_datenew calculationnew">
                                            </th>
                                            <th>
                                                <input type="text" value="0" readonly name="totalnew[]"
                                                    class="form-control totalnew">
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
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
                                    <textarea name="remarks" class="form-control" id="" cols="30" rows="5"></textarea>
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
        function totalvalue() {
            let grandtotal = 0;
            $.each($('.total'), function(index, item) {
                total = Number($(item).val());
                grandtotal += total;
                $('#GrandTotalold').val(grandtotal.toFixed(2));
            });
        }

        function totalvaluenew() {
            let grandtotal = 0;
            $.each($('.totalnew'), function(index, item) {
                total = Number($(item).val());
                grandtotal += total;
                $('#GrandTotal').val(grandtotal.toFixed(2));
            });
        }

        function getDay(formday, today) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(formday);
            const secondDate = new Date(today);
            const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)) + 1;
            return diffDays;
        }


        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        let datecount = getDay(firstDay, lastDay);

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
            let onedaysalary = sum / datecount;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('tr').find('.total').val(total.toFixed(1));

            totalvalue();
        });

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
            let onedaysalary = sum / datecount;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('tr').find('.total').val(total.toFixed(1));

            totalvalue();
        })

        $.each($('.item_idnew'), function() {
            let unitVal = Number($(this).closest('tr').find('.unitnew').val());
            let qtyVal = Number($(this).closest('tr').find('.qtynew').val());
            let rateVal = Number($(this).closest('tr').find('.ratenew').val());
            let vatVal = Number($(this).closest('tr').find('.vatnew').val());
            let from_date = $(this).closest('tr').find('.from_datenew').val() ? $(this).closest('tr').find(
                '.from_datenew').val() : '2022-12-1';
            let to_date = $(this).closest('tr').find('.to_datenew').val() ? $(this).closest('tr').find(
                '.to_datenew').val() : '2022-12-30';
            let countDay = getDay(from_date, to_date);
            let sum = qtyVal * rateVal
            let onedaysalary = sum / datecount;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('tr').find('.totalnew').val(total.toFixed(1));

            totalvaluenew();
        });

        $(document).on('input', '.calculationnew', function() {

            let unitVal = Number($(this).closest('tr').find('.unitnew').val());
            let qtyVal = Number($(this).closest('tr').find('.qtynew').val());
            let rateVal = Number($(this).closest('tr').find('.ratenew').val());
            let vatVal = Number($(this).closest('tr').find('.vatnew').val());
            let from_date = $(this).closest('tr').find('.from_datenew').val() ? $(this).closest('tr').find(
                '.from_datenew').val() : '2022-12-1';
            let to_date = $(this).closest('tr').find('.to_datenew').val() ? $(this).closest('tr').find(
                '.to_datenew').val() : '2022-12-30';
            let countDay = getDay(from_date, to_date);
            let sum = qtyVal * rateVal
            let onedaysalary = sum / datecount;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('tr').find('.totalnew').val(total.toFixed(1));

            totalvaluenew();
        })
    </script>
@endsection
