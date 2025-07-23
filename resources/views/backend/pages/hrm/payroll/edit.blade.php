@extends('admin.master')

@section('title')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Payroll -
                            {{ $payroll->employee->name ?? 'Employee #' . $payroll->employee_id }}</h4>
                        <a href="{{ route('hrm.payroll.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
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

                        <form method="POST" action="{{ route('hrm.payroll.update', $payroll->id) }}" id="payrollForm">

                            @csrf


                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Salary Details</h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label required">Basic Salary </label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" name="basic" class="form-control"
                                            value="{{ $payroll->basic }}" required disabled id="basic">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Overtime Hours</label>
                                    <input type="number" step="0.01" name="overtime_hours" class="form-control"
                                        value="{{ $payroll->overtime_hours }}" id="overtime_hours" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Overtime Pay</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" name="overtime_pay" class="form-control"
                                            value="{{ $payroll->overtime_pay }}" id="overtime_pay" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- Allowances -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Allowances</h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Attendance Allowance</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" name="attendance_allowance"
                                            class="form-control" value="{{ $payroll->attendance_allowance }}" disabled
                                            id="attendance_allowance">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Other Allowances Name</label>
                                    <div class="input-group">

                                        <input type="text" name="attendance_pay" class="form-control"
                                            value="{{ $payroll->attendance_pay }}" id="attendance_pay">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Other Allowances Pay</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" name="allowances" class="form-control"
                                            value="{{ $payroll->other_allowance }}" id="allowances">
                                    </div>
                                </div>
                            </div>

                            <!-- Deductions & Additional -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Deductions & Additional</h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Absent Deductions</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" name="deductions" class="form-control"
                                            value="{{ $payroll->deductions }}" id="deductions" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Late Deductions</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" name="late_deduction" class="form-control"
                                            value="{{ $payroll->late_deduction }}" id="additionals" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Loan Deduation</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" step="0.01" name="loan_deduction"
                                            class="form-control bg-light" value="{{ $payroll->loan_deduction }}"
                                            id="loadDeduction" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Other Deductions</label>
                                    <div class="input-group">

                                        <input type="text" name="otherDeduction" class="form-control"
                                            value="{{ $payroll->other_deduction }}" id="otherDeduction">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Other Deduation Pay</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="text" class="form-control bg-light" name="other_deduction_pay"
                                            value="{{ $payroll->other_deduction_pay }}" id="otherDeductionPay">
                                    </div>
                                </div>
                            </div>



                            <!-- Payment Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Payment Information</h5>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Payment Mode *</label>
                                    <!-- <select name="payment_mode" class="form-select form-control" required>
                                            <option value="">Select Payment Mode</option>
                                            <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="bank_transfer" {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                            <option value="paypal" {{ old('payment_mode') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                            <option value="bkash" {{ old('payment_mode') == 'bkash' ? 'selected' : '' }}>bKash</option>
                                        </select> -->

                                    <select name="advance_ledger_id" class="form-control select2">
                                        <x-account :setAccounts="$accounts" />
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Pay Date *</label>
                                    <input type="date" name="pay_date" class="form-control"
                                        value="{{ old('pay_date', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <!-- Summary Card -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Salary Summary</h5>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>Basic:</strong> <span
                                                        id="summary_basic">৳{{ $payroll->basic }}</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Total Allowances:</strong> <span
                                                        id="summary_allowances">৳0.00</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Total Deductions:</strong> <span
                                                        id="summary_deductions">৳0.00</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Net Salary:</strong> <span id="summary_net"
                                                        class="text-success fw-bold">৳{{ $payroll->net_salary }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="net_salary" id="net_salary" value="{{ $payroll->net_salary }}">
                            <input type="hidden" name="basic" value="{{ $payroll->basic }}">
                            <!-- <input type="hidden" name="overtime_pay" value="{{ $payroll->basic }}">
        <input type="hidden" name="deductions" value="{{ $payroll->basic }}">
        <input type="hidden" name="additionals" value="{{ $payroll->basic }}">
        <input type="hidden" name="loadDeduction" value="{{ $payroll->basic }}">
        <input type="hidden" name="attendance_allowance" value="{{ $payroll->basic }}"> -->








                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-save"></i> Update Payroll
                                    </button>

                                    <a href="{{ route('hrm.payroll.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            function calculateNetSalary() {
                let basic = parseFloat($('#basic').val()) || 0;
                let overtime = parseFloat($('#overtime_pay').val()) || 0;
                let otherAllowance = parseFloat($('#allowances').val()) || 0;
                let attendancePay = parseFloat($('#attendance_pay').val()) || 0;

                let totalAllowances = overtime + otherAllowance + attendancePay;

                let deductions = parseFloat($('#deductions').val()) || 0;
                let additionals = parseFloat($('#additionals').val()) || 0;
                let otherDeduction = parseFloat($('#otherDeductionPay').val()) || 0;
                let loanDeduction = parseFloat($('#loadDeduction').val()) || 0;

                let totalDeductions = deductions + additionals + otherDeduction + loanDeduction;

                let netSalary = (basic + totalAllowances) - totalDeductions;

                // Update the DOM
                $('#summary_allowances').text('৳' + totalAllowances.toFixed(2));
                $('#summary_deductions').text('৳' + totalDeductions.toFixed(2));
                $('#summary_net').text('৳' + netSalary.toFixed(2));

                // If you want to store it in a hidden field to submit later
                $('#net_salary').val(netSalary.toFixed(2));
            }

            // Trigger calculation on input change
            $('#attendance_pay, #allowances, #overtime_pay, #otherDeductionPay, #loadDeduction').on('input',
                function() {
                    calculateNetSalary();
                });

            // Initial call
            calculateNetSalary();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ajax form submission
            $('#payrollForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let actionUrl = form.attr('action');
                let formData = form.serialize();

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {

                            // Optionally redirect or update summary
                            window.location.href = "{{ route('hrm.payroll.index') }}";
                        } else {
                            toastr.error(response.message || 'Something went wrong.');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            $.each(errors, function(key, value) {
                                errorMsg += value[0] + '<br>';
                            });
                            toastr.error(errorMsg);
                        } else {
                            toastr.error('An unexpected error occurred.');
                        }
                    }
                });
            });
        });
    </script>


    <style>
        .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection
