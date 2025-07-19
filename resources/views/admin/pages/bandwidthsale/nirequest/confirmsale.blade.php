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
</style>

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Show' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <form action="{{ $store_url }}" method="post" enctype=multipart/form-data>
                    @csrf
                    <div class="card-body">
                        <div class="bs-stepper">
                            <div class="bs-stepper-header" role="tablist">
                                <!-- your steps here -->
                                <div class="step" data-target="#price">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="price"
                                        id="#price-trigger">
                                        <span class="bs-stepper-circle">1</span>
                                        <span class="bs-stepper-label">Final Price</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#contact">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="contact"
                                        id="contact-trigger">
                                        <span class="bs-stepper-circle">2</span>
                                        <span class="bs-stepper-label">Contact</span>
                                    </button>
                                </div>
                                <div class="line"></div>

                                <div class="line"></div>
                                <div class="step" data-target="#legalinfo">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="legalinfo"
                                        id="legalinfo-trigger">
                                        <span class="bs-stepper-circle">5</span>
                                        <span class="bs-stepper-label">Legal Information</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content custom-style">
                                <!-- Price-->
                                <div id="price" class="content" role="tabpanel" aria-labelledby="price-trigger">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <label for="">Vat</label>
                                            <select class="form-control" name="vat_check" id="vat_check">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                    @php
                                    $pack = json_decode($editinfo->package);
//                                        $category_id = explode(',', $editinfo->package->category_id);
//                                        $item_id = explode(',', json_decode($editinfo->package)->item_id);
//                                        $quantity = explode(',', $editinfo->package->qty);
//                                        $asking_price = explode(',', $editinfo->package->rate);
                                    $item_id = $pack->item_id;
                                    $quantity = $pack->quantity;
                                    $asking_price = $pack->asking_price;

//                                    @foreach ($item_id as $index => $id)
//                                        Item ID: {{ $id }},
//                                        Quantity: {{ $quantity[$index] ?? '-' }},
//                                        Asking Price: {{ $asking_price[$index] ?? '-' }} <br>
//                                    @endforeach


                                    @endphp
                                    @foreach ($item_id as $key => $val)
                                        @php
                                            $itemvat = App\Models\Item::find($val);
                                        @endphp

                                        <div class="row" style="background: #ededed; padding: 20px; margin-bottom:10px">
                                            <!-- Category -->
{{--                                            <div class="col-md-3">--}}
{{--                                                <label for="">Category</label>--}}
{{--                                                <select name="category_id[]" id="category_id"--}}
{{--                                                    class="form-control category_id" required>--}}
{{--                                                    <option value="">Select Category</option>--}}
{{--                                                    @foreach ($categories as $category)--}}
{{--                                                        <option {{ $category_id[$key] == $category->id ? 'selected' : '' }}--}}
{{--                                                            value="{{ $category->id }}">--}}
{{--                                                            {{ $category->name }}--}}
{{--                                                        </option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}

                                            <!-- Item -->
                                            <div class="col-md-3">
                                                <label for="">Item</label>
                                                <select name="item_id[]" class="form-control item_id">
                                                    <option value="">Select</option>
                                                    @foreach ($items as $item)
                                                        <option {{ $val == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-md-3">
                                                <label for="">Quantity</label>
                                                <input type="number" value="{{ $quantity[$key] ?? 0 }}" name="quantity[]"
                                                    class="form-control qty calculation">
                                            </div>

                                            <!-- Price -->
                                            <div class="col-md-3">
                                                <label for="">Price</label>
                                                <input type="text" value="{{ $asking_price[$key] ?? 0 }}"
                                                    name="asking_price[]" class="form-control rate calculation">
                                            </div>

                                            <!-- Vat -->
                                            <div class="col-md-3 vatcolumn">
                                                <label for="">Vat</label>
                                                <input type="text" value="{{ $itemvat->vat ?? null }}" name="vat[]"
                                                    class="form-control  vat calculation">
                                            </div>
                                            <!-- Billing Frequency Selector -->
                                            <div class="col-md-3">
                                                <label for="billing_frequency">Billing Frequency</label>
                                                <select name="billing_frequency[]" class="form-control billing-frequency">
                                                    <option value="0">Select</option>
                                                    <option value="ONETIME">ONETIME</option>
                                                    <option value="MONTHLY">MONTHLY</option>
                                                    <option value="YEARLY">YEARLY</option>
                                                </select>
                                            </div>
                                            <!-- Total -->
                                            <div class="col-md-3">
                                                <label for="">Total</label>
                                                <input type="text" value="0" readonly name="total[]"
                                                    class="form-control total">
                                            </div>



                                            <!-- ONETIME Fields (Example for Service 1) -->
                                            <div class="col-md-12 onetime-fields" data-service-id="1"
                                                style="display:none;">
                                                @php
                                                    $unique = rand(11111,99999);
                                                @endphp
                                                <input type="hidden" value="{{$unique}}" name="uniqueid[]">
                                                <label>Title</label>
                                                <input type="text" name="title_onetime_1[]" class="form-control">
                                                <label>Installments</label>
                                                <div class="installment-container">
                                                    <div class="row installment-row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Installment (%)</label>
                                                                <input type="number" class="form-control"
                                                                    name="installment_{{$unique}}[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input type="date" class="form-control"
                                                                    name="installment_date_{{$unique}}[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button"
                                                                class="btn btn-danger remove-installment"><i
                                                                    class="fas fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add Installment Button -->
                                                <button type="button" class="btn btn-primary add-installment">
                                                    <i class="fas fa-plus"></i> Add Installment
                                                </button>
                                            </div>


                                            <!-- Repeat similar structure for other services, updating `data-service-id="2"`, etc. -->


                                            <!-- MONTHLY Fields -->
                                            <div class="col-md-12 monthly-fields" style="display:none;">
                                                <label>Title</label>
                                                <input type="text" name="title_monthly[]" class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_monthly[]" class="form-control">
                                            </div>

                                            <!-- YEARLY Fields -->
                                            <div class="col-md-12 yearly-fields" style="display:none;">
                                                <label>Title</label>
                                                <input type="text" name="title_yearly[]" class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_yearly[]" class="form-control">
                                            </div>
                                            <!-- Remove Button -->
                                            <button style="margin-top:10px" type="button"
                                                class="btn btn-danger remove w-100">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    <div class="package">

                                    </div>
                                    <button class="btn btn-success" id="addrow" type="button" onclick="">Add
                                        New</button>
                                    <button class="btn btn-primary text-right" type="button"
                                        onclick="stepper.next()">Next</button>
                                </div>

                                {{-- admin contact --}}
                                <div id="contact" class="content" role="tabpanel" aria-labelledby="contact-trigger">
                                    <h3>Admin Contact</h3>
                                    <div class="form-group">
                                        <label for="admin_name">Name</label>
                                        <input type="text" class="form-control" name="admin_name" id="admin_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_designation">Designation</label>
                                        <input type="text" class="form-control" name="admin_designation"
                                            id="admin_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_cell">Cell</label>
                                        <input type="text" class="form-control" name="admin_cell" id="admin_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_email">Email</label>
                                        <input type="text" class="form-control" name="admin_email" id="admin_email">
                                    </div>

                                    <hr>

                                    <h3>Billing Contact</h3>
                                    <div class="form-group">
                                        <label for="billing_name">Name</label>
                                        <input type="text" class="form-control" name="billing_name"
                                            id="billing_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_designation">Designation</label>
                                        <input type="text" class="form-control" name="billing_designation"
                                            id="billing_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_cell">Cell</label>
                                        <input type="text" class="form-control" name="billing_cell"
                                            id="billing_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_email">Email</label>
                                        <input type="text" class="form-control billing_email" name="billing_email[]"
                                            id="billing_email">
                                        <button type="button" class="addemail mt-2 btn-info"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="appendemail">

                                    </div>
                                    <hr>


                                    <h3>Technical Contact</h3>
                                    <div class="form-group">
                                        <label for="technical_name">Name</label>
                                        <input type="text" class="form-control" name="technical_name"
                                            id="technical_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_designation">Designation</label>
                                        <input type="text" class="form-control" name="technical_designation"
                                            id="technical_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_cell">Cell</label>
                                        <input type="text" class="form-control" name="technical_cell"
                                            id="technical_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_email">Email</label>
                                        <input type="text" class="form-control" name="technical_email"
                                            id="technical_email">
                                    </div>

                                    <button class="btn btn-primary" type="button"
                                        onclick="stepper.previous()">Previous</button>
                                    <button class="btn btn-primary" type="button" onclick="stepper.next()">Next</button>
                                </div>


                                {{-- Legal info --}}
                                <div id="legalinfo" class="content" role="tabpanel" aria-labelledby="legalinfo-trigger">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Agreement</label>
                                                <input type="file" class="form-control" name="agreement">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cheque</label>
                                                <input type="file" class="form-control" name="cheque">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cheque Authorization</label>
                                                <input type="file" class="form-control" name="cheque_authorization">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cash</label>
                                                <input type="file" class="form-control" name="cash">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NOC/Payment Clearance</label>
                                                <input type="file" class="form-control" name="noc_payment_clearance">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ISP License</label>
                                                <input type="file" class="form-control" name="isp_license">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Conversion (receive copy)</label>
                                                <input type="file" class="form-control" name="conversion">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Renewal (receive copy)</label>
                                                <input type="file" class="form-control" name="renewal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Trade (Updated)</label>
                                                <input type="file" class="form-control" name="trade">
                                            </div>
                                        </div>
                                        <div class="col md 6">
                                            <div class="form-group">
                                                <label>NID</label>
                                                <input type="file" class="form-control" name="nid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Photo</label>
                                                <input type="file" class="form-control" name="photo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tin</label>
                                                <input type="file" class="form-control" name="tin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>BIN</label>
                                                <input type="file" class="form-control" name="bin">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Authorization Letter</label>
                                                <input type="file" class="form-control" name="authorization_letter">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Partnership Deed (ORG)</label>
                                                <input type="file" class="form-control" name="partnership_deed_org">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Partnership Deed</label>
                                                <input type="file" class="form-control" name="partnership_deed">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Power of Attorney</label>
                                                <input type="file" class="form-control" name="power_of_attorney">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cert. of Incorporation</label>
                                                <input type="file" class="form-control" name="cert_of_incorporation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Form XII</label>
                                                <input type="file" class="form-control" name="form_xii">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>MOA,AOA</label>
                                                <input type="file" class="form-control" name="moa_aoa">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Utility Bill</label>
                                                <input type="file" class="form-control" name="utility_bill">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>User List</label>
                                                <input type="file" class="form-control" name="user_list">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Rent Agreement (PoP)</label>
                                                <input type="file" class="form-control" name="rent_agreement">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Equipment Agreement</label>
                                                <input type="file" class="form-control" name="equipment_agreement">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Work Order</label>
                                                <input type="file" class="form-control" name="work_order">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>IP Lease Agreement</label>
                                        <input type="file" class="form-control" name="iP_lease_agreement">
                                    </div>
                                    <button class="btn btn-primary" type="button"
                                        onclick="stepper.previous()">Previous</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script>

@section('scripts')
    <script>
        $(document).on('change', '#connection_path_id', function() {
            let provider = jQuery.parseJSON($("#connection_path_id option:selected").attr('provider'));
            let html = "";
            $.each(provider, function(index, value) {
                html += `<option value="${value}">${value}</option>`;
                console.log(index + ": " + value);
            });
            $('#provider_id').html(html);
        })
        function getRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
        $('#addrow').on('click', function() {

            let vat_value = $("#vat_check option:selected").val();
            let uniqueNumber = getRandomNumber(1000, 9999);
            const addrow = `
<div class="row" style="background: #ededed; padding: 20px; margin-bottom:10px">
                                            <div class="col-md-3">
                                                <label for="">Category</label>
                                                <select name="category_id[]" id="category_id"
                                                    class="form-control category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Item -->
                                            <div class="col-md-3">
                                                <label for="">Item</label>
                                                <select name="item_id[]" class="form-control item_id">
                                                    <option value="">Select</option>

                                                </select>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-md-3">
                                                <label for="">Quantity</label>
                                                <input type="number" value="" name="quantity[]"
                                                    class="form-control qty calculation">
                                            </div>

                                            <!-- Price -->
                                            <div class="col-md-3">
                                                <label for="">Price</label>
                                                <input type="text" value=""
                                                    name="asking_price[]" class="form-control rate calculation">
                                            </div>

                                            <!-- Vat -->
                                            <div class="col-md-3 vatcolumn">
                                                <label for="">Vat</label>
                                                <input type="text" value="" name="vat[]"
                                                    class="form-control  vat calculation">
                                            </div>
                                            <!-- Billing Frequency Selector -->
                                            <div class="col-md-3">
                                                <label for="billing_frequency">Billing Frequency</label>
                                                <select name="billing_frequency[]" class="form-control billing-frequency">
                                                    <option value="0">Select</option>
                                                    <option value="ONETIME">ONETIME</option>
                                                    <option value="MONTHLY">MONTHLY</option>
                                                    <option value="YEARLY">YEARLY</option>
                                                </select>
                                            </div>
                                            <!-- Total -->
                                            <div class="col-md-3">
                                                <label for="">Total</label>
                                                <input type="text" value="0" readonly name="total[]"
                                                    class="form-control total">
                                            </div>



                                            <!-- ONETIME Fields -->
                             <div class="col-md-12 onetime-fields" data-service-id="1" style="display:none;">

                                                <input type="hidden" value="${uniqueNumber}" name="uniqueid[]">

    <label>Title</label>
    <input type="text" name="title_onetime_1[]" class="form-control">
    <label>Installments</label>
    <div class="installment-container">
        <div class="row installment-row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Installment (%)</label>
                    <input type="number" class="form-control" name="installment_${uniqueNumber}[]">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control" name="installment_date_${uniqueNumber}[]">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-installment"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    </div>
    <!-- Add Installment Button -->
    <button type="button" class="btn btn-primary add-installment">
        <i class="fas fa-plus"></i> Add Installment
    </button>
</div>


                                            <!-- MONTHLY Fields -->
                                            <div class="col-md-12 monthly-fields" style="display:none;">
                                                <label>Title</label>
                                                <input type="text" name="title_monthly[]" class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_monthly[]" class="form-control">
                                            </div>

                                            <!-- YEARLY Fields -->
                                            <div class="col-md-12 yearly-fields" style="display:none;">
                                                <label>Title</label>
                                                <input type="text" name="title_yearly[]" class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_yearly[]" class="form-control">
                                            </div>
                                            <!-- Remove Button -->
                                            <button style="margin-top:10px" type="button"
                                                class="btn btn-danger remove w-100">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                </div>
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
                    thisval.closest('.row').find('.unit').val(data.unit);
                    thisval.closest('.row').find('.vat').val(data.vat);
                }
            })
        });

        $(document).on('click', '.addemail', function() {
            let html = `<div class="form-group">
                      <label for="billing_email">Email</label>
                      <input type="text" class="form-control " name="billing_email[]" id="billing_email">
                      <button type="button" class="addemail mt-2 btn-danger"><i class="fa fa-minus"></i></button>
                    </div>`;
            $('.appendemail').append(html);
        });

        $(document).on('click', '.delete', function() {
            $(this).closest('.row').remove();
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
            $(this).closest('.row').remove();
        })

        function totalvalue() {
            let grandtotal = 0;
            $.each($('.total'), function(index, item) {
                total = Number($(item).val());
                grandtotal += total;
                $('#GrandTotal').val(grandtotal);
            });
            $("#totalamount").val(grandtotal);
        }

        $(document).on('input', '.calculation', function() {

            let qtyVal = Number($(this).closest('.row').find('.qty').val());
            let rateVal = Number($(this).closest('.row').find('.rate').val());

            let vat_value = $("#vat_check option:selected").val();

            let vatVal = (vat_value == "yes" ? Number($(this).closest('.row').find('.vat').val()) : 0);

            let countDay = 30;
            let sum = qtyVal * rateVal
            let onedaysalary = sum / 30;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('.row').find('.total').val(total.toFixed(1));
            totalvalue();
        })

        $.each($('.qty'), function() {
            let qtyVal = Number($(this).closest('.row').find('.qty').val());
            let rateVal = Number($(this).closest('.row').find('.rate').val());

            let vat_value = $("#vat_check option:selected").val();

            let vatVal = (vat_value == "yes" ? Number($(this).closest('.row').find('.vat').val()) : 0);

            let countDay = 30;
            let sum = qtyVal * rateVal
            let onedaysalary = sum / 30;
            let daySum = onedaysalary * countDay;
            let vat = vatVal / 100 * (daySum);
            let total = (daySum) + vat;

            $(this).closest('.row').find('.total').val(total.toFixed(1));
            totalvalue();
        })

        $(document).on('change', ".category_id", function() {
            let categoryId = $(this).val();
            let $row = $(this).closest(".row"); // Get the current row

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

        $(document).ready(function() {
            $(document).on('change', '.billing-frequency', function() {
                const selectedOption = $(this).val();
                const row = $(this).closest('.row');

                // Hide all optional sections initially
                row.find('.onetime-fields, .monthly-fields, .yearly-fields').hide();

                // Show fields based on the selection
                if (selectedOption === 'ONETIME') {
                    row.find('.onetime-fields').show();
                } else if (selectedOption === 'MONTHLY') {
                    row.find('.monthly-fields').show();
                } else if (selectedOption === 'YEARLY') {
                    row.find('.yearly-fields').show();
                }
            });
        });

        $(document).on('click', '.add-installment', function() {
            const container = $(this).siblings('.installment-container');
            const serviceId = $(this).closest('.onetime-fields').find('input[name="uniqueid[]"]').val();

            // Clone the first installment row
            const newInstallment = `    <div class="row installment-row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Installment (%)</label>
                                                                <input type="number" class="form-control"
                                                                    name="installment_${serviceId}[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input type="date" class="form-control"
                                                                    name="installment_date_${serviceId}[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button"
                                                                class="btn btn-danger remove-installment"><i
                                                                    class="fas fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>`;

            // Append the cloned installment to the container
            container.append(newInstallment);
        });

        // Event delegation for dynamically added "Remove Installment" buttons
        $(document).on('click', '.remove-installment', function() {
            // Remove the installment row only if more than one exists
            if ($(this).closest('.installment-container').find('.installment-row').length > 1) {
                $(this).closest('.installment-row').remove();
            } else {
                alert("At least one installment is required.");
            }
        });
    </script>
@endsection
