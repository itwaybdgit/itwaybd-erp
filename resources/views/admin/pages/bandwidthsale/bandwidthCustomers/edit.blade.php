@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Edit' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <div class="basic-form">
                        <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $editinfo->company_name }}" name="company_name"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Company Owner Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $editinfo->company_owner_name }}"
                                        name="company_owner_name" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Company Owner Phone <span class="text-danger">*</span></label>
                                    <input type="tel" value="{{ $editinfo->company_owner_phone }}"
                                        name="company_owner_phone" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Division <span class="text-danger">*</span></label>
                                    <select name="division_id" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($divisions as $val)
                                            <option {{ $editinfo->division_id == $val->id ? 'selected' : '' }}
                                                value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>District <span class="text-danger">*</span></label>
                                    <select name="district_id" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($districts as $val)
                                            <option {{ $editinfo->district_id == $val->id ? 'selected' : '' }}
                                                value="{{ $val->id }}">{{ $val->district_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Upazila/Thana <span class="text-danger">*</span></label>
                                    <select name="upazila_id" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ($upazilas as $val)
                                            <option {{ $editinfo->upazila_id == $val->id ? 'selected' : '' }}
                                                value="{{ $val->id }}">{{ $val->upozilla_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Vill/Road <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $editinfo->road }}" name="road"
                                        class="form-control">
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Latitude <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $editinfo->latitude }}" name="latitude"
                                        class="form-control">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label>Longitude <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $editinfo->longitude }}" name="longitude"
                                        class="form-control">
                                </div>


                                <div class="col-md-4 mb-1">
                                    <label>House <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $editinfo->house }}" name="house"
                                        class="form-control">
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

                                        @php
                                            $contact_person = explode(',', $editinfo->contact_person_name);
                                            $contact_person_phone = explode(',', $editinfo->contact_person_phone);
                                        @endphp

                                        <tbody class="contact_row">
                                            @foreach ($contact_person as $key => $item)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="contact_person_name[]"
                                                            value="{{ $item }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="tel" name="contact_person_phone[]"
                                                            value="{{ $contact_person_phone[$key] ?? '' }}"
                                                            class="form-control">
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
                                    <input type="text" value="{{ $editinfo->customer_address }}"
                                        name="customer_address" class="form-control">
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
                                            <option {{ $editinfo->license_type == $value->id ? 'selected' : '' }}
                                                value="{{ $value->id }}">{{ $value->name }}</option>
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
                                            <option {{ $editinfo->created_by == $value->user_id ? 'selected' : '' }}
                                                value="{{ $value->user_id }}">{{ $value->name }}</option>
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
                                            <option {{ $editinfo->team_id == $value->id ? 'selected' : '' }}
                                                value="{{ $value->id }}">{{ $value->name }}</option>
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
                                        <option {{ $editinfo->customer_priority == 'Low' ? 'selected' : '' }}
                                            value="Low">Low</option>
                                        <option {{ $editinfo->customer_priority == 'Medium' ? 'selected' : '' }}
                                            value="Medium">Medium</option>
                                        <option {{ $editinfo->customer_priority == 'High' ? 'selected' : '' }}
                                            value="High">High</option>
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
                                    <input type="text" value="{{ $editinfo->commission }}" name="commission"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="technical_email">Type</label>
                                        <select name="connection_path_id" class="form-control selected"
                                            id="connection_path_id">
                                            <option selected disabled>Select</option>
                                            @foreach ($connection_paths as $path)
                                                <option {{ $editinfo->connection_path_id == $path->id ? 'selected' : '' }}
                                                    provider="{{ $path->provider }}" value="{{ $path->id }}">
                                                    {{ $path->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $providers = App\Models\ConnectedPath::find($editinfo->connection_path_id);
                                    $typs = json_decode($providers->provider ?? '');

                                @endphp
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="technical_email">Provider</label>
                                        <select name="provider" class="form-control" id="provider_id">
                                            @if ($typs)
                                                @foreach ($typs as $path)
                                                    <option {{ $editinfo->provider == $path ? 'selected' : '' }}
                                                        value="{{ $path ?? '' }}">{{ $path ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 mb-1">
                                    <h4>Package</h4>
                                    @foreach ($editinfo->package as $key => $val)
                                        @php
                                            $itemvat = App\Models\Item::find($val->item_id);
                                        @endphp
                                        <div class="row"
                                            style="background: #ededed; padding: 20px; margin-bottom:10px">
                                            <!-- Category -->
                                            <div class="col-md-3">
                                                <label for="">Category</label>
                                                <select name="category_id[]" id="category_id"
                                                    class="form-control category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option {{ $val->category_id == $category->id ? 'selected' : '' }}
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
                                                        <option {{ $val->item_id == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-md-3">
                                                <label for="">Quantity</label>
                                                <input type="number" value="{{ $val->qty ?? 0 }}" name="quantity[]"
                                                    class="form-control qty calculation">
                                            </div>

                                            <!-- Price -->
                                            <div class="col-md-3">
                                                <label for="">Price</label>
                                                <input type="text" value="{{ $val->rate ?? 0 }}"
                                                    name="asking_price[]" class="form-control rate calculation">
                                            </div>

                                            <!-- Vat -->
                                            <div class="col-md-3 vatcolumn">
                                                <label for="">Vat</label>
                                                <input type="text" value="{{ $val->vat ?? 0 }}" name="vat[]"
                                                    class="form-control  vat calculation">
                                            </div>
                                            <!-- Billing Frequency Selector -->
                                            <div class="col-md-3">
                                                <label for="billing_frequency">Billing Frequency</label>
                                                <select name="billing_frequency[]" class="form-control billing-frequency">
                                                    <option value="0">Select</option>
                                                    <option {{ $val->billing_frequency == 'ONETIME' ? 'selected' : '' }}
                                                        value="ONETIME">ONETIME</option>
                                                    <option {{ $val->billing_frequency == 'MONTHLY' ? 'selected' : '' }}
                                                        value="MONTHLY">MONTHLY</option>
                                                    <option {{ $val->billing_frequency == 'YEARLY' ? 'selected' : '' }}
                                                        value="YEARLY">YEARLY</option>
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
                                                style="{{ $val->billing_frequency == 'ONETIME' ? '' : 'display: none' }}">
                                                @php
                                                    $unique = rand(11111, 99999);
                                                @endphp
                                                <input type="hidden" value="{{ $unique }}" name="uniqueid[]">
                                                <label>Title</label>
                                                <input type="text" name="title_onetime_1[]"
                                                    value="{{ $val->title_onetime }}" class="form-control">
                                                <label>Installments</label>
                                                <div class="installment-container">
                                                    @php
                                                        $installment = explode(',', $val->installment);
                                                        $installmentDate = explode(',', $val->installment_date);
                                                    @endphp
                                                    @foreach ($installment as $key => $value)
                                                        <div class="row installment-row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Installment (%)</label>
                                                                    <input type="number" value="{{ $value }}"
                                                                        class="form-control"
                                                                        name="installment_{{ $unique }}[]">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Date</label>
                                                                    <input type="date"
                                                                        value="{{ $installmentDate[$key] }}"
                                                                        class="form-control"
                                                                        name="installment_date_{{ $unique }}[]">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button"
                                                                    class="btn btn-danger remove-installment"><i
                                                                        class="fas fa-trash-alt"></i></button>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                                <!-- Add Installment Button -->
                                                <button type="button" class="btn btn-primary add-installment">
                                                    <i class="fas fa-plus"></i> Add Installment
                                                </button>
                                            </div>

                                            <!-- Repeat similar structure for other services, updating `data-service-id="2"`, etc. -->


                                            <!-- MONTHLY Fields -->
                                            <div class="col-md-12 monthly-fields"
                                                style="{{ $val->billing_frequency == 'MONTHLY' ? '' : 'display: none' }}">
                                                <label>Title</label>
                                                <input type="text" name="title_monthly[]"
                                                    value="{{ $val->title_monthly }}" class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_monthly[]"
                                                    value="{{ $val->payment_date_monthly }}" class="form-control">
                                            </div>

                                            <!-- YEARLY Fields -->
                                            <div class="col-md-12 yearly-fields"
                                                style="{{ $val->billing_frequency == 'YEARLY' ? '' : 'display: none' }}">
                                                <label>Title</label>
                                                <input type="text" name="title_yearly[]"
                                                    value="{{ $val->title_yearly }}" class="form-control">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date_yearly[]"
                                                    value="{{ $val->payment_date_yearly }}" class="form-control">
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
                                </div>

                                <div class="col-md-12">
                                    <h3>Admin Contact</h3>
                                    <div class="form-group">
                                        <label for="admin_name">Name</label>
                                        <input type="text" class="form-control" value="{{ $editinfo->admin_name }}"
                                            name="admin_name" id="admin_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_designation">Designation</label>
                                        <input type="text" class="form-control"
                                            value="{{ $editinfo->admin_designation }}" name="admin_designation"
                                            id="admin_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_cell">Cell</label>
                                        <input type="text" class="form-control" value="{{ $editinfo->admin_cell }}"
                                            name="admin_cell" id="admin_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_email">Email</label>
                                        <input type="text" class="form-control" value="{{ $editinfo->admin_email }}"
                                            name="admin_email" id="admin_email">
                                    </div>

                                    <hr>

                                    <h3>Billing Contact</h3>
                                    <div class="form-group">
                                        <label for="billing_name">Name</label>
                                        <input type="text" class="form-control" value="{{ $editinfo->billing_name }}"
                                            name="billing_name" id="billing_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_designation">Designation</label>
                                        <input type="text" class="form-control"
                                            value="{{ $editinfo->billing_designation }}" name="billing_designation"
                                            id="billing_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_cell">Cell</label>
                                        <input type="text" class="form-control" value="{{ $editinfo->billing_cell }}"
                                            name="billing_cell" id="billing_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_email">Email</label>
                                        <input type="text" class="form-control"
                                            value="{{ $editinfo->billing_email }}" name="billing_email"
                                            id="billing_email">
                                    </div>
                                    <hr>

                                    <h3>Technical Contact</h3>
                                    <div class="form-group">
                                        <label for="technical_name">Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ $editinfo->technical_name }}" name="technical_name"
                                            id="technical_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_designation">Designation</label>
                                        <input type="text" class="form-control"
                                            value="{{ $editinfo->technical_designation }}" name="technical_designation"
                                            id="technical_designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_cell">Cell</label>
                                        <input type="text" class="form-control"
                                            value="{{ $editinfo->technical_cell }}" name="technical_cell"
                                            id="technical_cell">
                                    </div>
                                    <div class="form-group">
                                        <label for="technical_email">Email</label>
                                        <input type="text" class="form-control"
                                            value="{{ $editinfo->technical_email }}" name="technical_email"
                                            id="technical_email">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('Legal Documents') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row bg-white">
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Agreement') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php

                                                                $extension1 = File::extension(
                                                                    $legalInfo->agreement ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension1, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension1, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension1, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension1, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->agreement ?? '') }}"
                                                                    class="w-50" height="50px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="agreement" class="form-control">
                                                            @if ($legalInfo->agreement ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->agreement ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Cheque') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension2 = File::extension($legalInfo->cheque ?? '');
                                                            @endphp
                                                            @if (in_array($extension2, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50 "
                                                                    alt="">
                                                            @elseif (in_array($extension2, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension2, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension2, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->cheque ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="cheque" class="form-control">

                                                            @if ($legalInfo->cheque ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->cheque ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('Cheque Authorization') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension3 = File::extension(
                                                                    $legalInfo->cheque_authorization ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension3, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension3, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension3, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension3, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->cheque_authorization ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="cheque_authorization"
                                                                class="form-control">

                                                            @if ($legalInfo->cheque_authorization ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->cheque_authorization ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Cash') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension4 = File::extension($legalInfo->cash ?? '');
                                                            @endphp
                                                            @if (in_array($extension4, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension4, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension4, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension4, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->cash ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="cash" class="form-control">

                                                            @if ($legalInfo->cash ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->cash ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('NOC Payment Clearance') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension5 = File::extension(
                                                                    $legalInfo->noc_payment_clearance ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension5, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension5, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension5, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension5, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->noc_payment_clearance ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="noc_payment_clearance"
                                                                class="form-control">

                                                            @if ($legalInfo->noc_payment_clearance ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->noc_payment_clearance ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('ISP License') }}
                                                            </h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension6 = File::extension(
                                                                    $legalInfo->isp_license ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension6, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension6, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension6, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension6, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->isp_license ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="isp_license"
                                                                class="form-control">

                                                            @if ($legalInfo->isp_license ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->isp_license ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Conversion') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension7 = File::extension(
                                                                    $legalInfo->conversion ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension7, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension7, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension7, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension7, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->conversion ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="conversion" class="form-control">

                                                            @if ($legalInfo->conversion ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->conversion ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Renewal') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension8 = File::extension(
                                                                    $legalInfo->renewal ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension8, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension8, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension8, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension8, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->renewal ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="renewal" class="form-control">

                                                            @if ($legalInfo->renewal ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->renewal ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Trade') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension9 = File::extension($legalInfo->trade ?? '');
                                                            @endphp
                                                            @if (in_array($extension9, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension9, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension9, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension9, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->trade ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="trade" class="form-control">

                                                            @if ($legalInfo->trade ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->trade ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('NID') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension10 = File::extension($legalInfo->nid ?? '');
                                                            @endphp
                                                            @if (in_array($extension10, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension10, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension10, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension10, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->nid ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="nid" class="form-control">

                                                            @if ($legalInfo->nid ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->nid ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Photo') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension11 = File::extension($legalInfo->photo ?? '');
                                                            @endphp
                                                            @if (in_array($extension11, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension11, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension11, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension11, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->photo ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="photo" class="form-control">

                                                            @if ($legalInfo->photo ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->photo ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('TIN') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension12 = File::extension($legalInfo->tin ?? '');
                                                            @endphp
                                                            @if (in_array($extension12, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension12, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension12, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension12, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->tin ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="tin" class="form-control">

                                                            @if ($legalInfo->tin ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->tin ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('BIN') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension13 = File::extension($legalInfo->bin ?? '');
                                                            @endphp
                                                            @if (in_array($extension13, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension13, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension13, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension13, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->bin ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="bin" class="form-control">

                                                            @if ($legalInfo->bin ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->bin ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('Authorization Letter') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension14 = File::extension(
                                                                    $legalInfo->authorization_letter ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension14, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension14, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension14, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-100"
                                                                    alt="">
                                                            @elseif (in_array($extension14, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->authorization_letter ?? '') }}"
                                                                    class="w-100" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="authorization_letter"
                                                                class="form-control">

                                                            @if ($legalInfo->authorization_letter ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->authorization_letter ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('Partnership Deed Org') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension15 = File::extension(
                                                                    $legalInfo->partnership_deed_org ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension15, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-100"
                                                                    alt="">
                                                            @elseif (in_array($extension15, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-100"
                                                                    alt="">
                                                            @elseif (in_array($extension15, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension15, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->partnership_deed_org ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="partnership_deed_org"
                                                                class="form-control">

                                                            @if ($legalInfo->partnership_deed_org ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->partnership_deed_org ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('Partnership Deed') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension16 = File::extension(
                                                                    $legalInfo->partnership_deed ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension16, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension16, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension16, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension16, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->partnership_deed ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="partnership_deed"
                                                                class="form-control">

                                                            @if ($legalInfo->partnership_deed ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->partnership_deed ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('Power of Attorney') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension17 = File::extension(
                                                                    $legalInfo->power_of_attorney ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension17, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension17, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension17, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension17, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->power_of_attorney ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="power_of_attorney"
                                                                class="form-control">

                                                            @if ($legalInfo->power_of_attorney ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->power_of_attorney ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('Cert. of Incorporation') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension18 = File::extension(
                                                                    $legalInfo->cert_of_incorporation ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension18, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension18, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension18, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension18, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->cert_of_incorporation ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="cert_of_incorporation"
                                                                class="form-control">

                                                            @if ($legalInfo->cert_of_incorporation ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->cert_of_incorporation ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Form XII') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension19 = File::extension(
                                                                    $legalInfo->form_xii ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension19, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension19, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension19, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension19, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->form_xii ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="form_xii" class="form-control">

                                                            @if ($legalInfo->form_xii ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->form_xii ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('MOA AOA') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension20 = File::extension(
                                                                    $legalInfo->moa_aoa ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension20, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension20, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension20, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension20, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->moa_aoa ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="moa_aoa" class="form-control">

                                                            @if ($legalInfo->moa_aoa ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->moa_aoa ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Utility Bill') }}
                                                            </h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension21 = File::extension(
                                                                    $legalInfo->utility_bill ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension21, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension21, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension21, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension21, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->utility_bill ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="utility_bill"
                                                                class="form-control">

                                                            @if ($legalInfo->utility_bill ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->utility_bill ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('User List') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension22 = File::extension(
                                                                    $legalInfo->user_list ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension22, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension22, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension22, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension22, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->user_list ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="user_list" class="form-control">

                                                            @if ($legalInfo->user_list ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->user_list ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Rent Agreement') }}
                                                            </h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension23 = File::extension(
                                                                    $legalInfo->rent_agreement ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension23, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension23, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension23, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension23, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->rent_agreement ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="rent_agreement"
                                                                class="form-control">

                                                            @if ($legalInfo->rent_agreement ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->rent_agreement ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('Equipment Agreement') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension24 = File::extension(
                                                                    $legalInfo->equipment_agreement ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension24, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension24, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension24, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension24, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->equipment_agreement ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="equipment_agreement"
                                                                class="form-control">
                                                            @if ($legalInfo->equipment_agreement ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->equipment_agreement ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">
                                                                {{ __('IP Lease Agreement') }}</h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension25 = File::extension(
                                                                    $legalInfo->iP_lease_agreement ?? '',
                                                                );
                                                            @endphp
                                                            @if (in_array($extension25, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension25, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension25, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension25, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->iP_lease_agreement ?? '') }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="iP_lease_agreement"
                                                                class="form-control">

                                                            @if ($legalInfo->iP_lease_agreement ?? '')
                                                                <a href="{{ asset('storage' . $legalInfo->iP_lease_agreement ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header p-0">
                                                            <h6 class="text-center py-0 my-0">{{ __('Work Order') }}
                                                            </h6>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            @php
                                                                $extension25 = File::extension(
                                                                    $legalInfo->work_order ?? '',
                                                                );
                                                            @endphp

                                                            @if (in_array($extension25, ['pdf']))
                                                                <img src="{{ asset('image/pdf.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension25, ['doc', 'docx', 'rtf']))
                                                                <img src="{{ asset('image/doc.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension25, ['xls', 'xlsx', 'csv']))
                                                                <img src="{{ asset('image/xls.png') }}" class="w-50"
                                                                    alt="">
                                                            @elseif (in_array($extension25, ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif']))
                                                                <img src="{{ asset('storage' . $legalInfo->work_order) }}"
                                                                    class="w-50" height="150px" alt="">
                                                            @else
                                                            @endif
                                                        </div>
                                                        <div class="card-footer p-0" style="margin-top: 5px;">
                                                            <input type="file" name="work_order"
                                                                class="form-control">

                                                            @if (isset($legalInfo->work_order))
                                                                <a href="{{ asset('storage' . $legalInfo->work_order ?? '') }}"
                                                                    class="btn btn-sm btn-secondary" target="_blank"
                                                                    download>{{ __('Download') }}</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
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
                                        {{ $editinfo->remark }}
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
@push('scripts')
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
            let from_date = $(this).closest('.row').find('.from_date').val() ? $(this).closest('tr').find(
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
@endpush
