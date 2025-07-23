<?php

namespace App\Http\Controllers\Backend\Hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\EmpPayDetails;
use App\Models\Lone;
use App\Models\Account;
use App\Models\MonthlyPayableSalary;
use App\Models\Transection;
use Illuminate\Support\Facades\DB;

class PaySheetController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {

        global $conveyance;
        $title = 'Pay Sheet';
        $employees = Employee::where('employee_status', 'present')->orderBy('id_card', 'asc')->get();

        $accounts = Account::whereIn('id', [4, 5, 6])->get();
        if ($request->method() == "GET") {
            $MonthlyPaySheetscheck = MonthlyPayableSalary::whereMonth('date', date('m', strtotime($request->month)))->exists();
            if (!$MonthlyPaySheetscheck) {
                $tables = [];

                $takeEmployee = new Employee();
                if ($request->employee_id && $request->employee_id != "all") {
                    $takeEmployee = $takeEmployee->where("id", $request->employee_id);
                }
                $takeEmployee = $takeEmployee->where('employee_status', 'present')->get();


                foreach ($takeEmployee as $employee) {

                    $absenceDates = EMPLOYEE_ABSENT_DATES($employee->id, $request->month);

                    $inputMonth = $request->month;
                    $month = \Carbon\Carbon::parse($inputMonth);

                    $monthName = $month->format('F');
                    $year = $month->year;

                    $payroll = Payroll::where('month', $monthName)->where('year', $year)->where('employee_id', $employee->id)->count();
                    //  dd($payroll);
                    $absenceDays = EMPLOYEE_ABSENCE_DAY($employee->id, $request->month);
                    $lateDeductionDays = LATE_DAYS_SALARY_DEDUCTION($employee->id, $request->month);

                    $attendanceBonus = ($absenceDays >= 1 || $lateDeductionDays >= 1) ? 0 : $employee->attendanceBonus;
                    $tables[] = [
                        "employee_id" =>  $employee->id,
                        "id_card" =>  $employee->id_card,
                        "name" => $employee->name,
                        "date" => now(),
                        "total_salary" => $employee->salary,
                        'payroll' => $payroll,
                        'absenceDates' => $absenceDates,

                        "attendance_bonus" => $attendanceBonus,
                        // "basic_salary" => EMPLOYEE_BASIC_SALARY($employee->salary)['half_salary'],
                        // "house_rent" =>  EMPLOYEE_HOUSE_RENT_SALARY($employee->salary) ,
                        // "medical_allowance" => $employee->salary * 0.125,
                        // "travel_allowance" =>  $employee->salary * 0.125,
                        "working_day" =>  MONTH_WORKING_DAY($request->month),

                        "employee_presence_day" =>  EMPLOYEE_PRESENCE_DAY($employee->id, $request->month),
                        "employee_absence_day" =>  EMPLOYEE_ABSENCE_DAY($employee->id, $request->month),
                        "absece_salary_deduction" => round(($employee->salary / 30) * EMPLOYEE_ABSENCE_DAY($employee->id, $request->month)),
                        "employee_late" => LATE_DAYS($employee->id, $request->month),
                        "employee_late_deduction" => LATE_DAYS_SALARY_DEDUCTION($employee->id, $request->month),
                        "employee_late_salary_deduction" => round(($employee->salary / 30) * LATE_DAYS_SALARY_DEDUCTION($employee->id, $request->month)),
                        "employee_paid_leave" => PAID_LEAVE_COUNT($employee),
                        "employee_unpaid_leave" => UNPAID_LEAVE_COUNT($employee),
                        "overtime_houre" => $employee->over_time_is == 'yes' ? EMPLOYEE_OVER_TIME($employee->id, $request->month) : 'N/A',
                        "overtime_salary" => $employee->over_time_is == 'yes' ? OVERTIME_SALARY($employee, $request->month) : 'N/A',
                        "employee_payable_salary" => ($employee->salary + $attendanceBonus + OVERTIME_SALARY($employee, $request->month)) - (round(($employee->salary / 30) * EMPLOYEE_ABSENCE_DAY($employee->id, $request->month)) + round(($employee->salary / 30) * LATE_DAYS_SALARY_DEDUCTION($employee->id, $request->month))),
                        "created_at" => now(),
                        "updated_at" => now()
                    ];
                }
            } else {
                $MonthlyPaySheets = new MonthlyPayableSalary();
                if ($request->employee_id != 'all') {
                    $MonthlyPaySheets = $MonthlyPaySheets->where('employee_id', $request->employee_id);
                }
                if ($request->month) {
                    $MonthlyPaySheets = $MonthlyPaySheets->whereMonth('date', date("m", strtotime($request->month)));
                }
                $MonthlyPaySheets = $MonthlyPaySheets->get();
            }
        }

        return view('backend.pages.hrm.attendance.paysheet.index', get_defined_vars());
    }

    public function show(Employee $pay)
    {
        $title = 'Pay Sheet details';
        return view('backend.pages.hrm.attendance.paysheet.details', get_defined_vars());
    }


    public function empPayDetailsStore(Request $request, MonthlyPayableSalary $monthlyPayableSalary)
    {
        $request->validate([
            'payment_type' => 'required',
            'amount' => 'required'
        ]);

        $title = 'Pay Sheet details';

        try {
            $loan = DB::table('transections')->where('account_id', 1)->where('employee_id', $monthlyPayableSalary->employee_id)
                ->selectRaw('SUM(debit) as debit ,SUM(credit) as credit')
                ->first();
            $loanBalance = $loan->debit - $loan->credit;
            $empPayDetails = new EmpPayDetails();
            $empPayDetails->pay_sheet_id = $monthlyPayableSalary->id;
            $empPayDetails->branch_id = $monthlyPayableSalary->employee->branch_id;
            $empPayDetails->employee_id = $monthlyPayableSalary->employee_id;
            $empPayDetails->payble_salary = $monthlyPayableSalary->employee_payable_salary;
            $empPayDetails->amount = $request->amount;
            $empPayDetails->lone = $loanBalance;
            $empPayDetails->save();

            $loanAdjustment = Lone::where('employee_id', $monthlyPayableSalary->employee_id)->where('status', 'approved')->latest()->pluck('lone_adjustment')->first();

            if ($loanBalance > 0) {
                if ($request->amount < $loanAdjustment) {
                    $transection1['date'] = now();
                    $transection1['account_id'] = 3; //salary
                    $transection1['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection1['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection1['type'] =  16;
                    $transection1['amount'] = $request->amount;
                    $transection1['debit'] = $request->amount;
                    Transection::create($transection1);

                    $transection2['date'] = now();
                    $transection2['account_id'] = 1;
                    $transection2['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection2['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection2['type'] =  16;
                    $transection2['amount'] = $request->amount;
                    $transection2['credit'] = $request->amount;
                    Transection::create($transection2);
                } elseif ($loanBalance > $loanAdjustment) {
                    $transection1['date'] = now();
                    $transection1['account_id'] = 3; //salary
                    $transection1['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection1['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection1['type'] =  16;
                    $transection1['amount'] = $request->amount;
                    $transection1['debit'] = $request->amount;
                    Transection::create($transection1);

                    $transection2['date'] = now();
                    $transection2['account_id'] = 1;
                    $transection2['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection2['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection2['type'] =  16;
                    $transection2['amount'] = $loanAdjustment;
                    $transection2['credit'] = $loanAdjustment;
                    Transection::create($transection2);

                    $transection3['date'] = now();
                    $transection3['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection3['account_id'] = $request->payment_type; //cash ,bank , mobile banking
                    $transection3['type'] =  16;
                    $transection3['amount'] = ($request->amount -  $loanAdjustment);
                    $transection3['credit'] = ($request->amount -  $loanAdjustment);
                    Transection::create($transection3);
                } else {
                    $transection1['date'] = now();
                    $transection1['account_id'] = 3; //salary
                    $transection1['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection1['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection1['type'] =  16;
                    $transection1['amount'] = $request->amount;
                    $transection1['debit'] = $request->amount;
                    Transection::create($transection1);

                    $transection2['date'] = now();
                    $transection2['account_id'] = 1;
                    $transection2['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection2['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection2['type'] =  16;
                    $transection2['amount'] = $loanBalance;
                    $transection2['credit'] = $loanBalance;
                    Transection::create($transection2);

                    $transection3['date'] = now();
                    $transection3['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection3['account_id'] = 4; //cash ,bank , mobile banking
                    $transection3['type'] =  16;
                    $transection3['amount'] = ($request->amount -  $loanBalance);
                    $transection3['credit'] = ($request->amount -  $loanBalance);
                    Transection::create($transection3);
                    Lone::where('employee_id', $monthlyPayableSalary->employee_id)->where('status', 'approved')->latest()->update(['status' => 'completed']);
                }
            } else {
                if ($request->amount < $monthlyPayableSalary->employee_payable_salary) {
                    $transection7['date'] = now();
                    $transection7['account_id'] = 3;
                    $transection7['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection7['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection7['type'] =  15;
                    $transection7['amount'] = $monthlyPayableSalary->employee_payable_salary;
                    $transection7['debit'] = $monthlyPayableSalary->employee_payable_salary;
                    Transection::create($transection7);

                    $transection8['date'] = now();
                    $transection8['account_id'] = $request->payment_type;
                    $transection8['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection8['type'] =  15;
                    $transection8['amount'] = $request->amount;
                    $transection8['credit'] = $request->amount;
                    Transection::create($transection8);

                    $transection9['date'] = now();
                    $transection9['account_id'] = 2;
                    $transection9['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection9['employee_id'] = $monthlyPayableSalary->employee_id;
                    $transection9['type'] =  15;
                    $transection9['amount'] = ($monthlyPayableSalary->employee_payable_salary - $request->amount);
                    $transection9['credit'] =  ($monthlyPayableSalary->employee_payable_salary - $request->amount);
                    Transection::create($transection9);
                } else {
                    $transection10['date'] = now();
                    $transection10['account_id'] = 3;
                    $transection10['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection10['employee_id'] = $monthlyPayableSalary->employee_id;

                    $transection10['type'] =  15;
                    $transection10['amount'] = $request->amount;
                    $transection10['debit'] = $request->amount;
                    Transection::create($transection10);

                    $transection11['date'] = now();
                    $transection11['account_id'] = $request->payment_type;
                    $transection11['branch_id'] = $monthlyPayableSalary->employee->branch_id;
                    $transection11['employee_id'] = $monthlyPayableSalary->employee_id;

                    $transection11['type'] =  15;
                    $transection11['amount'] = $request->amount;
                    $transection11['credit'] = $request->amount;
                    Transection::create($transection11);
                }
            }
            $monthlyPayableSalary->update(['status' => 'paid']);
            session()->flash('success', 'Data successfully save!!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return $th->getMessage() . $th->getLine();
        }
        session()->flash('success', 'Data successfully save!!');
        return redirect()->back();
        return view('backend.pages.hrm.attendance.paysheet.details', get_defined_vars());
    }
}
