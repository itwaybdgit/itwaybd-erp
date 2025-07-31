<?php

namespace App\Http\Controllers\Backend\Hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\AdjustTransformer;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\ChartOfAccount;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Zone;
use App\Models\Accounts;
use App\Models\RollPermission;
use App\Models\Subzone;
use App\Models\Position;
use App\Models\Department;
use App\Models\Designation;
use App\Services\Hrm\EmployeeService;
use App\Services\InventorySetup\AdjustService;
use App\Helpers\ZktecoMatching;
use App\Models\Account;
use App\Models\Box;
use App\Models\Device;
use App\Models\Splitter;
use App\Models\Tj;
use App\Transformers\Transformers;
use Illuminate\Validation\ValidationException;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class EmployeeController extends Controller
{

    /**
     * @var employeService
     */
    private $systemService;
    /**
     * @var Transformer
     */
    private $systemTransformer;


    /**
     * CategoryController constructor.
     * @param employeService $systemService
     * @param Transformer $systemTransformer
     */

    public function __construct(EmployeeService $employeeService, Transformers $transformers)
    {


        $this->systemService = $employeeService;

        $this->systemTransformer = $transformers;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $title = 'Employee List';
        return view('backend.pages.hrm.employee.index', get_defined_vars());
    }

    public function dataProcessingEmployee(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Employee';
        $branchs = Branch::get();
        $designations = Designation::get();
        $userrolls = RollPermission::get();
        $departments = Department::get();

        $zones = Zone::get();
        $subzones = Subzone::get();
        $positions = Position::get();
        if (env("ZKTECO")) {
            $area =  isset(getZKTecoAreas()['data']) ? getZKTecoAreas()['data'] : [];
        } else {
            $area = [];
        }

        return view('backend.pages.hrm.employee.create', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, $this->systemService->storeValidation($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->store($request);
        session()->flash('success', 'Data successfully save!!');
        return redirect()->route('hrm.employee.index');
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
        $title = 'Add New Employee';
        // $userRoll = $this->userRoleService->getAllRole();
        $branchs = Branch::get();
        $positions = Position::get();
        $userrolls = RollPermission::get();
        $departments = Department::get();
        $zones = Zone::get();
        $subzones = Subzone::get();
        $designations = Designation::get();
        $positions = Position::get();
        $model = Employee::findOrFail($id);
        if (env("ZKTECO")) {
            $area =  isset(getZKTecoAreas()['data']) ? getZKTecoAreas()['data'] : [];
        } else {
            $area = [];
        }
        return view('backend.pages.hrm.employee.edit', get_defined_vars());
    }



    public function show(Employee $employee)
    {
        $title = 'Employee Details';
        $company = Company::first();
        return view('backend.pages.hrm.employee.details', get_defined_vars());
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
        return redirect()->route('hrm.employee.index');
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
    public function storeAccount(Request $request)
    {
        $employees = Employee::all();
        $created = 0;
        $skipped = 0;

        foreach ($employees as $employee) {
            $existingAccount = Account::where('accountable_id', $employee->id)
                ->where('accountable_type', "App\Models\Employee")
                ->first();

            if (!$existingAccount) {
                $account = new Account();
                $account->account_name = $employee->name ?? 'Employee';
                $account->parent_id = 16;
                $account->accountable_id = $employee->id;
                $account->accountable_type = "App\Models\Employee";
                $account->bill_by_bill = 1;
                $account->branch_id = $request->branch_id ?? 1; // default branch_id if not sent
                $account->status = 'Active';
                $account->created_by = auth()->user()->id;
                $account->save();

                $created++;
            } else {
                $skipped++;
            }
        }

        return back();
    }
}
