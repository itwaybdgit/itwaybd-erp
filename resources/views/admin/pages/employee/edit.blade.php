@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <form action="{{ $update_url ?? '#' }}" method="POST" autocomplete="off" enctype="multipart/form-data">
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
                                    value="{{ old('name') ?? $editinfo->name }}" name="name">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Personal Email</label>
                                <input type="email" class="form-control input-rounded"
                                    value="{{ old('email') ?? $editinfo->email }}" name="email">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Profile Photo</label>
                                <input type="file" class="form-control input-rounded" value="{{ old('image') }}"
                                    name="image">
                                @error('image')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Signature [PNG Photo Only]</label>
                                <input type="file" class="form-control input-rounded" value="{{ old('emp_signature') }}"
                                    name="emp_signature">
                                @error('emp_signature')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Personal Number <span class="text-danger">*</span></label>
                                <input type="number" class="form-control input-rounded"
                                    value="{{ old('personal_phone') ?? $editinfo->personal_phone }}" name="personal_phone">
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Marital Status</label>
                                <select name="marital_status" class="form-control">
                                    <option {{ $editinfo->marital_status == 'married' ? 'selected' : '' }} value="married">
                                        Married
                                    </option>
                                    <option {{ $editinfo->marital_status == 'unmarried' ? 'selected' : '' }}
                                        value="unmarried">Unmarried</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Nid</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('nid') ?? $editinfo->nid }}" name="nid">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Date Of Birth</label>
                                <input type="date" class="form-control input-rounded"
                                    value="{{ old('dob') ?? $editinfo->dob }}" name="dob">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control">
                                    <option {{ $editinfo->gender == 'male' ? 'selected' : '' }} value="male">Male
                                    </option>
                                    <option {{ $editinfo->gender == 'female' ? 'selected' : '' }} value="female">Female
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Reference</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('reference') ?? $editinfo->reference }}" name="reference">
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Active Address</label>
                                <textarea name="Active_address" class="form-control input-rounded">
                                {{ old('Active_address') ?? $editinfo->Active_address }}
                            </textarea>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Permanent Address</label>
                                <textarea name="permanent_address" class="form-control input-rounded">
                                {{ old('permanent_address') ?? $editinfo->permanent_address }}
                            </textarea>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Employee Status</label>
                                <select name="status" class="form-control" id="">
                                    <option {{ $editinfo->status == 'Active' ? 'selected' : '' }} value="Active">Active
                                    </option>
                                    <option {{ $editinfo->status == 'Resigned' ? 'selected' : '' }} value="Resigned">Resigned
                                    </option>
                                    <option {{ $editinfo->status == 'Suspended' ? 'selected' : '' }} value="Suspended">
                                        Suspended</option>
                                </select>
                                @error('status')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Received Documents Checkbox</label>
                                <select name="received_documents_checkbox[]" class="form-control js-example-tokenizer"
                                    multiple="multiple">
                                    @foreach (explode(',', $editinfo->received_documents_checkbox ?? '') as $item)
                                        <option selected value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('received_documents_checkbox')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Type </label>
                                @php
                                    $typevalue = explode(',', $editinfo->type ?? '');
                                @endphp
                                <select name="type[]" class="form-control js-example-tokenizer" multiple="multiple">
                                    <option {{ in_array('team_leader', $typevalue) ? 'selected' : '' }} value="team_leader">
                                        Team Leader</option>
                                    <option {{ in_array('Sales', $typevalue) ? 'selected' : '' }} value="Sales">Sales
                                    </option>
                                    <option {{ in_array('legal_department', $typevalue) ? 'selected' : '' }}
                                        value="legal_department">Legal department</option>
                                    <option {{ in_array('billing_department', $typevalue) ? 'selected' : '' }}
                                        value="billing_department">Bliing Department</option>
                                    <option {{ in_array('tx_planning', $typevalue) ? 'selected' : '' }} value="tx_planning">
                                        Tx Planning</option>
                                    <option {{ in_array('transmission', $typevalue) ? 'selected' : '' }}
                                        value="transmission">Transmission</option>
                                    <option {{ in_array('level_1', $typevalue) ? 'selected' : '' }} value="level_1">Level 1
                                    </option>
                                    <option {{ in_array('level_2', $typevalue) ? 'selected' : '' }} value="level_2">Level 2
                                    </option>
                                    <option {{ in_array('level_3', $typevalue) ? 'selected' : '' }} value="level_3">Level 3
                                    </option>
                                    <option {{ in_array('level_4', $typevalue) ? 'selected' : '' }} value="level_4">Level 4
                                    </option>
                                </select>

                                @error('type')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
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
                        <select name="achieved_degree" class="form-control select2">
                            <option {{ $editinfo->achieved_degree == 'Uneducated' ? 'selected' : '' }} value="Uneducated">
                                Uneducated</option>
                            <option {{ $editinfo->achieved_degree == 'PSC' ? 'selected' : '' }} value="PSC">PSC</option>
                            <option {{ $editinfo->achieved_degree == 'JSC' ? 'selected' : '' }} value="JSC">JSC</option>
                            <option {{ $editinfo->achieved_degree == 'SSC' ? 'selected' : '' }} value="SSC">SSC</option>
                            <option {{ $editinfo->achieved_degree == 'HSC' ? 'selected' : '' }} value="HSC">HSC</option>
                            <option {{ $editinfo->achieved_degree == 'Diploma' ? 'selected' : '' }} value="Diploma">Diploma
                            </option>
                            <option {{ $editinfo->achieved_degree == 'Honours/Equivalent' ? 'selected' : '' }}
                                value="Honours/Equivalent">Honours/Equivalent</option>
                            <option {{ $editinfo->achieved_degree == 'Masters/Equivalent' ? 'selected' : '' }}
                                value="Masters/Equivalent">Masters/Equivalent</option>
                            <option {{ $editinfo->achieved_degree == 'Mphil/Phd' ? 'selected' : '' }} value="Mphil/Phd">
                                Mphil/Phd</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Institution</label>
                        <input type="text" class="form-control input-rounded"
                            value="{{ old('institution') ?? $editinfo->institution }}" name="institution">
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Passing Year</label>
                        <input type="number" class="form-control input-rounded"
                            value="{{ old('passing_year') ?? $editinfo->passing_year }}" name="passing_year">
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Working Experiences</label>
                        <textarea value="{{ old('experience') }}" name="experience" class="form-control input-rounded">{{ $editinfo->experience }}</textarea>
                        @error('experience')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Professional Experiences</label>
                        <textarea value="{{ $editinfo->professional_experiences }}" name="professional_experiences"
                            class="form-control input-rounded"></textarea>
                        @error('professional_experiences')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Salary & Bank Acc Info</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-1">
                        <label for="tax_deduction">Tax Deduction</label>
                        <select name="tax_deduction" class="form-control">
                            <option {{ $editinfo->tax_deduction == 'Yes' ? 'selected' : '' }} value="Yes">Yes</option>
                            <option {{ $editinfo->tax_deduction == 'No' ? 'selected' : '' }} value="No">No</option>
                        </select>
                        @error('tax_deduction')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="tin">Taxpayer Identification Number (TIN)</label>
                        <input type="text" value="{{ $editinfo->tin }}" name="tin" class="form-control">
                        @error('tin')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="bank_account_information">Bank Account Information</label>
                        <input type="text" value="{{ $editinfo->bank_account_information }}"
                            name="bank_account_information" class="form-control">
                        @error('bank_account_information')
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
                            value="{{ old('join_date') ?? $editinfo->join_date }}" name="join_date">
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Choose Team </label>
                        <select name="team" class="form-control">
                            @php
                                use App\Models\Team;
                                $teams = Team::all();
                            @endphp

                            <option selected value="0">Non Team </span></option>
                            @foreach ($teams as $value)
                                <option {{ $editinfo->team == $value->id ? 'selected' : '' }} value="{{ $value->id }}">
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('team')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="">Department </label>
                        <select name="department_id" class="form-control">
                            <option selected disabled>Select Department</option>
                            @foreach ($departments as $department)
                                <option {{ $editinfo->department_id == $department->id ? 'selected' : '' }}
                                    value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Designation </label>
                        <select name="designation_id" class="form-control">
                            <option selected disabled>Select Designation</option>
                            @foreach ($designations as $designation)
                                <option {{ $editinfo->designation_id == $designation->id ? 'selected' : '' }}
                                    value="{{ $designation->id }}">{{ $designation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Name of Supervisor</label>
                        <input type="text" class="form-control input-rounded" value="{{ $editinfo->supervisor }}"
                            name="supervisor">
                        @error('supervisor')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-1">
                        <label for="">Official E-mail</label>
                        <input type="text" class="form-control input-rounded" value="{{ $editinfo->official_email }}"
                            name="official_email">
                        @error('official_email')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Office Number</label>
                        <input type="number" class="form-control input-rounded"
                            value="{{ old('office_phone') ?? $editinfo->office_phone }}" name="office_phone">
                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="">Net Salary <span class="text-danger">*</span></label>
                        <input type="number" class="form-control input-rounded"
                            value="{{ old('salary') ?? $editinfo->salary }}" name="salary">
                    </div>
                    {{-- <div class="col-md-4 mb-1">
                                <label for="">Status</label>
                                <select name="status" class="form-control">
                                    <option {{ $editinfo->status == 'active' ? 'selected' : '' }} value="active">Crrently
                                        Active
                                    </option>
                                    <option {{ $editinfo->status == 'left' ? 'selected' : '' }} value="left">Left
                                    </option>
                                </select>
                            </div> --}}
                    {{-- <div class="col-md-4 mb-1">
                            <label for="">Is Login</label>
                            <select name="is_login" id="_isLogin" onchange="isLogin()" class="form-control">
                                <option {{$editinfo->is_login == "true" ? 'selected':""}} value="true">Yes
                                </option>
                                <option {{$editinfo->is_login == "false" ? 'selected':""}} value="false">No
                                </option>
                            </select>
                        </div> --}}
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
                            value="{{ old('username') ?? ($editinfo->employelist->username ?? '') }}" name="username">
                    </div>
                    <div class="col-md-3 mb-1">
                        <label for="">Access Roll</label>
                        <select name="roll_id" class="form-control">
                            <option value="married">Select Roll</option>
                            @foreach ($userrolls as $userroll)
                                <option {{ ($editinfo->employelist->roll_id ?? 0) == $userroll->id ? 'selected' : '' }}
                                    value="{{ $userroll->id }}">{{ $userroll->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-1">
                        <label for="">Access Type</label>
                        <select name="access_type" class="form-control">
                            <option selected disabled>Select Type</option>
                            <option {{ ($editinfo->employelist->is_admin ?? 0) == 5 ? 'selected' : '' }} value="5">
                                Manager</option>
                            <option {{ ($editinfo->employelist->is_admin ?? 0) == 4 ? 'selected' : '' }} value="4">
                                Employee</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-1">
                        <label for="">Password</label>
                        <input type="password" class="form-control input-rounded"
                            value="{{ old('password') ?? $editinfo->password }}" autocomplete="new-password"
                            name="password">
                    </div>

                    <div class="col-md-3 mb-1">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control input-rounded"
                            value="{{ old('password_confirmation') ?? $editinfo->password_confirmation }}"
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

@push('scripts')
    <script>
        function isLogin() {
            let getValue = '{{ $editinfo->is_login }}';
            if (getValue == 'true') {
                $('#_logindiv').removeClass('d-none')
            } else {
                $('#_logindiv').addClass('d-none')
            }

        }
        isLogin();
        $(".js-example-tokenizer").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })
    </script>
@endpush
