<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Device;
use App\Models\GatewayNoc;
use App\Models\Pop;
use App\Models\PopConnection;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptimizeLevel3Controller extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'optimize_level3';
    protected $viewName =  'admin.pages.crm.optimize_level_3';

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
        $page_title = "Level 3";
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
            $this->getModel()->where('level_3_approve' , 1),
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

    function check_validity(ResellerOptimize $optimize) {
        $page_heading = "Level3 Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $noc2Remarks = ApprovalRemarks::where('type', 'noc2_approve')->where('created_by', Auth::user()->id)->get();
        $routes = Router::all();
        $ports = Pop::all();
        $devices  = Device::all();
        $customer = $optimize->customer;
        $package = json_decode($optimize->package);
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function assing_by(Request $request,BandwidthCustomer $customer) {

        $customer->update([
            'assign_to' => $request->assign_to,
            'assign_by' => auth()->user()->id
        ]);

        return redirect()->route('optimize_level3.index')->with('success', 'Assign successfully!');
    }

    public function confirm(ResellerOptimize $optimize) {
        $optimize->update([
            'level_3_approve' => 2,
            'confirm_bill_approve' => 1,
            'level_3_by' => auth()->user()->id
        ]);
        setNotification("billing_department","New confrim-billing Aprrove Request",route('optimize-confrim-billing.index'));


        return redirect()->route('optimize_level3.index')->with('success', 'Assign successfully!');
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
}
