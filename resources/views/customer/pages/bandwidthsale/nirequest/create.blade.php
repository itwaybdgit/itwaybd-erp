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
                <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_down">Customer:</label>
                                    <select name="customer" class="form-control select2">
                                        <option value="">{{ __('Choose One') }}</option>
                                        @foreach ($customers as $customer)
                                        <option {{ $request->customer == $customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ ucfirst($customer->company_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apply_date">Apply Date:</label>
                                    <input type="date" name="apply_date" value="{{date('Y-m-d')}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="table3" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="25%"><small class="text-secondary">Item</small></th>
                                            <th scope="col" width="20%"><small class="text-secondary">Quantity</small></th>
                                            <th scope="col" width="25%"><small class="text-secondary">Asking Price</small></th>
                                            <th scope="col" width="10%"><small class="text-secondary">Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody class="package">
                                        <tr>
                                            <td>
                                                <select name="item_id[]" class="form-control item_id">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" value="0" name="quantity[]" class="form-control qty calculation">
                                            </td>
                                            <td>
                                                <input type="text" value="0" name="asking_price[]" class="form-control rate calculation">
                                            </td>
                                            <td>
                                                <button class="btn btn-danger remove"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">
                                                <button type="button" class="btn btn-success" id="addrow">Add New</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Add new row
        $('#addrow').on('click', function () {
            const newRow = `
                <tr>
                    <td>
                        <select name="item_id[]" class="form-control item_id">
                            <option value="">Select</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" value="0" name="quantity[]" class="form-control qty calculation">
                    </td>
                    <td>
                        <input type="text" value="0" name="asking_price[]" class="form-control rate calculation">
                    </td>
                    <td>
                        <button class="btn btn-danger remove"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>`;
            $('.package').append(newRow);
        });

        // Remove row
        $(document).on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });

        // Calculate total on quantity or price change
        $('.calculation').on('input', function () {
            let qtyVal = parseFloat($(this).closest('tr').find('.qty').val());
            let rateVal = parseFloat($(this).closest('tr').find('.rate').val());

            let total = isNaN(qtyVal) || isNaN(rateVal) ? 0 : qtyVal * rateVal;
            $(this).closest('tr').find('.total').val(total.toFixed(2));
        });
    });
</script>
@endsection
