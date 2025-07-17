<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Pop;
use App\Models\ResellerCapUncap;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UncapLevel4ApproveController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'uncap_level4_approv';
    protected $viewName =  'admin.pages.crm.uncap_noc2_approv';

    protected function getModel()
    {
        return new ResellerCapUncap();
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
            $this->getModel()->where('level4_approve' , "1"),
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

    function check_validity(ResellerCapUncap $customer) {
        $page_heading = "Level 4 Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $customerDetails =  $customer->customer;
        $resellerUpgradation = ResellerCapUncap::where('status','pending')->where('customer_id',$customerDetails->id)->first();
        $package = json_decode($resellerUpgradation->package);
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
        $noc2Approve = ResellerCapUncap::findOrFail($id);
        $noc2Approve->level4_approve = '0';
        $noc2Approve->level3_approve = "1";
        $noc2Approve->save();
        // return redirect()->route('admin_approv.index')->with('success', 'Lead approved successfully!');
        return response()->json(['code' => 200, 'message' => 'Level 4 approved successfully', 'redirect_url' => route('uncap_level4_approv.index')]);
    }
}
