@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $page_heading ?? 'Edit Lead' }}</h4>
                    <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">

                    <x-alert></x-alert>

                    <!-- Lead Type Toggle Tabs -->
                    <div class="mb-4">
                        <ul class="nav nav-tabs justify-content-center" id="leadTypeTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ (!$lead->company_name && !$lead->group_name) ? 'active' : '' }}"
                                   id="personal-tab" data-toggle="tab" href="#personal" role="tab"
                                   aria-controls="personal" aria-selected="{{ (!$lead->company_name && !$lead->group_name) ? 'true' : 'false' }}">
                                    <i class="fas fa-user me-1"></i>Personal/Individual
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ ($lead->company_name || $lead->group_name) ? 'active' : '' }}"
                                   id="business-tab" data-toggle="tab" href="#business" role="tab"
                                   aria-controls="business" aria-selected="{{ ($lead->company_name || $lead->group_name) ? 'true' : 'false' }}">
                                    <i class="fas fa-building me-1"></i>Company/Business
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="basic-form">
                        <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data" id="myForm">
                            @csrf
                            @method('POST')

                            <!-- Hidden field to track lead type -->
                            <input type="hidden" name="lead_type" id="lead_type"
                                   value="{{ $lead->lead_type== 'personal'? 'personal' : 'business' }}">

                            <div class="tab-content" id="leadTypeTabsContent">
                                <!-- Personal Tab Content -->
                                <div class="tab-pane fade {{ $lead->lead_type== 'personal' ? 'show active' : '' }}"
                                     id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                    <div class="row">
                                        <div class="col-md-4 mb-1">
                                            <label>Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="full_name" class="form-control"
                                                   value="{{ old('full_name', $lead->company_owner_name) }}"
                                                {{ (!$lead->company_name && !$lead->group_name) ? 'required' : '' }}>
                                        </div>

                                        <div class="col-md-4 mb-1">
                                            <label>Email Address</label>
                                            <input type="email" name="contact_person_email[]" class="form-control"
                                                   value="{{ old('email', $contact_person_emails[0]) }}">
                                        </div>

                                        <div class="col-md-4 mb-1">
                                            <label>Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="phone" class="form-control"
                                                   value="{{ old('phone', $lead->company_owner_phone) }}"
                                                {{ (!$lead->company_name && !$lead->group_name) ? 'required' : '' }}>
                                        </div>

                                        <div class="col-md-4 mb-1">
                                            <label>Occupation</label>
                                            <input type="text" name="occupation" class="form-control"
                                                   value="{{ old('occupation', $lead->occupation) }}">
                                        </div>

                                        <div class="col-md-4 mb-1">
                                            <label>Age</label>
                                            <input type="number" name="age" class="form-control" min="18" max="100"
                                                   value="{{ old('age', $lead->age) }}">
                                        </div>

                                        <div class="col-md-4 mb-1">
                                            <label>Gender</label>
                                            <select name="gender" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Male" {{ old('gender', $lead->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $lead->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender', $lead->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Tab Content -->
                                <div class="tab-pane fade {{ ($lead->company_name || $lead->group_name) ? 'show active' : '' }}"
                                     id="business" role="tabpanel" aria-labelledby="business-tab">
                                    <!-- Company Group Checkbox -->
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_company_group"
                                                       name="is_company_group" value="1"
                                                    {{ ($lead->is_company_group==1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_company_group">
                                                    <strong>This is a Company Group</strong>
                                                    <small class="text-muted">(Multiple companies under one group)</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Single Company Fields (Default) -->
                                    <div class="single-company-fields"
                                         style="{{ ($lead->group_name || $lead->groupCompanies->count() > 0) ? 'display: none;' : '' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-1">
                                                <label>Company Name <span class="text-danger">*</span></label>
                                                <input type="text" name="company_name" class="form-control"
                                                       value="{{ old('company_name', $lead->company_name) }}">
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <label>Company Owner Name</label>
                                                <input type="text" name="company_owner_name" class="form-control"
                                                       value="{{ old('company_owner_name', $lead->company_owner_name) }}">
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <label>Company Owner Phone</label>
                                                <input type="tel" name="company_owner_phone" class="form-control"
                                                       value="{{ old('company_owner_phone', $lead->company_owner_phone) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Multiple Companies Fields (When Group is checked) -->
                                    <div class="multiple-companies-fields"
                                         style="{{ ($lead->group_name || $lead->groupCompanies->count() > 0) ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-4 mb-1">
                                                <label>Group Name <span class="text-danger">*</span></label>
                                                <input type="text" name="group_name" class="form-control"
                                                       value="{{ old('group_name', $lead->group_name) }}">
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <label>Group Owner Name</label>
                                                <input type="text" name="group_owner_name" class="form-control"
                                                       value="{{ old('group_owner_name', $lead->group_owner_name) }}">
                                            </div>

                                            <div class="col-md-4 mb-1">
                                                <label>Group Owner Phone</label>
                                                <input type="tel" name="group_owner_phone" class="form-control"
                                                       value="{{ old('group_owner_phone', $lead->group_owner_phone) }}">
                                            </div>

                                            <!-- Companies Table -->
                                            <div class="col-md-10 mb-3">
                                                <h6 class="mb-2">Companies in Group</h6>
                                                <div class="">
                                                    <table id="companiesTable" class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Company Name <span class="text-danger">*</span></th>
                                                            <th>Business Type</th>
                                                            <th width="10%" class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="companies_row">
                                                        @if($lead->groupCompanies->count() > 0)
                                                            @foreach($lead->groupCompanies as $index => $gcompany)
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="group_companies[{{ $index }}][company_name]"
                                                                               class="form-control"
                                                                               value="{{ old('group_companies.'.$index.'.company_name', $gcompany->company_name) }}" required>
                                                                    </td>
                                                                    <td>
                                                                        <select name="group_companies[{{ $index }}][business_type_id]" class="form-control select2">
                                                                            <option value="">Select</option>
                                                                            @foreach ($licenses as $val)
                                                                                <option value="{{ $val->id }}"
                                                                                    {{ old('group_companies.'.$index.'.business_type_id', $gcompany->business_type_id) == $val->id ? 'selected' : '' }}>
                                                                                    {{ $val->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="btn btn-danger btn-sm remove-company">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="group_companies[0][company_name]" class="form-control" required>
                                                                </td>
                                                                <td>
                                                                    <select name="group_companies[0][business_type_id]" class="form-control select2">
                                                                        <option value="">Select</option>
                                                                        @foreach ($licenses as $val)
                                                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger btn-sm remove-company">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-right">
                                                                <button type="button" class="btn btn-success btn-sm" id="addCompany">
                                                                    <i class="fas fa-plus mr-1"></i>Add Company
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Person Table (For both single and group) -->
                                    <div class="row">
                                        <div class="col-md-12 mb-1">
                                            <h6 class="mb-2">Contact Persons</h6>
                                            <div class="table-responsive">
                                                <table id="table1" class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Contact Person Name</th>
                                                        <th scope="col">Contact Person Email</th>
                                                        <th scope="col">Contact Person Phone</th>
                                                        <th scope="col" class="text-center" width="10%">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="contact_row">
                                                    @if(count($contact_person_names) > 0 && $contact_person_names[0])
                                                        @foreach($contact_person_names as $index => $name)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="contact_person_name[]" class="form-control"
                                                                           value="{{ old('contact_person_name.'.$index, $name) }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="contact_person_email[]" class="form-control"
                                                                           value="{{ old('contact_person_email.'.$index, $contact_person_emails[$index] ?? '') }}">
                                                                </td>
                                                                <td>
                                                                    <input type="tel" name="contact_person_phone[]" class="form-control"
                                                                           value="{{ old('contact_person_phone.'.$index, $contact_person_phones[$index] ?? '') }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger btn-sm delete">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="contact_person_name[]" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="contact_person_email[]" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="tel" name="contact_person_phone[]" class="form-control">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger btn-sm delete">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-right">
                                                            <button type="button" class="btn btn-success btn-sm" id="newrow">
                                                                <i class="fas fa-plus mr-1"></i>Add Contact Person
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--ttttttttttt{{$company->lead_fields}}--}}
                            <div class="row">
                                <!-- Common fields for both tabs -->
{{--                                {{$company->lead_fields}}--}}

                                <!-- Common Address Fields -->
                                @if(in_array('upazila', $company->lead_fields ?? []) || in_array('division', $company->lead_fields ?? []) || in_array('district', $company->lead_fields ?? []))
                                    <div class="col-md-4 mb-1">
                                        <label>Division</label>
                                        <select name="division_id" class="form-control select2 division_id">
                                            <option value="">Select</option>
                                            @foreach ($divisions as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('division_id', $lead->division_id) == $val->id ? 'selected' : '' }}>
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- District and Upazila HTML Section -->
                                @if(in_array('district', $company->lead_fields ?? []) || in_array('upazila', $company->lead_fields ?? []))
                                    <div class="col-md-4 mb-1">
                                        <label>District</label>
                                        <select name="district_id" class="form-control select2 district_id">
                                            <option value="">Select</option>
                                            @foreach ($selected_districts as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('district_id', $lead->district_id) == $val->id ? 'selected' : '' }}>
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if(in_array('upazila', $company->lead_fields ?? []))
                                    <div class="col-md-4 mb-1">
                                        <label>Upazila/Thana</label>
                                        <select name="upazila_id" class="form-control select2 upazila_id">
                                            <option value="">Select</option>
                                            @foreach ($selected_upazilas as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('upazila_id', $lead->upazila_id) == $val->id ? 'selected' : '' }}>
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-md-4 mb-1">
                                    <label>Branch</label>
                                    <select name="branch_id" class="form-control select2 branch_id">
                                        <option value="">Select</option>
                                        @foreach ($branches as $val)
                                            <option value="{{ $val->id }}"
                                                {{ old('branch_id', $lead->branch_id) == $val->id ? 'selected' : '' }}>
                                                {{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-1">
                                    <label>Purpose</label>
                                    <select name="purpose" class="form-control select2 purpose">
                                        <option value="buy" {{ old('purpose', $lead->purpose) == 'buy' ? 'selected' : '' }}>
                                            Buy Goods or Services
                                        </option>
                                        <option value="sell" {{ old('purpose', $lead->purpose) == 'sell' ? 'selected' : '' }}>
                                            Sell Goods or Services
                                        </option>
                                    </select>
                                </div>

                                <!-- Meeting Information -->
                                <div class="col-md-6 mb-1">
                                    <label>Meeting Date</label>
                                    <input type="datetime-local" name="meeting_date" class="form-control"
                                           value="{{ old('meeting_date', $meeting ? $meeting->meeting_date : '') }}">
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label>Meeting Remarks</label>
                                    <textarea name="meeting_remarks" class="form-control" rows="2">{{ old('meeting_remarks', $meeting ? $meeting->meeting_remarks : '') }}</textarea>
                                </div>

                                <!-- Follow-up Information -->
                                <div class="col-md-6 mb-1">
                                    <label>Follow-up Date</label>
                                    <input type="datetime-local" name="follow_up_date" class="form-control"
                                           value="{{ old('follow_up_date', $followup ? $followup->meeting_date : '') }}">
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label>Follow-up Remarks</label>
                                    <textarea name="follow_up_remarks" class="form-control" rows="2">{{ old('follow_up_remarks', $followup ? $followup->meeting_remarks : '') }}</textarea>
                                </div>

                                <hr>
                            </div>

                            <!-- Basic Textarea end -->
                            <div class="mt-1 form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ $back_url }}" class="btn btn-secondary">Cancel</a>
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
        const licenseOptions = `
        <option value="">Select</option>
        @foreach($licenses as $val)
        <option value="{{ $val->id }}">{{ $val->name }}</option>
        @endforeach
        `;

        $(document).ready(function() {
            let companyIndex = {{ $lead->groupCompanies->count() > 0 ? $lead->groupCompanies->count() : 1 }};

            // Company Group checkbox toggle
            $('#is_company_group').change(function() {
                if ($(this).is(':checked')) {
                    $('.single-company-fields').hide();
                    $('.multiple-companies-fields').show();
                    // Update validation
                    $('input[name="company_name"]').attr('required', false);
                    $('input[name="group_name"]').attr('required', true);
                } else {
                    $('.single-company-fields').show();
                    $('.multiple-companies-fields').hide();
                    // Update validation
                    $('input[name="company_name"]').attr('required', true);
                    $('input[name="group_name"]').attr('required', false);
                }
            });

            // Add new company to group
            $('#addCompany').on('click', function() {
                const newCompanyRow = `<tr>
                    <td>
                        <input type="text" name="group_companies[${companyIndex}][company_name]" class="form-control" required>
                    </td>
                    <td>
                        <select name="group_companies[${companyIndex}][business_type_id]" class="form-control select2">
                            ${licenseOptions}
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-company">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
                $('.companies_row').append(newCompanyRow);
                companyIndex++;
            });

            // Remove company from group
            $(document).on('click', '.remove-company', function() {
                if ($('.companies_row tr').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('At least one company is required in the group.');
                }
            });

            // Tab change event to track lead type
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                const targetTab = $(e.target).attr('aria-controls');
                $('#lead_type').val(targetTab);

                if (targetTab === 'personal') {
                    $('input[name="full_name"]').prop('required', true);
                    $('input[name="phone"]').prop('required', true);
                    $('input[name="company_name"]').prop('required', false);
                    $('input[name="group_name"]').prop('required', false);
                    $('input[name^="group_companies"]').prop('required', false);
                } else if (targetTab === 'business') {
                    if ($('#is_company_group').is(':checked')) {
                        $('input[name="group_name"]').prop('required', true);
                        $('input[name="company_name"]').prop('required', false);
                        $('input[name^="group_companies"]').prop('required', true);
                    } else {
                        $('input[name="company_name"]').prop('required', true);
                        $('input[name="group_name"]').prop('required', false);
                        $('input[name^="group_companies"]').prop('required', false);
                    }
                    $('input[name="full_name"]').prop('required', false);
                    $('input[name="phone"]').prop('required', false);
                }
            });

            const activeTab = $('a[data-toggle="tab"].active').attr('aria-controls');
            $('a[data-toggle="tab"][aria-controls="' + activeTab + '"]').trigger('shown.bs.tab');

            $('.division_id').on('change', function () {
                console.log('Division changed to:', $(this).val());
                let self = $(this);
                $('.district_id').html('<option value="">Loading...</option>');
                $('.upazila_id').html('<option value="">Select District First</option>');

                if (self.val()) {
                    $.ajax({
                        url: "{{ route('lead.division') }}",
                        type: "GET",
                        data: { division_id: self.val() },
                        cache: false,
                        success: function (data) {
                            console.log('Districts loaded successfully');
                            $('.district_id').html(data);

                            // If editing, set district and trigger change
                            @if($lead->district_id)
                            $('.district_id')
                                .val('{{ $lead->district_id }}')
                                .trigger('change');
                            @endif
                        },
                        error: function () {
                            console.log('Error loading districts');
                            $('.district_id').html('<option value="">Error loading districts</option>');
                        }
                    });
                } else {
                    $('.district_id').html('<option value="">Select Division First</option>');
                    $('.upazila_id').html('<option value="">Select Division First</option>');
                }
            });

            // District change handler
            $('.district_id').on('change', function () {
                console.log('District changed to:', $(this).val());
                let self = $(this);
                $('.upazila_id').html('<option value="">Loading...</option>');

                if (self.val()) {
                    $.ajax({
                        url: "{{ route('lead.upazila') }}",
                        type: "GET",
                        data: { district_id: self.val() },
                        cache: false,
                        success: function (data) {
                            console.log('Upazilas loaded successfully');
                            $('.upazila_id').html(data);

                            // If editing, set upazila
                            @if($lead->upazila_id)
                            $('.upazila_id').val('{{ $lead->upazila_id }}');
                            @endif
                        },
                        error: function () {
                            console.log('Error loading upazilas');
                            $('.upazila_id').html('<option value="">Error loading upazilas</option>');
                        }
                    });
                } else {
                    $('.upazila_id').html('<option value="">Select District First</option>');
                }
            });

            // 🚀 Initialization (works for both create & edit)
            @if($lead->division_id)
            console.log('Editing mode: preloading division/district/upazila...');
            $('.division_id')
                .val('{{ $lead->division_id }}')
                .trigger('change');
            @endif

            // Contact person management
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
                        <button type="button" class="btn btn-danger delete w-100">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
                $('.contact_row').append(addrow);
            });

            $(document).on('click', '.delete', function() {
                if ($('.contact_row tr').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('At least one contact person is required.');
                }
            });

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });

        }); // End of document.ready

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
    </script>
@endsection
