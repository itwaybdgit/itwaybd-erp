<?php

namespace App\Http\Controllers\Backend\Hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Transformers\AdjustTransformer;
use App\Transformers\Transformers;
use App\Models\Branch;
use App\Models\Attendance;
use App\Models\Customer;
use App\Models\ChartOfAccount;
use App\Models\Employee;
use App\Services\Hrm\AttendanceService;
use Illuminate\Validation\ValidationException;
use Carbon\carbon;


class AttendanceController extends Controller
{

    /**
     * @var attendanceService
     */
    private $systemService;
    /**
     * @var Transformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param adjustService $systemService
     * @param adjustTransformer $systemTransformer
     */
    public function __construct(AttendanceService $attendanceService, Transformers $Transformer)
    {
        $this->systemService = $attendanceService;

        $this->systemTransformer = $Transformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Attendance List';
        session(['previous_url' => url()->current()]);
        return view('backend.pages.hrm.attendance.index', get_defined_vars());
    }


    public function dataProcessingattendance(Request $request)
    {
        session()->put('type', 2);
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Adjust';
        $branch = Branch::get()->where('status', 'Active');
        $customer = Customer::get()->where('status', 'Active');
        $account = ChartOfAccount::get()->where('status', 'Active');
       $employees = Employee::where('employee_status','present')->orderBy('id_card','asc')->get();

        return view('backend.pages.hrm.attendance.create', get_defined_vars());
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sign_in(Request $request)
    {
        try {
            $this->validate($request, $this->systemService->signinValidation($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        if (Attendance::where('emplyee_id', $request->emplyee_id)->whereDate('date', $request->date)->first()) {
            session()->flash('error', 'This employee already check in');
            return redirect()->route('hrm.attendance.create');
        }
        $this->systemService->signin($request);
        $lock = 0;
        session()->put('sign', "0");

        session()->flash('success', 'Check In successfully!!');
        return redirect()->route('hrm.attendance.create');
    }

    public function sign_out(Request $request)
    {
        try {
            $this->validate($request, $this->systemService->signoutValidation($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        if (!Attendance::where('emplyee_id', $request->emplyee_id)->whereDate('date', today()->format('Y-m-d'))->first()) {
            session()->flash('error', 'This employee not check in');
            return redirect()->route('hrm.attendance.create');
        }
        $this->systemService->signout($request);
        session()->put('sign', "1");

        session()->flash('success', 'Check Out successfully!!');
        return redirect()->route('hrm.attendance.create');
    }


  public function absentEmployee(Request $request)
    {
    //    dd($request->all());
       
        if (Attendance::where('emplyee_id', $request->emplyee_id)->whereDate('date', today()->format('Y-m-d'))->first()) {
            session()->flash('error', 'This employee  check in');
            return redirect()->route('hrm.attendance.create');
        }
        $this->systemService->absent($request);
       

        session()->flash('success', 'Absent successfully!!');
        return redirect()->route('hrm.attendance.create');
    }


    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statusUpdate($id, $status)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->statusUpdate($id, $status);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }

    /**
     * Edit Attendance
     *
     * @author itwaybd
     * @contributor Sajjad
     * @param int $id
     * @created 17-09-23
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        
        $title = "Edit Attendance";
        $model = $this->systemService->edit($id);

        return view('backend.pages.hrm.attendance.edit', get_defined_vars());
    }

    /**
     * Update Attendance
     *
     * @author itwaybd
     * @contributor Sajjad
     * @param int Request $request
     * @created 17-09-23
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function update(Request $request, $id)
    {
        $updated = Attendance::find($id);
         $updated->date     = $request->date;
          $updated->sign_in   = $request->sign_in;
           $updated->sign_out   = $request->sign_out;
           $updated->save();

        if ($updated) {
            session()->flash('success', 'Attendance update successfuly!!');
           return redirect(session('previous_url') ?? route('admin.hrm-attendance-index'));
        }
    }

    /**
     * Delete Attendance
     *
     * @author itwaybd
     * @contributor Sajjad
     * @param int Request $request
     * @created 17-09-23
     *
     * @return      * Delete Attendance

     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $deleteInfo =  $this->systemService->destroy($id);
        if ($deleteInfo) {
            return response()->json($this->systemTransformer->delete($deleteInfo), 200);
        }
    }

public function mark(Request $request)
{
   
    $title = 'Attendance Mark';
    session(['previous_url' => url()->current()]);
     $employees = Employee::where('employee_status','present')->orderBy('id_card','asc')->get();

    
    // Initialize collections
    $attendances = collect();
    $dayes = collect();

    if ($request->isMethod('post')) {
        $query = Attendance::with('employe')
            ->selectRaw('DATE(date) as date, emplyee_id, sign_in, sign_out, id, markStatus, ot, attendanceStatus');


        // Apply filters
        if ($request->employee_id && $request->employee_id !== 'all') {
            $query->where('emplyee_id', $request->employee_id);
        }

        if ($request->from) {
            $query->whereDate('date', $request->from);
        } else {
            // Default to today if no date specified
            $query->whereDate('date', now()->toDateString());
        }

        $attendances = $query->orderBy('emplyee_id','asc')->get();

        // Get unique dates for grouping
        $dayes = $attendances->groupBy('date')->keys()->map(function($date) {
            return (object)['date' => $date];
        });
        //    dd($attendances);
        // For AJAX requests, return partial view
        if ($request->ajax()) {
            return view('backend.pages.hrm.attendance.partial_table', compact('attendances', 'dayes','employees'))->render();
        }
    } else {
        // Default GET request - show today's attendance
        $today = now()->toDateString();
        $attendances = Attendance::with('employe')
            ->selectRaw('DATE(date) as date, emplyee_id, sign_in, sign_out, id')
            ->whereDate('date', $today)
            ->get();

        $dayes = collect([(object)['date' => $today]]);
    }

    return view('backend.pages.hrm.attendance.mark', compact('title', 'employees', 'attendances', 'dayes'));
}

public function ajaxUpdate(Request $request)
{
    //  dd($request->all());
    foreach ($request->attendances as $item) {
        $attendance = Attendance::find($item['attendance_id']);

        if (!$attendance) continue;

        // Check previous date for late count
        $previousDate = \Carbon\Carbon::parse($attendance->date)->subDay()->toDateString();
        $previous = Attendance::where('emplyee_id', $item['employee_id'])
                              ->where('date', $previousDate)
                              ->first();

        $lateCount = $previous && $previous->lateStatus == 'yes'
            ? ($previous->lateCount ?? 0) + 1
            : 1;
  
        $attendance->update([
            'sign_in' => $item['sign_in'],
            'sign_out' => $item['sign_out'],
            'lateStatus' => $item['lateStatus'],
            'ot' => $item['ot'],
            'attendanceStatus' => $item['attendanceStatus'],
            'markStatus' => 'yes',
            'lateCount' => $lateCount,
        ]);
    }

    return response()->json(['success' => true]);
}


public function updateSingle(Request $request, $id)
{
    // dd($request->all());
    $attendance = Attendance::findOrFail($id);

    // Update basic fields
    $attendance->sign_in = $request->sign_in;
    $attendance->sign_out = $request->sign_out;

    // Update additional fields
    $attendance->lateStatus = $request->lateStatus ? 'yes' : 'no'; // Assuming it's a boolean
    $attendance->markStatus = $request->markStatus ? 'yes' : 'no';
    $attendance->attendanceStatus = $request->attendanceStatus; // 'present' or 'absent'
     $attendance->ot = $request->ot;

    

    $attendance->save();

  return response()->json([
        'success' => true,
       
    ]);
}


public function fetchRow($id)
{
    $attendance = Attendance::with('employe')->findOrFail($id);

    return view('backend.pages.hrm.attendance.single_row', compact('attendance'))->render();
}

}
