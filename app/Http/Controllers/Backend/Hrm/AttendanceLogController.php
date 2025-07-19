<?php

namespace App\Http\Controllers\Backend\Hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Holiday;
use Rats\Zkteco\Lib\ZKTeco;

class AttendanceLogController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $title = 'Attendance Log';
        session(['previous_url' => url()->current()]);
        $employees = Employee::where('employee_status', 'present')->orderBy('id_card', 'asc')->get();


        $attendances = collect();
        $dayes = collect();

        if ($request->method() == "POST") {
            // Fetch attendances with date grouping
            $attendances = Attendance::selectRaw('DATE(date) date, emplyee_id, sign_in, sign_out, id,attendanceStatus')->with('employe');

            if ($request->employee_id != 'all') {
                $attendances = $attendances->where('emplyee_id', $request->employee_id);
            }

            if ($request->from && $request->to) {
                $attendances = $attendances->whereBetween('date', [$request->from, $request->to]);
            }

            $attendances = $attendances
                ->orderByRaw('DATE(date) DESC')
                ->orderBy('id', 'ASC')
                ->get();
            // group by date after collection


            // Get only the list of distinct days (for header/loop maybe)
            $dayes = Attendance::selectRaw('DATE(date) as date');
            if ($request->from && $request->to) {
                $dayes = $dayes->whereBetween('date', [$request->from, $request->to]);
            }
            $dayes = $dayes->groupByRaw('DATE(date)')
                ->orderByRaw('DATE(date) ASC')
                ->get();
        }

        return view('backend.pages.hrm.attendance.attendance-log.index', compact('title', 'employees', 'attendances', 'dayes', 'request'));
    }




    public function newemployee(Request $request)
    {
        $title = 'New  Employee';

        $employees = Employee::whereMonth("created_at", date("m"))->whereYear("created_at", date("Y"))->get();

        return view('backend.pages.hrm.attendance.attendance-log.newemployee', compact("employees", "title"));
    }

    public function absent(Request $request)
    {
        $title = 'Attendance Absent';

        // Default date range: today
        $from = $request->from ?? date("Y-m-d");
        $to = $request->to ?? date("Y-m-d");

        // Get all holiday dates in range
        $holidays = Holiday::whereBetween('date', [$from, $to])->pluck('date')->toArray();

        // Get all employees
        $employees = Employee::where('employee_status', 'present')->orderBy('id_card', 'asc')->get();

        // Create date range
        $dateRange = collect();
        for ($date = strtotime($from); $date <= strtotime($to); $date = strtotime('+1 day', $date)) {
            $dateRange->push(date('Y-m-d', $date));
        }

        // Prepare employee-based absent data
        $employeeAbsents = [];

        foreach ($dateRange as $date) {
            // Skip holidays
            if (in_array($date, $holidays)) {
                continue;
            }

            // Present employees on this date
            $presentEmployeeIds = Attendance::whereDate('date', $date)->pluck('emplyee_id')->toArray();

            // Filter absent employees
            $absentEmployees = $employees->filter(function ($employee) use ($presentEmployeeIds) {
                return !in_array($employee->id, $presentEmployeeIds);
            });

            // Group absent dates by employee
            foreach ($absentEmployees as $employee) {
                $employeeAbsents[$employee->id]['employee'] = $employee;
                $employeeAbsents[$employee->id]['dates'][] = $date;
            }
        }

        return view('backend.pages.hrm.attendance.attendance-log.absent', compact(
            'title',
            'employeeAbsents',
            'from',
            'to',
            'employees',
            'request' // ✅ This line fixes the error
        ));
    }
}
