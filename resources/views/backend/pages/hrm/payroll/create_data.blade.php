                      <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Salary Details</h5>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Basic Salary </label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" step="0.01" name="basic" class="form-control" 
                                           value="{{ $employee->salary }}" required disabled id="basic">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Overtime Hours</label>
                                <input type="text"  name="overtime_hours" class="form-control" 
                                       value="{{ $employeeOT}}" id="overtime_hours" disabled >
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Overtime Pay</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" step="0.01" name="overtime_pay" class="form-control" 
                                           value="{{ $employeeOTSalary }}" id="overtime_pay" disabled>
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
                                    <input type="number" step="0.01" name="attendance_allowance" class="form-control" 
                                           value="{{ old('attendance_allowance', 0) }}" disabled id="attendance_allowance">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Other Allowances Name</label>
                                <div class="input-group">
                                   
                                    <input type="text" name="attendance_pay" class="form-control" 
                                           value="" id="attendance_pay">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Other Allowances Pay</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" step="0.01" name="allowances" class="form-control" 
                                           value="{{ old('allowances', 0) }}" id="allowances">
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
                                           value="{{ $employeeAbsenseSalaryDeduction }}" id="deductions" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Late Deductions</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" step="0.01" name="additionals" class="form-control" 
                                           value="{{ old('additionals', 0) }}" id="additionals" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Loan Deduation</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                   <input type="number" step="0.01" class="form-control bg-light" 
               value="{{ $loanAdjustment ?? 0 }}" id="loadDeduction" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Other Deductions</label>
                                <div class="input-group">
                                
                                    <input type="text"  name="otherDeduction" class="form-control" 
                                           value="" id="otherDeduction" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Other Deduation Pay</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="text" class="form-control bg-light" value="{{old('otherDeductionPay')}}" id="otherDeductionPay" >
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

                                <select name="advance_ledger_id" class="form-control select2">
                            <x-account :setAccounts="$accounts" />
                            </select>
                                <!-- <select name="payment_mode" class="form-select form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank_transfer" {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="paypal" {{ old('payment_mode') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="bkash" {{ old('payment_mode') == 'bkash' ? 'selected' : '' }}>bKash</option>
                                </select> -->
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
                                                <strong>Basic:</strong> <span id="summary_basic">৳{{$employee->salary}}</span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Total Allowances:</strong> <span id="summary_allowances">৳0.00</span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Total Deductions:</strong> <span id="summary_deductions">৳0.00</span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Net Salary:</strong> <span id="summary_net" class="text-success fw-bold">৳{{$payableSallery}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="net_salary" id="net_salary" value="">
                        <input type="hidden" name="basic" value="{{ $employee->salary }}">
<input type="hidden" name="overtime_pay" value="{{ $employeeOTSalary }}">
<input type="hidden" name="overtime_hours" value="{{ $employeeOT }}">
<input type="hidden" name="deductions" value="{{ $employeeAbsenseSalaryDeduction }}">
<input type="hidden" name="additionals" value="{{ old('additionals', 0) }}">
<input type="hidden" name="loadDeduction" value="{{ $loanAdjustment ?? 0 }}">
<input type="hidden" name="attendance_allowance" value="{{ old('attendance_allowance', 0) }}">


                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-save"></i> Create Payroll
                                </button>
                                <a href="{{ route('hrm.payroll.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>

         <script>
    $(document).ready(function () {
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
        $('#attendance_pay, #allowances, #overtime_pay, #otherDeductionPay, #loadDeduction').on('input', function () {
            calculateNetSalary();
        });

        // Initial call
        calculateNetSalary();
    });
</script>


