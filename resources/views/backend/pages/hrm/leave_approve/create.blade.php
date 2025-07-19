@extends('admin.master')

@section('title')
    Hrm - {{ $title }}
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add New Leave Applicaion</h3>
                    <div class="card-tools">
                        @if (helper::roleAccess('hrm.leave.index'))
                            <a class="btn btn-default" href="{{ route('hrm.leave.index') }}"><i class="fa fa-list"></i>
                                Salary Sheet List</a>
                        @endif
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
                    <form class="needs-validation" method="POST" action="{{ route('hrm.leave.store') }}"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for=""> EMPLOYEE NAME <span class="text-danger">*</span></label>
                                <select class="select2 form-control select2-lg" aria-label=".select2-lg example"
                                    name="employee_id">
                                    <option selected disabled>Select employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Application Start Date *:</label>
                                <input type="date" class="form-control input-rounded" name="apply_date"
                                    placeholder="Application Date">
                                @error('apply_date')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Application End Date *:</label>
                                <input type="date" class="form-control input-rounded" name="end_date"
                                    placeholder="Application End Date">
                                @error('apply_date')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Upload Document image/file *:</label>
                                <input type="file" class="form-control input-rounded" name="file"
                                    placeholder="Application End Date">
                                @error('file')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-6 mb-1">
                                <label for="">Application Reason</label>

                                <textarea name="reason" id="" cols="30" class="form-control" rows="3"></textarea>
                                @error('reason')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Payment Status</label>

                                <select name="payment_status" class="form-control">
                                    <option value="paid">Paid</option>
                                    <option value="non-paid">Non-Paid</option>
                                </select>
                                @error('payment_status')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
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
@endsection
