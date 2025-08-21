<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Helpers\ZktConnect;
use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Revert;
use App\Models\RollPermission;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevertController extends Controller

{
    /**
     * String property
     */
    protected $routeName =  'reverts';
    protected $viewName =  'admin.pages.revert';

    protected function getModel()
    {
        return new BandwidthCustomer();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'Sl',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Company name',
                'data' => 'company_name',
                'searchable' => true,
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => true,
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => true,
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Customer Priority',
                'data' => 'customer_priority',
                'searchable' => true,
                // 'relation' => 'getMProfile',
            ],
            [
                'label' => 'Action',
                'data' => 'action',
                'class' => 'text-nowrap',
                'orderable' => false,
                'searchable' => false,
            ],

        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Revert";
        $page_heading = "Revert List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $model = $this->viewName . '.salarystore';
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request)
    {
        $revert = Revert::where('status', 0)->pluck('table_id');
        $employeecheck = auth()->user()->employee;
        if ($employeecheck) {
            $model = $this->getModel()->whereIn('id', $revert)->where('created_by', auth()->user()->id);
        } else {
            $model = $this->getModel()->whereIn('id', $revert);
        }
        return $this->getDataResponse(
            //Model Instance
            $model,
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'show',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-eye',
                    'text' => '',
                    'title' => 'Confirm Sale',
                ],
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Revert Create";
        $page_heading = "Revert Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $designations = Designation::get();
        $userrolls = RollPermission::get();
        $departments = Department::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $revert = new Revert();
            $revert->type = $request->input('type');
            $revert->revert_by = auth()->id();
            $revert->table_id = $request->input('table_id');
            $revert->reason = $request->input('reason') ?? "";
            $revert->save();

            $bandwidthcustomer = Bandwidthcustomer::find($request->input('table_id'));
            $bandwidthcustomer->reject_sales_approve = 1;
            $bandwidthcustomer->save();

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getLine());
            return back()->with('failed', $this->getError($e));
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BandwidthCustomer $customer)
    {
        $modal_title = 'Customer Details';
        $customer = $customer;
        $revert = Revert::where('table_id', $customer->id)->orderBy('id', 'DESC')->first();
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    public function reject(Revert $revert)
    {
        $revert->update([
            'status' => 2,
        ]);

        $revert->bandwidthcustomer->update([
            'sales_approve' => 1,
            'legal_approve' => 1,
            'transmission_approve' => 1,
            'noc_approve' => 1,
            'noc2_approve' => 1,
            'billing_approve' => 1,
        ]);

        return redirect()->route('reverts.index')->with('success', 'Data Update Successfully');
    }

    public function confirm(Revert $revert)
    {
        $revert->update([
            'status' => 1,
        ]);

        $revert->bandwidthcustomer->update([
            'reject_sales_approve' => 0,
        ]);


        return redirect()->route('reverts.index')->with('success', 'Data Update Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $page_title = "Employee Edit";
        $page_heading = "Employee Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $employee->id);
        $designations = Designation::get();
        $userrolls = RollPermission::get();
        $departments = Department::get();
        $editinfo = $employee;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'id_card' => ['nullable'],
            'email' => ['required', 'unique:employees,email,' . $employee->id],
            'user_id' => ['nullable', 'numeric'],
            'dob' => ['nullable'],
            'gender' => ['nullable'],
            'username' => [Rule::requiredIf(!empty($request->username))],
            'roll_id' => [Rule::requiredIf(!empty($request->roll_id))],
            'personal_phone' => ['nullable'],
            'office_phone' => ['nullable'],
            'marital_status' => ['nullable'],
            'nid' => ['nullable'],
            'last_in_time' => ['nullable'],
            'reference' => ['nullable'],
            'experience' => ['nullable'],
            'Active_address' => ['nullable'],
            'permanent_address' => ['nullable'],
            'department_id' => ['nullable'],
            'designation_id' => ['nullable'],
            'achieved_degree' => ['nullable'],
            'institution' => ['nullable'],
            'passing_year' => ['nullable'],
            'salary' => ['nullable'],
            'join_date' => ['nullable'],
            'image' => ['nullable'],
            'emp_signature' => ['nullable'],
            'updated_by' => ['nullable'],
            'created_by' => ['nullable'],
            'deleted_by' => ['nullable'],
            'blood_group' => ['nullable'],
            'is_login' => ['nullable'],
            'password' => ['nullable', 'confirmed', 'min:6',],
        ]);

        try {
            DB::beginTransaction();

            if ($employee->is_login == "true") {
                $user['name'] = $request->name;
                $user['username'] = $request->username;
                $user['is_admin'] = $request->access_type;
                $user['email'] = $request->email;
                $user['phone'] = $request->phone;
                $user['roll_id'] = $request->roll_id;
                $user['password'] = $request->password ? Hash::make($request->password) : $employee->employelist->password;
                $employee->employelist->update($user);
            }

            $employee->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
