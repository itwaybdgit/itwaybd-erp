<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Pop;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Noc2ApproveController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'noc2_approv';
    protected $viewName =  'admin.pages.crm.noc2_approv';

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
            $this->getModel()->where('transmission_approve','1')->where('noc2_approve' , "0")->where('reject_sales_approve',"0"),
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
        $page_heading = "NOC2 Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');

        $noc2Remarks = ApprovalRemarks::where('type', 'noc2_approve')->where('created_by', Auth::user()->id)->get();

        $routes = Router::all();
        $ports = Pop::all();

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

        $noc2Remark = new ApprovalRemarks();
        $noc2Remark->type = 'noc2_approv';
        $noc2Remark->remarks = $request->remarks;
        $noc2Remark->customer_id = $id;
        $noc2Remark->created_by = Auth::user()->id;
        $noc2Remark->save();

        return redirect()->route('noc2_approv.index')->with('success', 'Remarks added successfully!');
    }

    public function approve($id) {
        $noc2Approve = BandwidthCustomer::findOrFail($id);
        $noc2Approve->noc2_approve = '1';
        $noc2Approve->assign_to = '3';
        $noc2Approve->assign_by = auth()->user()->id;
        $noc2Approve->noc2_approve_by = Auth::user()->id;
        $noc2Approve->save();

        setNotification('level_3',"New Client Level 3 Approve Notification",route('level_3.index'));
        // return redirect()->route('admin_approv.index')->with('success', 'Lead approved successfully!');
        return response()->json(['code' => 200, 'message' => 'Lead approved successfully', 'redirect_url' => route('noc2_approv.index')]);
    }
}
