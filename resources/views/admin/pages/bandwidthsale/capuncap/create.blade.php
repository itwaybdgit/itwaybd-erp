@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Create' }}</h4>
                    <form action="" method="GET" class="form-inline">
                        @csrf
                         <div class="d-flex">
                            <select name="customer" class="form-control select2 w-100" id="customer_down">
                                <option value="">{{ __('Choose One') }}</option>
                                @foreach ($customers as $customer)
                                    <option {{$request->customer == $customer->id ? "selected":""}} value="{{ $customer->id }}">{{ ucfirst($customer->company_name) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary ml-1">{{ __('Submit') }}</button>
                         </div>
                      </form>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>
                    @if ($selectedCustomer)
                    <form action="{{route('capuncap.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="customer" value="{{$request->customer}}">
                     <table id="table3" class="w-100 table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th scope="col" width="20%">
                                    <small class="text-secondary">Item</small>
                                </th>
                                <th scope="col" width="15%">
                                    <small class="text-secondary">Old Quantity</small>
                                </th>
                                <th scope="col" width="15%">
                                    <small class="text-secondary">Quantity</small>
                                </th>
                                <th scope="col" width="15%">
                                    <small class="text-secondary">Total Quantity</small>
                                </th>
                                {{-- <th scope="col" width="15%">
                                    <small class="text-secondary">Price</small>
                                </th>
                                <th scope="col" width="40%">
                                    <small class="text-secondary">Total</small>
                                </th> --}}
                                <th scope="col" width="10%">
                                    <small class="text-secondary">Action</small>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="package">
                            @foreach ($selectedCustomer as $selected)
                                <tr>
                                    <td>
                                        <select name="item_id[]" class="form-control item_id">
                                            @foreach ($items as $item)
                                            @if ($selected->item_id == $item->id)
                                            <option selected value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="{{ $selected->qty }}" name="old_quantity[]"
                                            class="form-control old-quantity calculation" readonly>
                                    </td>
                                    <td>
                                        <input type="number" value="" name="quantity[]"
                                            class="form-control qty calculation"
                                            oninput="calculateTotalQuantity(this)">
                                    </td>
                                    <td>
                                        <input type="number" value="{{ $selected->qty }}" name="total_quantity[]"
                                            class="form-control total-quantity calculation" readonly>
                                    </td>
                                    {{-- <td>
                                        <input type="text" value="{{ $selected->rate }}" name="asking_price[]"
                                            class="form-control rate calculation"
                                            oninput="calculateTotalPrice(this)">
                                    </td>
                                    <td>
                                        <input type="text" value="0" name="total[]"
                                            class="form-control total calculation" readonly>


                                    </td> --}}

                                    <td>
                                        <button class="btn btn-danger remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <input type="number" value="{{ $customer->id }}" name="customer_id"
                            class="form-control total-quantity calculation" hidden>
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><h5>Total:</h5></td>
                                <td colspan="1">
                                    <input type="text" value="" name="total1" class="form-control" readonly>
                                </td>
                            </tr>
                        </tfoot> --}}
                     </table>
                     <div class="col-md-6">
                        Time Limit
                        <input type="datetime-local" class="form-control" name="apply_date" value="{{date('Y-m-d\TH:i')}}" id="">
                     </div>

                      <button class="btn btn-success mt-2">Submit</button>
                    </form>
                     @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-KXzvAuUvV46LbFOkUH6HrADFB3iE0IU9wA2H35VJ/rw=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        calculateTotals();

        // Calculate and display totals when the page loads
        $('.total').on('input', calculateTotal);

        // Calculate total sum when any input field with class 'total' changes
        function calculateTotal() {
            var total = 0;
            $('.total').each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total += value;
                }
            });
            $('input[name="total1"]').val(total.toFixed(2));
        }

        // Calculate and display totals when the page loads
        function calculateTotals() {
            $('.package tr').each(function() {
                var row = $(this);
                var oldQuantity = parseFloat(row.find('.old-quantity').val());
                var totalQuantity = parseFloat(row.find('.total-quantity').val());
                var askingPrice = parseFloat(row.find('.rate').val());
                var total = totalQuantity * askingPrice;

                // Check if both total quantity and asking price are valid numbers
                if (!isNaN(totalQuantity) && !isNaN(askingPrice)) {
                    row.find('.total').val(total.toFixed(2));
                } else {
                    row.find('.total').val('');
                }
            });

            // Calculate the total sum of all 'total1' inputs
            calculateTotal();
        }

        // Function to calculate the total quantity when the quantity input changes
        $('.qty').on('input', function() {
            var row = $(this).closest('tr');
            var oldQuantity = parseFloat(row.find('.old-quantity').val());
            var newQuantity = parseFloat($(this).val());
            var totalQuantity = oldQuantity + newQuantity;
            row.find('.total-quantity').val(totalQuantity);
            calculateTotals();
        });

        // Function to calculate the total price when the price input changes
        $('.rate').on('input', function() {
            var row = $(this).closest('tr');
            var askingPrice = parseFloat($(this).val());
            var totalQuantity = parseFloat(row.find('.total-quantity').val());
            var total = totalQuantity * askingPrice;

            // Check if both total quantity and asking price are valid numbers
            if (!isNaN(totalQuantity) && !isNaN(askingPrice)) {
                row.find('.total').val(total.toFixed(2));
            } else {
                row.find('.total').val('');
            }

            // Recalculate the total when the price input changes
            calculateTotals();
        });
    });
</script>

<script>
    $('#addrow').on('click', function () {

        let vat_value = $("#vat_check option:selected").val();

        const addrow = `
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
                                                    <input type="number" value="0" name="quantity[]"
                                                        class="form-control qty calculation">
                                                </th>
                                                <th>
                                                    <input type="text" value="0" name="asking_price[]"
                                                        class="form-control rate calculation">
                                                </th>
                                                <th class="vatcolumn ${vat_value == "yes" ? "":"d-none" }">
                                                    <input type="text"   name="vat[]"
                                                        class="form-control vat calculation">
                                                </th>

                                                <th>
                                                    <button class="btn btn-danger remove w-100">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                         `;
        $('.package').append(addrow);
    })

    $(document).on('change', '.item_id', function () {
        let thisval = $(this);
        $.ajax({
            'url': "{{route('bandwidthsaleinvoice.getItemVal')}}",
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

    $(document).on('click', '.delete', function () {
        $(this).closest('tr').remove();
    })

    $(document).on('change', '#vat_check', function () {
         let val = $(this).val();
         if(val == 'yes'){
            $('.vatcolumn').removeClass('d-none');
        }else{
             $('.vatcolumn').addClass('d-none');
         }
    })

    $(document).on('click', '.remove', function () {
        $(this).closest('tr').remove();
    })

    // function totalvalue() {
    //     let grandtotal = 0;
    //     $.each($('.total'), function (index, item) {
    //         total = Number($(item).val());
    //         grandtotal += total;
    //         $('#GrandTotal').val(grandtotal);
    //     });
    // }

    $(document).on('input', '.calculation', function () {

        let qtyVal = Number($(this).closest('tr').find('.qty').val());
        let rateVal = Number($(this).closest('tr').find('.rate').val());

        let vat_value = $("#vat_check option:selected").val();

        let vatVal = (vat_value == "yes" ? Number($(this).closest('tr').find('.vat').val()) : 0) ;

        let countDay = 30;
        let sum = qtyVal * rateVal
        let onedaysalary = sum / 30;
        let daySum = onedaysalary * countDay;
        let vat = vatVal / 100 * (daySum);
        let total = (daySum) + vat;

        // $(this).closest('tr').find('.total').val(total.toFixed(1));
        // totalvalue();
    })

     $.each($('.qty'),function(){
        let qtyVal = Number($(this).closest('tr').find('.qty').val());
        let rateVal = Number($(this).closest('tr').find('.rate').val());

        let vat_value = $("#vat_check option:selected").val();

        let vatVal = (vat_value == "yes" ? Number($(this).closest('tr').find('.vat').val()) : 0) ;

        let countDay = 30;
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
