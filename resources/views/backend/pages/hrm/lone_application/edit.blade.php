@extends('admin.master')

@section('title')
    Hrm - {{ $title }}
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Loan Application Edit</h3>
                    <div class="card-tools">

                        <a class="btn btn-default" href="{{ route('hrm.lone.create') }}"><i class="fas fa-plus"></i>
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
                    <form class="needs-validation" method="POST" action="{{ route('hrm.lone.update', $model->id) }} "
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for=""> EMPLOYEE NAME <span class="text-danger">*</span></label>
                                <select class="select2 form-control select2-lg" aria-label=".select2-lg example"
                                    name="employee_id">
                                    <option selected>Select employee</option>
                                    @foreach ($employees as $employee)
                                        <option {{ $model->employee_id == $employee->id ? 'selected' : '' }}
                                            value="{{ $employee->id }}">{{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for=""> BRANCH NAME <span class="text-danger">*</span></label>
                                <select class="select2 form-control select2-lg" aria-label=".select2-lg example"
                                    name="branch_id">
                                    <option selected value="0">Not Applicable</option>
                                    @foreach ($branches as $branch)
                                        <option {{ $model->branch_id == $branch->id ? 'selected' : '' }}
                                            value="{{ $branch->id }}">{{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Amount</label>
                                <input type="number" class="form-control input-rounded" name="amount"
                                    value="{{ $model->amount }}">
                                @error('amount')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Loan Adjustment</label>
                                <input type="number" class="form-control input-rounded" name="lone_adjustment"
                                    value="{{ $model->lone_adjustment }}">
                                @error('lone_adjustment')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Loan Application Reason</label>
                                <textarea name="reason" cols="4" rows="4" class="form-control">{{ $model->reason }}</textarea>
                                @error('reason')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="">Loan Application Document [image/file]:</label>
                                <input type="file" name="file" value="{{ $model->file }}" class="form-control">
                                <img src="{{ asset('/storage/lone/' . $model->file) }}" alt="" width="100px"
                                    height="80px">
                                @error('file')
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
