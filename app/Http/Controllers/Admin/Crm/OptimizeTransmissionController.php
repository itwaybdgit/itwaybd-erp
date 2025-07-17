<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\GatewayNoc;
use App\Models\Item;
use App\Models\PopConnection;
use App\Models\ResellerOptimize;
use App\Models\Transmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OptimizeTransmissionController extends Controller
{

    /**
     * String property
     */

    protected $routeName =  'optimize_transmission';
    protected $viewName =  'admin.pages.crm.optimize_transmission';

    protected function getModel()
    {
        return new ResellerOptimize();
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
        $page_title = "Transmission";
        $page_heading = "Transmission List";
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
            $this->getModel()->where('transmission_head_approve' , 1),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'dataupdate',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'Check Validity',
                ],
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

    function check_validity(ResellerOptimize $optimize) {
        $page_heading = "Transmission Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $transmission_store_url = route($this->routeName . '.store.transmission',$optimize->id);
        $transmissionRemarks = ApprovalRemarks::where('type', 'transmission_approve')->where('created_by', Auth::user()->id)->get();
        $customer = $optimize->customer;
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    function dataupdate(ResellerOptimize $optimize) {
        $page_heading = "Transmission";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $datastoreurl = route($this->routeName . '.datastore', $optimize->customer->id);
        $transmission_store_url = route($this->routeName . '.store.transmission', $optimize->customer->id);
        $customer = $optimize->customer;
        return view($this->viewName.'.update_data',get_defined_vars());
    }

    function datastore(Request $request,$id) {
        $popconnection = PopConnection::where('bandwidth_customer_id',$id)->first();
        if(!$popconnection){
            $popconnection = new PopConnection();
        }

        $popconnection->rj45 = implode(',',($request->rj45 ?? []));
        $popconnection->customer_sfp = implode(',',($request->customer_sfp ?? []));
        $popconnection->fiber = implode(',',($request->fiber ?? []));
        $popconnection->patched = implode(',',($request->patched ?? []));
        $popconnection->sfp = implode(',',($request->sfp ?? []));
        $popconnection->save();

        return redirect()->route($this->routeName.'.index')->with('success', 'Transmission Store successfully!');
    }


    public function storetransmission(Request $request, $id) {
        $this->validate($request, [
            'bandwidth' => ['nullable'],
            'item' => ['nullable'],
        ]);

        $array = $request->link_id;

        $result = array_filter($array, function($v){
           return trim($v);
        });


        $nocgateway = GatewayNoc::where('bandwidth_customer_id',$id)->first();
        if(!$nocgateway){
            $nocgateway = new GatewayNoc();
        }
        $nocgateway->bandwidth_customer_id = $id;
        $nocgateway->vlan = implode(',',($request->vlan ?? []));
        $nocgateway->save();

        $transmission = Transmission::where('bandwidth_customer_id',$id)->first();
        if(!$transmission){
            $transmission = new Transmission();
        }
        $transmission->bandwidth_customer_id = $id;
        $transmission->link_id =  implode(',',$result);
        $transmission->bandwidth = $request->bandwidth;
        // $transmission->item = implode(',',$request->item_id);
        $transmission->vilan = implode(',',$request->vlan);
        $transmission->save();

        return redirect()->route('optimize_transmission.index')->with('success', 'Transmission Store successfully!');
    }

    public function store(Request $request, $id) {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'type' => 'required',
            'remarks' => 'required',
            'customer_id' => 'required',
            'created_by' => 'required',
        ]);

        $transmissionRemark = new ApprovalRemarks();
        $transmissionRemark->type = 'transmission_approv';
        $transmissionRemark->remarks = $request->remarks;
        $transmissionRemark->customer_id = $id;
        $transmissionRemark->created_by = Auth::user()->id;
        $transmissionRemark->save();

        return redirect()->route('optimize_transmission.index')->with('success', 'Remarks added successfully!');
    }

    public function approve($id) {
        $transmisisonApprove = ResellerOptimize::findOrFail($id);
        $transmisisonApprove->transmission_head_approve = 2;
        $transmisisonApprove->level_3_approve = 1;
        $transmisisonApprove->transmission_head_by = Auth::user()->id;
        $transmisisonApprove->save();
        setNotification("level_3","New level_3 approve Request",route('optimize_level3.index'));

        // return redirect()->route('admin_approv.index')->with('success', 'Lead approved successfully!');
        return response()->json(['code' => 200, 'message' => 'Transmission approved successfully', 'redirect_url' => route('optimize_transmission.index')]);
    }
}
