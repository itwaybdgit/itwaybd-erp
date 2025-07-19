@extends('admin.master')
@section('title')
    Hrm - {{ $title }}
@endsection

@section('styles')
    <style>
        .bootstrap-switch-large {
            width: 200px;
        }
    </style>
@endsection



@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Salary Pay Sheet details</h3>

                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="card-header">
                        <h4 class="card-title">Salary Pay Sheet History</h4>
                        <div class="card-tools">
                            <span id="buttons"></span>
                            <a class="btn btn-tool btn-default" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </a>
                            <a class="btn btn-tool btn-default" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card card-body">
                        <form class="needs-validation" action="{{ route('hrm.paysheet.empPayDetailsStore') }}"
                            method="POST" action="" novalidate>
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-4 mb-1">
                                    <input type="hidden" class="form-control" value="{{ $pay->id }}"
                                        name="employee_id">
                                    @error('emplyee_id')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Paybale Salary</label>
                                <div class="col-md-4 mb-1">
                                    <input type="number" class="form-control" value="{{ EMPLOYEE_PAYABLE_SALARY($pay) }}"
                                        name="payble_salary" readonly>
                                    @error('payble_salary')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">amount <span class="text-danger">*</span></label>
                                <div class="col-md-4 mb-1">
                                    <input type="number" class="form-control" name="amount">
                                    @error('amount')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Lone </span></label>
                                <div class="col-md-4 mb-1">
                                    <input type="number" class="form-control" name="lone">
                                    @error('lone')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>
                                    &nbsp;Save</button>
                            </div>
                        </form>
                    </div>


                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-->
    </div>
@endsection
