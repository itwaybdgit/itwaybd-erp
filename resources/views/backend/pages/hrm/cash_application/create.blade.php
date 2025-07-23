@extends('admin.master')

@section('title')
    Hrm - {{ $title }}
@endsection


@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add New Cash Requisition</h3>
                    <div class="card-tools">

                        <a class="btn btn-default" href="{{ route('hrm.cashapplicaon.index') }}"><i class="fa fa-list"></i>
                            Salary Sheet List</a>

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
                    <form class="needs-validation" method="POST" action="{{ route('hrm.cashapplicaon.store') }}"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">


                            <div class="col-md-6 mb-1">
                                <label for=""> EMPLOYEE NAME <span class="text-danger">*</span></label>
                                @if (auth()->user()->type != 'Admin' && auth()->user()->employee)
                                    <h4> {{ auth()->user()->employee->name ?? '' }}</h4>
                                    <input type="hidden" name="employee_id"
                                        value="{{ auth()->user()->employee->id ?? 0 }}">
                                @else
                                    <select class="select2 form-control select2-lg" aria-label=".select2-lg example"
                                        name="employee_id">
                                        <option selected disabled>Select employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                @error('employee_id')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="">Amount *:</label>
                                <input type="number" class="form-control input-rounded" name="amount"
                                    placeholder="amount">
                                @error('amount')
                                    <span class=" error text-red text-bold">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-6 mb-1">
                                <label for="">Cash Requisition Reason</label>

                                <textarea name="reason" id="" cols="30" class="form-control" rows="3"></textarea>
                                @error('reason')
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
