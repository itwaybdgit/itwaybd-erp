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
                    <h3 class="card-title">Attendance Log</h3>
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
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('hrm.absencelog.index') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="employe" class="mt-2">Employee:</label>
                            <div class="col-md-3">
                                <select name="employee_id" class="form-control select2" id="employe">
                                    <option value="all">All</option>
                                    @foreach ($employees as $employee)
                                        <option {{ $request->employee_id == $employee->id ? 'selected' : '' }}
                                            value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="From" class="mt-2">From:</label>
                            <div class="col-md-3">
                                <input type="date" id="From" value="{{ $request->from ?? date('Y-m-d') }}"
                                    class="form-control" name="from">
                            </div>
                            <label for="To" class="mt-2">To:</label>
                            <div class="col-md-3">
                                <input type="date" id="To" value="{{ $request->to ?? date('Y-m-d') }}"
                                    class="form-control" name="to">
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Absent List</h3>
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">ID No</th>

                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php $sl = 1; @endphp
                                @forelse($employeeAbsents as $data)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>{{ $data['employee']->name }}</td>
                                        <td>{{ $data['employee']->id_card }}</td>
                                        <td>
                                            {!! collect($data['dates'])->map(function ($d) {
                                                    return '<span style="border: 1px solid;padding:4px;margin:2px;display:inline-block;">' .
                                                        \Carbon\Carbon::parse($d)->format('d-m-Y') .
                                                        '</span>';
                                                })->implode(' ') !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No absent records found for selected date
                                            range.</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-->
    </div>
@endsection
