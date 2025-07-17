<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\LegalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LegalApproveController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'legal_approv';
    protected $viewName =  'admin.pages.crm.legal_approv';

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
                'searchable' => false,
                // 'relation' => 'lead',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => false,
                // 'relation' => 'lead',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => false,
                // 'relation' => 'lead',
            ],
            [
                'label' => 'Customer Priority',
                'data' => 'customer_priority',
                'searchable' => false,
                // 'relation' => 'lead',
            ],
            [
                'label' => 'KAM',
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
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('legal_approve' , "0")->where('sales_approve',"1")->where('reject_sales_approve',"0"),
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

    function check_validity(BandwidthCustomer $customer) {
        $page_heading = "Legal & Compliance Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');

        $legalRemarks = ApprovalRemarks::where('type', 'legal_approve')->where('customer_id', $customer->id)->where('created_by', Auth::user()->id)->get();

        $legalInfo = LegalInfo::where('bandwidth_customer_id', $customer->id)->first();

        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function store(Request $request, $id) {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'type' => 'required',
            'remarks' => 'required',
            'customer_id' => 'required',
            'created_by' => 'required',
        ]);

        $legalRemark = new ApprovalRemarks();
        $legalRemark->type = 'legal_approve';
        $legalRemark->remarks = $request->remarks;
        $legalRemark->customer_id = $id;
        $legalRemark->created_by = Auth::user()->id;
        $legalRemark->save();

        return redirect()->route('legal_approv.index')->with('success', 'Remarks added successfully!');
    }

    public function approve($id) {
        $legalApprove = BandwidthCustomer::findOrFail($id);
        $legalApprove->legal_approve = '1';
        $legalApprove->legal_approve_by = Auth::user()->id;
        $legalApprove->save();
        setNotification('billing_department',"New Client Billing Approve Notification",route('billing_approv.index'));
        return response()->json(['code' => 200, 'message' => 'Lead approved successfully', 'redirect_url' => route('legal_approv.index')]);
    }
}
