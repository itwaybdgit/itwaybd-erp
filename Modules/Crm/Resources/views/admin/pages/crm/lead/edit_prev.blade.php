@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Edit'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">

                <x-alert></x-alert>

                <div class="basic-form">

                    <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input type="text" value="{{$editinfo->company_name}}" name="company_name" class="form-control" required >
                            </div>

                            <div class="col-md-4 mb-1">
                                <label>Company Owner Name </label>
                                <input type="text" value="{{$editinfo->company_owner_name}}" name="company_owner_name" class="form-control"  >
                            </div>

                            <div class="col-md-4 mb-1">
                                <label>Company Owner Phone </label>
                                <input type="tel" value="{{$editinfo->company_owner_phone}}" name="company_owner_phone" class="form-control"  >
                            </div>

                            <div class="col-md-4 mb-1">
                                <label>Division <span class="text-danger">*</span></label>
                                <select name="division_id" class="form-control select2" required>
                                    <option value="">Select</option>
                                    @foreach ($divisions as $val)
                                    <option {{$editinfo->division_id == $val->id ? "selected":""}} value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label>District <span class="text-danger">*</span></label>
                                <select name="district_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($districts as $val)
                                    <option {{$editinfo->district_id == $val->id ? "selected":""}} value="{{$val->id}}">{{$val->district_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Upazila/Thana <span class="text-danger">*</span></label>
                                <select name="upazila_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($upazilas as $val)
                                    <option {{$editinfo->upazila_id == $val->id ? "selected":""}} value="{{$val->id}}">{{$val->upozilla_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Vill/Road </label>
                                <input type="text" value="{{$editinfo->road}}" name="road" class="form-control" >
                            </div>

                            <div class="col-md-4 mb-1">
                                <label>Latitude </label>
                                <input type="text" value="{{$editinfo->latitude}}" name="latitude" class="form-control">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label>Longitude </label>
                                <input type="text" value="{{$editinfo->longitude}}" name="longitude" class="form-control" >
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Choose Business Type </label>
                                <select name="license_type" class="form-control" >

                                    @php
                                    $licensetype = App\Models\LicenseType::all();
                                   @endphp
                                    <option  value="" selected disabled>Choose  Business type</option>
                                    @foreach ($licensetype as $value)
                                        <option {{$editinfo->license_type == $value->id ? "selected":"" }} value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Choose Recurring Type </label>
                                <select name="recurring_type" class="form-control" required>
                                        <option {{$editinfo->recurring_type == "Project" ? "selected":""}} value="Project">Project</option>
                                        <option {{$editinfo->recurring_type == "Monthly_Subscription" ? "selected":""}} value="Monthly_Subscription">Monthly Subscription</option>
                                        <option {{$editinfo->recurring_type == "Yearly_Subscription" ? "selected":""}} value="Yearly_Subscription">Yearly Subscription</option>
                                </select>
                                @error('recurring_type')
                                    <span class="error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label>House <span class="text-danger">*</span></label>
                                <input type="text" value="{{$editinfo->house}}" name="house" class="form-control" >
                            </div>

                            <div class="col-md-12 mb-1">
                                <table id="table1" class="w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="15%" >
                                                <small class="text-secondary">Contact Person Name</small>
                                            </th>
                                            <th scope="col" width="15%" >
                                                <small class="text-secondary">Contact Person Email</small>
                                            </th>
                                            <th scope="col" width="15%" >
                                                <small class="text-secondary">Contact Person Phone</small>
                                            </th>
                                            <th scope="col" class="text-center" width="5%" >
                                                <small class="text-secondary">Action</small>
                                            </th>
                                        </tr>
                                    </thead>

                                    @php
                                    $contact_person = explode(',',$editinfo->contact_person_name ?? "");
                                    $contact_person_phone = explode(',',$editinfo->contact_person_phone ?? "");
                                    $contact_person_email = explode(',',$editinfo->contact_person_email ?? "");
                                    @endphp

                                    <tbody class="contact_row">
                                      @foreach ($contact_person as $key=>$item)
                                        <tr>
                                            <td>
                                                <input type="text" name="contact_person_name[]" value="{{ $item}}" class="form-control" >
                                            </td>
                                            <td>
                                                <input type="text" name="contact_person_email[]" value="{{ $contact_person_email[$key] ?? ""}}" class="form-control" >
                                            </td>
                                            <td>
                                                <input type="tel" name="contact_person_phone[]" value="{{$contact_person_phone[$key] ?? ""}}"  class="form-control" >
                                            </td>
                                            <td>
                                                <button class="btn btn-danger delete w-100">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8" style="text-align: right;">
                                                <button type="button" class="btn btn-success aligh-right"
                                                    id="newrow">
                                                    Add New
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                                <div class="col-md-4 mb-1">
                                    <label>Customer Address <span class="text-danger">*</span></label>
                                    <input type="text" value="{{$editinfo->customer_address}}" name="customer_address" class="form-control" >
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Customer Priority <span class="text-danger">*</span></label>
                                    <select name="customer_priority" class="form-control" >
                                        <option value="">Select</option>
                                        <option {{$editinfo->customer_priority == "Low" ? "selected":"" }}  value="Low">Low</option>
                                        <option {{$editinfo->customer_priority == "Medium" ? "selected":"" }}  value="Medium">Medium</option>
                                        <option {{$editinfo->customer_priority == "High" ? "selected":"" }}  value="High">High</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Data Source <span class="text-danger">*</span></label>
                                    <select name="data_source" class="form-control" >
                                        <option value="">Select</option>
                                        @foreach ($datasources as $item)
                                        <option {{$editinfo->data_source == $item->id ? "selected":""}} value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Commission <span class="text-danger">*</span></label>
                                    <input type="text" value="{{$editinfo->commission}}" name="commission" class="form-control" >
                                </div>

                                <hr>
                            <div class="col-md-12 mb-1">
                                <table id="table3" class="w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="25%">
                                                <small class="text-secondary" >Item</small>
                                            </th>
                                            <th scope="col" width="20%">
                                                <small class="text-secondary" >Quantity</small>
                                            </th>
                                            <th scope="col" width="25%">
                                                <small class="text-secondary" >Asking Price</small>
                                            </th>

                                            <th scope="col" width="10%">
                                                <small class="text-secondary" >Action</small>
                                            </th>
                                        </tr>
                                    </thead>
                                    @php
                                    $category_id = explode(',',$editinfo->category_id);
                                    $item_id = explode(',',$editinfo->item_id);
                                    $quantity = explode(',',$editinfo->quantity);
                                    $asking_price = explode(',',$editinfo->asking_price);
                                    @endphp
                                    <tbody class="package">
                                        @foreach ($item_id as $key=>$val)
                                        <tr>
                                            <th>
                                                <!-- Category Dropdown -->
                                                <select name="category_id[]" id="category_id"
                                                    class="form-control category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option {{$category_id[$key] == $category->id ? "selected":""}} value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th>
                                                <select name="item_id[]" class="form-control item_id" required>
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                        <option {{$val == $item->id ? "selected":""}} value="{{ $item->id }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th>
                                                <input type="number" value="{{$quantity[$key] ?? 0}}" name="quantity[]"
                                                    class="form-control qty " required>
                                            </th>
                                            <th>
                                                <input type="text" value="{{$asking_price[$key] ?? 0}}" name="asking_price[]"
                                                    class="form-control rate " required>
                                            </th>
                                            <th>
                                                <button class="btn btn-danger remove w-100">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </th>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" style="text-align: right;">
                                                <button type="button" class="btn btn-success aligh-right"
                                                    id="addrow">
                                                    Add New
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            {{-- <div class="col-md-4">
                                <label>Meeting Date</label>
                                <input type="datetime-local" name="meeting_date" value="{{$editinfo->meeting_date}}" class="form-control mb-1" >
                                <label>Meeting Remarks</label>
                                <textarea class="form-control" name="meeting_remarks" id="exampleFormControlTextarea1" rows="3" placeholder="Remarks">{{$editinfo->meeting_remarks}}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label>Follow Up Date</label>
                                <input type="datetime-local" name="follow_up_date" value="{{$editinfo->follow_up_date}}" class="form-control mb-1" >
                                <label>Follow Up Remarks</label>
                                <textarea class="form-control" name="follow_up_remarks" id="exampleFormControlTextarea1" rows="3" placeholder="Remarks">{{$editinfo->follow_up_remarks}}</textarea>
                            </div> --}}
                            <div class="col-md-12">
                                <label>Remarks/Note</label>
                                <textarea class="form-control" name="remark" id="exampleFormControlTextarea1" rows="6" placeholder="Remarks">
                                    {{$editinfo->remark}}
                                </textarea>
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    $('#newrow').on('click', function () {
        const addrow = `<tr>
                                                <td>
                                                    <input type="text" name="contact_person_name[]" class="form-control" >
                                                </td>
                                                <td>
                               <input type="text" name="contact_person_email[]" class="form-control" >
                           </td>
                                                <td>
                                                    <input type="tel" name="contact_person_phone[]" class="form-control" >
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger delete w-100">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
              `;
        $('.contact_row').append(addrow);
    })

    $('#addrow').on('click', function () {
        const addrow = `
        <tr>
                                    <th>
                                                    <!-- Category Dropdown -->
                                                    <select name="category_id[]" id="category_id" class="form-control category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th>
                                                    <!-- Item Dropdown -->
                                                    <select name="item_id[]" id="item_id" class="form-control item_id" required>
                                                        <option value="">Select Item</option>
                                                        <!-- Items will be loaded here based on the selected category -->
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="number" value="0" name="quantity[]"
                                                        class="form-control qty ">
                                                </th>
                                                <th>
                                                    <input type="text" value="0" name="asking_price[]"
                                                        class="form-control rate ">
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
            'data': { item_id: thisval.val() },
            success: (data) => {
                thisval.closest('tr').find('.unit').val(data.unit);
                thisval.closest('tr').find('.vat').val(data.vat);
            }
        })
    });

    $(document).on('click', '.delete', function () {
        $(this).closest('tr').remove();
    })

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
    $(document).on('change', ".category_id", function() {
                let categoryId = $(this).val();
                let $row = $(this).closest("tr"); // Get the current row

                // Clear previous items in the item dropdown
                $row.find('.item_id').html('<option value="">Select Item</option>');

                if (categoryId) {
                    $.ajax({
                        url: '/admin/lead/get-items-by-category/' + categoryId,
                        type: 'GET',
                        success: function(data) {
                            // Populate the item dropdown with new options
                            $.each(data.items, function(key, item) {
                                $row.find('.item_id').append('<option value="' + item
                                    .id + '">' + item.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error in AJAX request:", error);
                        }
                    });
                }
            });
</script>
@endsection
