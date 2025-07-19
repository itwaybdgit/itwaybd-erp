@extends('admin.master')

@section('title')
    Hrm - {{ $title }}
@endsection



@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Payroll Management</h4>
                        <div>
                            <a href="{{ route('hrm.payroll.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Payroll
                            </a>

                            <button type="button" class="btn btn-success" onclick="submitPayslipForm()">
                                <i class="fas fa-file-invoice"></i> Generate Payslip
                            </button>


                        </div>
                    </div>

                    <!-- Filter Form -->
                    <div class="card-body border-bottom">
                        <form method="GET" action="{{ route('hrm.payroll.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Employee</label>
                                <select name="employee_id" class="form-select form-control">
                                    <option value="">All Employees</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}({{ $employee->id_card }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Month</label>
                                <select name="month" class="form-select form-control">
                                    <option value="">All Months</option>
                                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                        <option value="{{ $month }}"
                                            {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Year</label>
                                <select name="year" class="form-select form-control">
                                    <option value="">All Years</option>
                                    @for ($year = date('Y') - 5; $year <= date('Y') + 1; $year++)
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-secondary me-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('hrm.payroll.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($payrolls->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>Employee</th>
                                            <th>Period</th>
                                            <th>Basic Salary</th>
                                            <th>Total Allowances</th>
                                            <th>Total Deductions</th>
                                            <th>Net Salary</th>
                                            <!-- <th>Payment Mode</th> -->
                                            <th>Pay Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <!-- In table body -->
                                    <tbody>
                                        @foreach ($payrolls as $payroll)
                                            @php
                                                $totalDeduction =
                                                    $payroll->absent_deduction +
                                                    $payroll->late_deduction +
                                                    $payroll->loan_deduction +
                                                    $payroll->other_deduction_pay;
                                                $totalAllowance = $payroll->overtime_pay;
                                            @endphp
                                            <tr>
                                                <td><input type="checkbox" name="payroll_ids[]" class="payroll-checkbox"
                                                        value="{{ $payroll->id }}"></td>
                                                <td><strong>{{ $payroll->employee->name ?? 'Employee #' . $payroll->employee_id }}</strong>
                                                </td>
                                                <td>{{ $payroll->month }} {{ $payroll->year }}</td>
                                                <td>৳{{ $payroll->basic }}</td>
                                                <td>৳{{ $payroll->total_allowance }}</td>
                                                <td>৳{{ $totalDeduction }}</td>
                                                <td><strong class="text-success">৳{{ $payroll->net_salary }}</strong></td>
                                                <td>{{ $payroll->pay_date }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('hrm.payroll.show', $payroll) }}"
                                                            class="btn btn-sm btn-outline-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('hrm.payroll.edit', $payroll) }}"
                                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $payrolls->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-money-bill-wave fa-5x text-muted mb-3"></i>
                                <h5 class="text-muted">No payroll records found</h5>
                                <p class="text-muted">Start by creating a new payroll record.</p>
                                <a href="{{ route('hrm.payroll.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create First Payroll
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this payroll record? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(payrollId) {
            const form = document.getElementById('deleteForm');
            form.action = `/payroll/${payrollId}`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>

    <script>
        // Select all checkboxes
        document.getElementById('select-all').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.payroll-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        function submitPayslipForm() {
            const selected = [];
            document.querySelectorAll('.payroll-checkbox:checked').forEach(cb => {
                selected.push(cb.value);
            });

            if (selected.length === 0) {
                alert('Please select at least one payroll record.');
                return;
            }

            // Get filter values
            const month = document.querySelector('select[name="month"]').value;
            const year = document.querySelector('select[name="year"]').value;

            const url = new URL(`{{ route('hrm.payslip.index') }}`, window.location.origin);
            url.searchParams.set('ids', selected.join(','));

            if (month) url.searchParams.set('month', month);
            if (year) url.searchParams.set('year', year);

            window.location.href = url.toString();
        }
    </script>



@endsection
