@extends('admin.master')

@section('content')
<style>


.avatar-xxl {
    height: 7rem;
    width: 7rem;
}

.card {
    margin-bottom: 20px;
    -webkit-box-shadow: 0 2px 3px #eaedf2;
    box-shadow: 0 2px 3px #eaedf2;
}

.pb-0 {
    padding-bottom: 0!important;
}

.font-size-16 {
    font-size: 16px!important;
}
.avatar-title {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    background-color: #038edc;
    color: #fff;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-weight: 500;
    height: 100%;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 100%;
}

.bg-soft-primary {
    background-color: rgba(3,142,220,.15)!important;
}
.rounded-circle {
    border-radius: 50%!important;
}

.nav-tabs-custom .nav-item .nav-link.active {
    color: #038edc;
}
.nav-tabs-custom .nav-item .nav-link {
    border: none;
}
.nav-tabs-custom .nav-item .nav-link.active {
    color: #038edc;
}

.avatar-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding-left: 12px;
}

.border-end {
    border-right: 1px solid #eff0f2 !important;
}

.d-inline-block {
    display: inline-block!important;
}

.badge-soft-danger {
    color: #f34e4e;
    background-color: rgba(243,78,78,.1);
}

.badge-soft-warning {
    color: #f7cc53;
    background-color: rgba(247,204,83,.1);
}

.badge-soft-success {
    color: #51d28c;
    background-color: rgba(81,210,140,.1);
}

.avatar-group .avatar-group-item {
    margin-left: -14px;
    border: 2px solid #fff;
    border-radius: 50%;
    -webkit-transition: all .2s;
    transition: all .2s;
}

.avatar-sm {
    height: 2rem;
    width: 2rem;
}

.nav-tabs-custom .nav-item {
    position: relative;
    color: #343a40;
}

.nav-tabs-custom .nav-item .nav-link.active:after {
    -webkit-transform: scale(1);
    transform: scale(1);
}

.nav-tabs-custom .nav-item .nav-link::after {
    content: "";
    background: #038edc;
    height: 2px;
    position: absolute;
    width: 100%;
    left: 0;
    bottom: -2px;
    -webkit-transition: all 250ms ease 0s;
    transition: all 250ms ease 0s;
    -webkit-transform: scale(0);
    transform: scale(0);
}

.badge-soft-secondary {
    color: #74788d;
    background-color: rgba(116,120,141,.1);
}

.badge-soft-secondary {
    color: #74788d;
}

.work-activity {
    position: relative;
    color: #74788d;
    padding-left: 5.5rem
}

.work-activity::before {
    content: "";
    position: absolute;
    height: 100%;
    top: 0;
    left: 66px;
    border-left: 1px solid rgba(3,142,220,.25)
}

.work-activity .work-item {
    position: relative;
    border-bottom: 2px dashed #eff0f2;
    margin-bottom: 14px
}

.work-activity .work-item:last-of-type {
    padding-bottom: 0;
    margin-bottom: 0;
    border: none
}

.work-activity .work-item::after,.work-activity .work-item::before {
    position: absolute;
    display: block
}

.work-activity .work-item::before {
    content: attr(data-date);
    left: -157px;
    top: -3px;
    text-align: right;
    font-weight: 500;
    color: #74788d;
    font-size: 12px;
    min-width: 120px
}

.work-activity .work-item::after {
    content: "";
    width: 10px;
    height: 10px;
    border-radius: 50%;
    left: -26px;
    top: 3px;
    background-color: #fff;
    border: 2px solid #038edc
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="container">
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body ">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="text-center ">
                           @if($employee->image)
                           <img src="{{asset('storage/photo/'.$employee->image)}}" class="img-fluid avatar-xxl rounded-circle" alt="">
                           @else
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="img-fluid avatar-xxl rounded-circle" alt="">
                           @endif
                            <h4 class="text-primary font-size-20 mt-3 mb-2">{{$employee->name}}</h4>
                            <h5 class="text-muted font-size-13 mb-0">{{$employee->designations->name ?? ""}}</h5>
                        </div>
                    </div><!-- end col -->

                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="card-title mb-4">Personal Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Employee Id</th>
                                    <td>{{$employee->id_card}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{$employee->email}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Number</th>
                                    <td>{{$employee->personal_phone ?? "N/A"}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Marital Status</th>
                                    <td>{{ strtoupper($employee->marital_status)  ?? "N/A"}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Nid</th>
                                    <td>{{$employee->nid ?? "N/A"}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Date Of Birth</th>
                                    <td>{{$employee->dob ?? "N/A"}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Gender</th>
                                    <td>{{$employee->gender ?? "N/A"}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Reference</th>
                                    <td>{{$employee->reference ?? "N/A"}}</td>
                                </tr><!-- end tr -->

                                <tr>
                                    <th scope="row">Present Address</th>
                                    <td>{{$employee->present_address ?? "N/A"}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Permanent Address</th>
                                    <td>{{$employee->permanent_address ?? "N/A"}}</td>
                                </tr><!-- end tr -->
                                <tr>
                                    <th scope="row">Received Documents</th>
                                    <td>
                                    @foreach (explode(',',$employee->received_documents_checkbox??"") as $item)
                                    {{$item}},
                                    @endforeach
                                  </td>
                                </tr><!-- end tr -->
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->

        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="card-title mb-4">Qualification Info & Experiences</h4>
                    <ul class="list-unstyled work-activity mb-0">
                        <li class="work-item" data-date="{{$employee->passing_year}}">
                            <h6 class="lh-base mb-0">{{$employee->institution}}</h6>
                            <p class="font-size-13 mb-2">{{$employee->achieved_degree}}</p>
                        </li>
                    </ul><!-- end ul -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Working Experiences</th>
                                    <td>{{$employee->experience ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Professional Experiences</th>
                                    <td>{{$employee->professional_experiences ?? "N/A"}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->

        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="card-title mb-4">Salary & Bank Acc Info</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Tax Deduction</th>
                                    <td>{{$employee->tax_deduction ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Taxpayer Identification Number (TIN)</th>
                                    <td>{{$employee->tin ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Bank Account Information</th>
                                    <td>{{$employee->bank_account_information ?? "N/A"}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="card-title mb-4">Office Information</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Joining Date</th>
                                    <td>{{$employee->join_date ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Team</th>
                                    <td>{{$employee->teams->name ?? "Non Team"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Department</th>
                                    <td>{{$employee->departments->name ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Designation</th>
                                    <td>{{$employee->designations->name ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Name of Supervisor</th>
                                    <td>{{$employee->supervisor ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Official E-mail</th>
                                    <td>{{$employee->official_email ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Office Number</th>
                                    <td>{{$employee->office_phone ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Net Salary</th>
                                    <td>{{$employee->salary ?? "N/A"}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
        <div class="card">
            <div class="card-body">
                <div>
                    <h4 class="card-title mb-4">Login Info</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">User Name</th>
                                    <td>{{$employee->employelist->username ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Access Roll</th>
                                    <td>{{$employee->employelist->rollaccess->name ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Access Type</th>
                                    <td>{{($editinfo->employelist->is_admin ?? 0) == 5  ? "Manager":"Employee" }}</td>
                                </tr>
                                @if(auth()->user()->employee)
                                @else
                                <tr>
                                    <th scope="row">Password</th>
                                    <td>{{$employee->password}}</td>
                                    @php
                                    @endphp
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
</div>
@endsection
