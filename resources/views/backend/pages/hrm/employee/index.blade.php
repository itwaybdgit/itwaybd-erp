@extends('admin.master')
@section('title')
    Hrm - {{ $title }}
@endsection

@section('styles')
    <style>
        .bootstrap-switch-large {
            width: 200px;
        }

        table.dataTable>thead>tr>th:not(.sorting_disabled),
        table.dataTable>thead>tr>td:not(.sorting_disabled) {
            padding-right: 16px;
        }
    </style>
@endsection



@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Employee List</h3>
                    <div class="card-tools">

                        <a class="btn btn-default" href="{{ route('hrm.employee.create') }}"><i class="fas fa-plus"></i>Add
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
                        <button type="button" data-toggle="modal" class="btn btn-dark" data-target="#columnModal">Select
                            Columns</button>

                        <table id="systemDatatable" class="display table-hover table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Personal Phone</th>
                                    <th>Office Phone</th>
                                    <th>Nid</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Active Address</th>
                                    <th>Salary</th>
                                    <th>Overtime</th>
                                    <th>Join Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Personal Phone</th>
                                    <th>Office Phone</th>
                                    <th>Nid</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Active Address</th>
                                    <th>Salary</th>
                                    <th>Join Date</th>
                                    <th>Overtime</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div>
                    <div class="modal fade" id="columnModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="columnSelectForm">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Choose Columns</h5>
                                    </div>
                                    <div class="modal-body">
                                        @foreach (['SL', 'Name', 'Date of Birth', 'Gender', 'Personal Phone', 'Office Phone', 'Nid', 'Email', 'Department', 'Active Address', 'Salary', 'Overtime', 'Join Date', 'Action'] as $col)
                                            <div class="form-check">
                                                <input class="form-check-input column-checkbox" type="checkbox"
                                                    value="{{ $col }}" id="col_{{ $col }}" checked>
                                                <label class="form-check-label"
                                                    for="col_{{ $col }}">{{ $col }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="applyColumns">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('backend.pages.hrm.employee.script')

    <script>
        $(document).ready(function() {
            var table = $('#systemDatatable').DataTable();

            $('#applyColumns').on('click', function() {
                $('#columnModal').modal('hide');
                $('.column-checkbox').each(function(index) {
                    var column = table.column(index);
                    if ($(this).is(':checked')) {
                        column.visible(true);
                    } else {
                        column.visible(false);
                    }
                });
            });
        });


        $('.column-checkbox').on('change', function() {
            var selected = [];
            $('.column-checkbox:checked').each(function() {
                selected.push($(this).val());
            });
            localStorage.setItem('datatable_columns', JSON.stringify(selected));
        });


        $(document).ready(function() {
            var selected = JSON.parse(localStorage.getItem('datatable_columns') || '[]');
            if (selected.length) {
                $('.column-checkbox').each(function() {
                    $(this).prop('checked', selected.includes($(this).val()));
                });
                $('#applyColumns').click();
            }
        });
    </script>
@endsection
