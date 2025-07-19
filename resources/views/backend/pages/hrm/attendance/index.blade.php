@extends('admin.master')
@section('title')
    Hrm - {{ $title }}
@endsection

@section('styles')
    <style>
        .underline-red {
            display: inline-block;
            border-bottom: 2px solid red;
            padding-bottom: 2px;
        }

        .bootstrap-switch-large {
            width: 200px;
        }

        .red-separator {
            background-color: red !important;
            /* light yellow */
        }
    </style>
@endsection



@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Attendance List</h3>
                    <div class="card-tools">

                        <a class="btn btn-default" href="{{ route('hrm.attendance.create') }}"><i class="fas fa-plus"></i>
                            Custom Attendance</a>

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
                    <div class="table-responsive">
                        <table id="systemDatatable" class="display table-hover table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>ID Card</th>
                                    <th>Emplyee Name</th>
                                    <th>Date</th>
                                    <th>Sign In</th>
                                    <th>location IN</th>
                                    <th>Sign_Out</th>
                                    <th>location Out</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>ID Card</th>
                                    <th>Emplyee_Name</th>
                                    <th>Date</th>
                                    <th>Sign In</th>
                                    <th>location IN</th>
                                    <th>Sign_Out</th>
                                    <th>location Out</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
@endsection
@section('scripts')
    @include('backend.pages.hrm.attendance.script')
@endsection
