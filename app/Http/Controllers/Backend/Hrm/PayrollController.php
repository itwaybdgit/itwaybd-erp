<?php

namespace App\Http\Controllers\Backend\Hrm;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\ChartOfAccount;
use App\Models\AccountTransaction;
use App\Models\Company;
use App\Models\Lone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PayrollController extends Controller
{
     
       
      public function index(Request $request)
        {
           $title = 'Payroll';
        $query = Payroll::with('employee');

        // Filter by employee if provided
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by month and year if provided
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $payrolls = $query->orderBy('created_at', 'desc')->paginate(15);
        $employees = Employee::where('employee_status','present')->orderBy('id_card','asc')->get();
       

        return view('backend.pages.hrm.payroll.index', compact('payrolls', 'employees','title'));
      
       
    }

   public function create(Request $request)
{
    $employees = Employee::where('employee_status','present')->orderBy('id_card','asc')->get();
       
    $employee = null;

    if ($request->isMethod('post')) {
        $employee = Employee::where('id', $request->employee_id)->first();
    }

    $title = 'Payroll Create';
    $months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    $years = range(date('Y') - 5, date('Y') + 1);

    return view('backend.pages.hrm.payroll.create', compact('employee', 'employees', 'months', 'years', 'title'));
}


public function fetch(Request $request)
{
    $payroll = Payroll::where('employee_id', $request->employee_id)->count();
    if($payroll >0){
         return response()->json(['status' => 'success', 'message' => 'Payroll already created!']);
    }
    $employeeId = $request->employee_id;
    $monthInput = $request->month; // উদাহরণ: "May"
    $year = $request->year;        // উদাহরণ: "2025"

    // মাস নাম কে নাম্বারে রূপান্তর করা (May → 05)
    $month = date('m', strtotime("1 $monthInput"));
    $employee = Employee::where('id',$employeeId)->first();
     $accounts = ChartOfAccount::whereIn('id', [getAccountByUniqueID(6)->id])->get();
    // Attendance ফিল্টার
    $attendances = Attendance::where('emplyee_id', $employeeId)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->orderBy('date', 'asc')
        ->get();
        $employeeOT = $employee->over_time_is =='yes'? EMPLOYEE_OVER_TIME($employee->id, $request->month): 'N/A';
        $employeeOTSalary = $employee->over_time_is == 'yes' ? OVERTIME_SALARY($employee, $request->month): 'N/A';
      $holidayCount = Holiday::whereMonth('date', $month)
        ->whereYear('date', $year)->count();
        $attendnace = DB::table('attendances')->where('emplyee_id', $employeeId)->whereMonth('date', $month)
        ->whereYear('date', $year)->count();
        $leaveCount = EMPLOYEE_ABSENCE_DAY($employee->id, $request->month) ;
        $employeeAbsenseSalaryDeduction = round(($employee->salary/30)*EMPLOYEE_ABSENCE_DAY($employee->id, $request->month));
       
          $loanAdjustment = Lone::where(
                                                    'employee_id',
                                                    $employeeId,
                                                )
                                                    ->where('status', 'approved')
                                                    ->latest()
                                                    ->pluck('lone_adjustment')
                                                    ->first();
        $absenceDays = EMPLOYEE_ABSENCE_DAY($employee->id, $request->month);
       $lateDeductionDays = LATE_DAYS_SALARY_DEDUCTION($employee->id, $request->month);

         $attendanceBonus = ($absenceDays >= 1 || $lateDeductionDays >= 1) ? 0 : $employee->attendanceBonus;
        $payableSallery = ($employee->salary + $attendanceBonus + OVERTIME_SALARY($employee, $request->month)) -($loanAdjustment + round(($employee->salary/30)*EMPLOYEE_ABSENCE_DAY($employee->id, $request->month)) +round(($employee->salary/30)*LATE_DAYS_SALARY_DEDUCTION($employee->id, $request->month)));
     return view('backend.pages.hrm.payroll.create_data', compact('accounts','loanAdjustment','payableSallery','employeeOT','employee','leaveCount','attendances','employeeAbsenseSalaryDeduction','employeeOTSalary'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'advance_ledger_id' => 'required|string',
        'pay_date' => 'required|date',
        'net_salary' => 'required|numeric',
        // Add more validation rules if necessary
    ]);
$account = ChartOfAccount::where('accountable_id', $request->employee_id)
    ->where('accountable_type', 'App\Models\Employee')
    ->first();

if (!$account) {
    return response()->json(['status' => 'error', 'message' => 'Employee account not found.']);
}
//  dd($request->overtime_hours);
    $payroll = new Payroll();
    $payroll->employee_id = $request->employee_id; // Add employee_id field if needed
    $payroll->basic = $request->basic ?? 0;
    $payroll->overtime_hours = $request->overtime_hours ?? 0;
    $payroll->overtime_pay = $request->overtime_pay ?? 0;
    $payroll->attendance_allowance = $request->attendance_allowance ?? 0;
    $payroll->other_allowance_name = $request->attendance_pay;
    $payroll->other_allowance = $request->allowances ?? 0;
    $payroll->absent_deduction = $request->deductions ?? 0;
    $payroll->late_deduction = $request->additionals ?? 0;
    $payroll->loan_deduction = $request->loadDeduction ?? 0;
    $payroll->other_deduction = $request->otherDeduction ?? '';
    $payroll->other_deduction_pay = $request->otherDeductionPay ?? 0;
    $payroll->payment_mode = $request->advance_ledger_id;
    $payroll->pay_date = $request->pay_date;
    $payroll->net_salary = $request->net_salary;
     $payroll->month = $request->month;
    $payroll->year = $request->year;
    $payroll->save();

    $employeeInfo = Employee::where('id',$request->employee_id)->first();

    $invoice = AccountTransaction::accountInvoice();
    $transactionPay['payment_invoice'] = $request->invoice_no? $request->invoice_no :'';
    $transactionPay['invoice'] = $invoice ;
    $transactionPay['table_id'] =  $payroll->id;
    $transactionPay['account_id'] = getAccountByUniqueID(26)->id; // ->salary
    $transactionPay['type'] = 15;
    $transactionPay['branch_id'] = $employeeInfo->branch_id ?? 0;
    $transactionPay['debit'] =  $request->net_salary;
    $transactionPay['remark'] = $request->narration;
    $transactionPay['created_by'] = Auth::id();
    $transactionPay['supplier_id'] = $request->supplier_id ?? 0;
    $transactionPay['created_at'] = \Carbon\Carbon::now();
    AccountTransaction::create($transactionPay);


    $transaction['payment_invoice'] = $request->invoice_no ? $request->invoice_no :'';
    $transaction['invoice'] = $invoice ;
    $transaction['table_id'] =  $payroll->id;
    $transaction['account_id'] = $account->id;
    $transaction['type'] = 15;
    $transaction['branch_id'] = $employeeInfo->branch_id ?? 0;
    $transaction['credit'] = $request->net_salary;
    $transaction['remark'] = $request->narration ? $request->narration:'';
    $transaction['created_by'] = Auth::id();
    $transaction['employee_id'] = $request->employee_id ?? 0;
    $transaction['created_at'] = \Carbon\Carbon::now();
    AccountTransaction::create($transaction);


    $invoice = AccountTransaction::accountInvoice();
    $transactionPay['payment_invoice'] = $request->invoice_no ? $request->invoice_no :'';
    $transactionPay['invoice'] = $invoice ;
    $transactionPay['table_id'] = $payroll->id;
    $transactionPay['account_id'] = $account->id;
    $transactionPay['type'] = 15;
    $transactionPay['branch_id'] = $employeeInfo->branch_id ?? 0;
    $transactionPay['debit'] =  $request->net_salary;
    $transactionPay['remark'] = $request->narration;
    $transactionPay['created_by'] = Auth::id();
    $transactionPay['supplier_id'] = $request->supplier_id ?? 0;
    $transactionPay['created_at'] = \Carbon\Carbon::now();
    AccountTransaction::create($transactionPay);


    $transaction['payment_invoice'] = $request->invoice_no ? $request->invoice_no :'';
    $transaction['invoice'] = $invoice ;
    $transaction['table_id'] =  $payroll->id;
    $transaction['account_id'] =$request->advance_ledger_id; // account payable
    $transaction['type'] = 15;
    $transaction['branch_id'] = $employeeInfo->branch_id ?? 0;
    $transaction['credit'] = $request->net_salary;
    $transaction['remark'] = $request->narration ? $request->narration:'';
    $transaction['created_by'] = Auth::id();
    $transaction['employee_id'] = $request->employee_id ?? 0;
    $transaction['created_at'] = \Carbon\Carbon::now();
    AccountTransaction::create($transaction);

    return response()->json(['status' => 'success', 'message' => 'Payroll created successfully!']);
}

public function show(Payroll $payroll, $id =null)
    {
        $payroll = Payroll::where('id',$id)->with('employee')->first();
             $accounts = ChartOfAccount::whereIn('id', [getAccountByUniqueID(6)->id])->get();
        // dd($payroll);
        return view('backend.pages.hrm.payroll.show', compact('payroll','accounts'));
    }

    public function edit(Payroll $payroll, $id=null)
    {
        $employees = Employee::where('employee_status','present')->orderBy('id_card','asc')->get();
       
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $years = range(date('Y') - 5, date('Y') + 1);
       $payroll = Payroll::with('employee')->where('id',$id)->first();
         $accounts = ChartOfAccount::whereIn('id', [getAccountByUniqueID(6)->id])->get();
        // dd($payroll);
        return view('backend.pages.hrm.payroll.edit', compact('accounts','payroll', 'employees', 'months', 'years'));
    }
public function update(Request $request, $id=null)
{
    $validated = $request->validate([
        'advance_ledger_id' => 'required|string',
        'pay_date' => 'required|date',
        'net_salary' => 'required|numeric',
        // Add more validation rules if necessary
    ]);

    $payroll =  Payroll::find($id);
    // $payroll->employee_id = $request->employee_id; 
    $payroll->basic = $request->basic ?? 0;
    $payroll->overtime_pay = $request->overtime_pay ?? 0;
    $payroll->attendance_allowance = $request->attendance_allowance ?? 0;
    $payroll->other_allowance_name = $request->attendance_pay;
    $payroll->other_allowance = $request->allowances ?? 0;
    $payroll->absent_deduction = $request->deductions ?? 0;
    $payroll->late_deduction = $request->additionals ?? 0;
    $payroll->loan_deduction = $request->loadDeduction ?? 0;
    $payroll->other_deduction = $request->otherDeduction ?? '';
    $payroll->other_deduction_pay = $request->otherDeductionPay ?? 0;
    $payroll->payment_mode = $request->advance_ledger_id;
    $payroll->pay_date = $request->pay_date;
    $payroll->net_salary = $request->net_salary;
    $payroll->save();

    return response()->json(['status' => 'success', 'message' => 'Payroll update successfully!']);
}



public function payslip(Request $request)
{
    $ids = explode(',', $request->input('ids'));
    $month = $request->input('month');
    $year = $request->input('year');

    $query = Payroll::with('employee')->whereIn('id', $ids);

    if ($month) {
        $query->where('month', $month);
    }

    if ($year) {
        $query->where('year', $year);
    }

    $payslips = $query->get();
    $companyInfo = Company::latest('id')->first();

    return view('backend.pages.hrm.payroll.payslip', compact('payslips', 'companyInfo','month','year'));
}


}
