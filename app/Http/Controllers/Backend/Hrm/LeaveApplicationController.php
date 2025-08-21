<?php

namespace App\Http\Controllers\Backend\Hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Transformers\AdjustTransformer;
use App\Services\Hrm\LeaveApplicationService;
use App\Services\InventorySetup\AdjustService;
use App\Transformers\Transformers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class LeaveApplicationController extends Controller
{

    /**
     * @var adjustService
     */
    private $systemService;
    /**
     * @var adjustTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param adjustService $systemService
     * @param adjustTransformer $systemTransformer
     */
    public function __construct(LeaveApplicationService $LeaveApplicationService, Transformers $transformers)
    {
        $this->systemService = $LeaveApplicationService;

        $this->systemTransformer = $transformers;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Leave application List';
        $leaveAplications = LeaveApplication::get();
        return view('backend.pages.hrm.leave_application.index', get_defined_vars());
    }


    public function dataProcessingLeaveApplication(Request $request)
    {

        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Leave application ';
        $employees = Employee::get();
        $departments = Department::get();
        return view('backend.pages.hrm.leave_application.create', get_defined_vars());
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $LeaveApplication = new LeaveApplication();
        $LeaveApplication->employee_id = $request->employee_id;
        $LeaveApplication->department_id = $request->department_id;
        $LeaveApplication->apply_date = $request->apply_date;
        $LeaveApplication->end_date = $request->end_date;
        $LeaveApplication->reason = $request->reason;
        $LeaveApplication->payment_status = $request->payment_status;
        $file = $request->file('file');
        if (isset($file)) {
            $currentDate = Carbon::now()->toDateString();
            $fileName  = $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('leave')) {
                Storage::disk('public')->makeDirectory('leave');
            }

            $file->storeAs('leave', $fileName, 'public');
        } else {
            $fileName = null;
        }
        $LeaveApplication->file = $fileName;
        $LeaveApplication->save();
        return redirect()->route('hrm.leave.index');
    }
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo =   $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        $title = 'Add New Salary Sheet';
        $employees = Employee::where('status', 'Active')->get();
        $model = LeaveApplication::findOrFail($id);
        return view('backend.pages.hrm.leave_application.edit', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo = $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        try {
            $this->validate($request, $this->systemService->updateValidation($request, $id));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('hrm.leave.index');
    }

    // Leave Application Deatails
    public function show(LeaveApplication $leave)
    {

        $title = 'Leave application Details';
        return view('backend.pages.hrm.leave_application.details', get_defined_vars());
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
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
}
