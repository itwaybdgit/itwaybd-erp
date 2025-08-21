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
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input type="text" value="" name="company_name" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Company Owner Name <span class="text-danger">*</span></label>
                                    <input type="text" value="" name="company_owner_name" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Company Owner Phone <span class="text-danger">*</span></label>
                                    <input type="tel" value="" name="company_owner_phone" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Division</label>
                                    <select name="division_id" class="form-control select2 division_id">
                                        <option value="">Select</option>
                                        @foreach ($divisions as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>District</label>
                                    <select name="district_id" class="form-control select2 district_id">

                                    </select>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Upazila/Thana</label>
                                    <select name="upazila_id" class="form-control select2 upazila_id">

                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Vill/Road <span class="text-danger">*</span></label>
                                    <input type="text" value="" name="road" class="form-control">
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Latitude <span class="text-danger">*</span></label>
                                    <input type="text" value="" name="latitude" class="form-control">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Longitude <span class="text-danger">*</span></label>
                                    <input type="text" value="" name="longitude" class="form-control">
                                </div>


                                <div class="col-md-4 mb-1">
                                    <label>House <span class="text-danger">*</span></label>
                                    <input type="text" value="" name="house" class="form-control">
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Client Logo</label>
                                    <input type="file" name="invoice_logo" class="form-control">
                                </div>

                                <div class="col-md-12 mb-1">
                                    <table id="table1" class="w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="15%">
                                                    <small class="text-secondary">Contact Person Name</small>
                                                </th>
                                                <th scope="col" width="15%">
                                                    <small class="text-secondary">Contact Person Phone</small>
                                                </th>
                                                <th scope="col" class="text-center" width="5%">
                                                    <small class="text-secondary">Action</small>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="contact_row">
                                            <tr>
                                                <td>
                                                    <input type="text" name="contact_person_name[]" value=""
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <input type="tel" name="contact_person_phone[]" value=""
                                                        class="form-control">
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger delete w-100">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>

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
                                    <input type="text" value="" name="customer_address" class="form-control">
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label for="">License Type <span class="text-danger">*</span></label>
                                    <select name="license_type" class="form-control">

                                        @php
                                            use App\Models\LicenseType;
                                            $licensetype = LicenseType::all();
                                        @endphp
                                        <option selected disabled>Choose License type</option>
                                        @foreach ($licensetype as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('license_type')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label for="">Kam <span class="text-danger">*</span></label>
                                    <select name="created_by" class="form-control select2">
                                        @php
                                            use App\Models\Employee;
                                            $kams = Employee::all();
                                        @endphp
                                        <option selected disabled>Choose Kam</option>
                                        @foreach ($kams as $value)
                                            <option value="{{ $value->user_id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('created_by')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label for="">Team <span class="text-danger">*</span></label>
                                    <select name="team_id" class="form-control">
                                        @php
                                            use App\Models\Team;
                                            $teams = Team::all();
                                        @endphp
                                        <option selected disabled>Choose Kam</option>
                                        @foreach ($teams as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('team_id')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Customer Priority <span class="text-danger">*</span></label>
                                    <select name="customer_priority" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Data Source <span class="text-danger">*</span></label>
                                    <select name="data_source" class="form-control">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Commission <span class="text-danger">*</span></label>
                                    <input type="text" value="" name="commission" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="technical_email">Type</label>
                                        <select name="connection_path_id" class="form-control selected"
                                            id="connection_path_id">
                                            <option selected disabled>Select</option>
                                            @foreach ($connection_paths as $path)
                                                <option provider="{{ $path->provider }}" value="{{ $path->id }}">
                                                    {{ $path->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <hr>
                                <div class="col-md-12 mb-1">
                                    <h4>Package</h4>
                                        <div class="row"
                                            style="background: #ededed; padding: 20px; margin-bottom:10px">
                                            <!-- Category -->
                                            <div class="col-md-3">
                                                <label for="">Category</label>
                                                <select name="category_id[]" id="category_id"
                                                    class="form-control category_id">
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
                                                    @foreach ($items as $item)
                                                        <option
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
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



                                            <!-- ONETIME Fields (Example for Service 1) -->
                                            <div class="col-md-12 onetime-fields" data-service-id="1"
                                                style="display: none">
                                                @php
                                                    $unique = rand(11111, 99999);
                                                @endphp
                                                <input type="hidden" value="{{ $unique }}" name="uniqueid[]">
                                                <label>Title</label>
                                                <input type="text" name="title_onetime_1[]" value=""
                                                    class="form-control">
                                                <label>Installments</label>
                                                <div class="installment-container">

                                                    <div class="row installment-row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Installment (%)</label>
                                                                <input type="number" value="" class="form-control"
                                                                    name="installment_{{ $unique }}[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input type="date" value="" class="form-control"
                                                                    name="installment_date_{{ $unique }}[]">
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
                                            <div class="col-md-12 monthly-fields" style="display: none">
                                                <label>Title</label>
                                                <input type="text" name="title_monthly[]" value=""
                                                    class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_monthly[]" value=""
                                                    class="form-control">
                                            </div>

                                            <!-- YEARLY Fields -->
                                            <div class="col-md-12 yearly-fields" style="display: none">
                                                <label>Title</label>
                                                <input type="text" name="title_yearly[]" value=""
                                                    class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_yearly[]" value=""
                                                    class="form-control">
                                            </div>
                                            <!-- Remove Button -->
                                            <button style="margin-top:10px" type="button"
                                                class="btn btn-danger remove w-100">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    <div class="package">

                                    </div>
                                    <button class="btn btn-success" id="addrow" type="button" onclick="">Add
                                        New</button>
                                </div>

                                <div class="col-md-12">
                                    <h3>Admin Contact</h3>
                                    <div class="form-group">
                                        <label for="admin_name">Name</label>
                                        <input type="text" class="form-control" value="" name="admin_name"
                                            id="admin_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_designation">Designation</label>
                                        <input type="text" class="form-control" value=""
                                            name="admin_designation" id="admin_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_cell">Cell</label>
                                        <input type="text" class="form-control" value="" name="admin_cell"
                                            id="admin_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_email">Email</label>
                                        <input type="text" class="form-control" value="" name="admin_email"
                                            id="admin_email">
                                    </div>

                                    <hr>

                                    <h3>Billing Contact</h3>
                                    <div class="form-group">
                                        <label for="billing_name">Name</label>
                                        <input type="text" class="form-control" value="" name="billing_name"
                                            id="billing_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_designation">Designation</label>
                                        <input type="text" class="form-control" value=""
                                            name="billing_designation" id="billing_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_cell">Cell</label>
                                        <input type="text" class="form-control" value="" name="billing_cell"
                                            id="billing_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_email">Email</label>
                                        <input type="text" class="form-control" value="" name="billing_email"
                                            id="billing_email">
                                    </div>
                                    <hr>

                                    <h3>Technical Contact</h3>
                                    <div class="form-group">
                                        <label for="technical_name">Name</label>
                                        <input type="text" class="form-control" value="" name="technical_name"
                                            id="technical_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_designation">Designation</label>
                                        <input type="text" class="form-control" value=""
                                            name="technical_designation" id="technical_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_cell">Cell</label>
                                        <input type="text" class="form-control" value="" name="technical_cell"
                                            id="technical_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_email">Email</label>
                                        <input type="text" class="form-control" value="" name="technical_email"
                                            id="technical_email">
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
                                </div>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Remarks/Note</label>
                        <textarea class="form-control" name="remark" id="exampleFormControlTextarea1" rows="6"
                            placeholder="Remarks">
                                    </textarea>
                    </div>
                </div>

                <div class="mb-3 mt-2 form-group">
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
        $(document).ready(function() {
            $('.division_id').on('change', function() {
                let self = $(this);
                $.ajax({
                    "url": "{{ route('lead.division') }}",
                    "type": "GET",
                    "data": {
                        division_id: self.val()
                    },
                    cache: false,
                    success: function(data) {
                        $('.district_id').html(data);
                    }
                });
            })
            $('.district_id').on('change', function() {
                let self = $(this);
                $.ajax({
                    "url": "{{ route('lead.upazila') }}",
                    "type": "GET",
                    "data": {
                        district_id: self.val()
                    },
                    cache: false,
                    success: function(data) {
                        $('.upazila_id').html(data);
                    }
                });
            })
        });

        $('#newrow').on('click', function() {
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
                    thisval.closest('tr').find('.unit').val(data.unit);
                    thisval.closest('tr').find('.vat').val(data.vat);
                }
            })
        });

        $(document).on('click', '.delete', function() {
            $(this).closest('tr').remove();
        })

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        })

        function totalvalue() {
            let grandtotal = 0;
            $.each($('.total'), function(index, item) {
                total = Number($(item).val());
                grandtotal += total;
                $('#GrandTotal').val(grandtotal);
            });
        }

        function getDay(formday, today) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(formday);
            const secondDate = new Date(today);
            const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)) + 1;
            return diffDays;
        }

        $(document).on('input', '.calculation', function() {
            let unitVal = Number($(this).closest('.row').find('.unit').val());
            let qtyVal = Number($(this).closest('.row').find('.qty').val());
            let rateVal = Number($(this).closest('.row').find('.rate').val());
            let vatVal = Number($(this).closest('.row').find('.vat').val());
            let from_date = $(this).closest('.row').find('.from_date').val() ? $(this).closest('.row').find(
                '.from_date').val() : '2022-12-1';
            let to_date = $(this).closest('.row').find('.to_date').val() ? $(this).closest('.row').find('.to_date')
                .val() : '2022-12-30';
            let countDay = getDay(from_date, to_date);
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
    </script>
@endsection
