@extends('admin.master')

@section('content')
    <div class="row text-center">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>

                </div>
                <div class="card-body">
                    <x-alert></x-alert>
                    <h5>Package</h5>
                    <table class="table table-sm" id="packageTable">
                        <form id="packageForm" method="POST" action="{{ route('upgradation.update', $upgradation->id) }}">
                            @csrf
                            @method('PUT')
                        <thead>
                            <tr>
                                <th scope="col">
                                    <small class="text-secondary">Item</small>
                                </th>
                                <th scope="col">
                                    <small class="text-secondary">Old Quantity</small>
                                </th>
                                <th scope="col">
                                    <small class="text-secondary">Quantity</small>
                                </th>
                                <th scope="col">
                                    <small class="text-secondary">New Quantity</small>
                                </th>
                                <th scope="col">
                                    <small class="text-secondary">Price</small>
                                </th>
                                <th scope="col">
                                    <small class="text-secondary">Old Amount</small>
                                </th>
                                <th scope="col">
                                    <small class="text-secondary">New Amount</small>
                                </th>
                            </tr>
                        </thead>
                        @php
                        $oldtotal = 0;
                        $total = 0;
                        $qty = 0;
                        $oldqty = 0;
                        $newqty = 0;
                    @endphp
                    @foreach ($package->item_id as $key => $value)
                        @php
                            $item = App\Models\Item::find($value);
                            $oldsubtotal = $package->old_quantity[$key] * $package->asking_price[$key];
                            $subtotal = ($package->old_quantity[$key] + $package->quantity[$key]) * $package->asking_price[$key];
                            $oldtotal += $oldsubtotal;
                            $total += $subtotal;
                            $oldqty += $package->old_quantity[$key];
                            $newqty += $package->old_quantity[$key] + $package->quantity[$key];
                            $qty += $package->quantity[$key];
                        @endphp
                        <tr>
                            <td>
                                <select name="item_id[]" class="form-control item_id">
                                    <option value="">Select</option>
                                    @foreach ($items as $item)
                                        <option {{ $value == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" value="{{ $package->old_quantity[$key] ?? '' }}" name="old_quantity[]"
                                    class="form-control old-quantity calculation" readonly>
                            </td>
                            <td>
                                <input type="number" value="{{ $package->quantity[$key] ?? '' }}" name="quantity[]"
                                    class="form-control qty calculation" oninput="calculateTotalQuantity(this)">
                            </td>
                            <td>
                                <input type="number" value="{{ $package->old_quantity[$key] + $package->quantity[$key] ?? '' }}" name="total_quantity[]"
                                    class="form-control total-quantity calculation" readonly>
                            </td>
                            <td>
                                <input type="text" value="{{ $package->asking_price[$key] ?? '' }}" readonly name="asking_price[]"
                                    class="form-control rate calculation" oninput="calculateTotalPrice(this)">
                            </td>
                            <td>
                                <input type="text" value="{{ $oldsubtotal ?? '' }}" name="old_total[]"
                                    class="form-control old total1 calculation " readonly>
                            </td>
                            <td>
                                <input type="text" value="{{ $subtotal ?? '' }} " name="total[]"
                                    class="form-control total calculation" readonly>
                            </td>
                            {{-- <td>
                                <button type="button" class="btn btn-sm btn-danger deleteRow">Delete</button>
                            </td> --}}
                        </tr>

                    @endforeach

                    <tfoot>
                        <tr>
                            <td>Total:</td>
                            <td>{{ $oldqty }}</td>
                            <td>{{ $qty }}</td>
                            <td>{{ $newqty }}</td>
                            <td></td>
                            <td>{{ $oldtotal }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    </tfoot>



                </table>
                <div class="col-md-6 mt-4">
                    <label for="">Apply Date</label>
                    <input type="date" name="apply_date" value={{ $upgradation->apply_date }} class="form-control">
                </div>
                <button type="submit"  class="btn btn-info d-flex justify-content-start mt-2"> Update</button>

            </div>

            </div>
        </div>

    </div>
</form>
@endsection

@section('scripts')
<script>
      $('#packageTable').on('click', '.deleteRow', function() {
            $(this).closest('tr').remove(); // Remove the closest row
            calculateFooterTotals(); // Recalculate totals
        });
</script>
<script>
    function calculateTotalQuantity(input) {
        var row = $(input).closest("tr");
        var oldQuantity = parseFloat(row.find(".old-quantity").val()) || 0;
        var newQuantity = parseFloat(row.find(".qty").val()) || 0;
        var totalQuantity = oldQuantity + newQuantity;
        row.find(".total-quantity").val(totalQuantity);
        calculateAmount(row);
        calculateFooterTotals();
    }

    function calculateTotalPrice(input) {
        var row = $(input).closest("tr");
        calculateAmount(row);
        calculateFooterTotals();
    }

    function calculateAmount(row) {
        var askingPrice = parseFloat(row.find(".rate").val()) || 0;
        var totalQuantity = parseFloat(row.find(".total-quantity").val()) || 0;
        var amount = askingPrice * totalQuantity;
        row.find(".total").val(amount.toFixed(2));
    }

    function calculateFooterTotals() {
        var oldTotal = 0;
        var total = 0;
        var oldQty = 0;
        var newQty = 0;
        var qty = 0;
        $(".old-quantity").each(function() {
            oldQty += parseFloat($(this).val()) || 0;
        });
        $(".qty").each(function() {
            qty += parseFloat($(this).val()) || 0;
        });
        $(".total-quantity").each(function() {
            newQty += parseFloat($(this).val()) || 0;
        });
        $(".old.total1").each(function() {
            oldTotal += parseFloat($(this).val()) || 0;
        });
        $(".total").each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $("tfoot td:eq(1)").text(oldQty);
        $("tfoot td:eq(2)").text(qty);
        $("tfoot td:eq(3)").text(newQty);
        $("tfoot td:eq(5)").text(oldTotal.toFixed(2));
        $("tfoot td:eq(6)").text(total.toFixed(2));
    }
</script>

@endsection
