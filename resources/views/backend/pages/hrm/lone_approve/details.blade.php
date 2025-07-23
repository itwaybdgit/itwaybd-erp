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
                    {{-- <div class="card-tools">
                    @if (helper::roleAccess('hrm.leave.create'))
                    <a class="btn btn-default" href="{{ route('hrm.leave.create') }}"><i
                            class="fas fa-plus"></i>Add New</a>
                    @endif
                    <span id="buttons"></span>
                    <a class="btn btn-tool btn-default" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </a>
                    <a class="btn btn-tool btn-default" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </a>
                </div> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('hrm.loneapprove.approve', $lone->id) }}" method="get">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th width="15%">Amount</th>
                                        <th width="15%">Loan Adjustment</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>{{ $lone->employee->name }}</td>
                                    <td>{{ $lone->branch->name }}</td>
                                    <td><input type="number" name="amount" class="form-control"
                                            value="{{ $lone->amount }}"></td>
                                    <td>
                                        <input type="number" name="lone_adjustment" class="form-control"
                                            value="{{ $lone->lone_adjustment }}">
                                    </td>
                                    <td>{{ $lone->reason }}</td>
                                    <td>{{ $lone->status }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <button class="btn btn-info" type="submit">Approve</button>
                            </div>
                        </div>
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
