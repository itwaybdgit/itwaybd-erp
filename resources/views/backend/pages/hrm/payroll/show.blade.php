@extends('admin.master')

@section('title')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center no-print-header">

                        <h4 class="mb-0">Payroll Details</h4>
                        <div>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('hrm.payroll.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Employee Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h3 class="mb-1">
                                                    {{ $payroll->employee->name ?? 'Employee #' . $payroll->employee_id }}
                                                </h3>
                                                <p class="mb-0">
                                                    <i class="fas fa-calendar"></i> {{ $payroll->month }}
                                                    {{ $payroll->year }} |
                                                    <i class="fas fa-credit-card"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $payroll->payment_mode)) }} |
                                                    <i class="fas fa-calendar-day"></i> Paid on {{ $payroll->pay_date }}
                                                </p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <h2 class="mb-0">৳{{ $payroll->net_salary }}</h2>
                                                <small>Net Salary</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Salary Breakdown -->
                        <div class="row">
                            <!-- Basic Salary & Overtime -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0"><i class="fas fa-money-bill-wave"></i> Basic Salary & Overtime
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-8">
                                                <strong>Basic Salary</strong>
                                            </div>
                                            <div class="col-4 text-end">
                                                <span class="badge bg-success">৳{{ $payroll->basic }}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-8">
                                                Overtime Hours
                                            </div>
                                            <div class="col-4 text-end">
                                                {{ $payroll->overtime_hours }} hrs
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <strong>Overtime Pay</strong>
                                            </div>
                                            <div class="col-4 text-end">
                                                <span class="badge bg-success">৳{{ $payroll->overtime_pay }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Allowances -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Allowances</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-8">
                                                Attendance Allowance
                                            </div>
                                            <div class="col-4 text-end">
                                                ৳{{ $payroll->attendance_allowance }}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-8">
                                                Attendance Pay
                                            </div>
                                            <div class="col-4 text-end">
                                                ৳{{ $payroll->attendance_pay }}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-8">
                                                Other Allowances
                                            </div>
                                            <div class="col-4 text-end">
                                                ৳{{ $payroll->allowances }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-8">
                                                <strong>Total Allowances</strong>
                                            </div>
                                            <div class="col-4 text-end">
                                                <span class="badge bg-info">৳{{ $payroll->total_allowance }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Deductions -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-warning text-dark">
                                        <h5 class="mb-0"><i class="fas fa-minus-circle"></i> Deductions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <strong>Total Deductions</strong>
                                            </div>
                                            <div class="col-4 text-end">
                                                <span
                                                    class="badge bg-warning text-dark">৳{{ $payroll->total_deduction }}</span>
                                            </div>
                                        </div>
                                        @if ($payroll->deductions > 0)
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <small class="text-muted">Includes various deductions as per company
                                                        policy</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Payments -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0"><i class="fas fa-gift"></i> Additional Payments</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <strong>Total Additional</strong>
                                            </div>
                                            <div class="col-4 text-end">
                                                <span class="badge bg-secondary">৳{{ $payroll->total_additional }}</span>
                                            </div>
                                        </div>
                                        @if ($payroll->additionals > 0)
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <small class="text-muted">Bonus, incentives, and other additional
                                                        payments</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Net Salary Calculation -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="fas fa-calculator"></i> Salary Calculation</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-8">Basic Salary</div>
                                            <div class="col-4 text-end">+ ৳{{ $payroll->basic }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-8">Overtime Pay</div>
                                            <div class="col-4 text-end">+ ৳{{ $payroll->overtime_pay }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-8">Attendance Pay</div>
                                            <div class="col-4 text-end">+ ৳{{ $payroll->attendance_pay }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-8">Total Allowances</div>
                                            <div class="col-4 text-end">+ ৳{{ $payroll->total_allowance }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-8">Additional Payments</div>
                                            <div class="col-4 text-end">+ ৳{{ $payroll->total_additional }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-8">Total Deductions</div>
                                            <div class="col-4 text-end text-danger">- ৳{{ $payroll->total_deduction }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-8">
                                                <h4 class="mb-0">Net Salary</h4>
                                            </div>
                                            <div class="col-4 text-end">
                                                <h4 class="mb-0 text-success">
                                                    ৳{{ number_format($payroll->net_salary, 2) }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Print Button -->
                        <div class="row no-print">
                            <div class="col-12 text-center">
                                <button onclick="window.print()" class="btn btn-outline-primary">
                                    <i class="fas fa-print"></i> Print Payroll Details
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional Print Styling -->
    <style>
        @media print {

            /* Hide full header */
            .no-print-header {
                display: none !important;
            }

            /* Hide print button row */
            .no-print,
            .btn,
            .card-header a,
            .card-header button {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Optional: Ensure card-header background color prints correctly */
            .bg-success,
            .bg-info,
            .bg-warning,
            .bg-secondary,
            .bg-primary {
                color: white !important;
            }
        }
    </style>
@endsection
