@extends('admin.master')
<style>
    /* Add gap between input fields */
    .th[type="number"],
    .th input[type="text"] {
        gap: 100px;
        /* Adjust as needed */
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
    display: block;
    padding-left: 8px;
    padding-right: 20px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 300px;
}
</style>

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
                        <form action="{{ route('discontinue.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Customer</label>
                                    <select name="customer_id" class="form-control select2 w-100" id="customer_down">
                                        <option value="">{{ __('Choose One') }}</option>
                                        @foreach ($customers as $customer)
                                            <option {{ $request->customer == $customer->id ? 'selected' : '' }}
                                                value="{{ $customer->id }}">{{ ucfirst($customer->company_name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Apply Date</label>
                                    <input type="date" name="apply_date" value="{{date('Y-m-d')}}" class="form-control">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-12">
                                    <label for="">Reason</label>
                                 <textarea name="reason" class="form-control" cols="20" rows="3"></textarea>
                                </div>
                            </div>



                            <button class="btn btn-success mt-2">Submit</button>
                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-KXzvAuUvV46LbFOkUH6HrADFB3iE0IU9wA2H35VJ/rw=" crossorigin="anonymous"></script>





@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-KXzvAuUvV46LbFOkUH6HrADFB3iE0IU9wA2H35VJ/rw=" crossorigin="anonymous"></script>

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
                var oldMRCtotal = 0; // Variable to store total Old MRC
                var newMRCtotal = 0; // Variable to store total New MRC

                $('.package tr').each(function() {
                    var row = $(this);
                    var oldQuantity = parseFloat(row.find('.old-quantity').val());
                    var askingPrice = parseFloat(row.find('.rate').val());
                    var oldMRC = oldQuantity * askingPrice; // Calculate old MRC for this row

                    if (!isNaN(oldMRC)) {
                        oldMRCtotal += oldMRC; // Add old MRC for this row to the total
                    }

                    // Set value for Old MRC field in this row
                    row.find('.old').val(oldMRC.toFixed(2));

                    var totalQuantity = parseFloat(row.find('.total-quantity').val());
                    var newMRC = totalQuantity * askingPrice; // Calculate new MRC for this row

                    if (!isNaN(newMRC)) {
                        newMRCtotal += newMRC; // Add new MRC for this row to the total
                    }
                    row.find('.total').val(newMRC.toFixed(2)); // Set value for New MRC field in this row
                });

                $('input[name="total2"]').val(oldMRCtotal.toFixed(2)); // Set the total Old MRC
                $('input[name="total1"]').val(newMRCtotal.toFixed(2)); // Set the total New MRC
                calculateTotal(); // Recalculate the total sum
            }

            // Function to calculate the total quantity when the quantity input changes
            $('.qty').on('input', function() {
                var row = $(this).closest('tr');
                var oldQuantity = parseFloat(row.find('.old-quantity').val());
                let val = ($(this).val() == "") ? 0 : $(this).val();
                var newQuantity = parseFloat(val);
                var totalQuantity = oldQuantity + newQuantity; // Calculate total quantity
                row.find('.total-quantity').val(totalQuantity); // Set total quantityd
                calculateTotals(); // Recalculate totals
            });

            // Function to calculate the total quantity when the quantity input changes
            $('.minusqty').on('input', function() {
                var row = $(this).closest('tr');
                var oldQuantity = parseFloat(row.find('.old-quantity').val());
                let val = ($(this).val() == "") ? 0 : $(this).val();
                console.log(val);
                var newQuantity = parseFloat(val);
                var totalQuantity = oldQuantity - newQuantity; // Calculate total quantity
                row.find('.total-quantity').val(totalQuantity); // Set total quantity
                calculateTotals(); // Recalculate totals
            });

            // Function to calculate the total price when the price input changes
            $('.rate').on('input', function() {
                calculateTotals(); // Recalculate totals
            });
        });
    </script>





    <script>
        $('#addrow').on('click', function() {

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

        $(document).on('click', '.delete', function() {
            $(this).closest('tr').remove();
        })

        $(document).on('change', '#vat_check', function() {
            let val = $(this).val();
            if (val == 'yes') {
                $('.vatcolumn').removeClass('d-none');
            } else {
                $('.vatcolumn').addClass('d-none');
            }
        })

        $(document).on('click', '.remove', function() {
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

        // $(document).on('input', '.calculation', function () {

        //     let qtyVal = Number($(this).closest('tr').find('.qty').val());
        //     let rateVal = Number($(this).closest('tr').find('.rate').val());

        //     let vat_value = $("#vat_check option:selected").val();

        //     let vatVal = (vat_value == "yes" ? Number($(this).closest('tr').find('.vat').val()) : 0) ;

        //     let countDay = 30;
        //     let sum = qtyVal * rateVal
        //     let onedaysalary = sum / 30;
        //     let daySum = onedaysalary * countDay;
        //     let vat = vatVal / 100 * (daySum);
        //     let total = (daySum) + vat;

        //     $(this).closest('tr').find('.total').val(total.toFixed(1));
        //     totalvalue();
        // })

        $.each($('.qty'), function() {
            let qtyVal = Number($(this).closest('tr').find('.qty').val());
            let rateVal = Number($(this).closest('tr').find('.rate').val());

            let vat_value = $("#vat_check option:selected").val();

            let vatVal = (vat_value == "yes" ? Number($(this).closest('tr').find('.vat').val()) : 0);

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
