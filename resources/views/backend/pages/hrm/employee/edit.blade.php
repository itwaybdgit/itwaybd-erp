@extends('admin.master')

@section('title')
    Hrm - {{ $title }}
@endsection


{{-- @section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Employee Edit</h3>
                    <div class="card-tools">

                        <a class="btn btn-default" href="{{ route('hrm.employee.create') }}"><i class="fas fa-plus"></i>
                            Add New</a>

                        <span id="buttons"></span>

                        <a class="btn btn-tool btn-default" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </a>
                        <a class="btn btn-tool btn-default" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="{{ route('hrm.employee.update', $model->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Basic details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label for="">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input-rounded" value="{{ $model->name }}"
                                            name="name">
                                        @error('name')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label for="">Attendance names <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->am_name }}" name="am_name">
                                        @error('name')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label for="">Employee Id<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->id_card }}" name="id_card">
                                        @error('id_card')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Profile Photo<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control input-rounded" value="{{ old('image') }}"
                                            name="image">
                                        @error('image')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Signature [PNG Photo]<span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control input-rounded"
                                            value="{{ old('emp_signature') }}" name="emp_signature">
                                        @error('emp_signature')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control input-rounded"
                                            value="{{ $model->email }}" name="email">
                                        @error('email')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Personal Number <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control input-rounded"
                                            value="{{ $model->personal_phone }}" name="personal_phone">
                                        @error('personal_phone')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Office Number</label>
                                        <input type="number" class="form-control input-rounded"
                                            value="{{ $model->office_phone }}" name="office_phone">
                                        @error('office_phone')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Marital Status</label>
                                        <select value="{{ $model->marital_status }}" name="marital_status"
                                            class="form-control">
                                            <option {{ $model->marital_status == 'married' ? 'selected' : '' }}
                                                value="married">Married</option>
                                            <option {{ $model->marital_status == 'unmarried' ? 'selected' : '' }}
                                                value="unmarried">Unmarried</option>
                                        </select>
                                        @error('marital_status')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Nid</label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->nid }}" name="nid">
                                        @error('nid')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Date Of Birth</label>
                                        <input type="date" class="form-control input-rounded"
                                            value="{{ $model->dob }}" name="dob">
                                        @error('dob')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Blood Group</label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->blood_group }}" name="blood_group">
                                        @error('blood_group')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Gender <span class="text-danger">*</span></label>
                                        <select value="{{ $model->gender }}" name="gender" class="form-control">
                                            <option {{ $model->gender == 'male' ? 'selected' : '' }} value="male">Male
                                            </option>
                                            <option {{ $model->gender == 'female' ? 'selected' : '' }} value="female">
                                                Female
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Reference</label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->reference }}" name="reference">
                                        @error('reference')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Guardian Number</label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->guardian_number }}" name="guardian_number">
                                        @error('guardian_number')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Guardian NID Photo</label>
                                        <input type="file" class="form-control input-rounded"
                                            value="{{ old('guardian_nid') }}" name="guardian_nid">
                                        @error('guardian_nid')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Experience</label>
                                        <textarea name="experience" class="form-control input-rounded">{{ $model->experience }}</textarea>
                                        @error('experience')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Active Address</label>
                                        <textarea name="Active_address" class="form-control input-rounded">{{ $model->Active_address }}</textarea>
                                        @error('Active_address')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Permanent Address</label>
                                        <textarea name="permanent_address" class="form-control input-rounded">{{ $model->permanent_address }}</textarea>
                                        @error('permanent_address')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Qualification Info</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label for="">Achieved Degree</label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->achieved_degree }}" name="achieved_degree">
                                        @error('achieved_degree')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Institution</label>
                                        <input type="text" class="form-control input-rounded"
                                            value="{{ $model->institution }}" name="institution">
                                        @error('institution')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Passing Year</label>
                                        <input type="number" class="form-control input-rounded"
                                            value="{{ $model->passing_year }}" name="passing_year">
                                        @error('passing_year')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Office Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label for="">Joining Date</label>
                                        <input type="date" class="form-control input-rounded"
                                            value="{{ $model->join_date }}" name="join_date">
                                        @error('join_date')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Last In Date</label>
                                        <input type="time" class="form-control input-rounded"
                                            value="{{ $model->last_in_time }}" name="last_in_time">
                                        @error('last_in_time')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Department <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ $model->department }}" name="department"
                                            class="form-control">
                                        @error('department')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Position <span class="text-danger">*</span></label>
                                        <select value="{{ $model->position_id }}" name="position_id"
                                            class="form-control">
                                            <option selected disabled>Select Position</option>
                                            @foreach ($positions as $value)
                                                <option {{ $model->position_id == $value->id ? 'selected' : '' }}
                                                    value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('position_id')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Branch <span class="text-danger">*</span></label>
                                        <select value="{{ $model->branch_id }}" name="branch_id" class="form-control">
                                            <option selected value="0">No Applicable</option>
                                            @foreach ($branchs as $value)
                                                <option {{ $model->branch_id == $value->id ? 'selected' : '' }}
                                                    value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @php
                                        $areasjson = json_decode($model->area) ?? [];
                                    @endphp
                                    <div class="col-md-4 mb-1">
                                        <label for="">Area <span class="text-danger">*</span></label>
                                        <select name="area[]" class="form-control select2" multiple>
                                            @foreach ($area as $item)
                                                <option {{ in_array($item['id'], $areasjson) ? 'selected' : '' }}
                                                    value="{{ $item['id'] }}">{{ $item['area_name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Salary <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control input-rounded"
                                            value="{{ $model->salary }}" name="salary">
                                        @error('salary')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Attendance Bonus <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control input-rounded"
                                            value="{{ $model->attendanceBonus }}" name="attendanceBonus">
                                        @error('attendanceBonus')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Hourly Rate <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control input-rounded"
                                            value="{{ old('hourlyRate') }}" name="hourlyRate">
                                        @error('hourlyRate')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Overtime <span class="text-danger">*</span></label>
                                        <select name="over_time_is" class="form-control" id="">
                                            <option value="yes" {{ $model->over_time_is == 'yes' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="no" {{ $model->over_time_is == 'no' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                        @error('over_time_is')
                                            <span class=" error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label for="">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control">

                                            <option value="Active"
                                                {{ $model->status == 'Active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="left"
                                                {{ $model->status == 'left' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="error text-red text-bold">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
@endsection --}}

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <form action="{{ route('hrm.employee.update', $model->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-alert></x-alert>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $page_heading ?? 'Edit' }}</h4>
                        <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('name') ?? $model->name }}" name="name">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Employee Id<span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" value="{{ $model->id_card }}"
                                    name="id_card">
                                @error('id_card')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Email</label>
                                <input type="email" class="form-control input-rounded"
                                    value="{{ old('email') ?? $model->email }}" name="email">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Personal Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control input-rounded"
                                    value="{{ old('personal_phone') ?? $model->personal_phone }}" name="personal_phone">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Office Number</label>
                                <input type="number" class="form-control input-rounded"
                                    value="{{ old('office_phone') ?? $model->office_phone }}" name="office_phone">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Marital Status</label>
                                <select name="marital_status" class="form-control">
                                    <option {{ $model->marital_status == 'married' ? 'selected' : '' }} value="married">
                                        Married
                                    </option>
                                    <option {{ $model->marital_status == 'unmarried' ? 'selected' : '' }}
                                        value="unmarried">
                                        Unmarried</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Profile Photo<span class="text-danger">*</span></label>
                                <input type="file" class="form-control input-rounded" value="{{ old('image') }}"
                                    name="image">
                                @error('image')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Signature [PNG Photo Only]<span class="text-danger">*</span></label>
                                <input type="file" class="form-control input-rounded" value="{{ old('emp_signature') }}"
                                    name="emp_signature">
                                @error('emp_signature')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Nid</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('nid') ?? $model->nid }}" name="nid">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Date Of Birth</label>
                                <input type="date" class="form-control input-rounded"
                                    value="{{ old('dob') ?? $model->dob }}" name="dob">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control">
                                    <option {{ $model->gender == 'male' ? 'selected' : '' }} value="male">Male
                                    </option>
                                    <option {{ $model->gender == 'female' ? 'selected' : '' }} value="female">Female
                                    </option>
                                </select>
                            </div>
                            @php
                                $zone_id = explode(',', $model->zone_id);
                                $subzone_id = explode(',', $model->subzone_id);
                            @endphp
                            <div class="col-md-4 mb-1">
                                <label for="">Zone <span class="text-danger">*</span></label>
                                <select name="zone_id[]" class="form-control select2" multiple>
                                    @foreach ($zones as $item)
                                        <option {{ in_array($item->id, $zone_id) ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('zone_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Sub Zone <span class="text-danger">*</span></label>
                                <select name="subzone_id[]" id="sub_zone_id" class="form-control select2" multiple>
                                    @foreach ($subzones as $subzone)
                                        <option {{ in_array($subzone->id, $subzone_id) ? 'selected' : '' }}
                                            value="{{ $subzone->id }}">{{ $subzone->name }}</option>
                                    @endforeach
                                </select>
                                @error('subzone_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Reference</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('reference') ?? $model->reference }}" name="reference">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Experience</label>
                                <textarea name="experience" class="form-control input-rounded">
                                {{ old('experience') ?? $model->experience }}
                            </textarea>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Active Address</label>
                                <textarea name="Active_address" class="form-control input-rounded">
                                {{ old('Active_address') ?? $model->Active_address }}
                            </textarea>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Permanent Address</label>
                                <textarea name="permanent_address" class="form-control input-rounded">
                                {{ old('permanent_address') ?? $model->permanent_address }}
                            </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Qualification Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <label for="">Achieved Degree</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('achieved_degree') ?? $model->achieved_degree }}"
                                    name="achieved_degree">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Institution</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('institution') ?? $model->institution }}" name="institution">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Passing Year</label>
                                <input type="number" class="form-control input-rounded"
                                    value="{{ old('passing_year') ?? $model->passing_year }}" name="passing_year">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Office Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <label for="">Joining Date</label>
                                <input type="date" class="form-control input-rounded"
                                    value="{{ old('join_date') ?? $model->join_date }}" name="join_date">
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Last In Date</label>
                                <input type="time" class="form-control input-rounded"
                                    value="{{ $model->last_in_time }}" name="last_in_time">
                                @error('last_in_time')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Department </label>
                                <select name="department_id" class="form-control">
                                    <option selected disabled>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option {{ $model->department_id == $department->id ? 'selected' : '' }}
                                            value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Designation </label>
                                <select name="designation_id" class="form-control">
                                    <option selected disabled>Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option {{ $model->designation_id == $designation->id ? 'selected' : '' }}
                                            value="{{ $designation->id }}">{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Team <span class="text-danger">*</span></label>
                                <select name="team" class="form-control select2">
                                    <option selected disabled>Select Team</option>
                                    @foreach ($teams as $value)
                                        <option {{ $model->team == $value->id ? 'selected' : '' }}
                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Salary <span class="text-danger">*</span></label>
                                <input type="number" class="form-control input-rounded"
                                    value="{{ old('salary') ?? $model->salary }}" name="salary">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Status</label>
                                <select name="status" class="form-control">
                                    <option {{ $model->status == 'active' ? 'selected' : '' }} value="active">Crrently
                                        Active
                                    </option>
                                    <option {{ $model->status == 'left' ? 'selected' : '' }} value="left">Left
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Is Login</label>
                                <select name="is_login" id="_isLogin" onchange="isLogin()" class="form-control">
                                    <option {{ $model->is_login == 'true' ? 'selected' : '' }} value="true">Yes
                                    </option>
                                    <option {{ $model->is_login == 'false' ? 'selected' : '' }} value="false">No
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" id="_logindiv">
                    <div class="card-header">
                        <h4 class="card-title">Login Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-1">
                                <label for="">User Name</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('username') ?? ($model->employelist->username ?? '') }}"
                                    name="username">
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Access Roll</label>
                                <select name="roll_id" class="form-control">
                                    <option value="married">Select Roll</option>
                                    @foreach ($userrolls as $userroll)
                                        <option
                                            {{ ($model->employelist->roll_id ?? 0) == $userroll->id ? 'selected' : '' }}
                                            value="{{ $userroll->id }}">{{ $userroll->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Access Type</label>
                                <select name="access_type" class="form-control">
                                    <option selected disabled>Select Type</option>
                                    <option {{ ($model->employelist->is_admin ?? 0) == 5 ? 'selected' : '' }}
                                        value="5">
                                        Manager</option>
                                    <option {{ ($model->employelist->is_admin ?? 0) == 4 ? 'selected' : '' }}
                                        value="4">
                                        Employee</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Password</label>
                                <input type="password" class="form-control input-rounded"
                                    value="{{ old('password') ?? $model->password }}" name="password">
                            </div>

                            <div class="col-md-3 mb-1">
                                <label for="">Confirm Password</label>
                                <input type="password" class="form-control input-rounded"
                                    value="{{ old('password_confirmation') ?? $model->password_confirmation }}"
                                    name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-1 form-group" style="text-align:right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function isLogin() {
            let getValue = '{{ $model->is_login }}';
            if (getValue == 'true') {
                $('#_logindiv').removeClass('d-none')
            } else {
                $('#_logindiv').addClass('d-none')
            }

        }
        isLogin();

        $(document).on('change', '#zone_id', function() {
            let self = $(this);
            $.ajax({
                "url": "{{ route('api.subzones') }}",
                "type": "GET",
                "data": {
                    zone_id: self.val()
                },
                cache: false,
                success: function(data) {
                    $('#sub_zone_id').empty();
                    $('#sub_zone_id').html(data);
                }
            });
        });
    </script>
@endsection
