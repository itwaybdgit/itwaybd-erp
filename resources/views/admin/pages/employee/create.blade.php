@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <form action="{{ $store_url ?? '#' }}" method="POST" enctype="multipart/form-data" autocomplete="false">
                @csrf
                <x-alert></x-alert>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Basic details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-rounded" value="{{ old('name') }}"
                                    name="name">
                                @error('name')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <input autocomplete="false" name="hidden" type="text" class="hidden">
                            <div class="col-md-4 mb-1">
                                <label for="">Employee Id</label>
                                <input type="text" class="form-control input-rounded" value="{{ old('id_card') }}"
                                    name="id_card">
                                @error('id_card')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Personal Email</label>
                                <input type="email" class="form-control input-rounded" value="{{ old('email') }}"
                                    name="email">
                                @error('email')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
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
                                <label for="">Personal Number </label>
                                <input type="number" class="form-control input-rounded"
                                    value="{{ old('personal_phone') }}" name="personal_phone">
                                @error('personal_phone')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Marital Status</label>
                                <select name="marital_status" class="form-control">
                                    <option value="married">Married</option>
                                    <option value="unmarried">Unmarried</option>
                                </select>
                                @error('marital_status')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Nid</label>
                                <input type="text" class="form-control input-rounded" value="{{ old('nid') }}"
                                    name="nid">
                                @error('nid')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Date Of Birth</label>
                                <input type="date" class="form-control input-rounded" value="{{ old('dob') }}"
                                    name="dob">
                                @error('dob')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Blood Group</label>
                                <input type="text" class="form-control input-rounded" value="{{ old('blood_group') }}"
                                    name="blood_group">
                                @error('blood_group')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Gender </label>
                                <select name="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Present Address</label>
                                <textarea value="{{ old('present_address') }}" name="present_address" class="form-control input-rounded"></textarea>
                                @error('present_address')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Permanent Address</label>
                                <textarea value="{{ old('permanent_address') }}" name="permanent_address" class="form-control input-rounded"></textarea>
                                @error('permanent_address')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Reference</label>
                                <input type="text" class="form-control input-rounded" value="{{ old('reference') }}"
                                    name="reference">
                                @error('reference')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Employee Status</label>
                                <select name="status" class="form-control" id="">
                                    <option value="Active">Active</option>
                                    <option value="Resigned">Resigned</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                                @error('status')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Received Documents Checkbox</label>
                                <select name="received_documents_checkbox[]"  class="form-control js-example-tokenizer" multiple="multiple">
                                  <option value="CV">CV</option>
                                </select>
                                @error('received_documents_checkbox')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                              <label for="">Type </label>
                                <select name="type[]" class="form-control js-example-tokenizer" multiple="multiple">
                                    <option value="team_leader">Team Leader</option>
                                    <option value="Sales">Sales</option>
                                    <option value="legal_department">Legal department</option>
                                    <option value="billing_department">Bliing Department</option>
                                    <option value="tx_planning">Tx Planning</option>
                                    <option value="transmission">Transmission</option>
                                    <option value="level_1">Level 1</option>
                                    <option value="level_2">Level 2</option>
                                    <option value="level_3">Level 3</option>
                                    <option value="level_4">Level 4</option>
                                </select>
                                @error('type')
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
                                <label for="">Last Accademic Degrees </label>
                                <select name="achieved_degree" class="form-control select2">
                                    <option value="Uneducated">Uneducated</option>
                                    <option value="PSC">PSC</option>
                                    <option value="JSC">JSC</option>
                                    <option value="SSC">SSC</option>
                                    <option value="HSC">HSC</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Honours/Equivalent">Honours/Equivalent</option>
                                    <option value="Masters/Equivalent">Masters/Equivalent</option>
                                    <option value="Mphil/Phd">Mphil/Phd</option>
                                </select>
                                @error('achieved_degree')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Name of Institution</label>
                                <input type="text" class="form-control input-rounded"
                                    value="{{ old('institution') }}" name="institution">
                                @error('institution')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Passing Year</label>
                                <input type="number" class="form-control input-rounded"
                                    value="{{ old('passing_year') }}" name="passing_year">
                                @error('passing_year')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Working Experiences</label>
                                <textarea value="{{ old('experience') }}" name="experience" class="form-control input-rounded"></textarea>
                                @error('experience')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Professional Experiences</label>
                                <textarea value="{{ old('professional_experiences') }}" name="professional_experiences" class="form-control input-rounded"></textarea>
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
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                @error('tax_deduction')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="tin">Taxpayer Identification Number (TIN)</label>
                                 <input type="text" name="tin" class="form-control">
                                @error('tin')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="bank_account_information">Bank Account Information</label>
                                 <input type="text" name="bank_account_information" class="form-control">
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
                                <input type="date" class="form-control input-rounded" value="{{ old('join_date') }}"
                                    name="join_date">
                                @error('join_date')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Name of Supervisor</label>
                                <input type="text" class="form-control input-rounded" value="{{ old('supervisor') }}"
                                    name="supervisor">
                                @error('supervisor')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-1">
                                <label for="">Official E-mail</label>
                                <input type="text" class="form-control input-rounded" value="{{ old('official_email') }}"
                                    name="official_email">
                                @error('official_email')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Office Number</label>
                                <input type="number" class="form-control input-rounded" value="{{ old('office_phone') }}"
                                    name="office_phone">
                                @error('office_phone')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Last In Date</label>
                                <input type="time" class="form-control input-rounded"
                                    value="{{ old('last_in_time') ?? '21:00:00' }}" name="last_in_time">
                                @error('last_in_time')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Choose Team </label>
                                <select name="team" class="form-control">
                                    @php
                                      use App\Models\Team;
                                      $teams = Team::all();
                                    @endphp
                                     <option selected value="0">Non Team </option>
                                    @foreach ($teams as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                                    @foreach ($departments as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Designations</label>
                                <select name="designation_id" class="form-control">
                                    <option selected disabled>Select Designations</option>
                                    @foreach ($designations as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Net Salary</label>
                                <input type="number" class="form-control input-rounded" value="{{ old('salary') }}"
                                    name="salary">
                                @error('salary')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Overtime</label>
                                <select name="over_time_is" class="form-control">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                                @error('salary')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-1">
                                <label for="">Is Login</label>
                                <select name="is_login" id="_isLogin" onchange="isLogin()" class="form-control">
                                    <option value="true">Yes</option>
                                    <option selected value="false">No</option>
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
                                <input type="text" class="form-control input-rounded" value="{{ old('username') }}"
                                    name="username">
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Access Roll</label>
                                <select name="roll_id" class="form-control">
                                    <option selected disabled>Select Roll</option>
                                    @foreach ($userrolls as $userroll)
                                        <option value="{{ $userroll->id }}">{{ $userroll->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Access Type</label>
                                <select name="access_type" class="form-control">
                                    <option selected disabled>Select Type</option>
                                    <option value="5">Manager</option>
                                    <option value="4">Employee</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="">Password</label>
                                <input type="password" class="form-control input-rounded" autocomplete="new-password"
                                    name="password">
                            </div>

                            <div class="col-md-3 mb-1">
                                <label for="">Confirm Password</label>
                                <input type="password" class="form-control input-rounded"
                                    value="{{ old('password_confirmation') }}" name="password_confirmation">
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
            let getValue = $('#_isLogin option:selected').val();
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
