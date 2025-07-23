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
                <div class="card-header text-center">
                    <h3 class="card-title">Loan Application Details</h3>
                    <div class="card-tools">

                        <a class="btn btn-default" href="{{ route('hrm.lone.create') }}"><i class="fas fa-plus"></i>Add
                            New</a>

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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Amount</th>
                                    <th>Loan Adjustment</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <td>{{ $lone->employee->name }}</td>
                                <td>{{ $lone->branch->name }}</td>
                                <td>{{ $lone->amount }}</td>
                                <td>{{ $lone->lone_adjustment }}</td>
                                <td>{{ $lone->reason }}</td>
                                <td>{{ $lone->status }}</td>
                                </tr>

                            </tbody>
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
