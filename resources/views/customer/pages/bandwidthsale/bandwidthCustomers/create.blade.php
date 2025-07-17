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
                            <div class="card">
                                <div class="card-header">
                                    <h2>Customer Information</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control input-rounded" name="name"
                                                    value="{{ old('name') ?? '' }}" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Phone <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control input-rounded" name="phone"
                                                    value="{{ old('phone') ?? '' }}" placeholder="Phone">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Code</label>
                                                <input type="text" class="form-control input-rounded" name="code"
                                                    value="{{ old('code') ?? '' }}" placeholder="Code">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Contact Person </label>
                                                <input type="text" class="form-control input-rounded"
                                                    name="contact_person" value="{{ old('contact_person') ?? '' }}"
                                                    placeholder="Contact Person">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Email</label>
                                                <input type="text" class="form-control input-rounded" name="email"
                                                    value="{{ old('email') ?? '' }}" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Mobile </label>
                                                <input type="text" class="form-control input-rounded" name="mobile"
                                                    value="{{ old('mobile') ?? '' }}" placeholder="Mobile">
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Status <span
                                                        class="text-danger">*</span></label>
                                                <select name="status" id="status" class="form-control input-rounded">
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Reference By</label>
                                                <input type="text" class="form-control input-rounded" name="reference_by"
                                                    value="{{ old('reference_by') ?? '' }}" placeholder="reference_by">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase"> Address</label>
                                                <input type="text" class="form-control input-rounded" name="address"
                                                    value="{{ old('address') ?? '' }}" placeholder="address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Remarks</label>
                                                <input type="text" class="form-control input-rounded" name="remarks"
                                                    value="{{ old('remarks') ?? '' }}" placeholder="remarks">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Facebook </label>
                                                <input type="text" class="form-control input-rounded" name="facebook"
                                                    value="{{ old('facebook') ?? '' }}" placeholder="facebook">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Skype ID</label>
                                                <input type="text" class="form-control input-rounded" name="skypeid"
                                                    value="{{ old('skypeid') ?? '' }}" placeholder="skypeid">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Website</label>
                                                <input type="text" class="form-control input-rounded" name="website"
                                                    value="{{ old('website') ?? '' }}" placeholder="website">
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">Image <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" class="form-control input-rounded" name="image">
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h2>Transmission Information</h2>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h2>Noc Information</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">nttn info</label>
                                                <input type="text" class="form-control input-rounded" name="nttn_info"
                                                    value="{{ old('nttn_info') ?? '' }}" placeholder="nttn_info">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">vlan info</label>
                                                <input type="text" class="form-control input-rounded" name="vlan_info"
                                                    value="{{ old('vlan_info') ?? '' }}" placeholder="vlan_info">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">vlan id</label>
                                                <input type="text" class="form-control input-rounded" name="vlan_id"
                                                    value="{{ old('vlan_id') ?? '' }}" placeholder="vlan_id">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">SCR OR LINK ID</label>
                                                <input type="text" class="form-control input-rounded"
                                                    name="scr_or_link_id" value="{{ old('scr_or_link_id') ?? '' }}"
                                                    placeholder="scr_or_link_id">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">activation date</label>
                                                <input type="text" class="form-control input-rounded"
                                                    name="activition_date" value="{{ old('activition_date') ?? '' }}"
                                                    placeholder="activition_date">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">ip address</label>
                                                <input type="text" class="form-control input-rounded" name="ipaddress"
                                                    value="{{ old('ipaddress') ?? '' }}" placeholder="ip address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label class="text-uppercase">pop name</label>
                                                <input type="text" class="form-control input-rounded" name="pop_name"
                                                    value="{{ old('pop_name') ?? '' }}" placeholder="pop_name">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        <div class="card-datatable table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" width="15%"> Item</th>
                                        <th scope="col" width="15%"> Description</th>
                                        <th scope="col" width="15%"> Unit</th>
                                        <th scope="col" width="15%"> Quantity</th>
                                        <th scope="col" width="15%"> Rate</th>
                                        <th scope="col" width="15%"> VAT(%)</th>
                                        {{-- <th scope="col"> From Date</th>
                                         <th scope="col"> To Date</th>
                                        <th scope="col"> Total</th> --}}
                                        <th scope="col" width="15%"> Action</th>
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

                                        {{-- <th>
                                            <input type="text" value="0" readonly name="total[]"
                                                class="form-control total">
                                        </th> --}}
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
                                </tfoot>
                            </table>
                        </div>

                            {{-- <div class="card">
                            <div class="card-header">
                                <h2>Login Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">UserName</label>
                                            <input type="text" class="form-control input-rounded" name="username" value="{{ old('username') ?? ''}}"
                                                placeholder="username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Password *</label>
                                            <input type="password" class="form-control input-rounded" name="password"
                                                placeholder="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label class="text-uppercase">Confirm Password *</label>
                                            <input type="password" class="form-control input-rounded" name="password_confirmation"
                                                placeholder="Re-enter your password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="mb-1 text-right form-group">
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
    $('#addrow').on('click', function () {
        const addrow = `
    <tr>
                                            <th>
                                                <select name="item_id[]" class="form-control item_id">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
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
                                                <button class="btn btn-danger remove">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </th>
                                        </tr>
              `;
        $('tbody').append(addrow);
    })

    $(document).on('change', '.item_id', function () {
        let thisval = $(this);
        $.ajax({
            'url': "{{route('bandwidthsaleinvoice.getItemVal')}}",
            'method': "get",
            'dataType': "JSON",
            'data': { item_id: thisval.val() },
            success: (data) => {
                thisval.closest('tr').find('.unit').val(data.unit);
                thisval.closest('tr').find('.vat').val(data.vat);
            }
        })
    });

    $(document).on('click', '.remove', function () {
        $(this).closest('tr').remove();
    })

    function totalvalue() {
        let grandtotal = 0;
        $.each($('.total'), function (index, item) {
            total = Number($(item).val());
            grandtotal += total;
            $('#GrandTotal').val(grandtotal);
        });
    }
    function getDay(formday,today){

        const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
        const firstDate = new Date(formday);
        const secondDate = new Date(today);
        const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay))+1;
        return  diffDays;
    }

    $(document).on('input', '.calculation', function () {
        let unitVal = Number($(this).closest('tr').find('.unit').val());
        let qtyVal = Number($(this).closest('tr').find('.qty').val());
        let rateVal = Number($(this).closest('tr').find('.rate').val());
        let vatVal = Number($(this).closest('tr').find('.vat').val());
        let from_date = $(this).closest('tr').find('.from_date').val() ? $(this).closest('tr').find('.from_date').val() : '2022-12-1';
        let to_date = $(this).closest('tr').find('.to_date').val() ? $(this).closest('tr').find('.to_date').val() : '2022-12-30' ;
        let countDay = getDay(from_date,to_date);
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
