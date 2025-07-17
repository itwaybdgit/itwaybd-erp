@extends('customer.master')

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
                                    <option {{$request->customer == $customer->id ? "selected":""}} value="{{ $customer->id }}">{{ ucfirst($customer->company_owner_name) }}
                                    </option>
                            </select>
                            <button type="submit" class="btn btn-primary ml-1">{{ __('Submit') }}</button>
                         </div>
                      </form>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>
                    @if ($selectedCustomer)
                    <form action="{{  $store_url }}" method="post">
                        @csrf
                        <input type="hidden" name="customer" value="{{$customer->id}}">
                          <table id="table3" class="  table-responsive">
                                <thead class="p-5">
                                    <tr>
                                        <th scope="col" width="12%">
                                            <small class="text-secondary">Item</small>
                                        </th>
                                        <th scope="col" width="12%">
                                            <small class="text-secondary">Old Quantity</small>
                                        </th>
                                        <th scope="col" width="15%">
                                            <small class="text-secondary">Quantity</small>
                                        </th>
                                        <th scope="col" width="15%">
                                            <small class="text-secondary">Total Quantity</small>
                                        </th>
                                        <th scope="col" width="8%">
                                            <small class="text-secondary">Price</small>
                                        </th>
                                        <th scope="col" width="20%">
                                            <small class="text-secondary">Old MRC</small>
                                        </th>
                                        <th scope="col" width="20%">
                                            <small class="text-secondary">New MRC</small>
                                        </th>
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
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                        <option {{ $selected->item_id == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
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
                                            <td>
                                                <input type="text" readonly value="{{ $selected->rate }}" name="asking_price[]"
                                                    class="form-control rate calculation"
                                                    oninput="calculateTotalPrice(this)">
                                            </td>
                                            <td>
                                                <input type="text" value="0" name="total[]"
                                                    class="form-control old total1 calculation " readonly>


                                            </td>
                                            <td>
                                                <input type="text" value="0" name="total[]"
                                                    class="form-control total calculation" readonly>


                                            </td>

                                            <td>
                                                <button class="btn btn-danger remove">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td> <!-- Colspan 5 for empty cells under "Price" -->
                                        <td colspan="1">
                                            <input type="text" value="" name="total2" class="form-control mt-1" readonly>
                                        </td>
                                        <td colspan="1">
                                            <input type="text" value="" name="total1" class="form-control mt-1" readonly>
                                        </td>
                                        <td colspan="1"></td> <!-- Colspan 1 for empty cell under "Action" -->
                                    </tr>
                                </tfoot>

                            </table>
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
        if (!isNaN(value) ) {
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
           var newQuantity = parseFloat($(this).val());
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
