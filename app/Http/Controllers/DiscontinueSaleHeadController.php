<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Employee;
use App\Models\ResellerDiscontinue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiscontinueSaleHeadController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'discontinue_salehead';
    protected $viewName =  'admin.pages.crm.discontinue_salehead';

    protected function getModel()
    {
        return new ResellerDiscontinue();
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
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => false,
                'relation' => 'customer',
            ],

            [
                'label' => 'Kam',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'kam',
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
        $page_title = "Customer";
        $page_heading = "Customer List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $is_show_checkbox = false;
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

    public function dataProcessing()
    {
        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            $employee = Employee::where('team',auth()->user()->employee->team ?? 0)->pluck('user_id');
            $model = $this->getModel()->where('sale_head_approve' , 1)->whereIn('created_by',$employee);
        }else{
            $model = $this->getModel()->where('sale_head_approve' , 1);
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
                    'method_name' => 'check_validity',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-check',
                    'text' => '',
                    'title' => 'Check Validity',
                ],
            ]
        );
    }

    function check_validity(ResellerDiscontinue $discontinue) {
        $page_heading = "Head Of Sales Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $customer = $discontinue->customer;
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function store(Request $request, $id) {
        $validate = Validator::make($request->all(), [
            'type' => 'required',
            'remarks' => 'required',
            'customer_id' => 'required',
            'created_by' => 'required',
        ]);

        $adminRemark = new ApprovalRemarks();
        $adminRemark->type = 'admin_approve';
        $adminRemark->remarks = $request->remarks;
        $adminRemark->customer_id = $id;
        $adminRemark->created_by = Auth::user()->id;
        $adminRemark->save();
        return redirect()->route('admin_approv.index')->with('success', 'Remarks added successfully!');
    }

    public function approve($id) {
        $salesApprove = ResellerDiscontinue::findOrFail($id);
        $salesApprove->sale_head_approve = '2';
        $salesApprove->bill_head_approve = '1';
        $salesApprove->sale_head_by = Auth::user()->id;
        $salesApprove->save();
        setNotification("billing_department","New billing Approve Request",route('discontinue_billing.index'));

        // return redirect()->route('admin_approv.index')->with('success', 'Lead approved successfully!');
        return response()->json(['code' => 200, 'message' => 'Sale approved successfully', 'redirect_url' => route('discontinue_salehead.index')]);
    }
}
