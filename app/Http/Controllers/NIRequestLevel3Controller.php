<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Device;
use App\Models\GatewayNoc;
use App\Models\Pop;
use App\Models\PopConnection;
use App\Models\ResellerDowngradation;
use App\Models\ResellerOptimize;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NIRequestLevel3Controller extends Controller
{
    /**
     * String property
     */

    protected $routeName =  'optimize_tx';
    protected $viewName =  'admin.pages.crm.nirequest_level_3';

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
            $this->getModel()->where('tx_pluning_head_approve' , 1),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,

            true,
            [
                [
                    'method_name' => 'updatedata',
                    'class' => 'btn-warning btn-sm',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'Update Data',
                ],
                [
                    'method_name' => 'check_validity',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => 'fa fa-eye',
                    'text' => '',
                    'title' => 'Check Validity',
                ],
            ]
        );
    }

    function check_validity(ResellerOptimize $optimize) {
        $page_heading = "NOC Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');

        $customer  = $optimize->customer;
        $package = json_decode($optimize->package);
        $routes = Router::all();
        $ports = Pop::all();
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    function updatedata(ResellerOptimize $optimize) {
        $page_heading = "NOC Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $ports = Pop::all();
        $routes = Router::all();
        $customer  = $optimize->customer;
        $devices = Device::all();
        $package = json_decode($optimize->package);
        return view($this->viewName.'.update_data',get_defined_vars());
    }

    public function updatestore(Request $request, $id) {
        $this->validate($request, [
            'bandwidth' => ['nullable'],
            'item' => ['nullable'],
        ]);

           $transmission = GatewayNoc::where('bandwidth_customer_id',$id)->first();
           if(!$transmission){
               $transmission = new GatewayNoc();
           }

           $transmission->bandwidth_customer_id = $id;
           $transmission->item_for_vlan = implode(',',($request->item_id ?? []));
           $transmission->vlan = implode(',',($request->vlan ?? []));
           $transmission->ip = implode(',',($request->ip ?? []));
           $transmission->item_id =  implode(',',($request->item_id_ext ?? []));
           $transmission->remote_asn = implode(',',($request->remote_asn ?? []));
           $transmission->client_asn = implode(',',($request->client_asn ?? []));
           $transmission->ip_lease = implode(',',($request->ip_lease ?? []));
           $transmission->router_id = implode(',',($request->router_id ?? []));
           $transmission->save();

           $popconnection = PopConnection::where('bandwidth_customer_id',$id)->first();
           if(!$popconnection){
               $popconnection = new PopConnection();
           }

           $popconnection->bandwidth_customer_id = $id;
           $popconnection->pop_id = implode(',',($request->pop_id ?? []));
           $popconnection->port = implode(',',($request->port ?? []));
           $popconnection->device_id = implode(',',($request->device_id ?? []));
           $popconnection->device_name = implode(',',($request->device_name ?? []));
           $popconnection->port_type = implode(',',($request->port_type_id ?? []));
            $popconnection->save();

        return redirect()->route($this->routeName.'.index')->with('success', 'Transmission Store successfully!');
    }

    public function approve($id) {
        $nocApprove = ResellerOptimize::findOrFail($id);
        $nocApprove->tx_pluning_head_approve = 2;
        $nocApprove->transmission_head_approve = 1;
        $nocApprove->tx_pluning_head_by = auth()->id();
        $nocApprove->save();
        return response()->json(['code' => 200, 'message' => 'TX planning approved successfully', 'redirect_url' => route('optimize_tx.index')]);
    }
}
