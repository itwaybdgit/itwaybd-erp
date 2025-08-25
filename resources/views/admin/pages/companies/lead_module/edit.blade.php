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
                                <h3 class="mb-2">Input Fields to show while creating lead:</h3>

                                <div class="col-12 mb-3">

                                    <div class="row">
                                        <div class="col-md-2 form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="division" name="lead_fields[]" value="division"
                                                {{ in_array('division', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="division">
                                                <strong>Division</strong>
                                            </label>
                                        </div>
                                        <div id="division_default" class="col-md-4 ms-4 mb-3" style="display: {{ in_array('division', $editinfo->lead_fields ?? []) ? 'block' : 'none' }};">
                                            <label for="division_default_value" class="form-label">Default Division:</label>
                                            <select class="form-control" id="division_default_value" name="division_default_value">
                                                <option value="">Select Default Division</option>
                                                @foreach($divisions ?? [] as $division_item)
                                                    <option value="{{ $division_item->id }}"
                                                        {{ ($editinfo->division_default_value ?? '') == $division_item->id ? 'selected' : '' }}>
                                                        {{ $division_item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="district" name="lead_fields[]" value="district"
                                                {{ in_array('district', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="district">
                                                <strong>District</strong>
                                            </label>
                                        </div>
                                        <div id="district_default" class="col-md-4 ms-4 mb-3" style="display: {{ in_array('district', $editinfo->lead_fields ?? []) ? 'block' : 'none' }};">
                                            <label for="district_default_value" class="form-label">Default District:</label>
                                            <select class="form-control" id="district_default_value" name="district_default_value">
                                                <option value="">Select Default District</option>
                                                @foreach($districts ?? [] as $district_item)
                                                    <option value="{{ $district_item->id }}"
                                                        {{ ($editinfo->district_default_value ?? '') == $district_item->id ? 'selected' : '' }}>
                                                        {{ $district_item->district_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="upazila" name="lead_fields[]" value="upazila"
                                                {{ in_array('upazila', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="upazila">
                                                <strong>Upazila</strong>
                                            </label>
                                        </div>
                                        <div id="upazila_default" class="col-md-4 ms-4 mb-3" style="display: {{ in_array('upazila', $editinfo->lead_fields ?? []) ? 'block' : 'none' }};">
                                            <label for="upazila_default_value" class="form-label">Default Upazila:</label>
                                            <select class="form-control" id="upazila_default_value" name="upazila_default_value">
                                                <option value="">Select Default Upazila</option>
                                                @foreach($upazilas ?? [] as $upazila_item)
                                                    <option value="{{ $upazila_item->id }}"
                                                        {{ ($editinfo->upazila_default_value ?? '') == $upazila_item->id ? 'selected' : '' }}>
                                                        {{ $upazila_item->upozilla_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="address" name="lead_fields[]" value="address"
                                                {{ in_array('address', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="address">
                                                <strong>Address</strong>
                                            </label>
                                        </div>
                                        <div id="address_default" class="col-md-4 ms-4 mb-3" style="display: {{ in_array('address', $editinfo->lead_fields ?? []) ? 'block' : 'none' }};">
                                            <label for="address_default_value" class="form-label">Default Address:</label>
                                            <input type="text" class="form-control" id="address_default_value" name="address_default_value"
                                                   value="{{ $editinfo->address_default_value ?? '' }}" placeholder="Enter default address">
                                        </div>
                                    </div>

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
        document.addEventListener('DOMContentLoaded', function () {

            const division = document.getElementById('division');
            const district = document.getElementById('district');
            const upazila = document.getElementById('upazila');
            const address = document.getElementById('address');

            const divisionDefault = document.getElementById('division_default');
            const districtDefault = document.getElementById('district_default');
            const upazilaDefault = document.getElementById('upazila_default');
            const addressDefault = document.getElementById('address_default');

            // Function to toggle default value sections
            function toggleDefaultSection(checkbox, defaultSection) {
                if (checkbox.checked) {
                    defaultSection.style.display = 'block';
                } else {
                    defaultSection.style.display = 'none';
                    // Clear the default value when unchecked
                    const select = defaultSection.querySelector('select');
                    const input = defaultSection.querySelector('input');
                    if (select) select.value = '';
                    if (input) input.value = '';
                }
            }

            // Division checkbox change
            division.addEventListener('change', function () {
                toggleDefaultSection(this, divisionDefault);
                if (!this.checked) {
                    // Clear district and upazila dropdowns when division is unchecked
                    $('#district_default_value').html('<option value="">Select Default District</option>');
                    $('#upazila_default_value').html('<option value="">Select Default Upazila</option>');
                }
            });

            // District checkbox change
            district.addEventListener('change', function () {
                if (this.checked) {
                    division.checked = true;
                    divisionDefault.style.display = 'block';
                }
                toggleDefaultSection(this, districtDefault);
                if (!this.checked) {
                    // Clear upazila dropdown when district is unchecked
                    $('#upazila_default_value').html('<option value="">Select Default Upazila</option>');
                }
            });

            // Upazila checkbox change
            upazila.addEventListener('change', function () {
                if (this.checked) {
                    district.checked = true;
                    division.checked = true;
                    districtDefault.style.display = 'block';
                    divisionDefault.style.display = 'block';
                }
                toggleDefaultSection(this, upazilaDefault);
            });

            // Address checkbox change
            address.addEventListener('change', function () {
                toggleDefaultSection(this, addressDefault);
            });

            // Handle unchecking parent elements
            division.addEventListener('change', function () {
                if (!this.checked) {
                    district.checked = false;
                    upazila.checked = false;
                    districtDefault.style.display = 'none';
                    upazilaDefault.style.display = 'none';
                    // Clear values
                    document.getElementById('district_default_value').value = '';
                    document.getElementById('upazila_default_value').value = '';
                }
            });

            district.addEventListener('change', function () {
                if (!this.checked) {
                    upazila.checked = false;
                    upazilaDefault.style.display = 'none';
                    // Clear value
                    document.getElementById('upazila_default_value').value = '';
                }
            });

            // ✅ Division change - AJAX to load districts
            $('#division_default_value').on('change', function() {
                let divisionId = $(this).val();

                // Clear district and upazila dropdowns
                $('#district_default_value').html('<option value="">Select Default District</option>');
                $('#upazila_default_value').html('<option value="">Select Default Upazila</option>');

                if (divisionId) {
                    $.ajax({
                        url: "{{ route('lead.division') }}",
                        type: "GET",
                        data: { division_id: divisionId },
                        cache: false,
                        success: function(data) {
                            $('#district_default_value').html(data);
                        },
                        error: function() {
                            console.log('Error loading districts');
                        }
                    });
                }
            });

            // ✅ District change - AJAX to load upazilas
            $('#district_default_value').on('change', function() {
                let districtId = $(this).val();

                // Clear upazila dropdown
                $('#upazila_default_value').html('<option value="">Select Default Upazila</option>');

                if (districtId) {
                    $.ajax({
                        url: "{{ route('lead.upazila') }}",
                        type: "GET",
                        data: { district_id: districtId },
                        cache: false,
                        success: function(data) {
                            $('#upazila_default_value').html(data);
                        },
                        error: function() {
                            console.log('Error loading upazilas');
                        }
                    });
                }
            });

        });
    </script>
@endsection
