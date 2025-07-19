@extends('admin.master')

@section('title')
    Hrm - {{ $title }}
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create New Payroll</h4>
                        <a href="{{ route('hrm.payroll.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        @if (session('success'))
                            <script>
                                toastr.success("{{ session('success') }}");
                            </script>
                        @endif

                        @if (session('error'))
                            <script>
                                toastr.error("{{ session('error') }}");
                            </script>
                        @endif

                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="payrollForm" method="POST">
                            @csrf

                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Basic Information</h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Employee *</label>
                                    <!-- <select id="employee_id" class="form-select" required>
                        <option value="">Select Employee</option>
                        @foreach ($employees as $employee)
    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
    @endforeach
                    </select> -->

                                    <select name="employee_id" class="form-control select2" id="employee_id">

                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->name }}({{ $employee->id_card }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Month -->
                                <div class="col-md-3">
                                    <label class="form-label required">Month *</label>
                                    <select id="month" name="month" class="form-control form-select" required>
                                        <option value="">Select Month</option>
                                        @foreach ($months as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Year -->
                                <div class="col-md-3">
                                    <label class="form-label required">Year *</label>
                                    <select id="year" name="year" class="form-control form-select" required>
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2" style="padding-top:27px">
                                    <button type="button" class="btn green form-control" id="goBtn"
                                        style="color: #FFFFFF;background: #26a1ab;border-color: #26a1ab;">Go</button>
                                </div>
                            </div>

                            <!-- Salary Details -->
                            <div id="attendanceResult">

                            </div>




                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Include Toastr for better user feedback -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#goBtn').on('click', function() {
                let employeeId = $('#employee_id').val();
                let month = $('#month').val();
                let year = $('#year').val();

                if (!employeeId || !month || !year) {
                    toastr.error("Please select employee, month, and year");
                    return;
                }

                $.ajax({
                    url: "{{ route('hrm.payroll.fetch') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        employee_id: employeeId,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.message ===
                            'Payroll already created!') {
                            toastr.warning(response.message);

                            $('#attendanceResult').html(response);
                        }

                        // Otherwise, assume it's an HTML view and render
                        $('#attendanceResult').html(response);
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong!');
                    }
                });
            });

            // Form Submit
            $('#payrollForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('hrm.payroll.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    beforeSend: function() {
                        // Optional loader
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            window.location.href = "{{ route('hrm.payroll.index') }}";
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let messages = "";
                        for (let key in errors) {
                            messages += errors[key][0] + "\n";
                        }
                        toastr.error(messages);
                    }
                });
            });
        });
    </script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };
    </script>



    <style>
        .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection
