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
                                <h3>Input Fields to show while creating lead:</h3>
                                <div class="col-12 mb-3">

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="division" name="lead_fields[]" value="division"
                                            {{ in_array('division', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="division">
                                            <strong>Division</strong>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="district" name="lead_fields[]" value="district"
                                            {{ in_array('district', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="district">
                                            <strong>District</strong>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="upazila" name="lead_fields[]" value="upazila"
                                            {{ in_array('upazila', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="upazila">
                                            <strong>Upazila</strong>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="address" name="lead_fields[]" value="address"
                                            {{ in_array('address', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="address">
                                            <strong>Address</strong>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="branch" name="lead_fields[]" value="branch"
                                            {{ in_array('branch', $editinfo->lead_fields ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="branch">
                                            <strong>Branch</strong>
                                        </label>
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

            // If district checked → auto-check division
            district.addEventListener('change', function () {
                if (this.checked) {
                    division.checked = true;
                }
            });

            // If upazila checked → auto-check district + division
            upazila.addEventListener('change', function () {
                if (this.checked) {
                    district.checked = true;
                    division.checked = true;
                }
            });
        });
    </script>
@endsection
