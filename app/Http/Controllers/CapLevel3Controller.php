<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\Device;
use App\Models\GatewayNoc;
use App\Models\Pop;
use App\Models\PopConnection;
use App\Models\ResellerCapUncap;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CapLevel3Controller extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'cap_level3';
    protected $viewName =  'admin.pages.crm.cap_level_3';

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
            $this->getModel()->where('level3_approve' , '3'),
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
        $page_heading = "Level3 Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $routes = Router::all();
        $ports = Pop::all();
        $devices  = Device::all();
        $customerDetails = $customer->customer;
        $package = json_decode($customer->package);
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function assing_by(Request $request,BandwidthCustomer $customer) {

        $customer->update([
            'assign_to' => $request->assign_to,
            'assign_by' => auth()->user()->id
        ]);

        return redirect()->route('upgradtionlist-level3.index')->with('success', 'Assign successfully!');
    }

    public function confirm(ResellerCapUncap $customer) {
        $customer->update([
            'level3_approve' => 4,
            'status' => "approve",
    ]);

    //    $packages = BandwidthCustomerPackage::where('bandwidht_customer_id', $customer->id)->get();

    //     $data = [];

    //     foreach ($packages as $package) {
    //         $data[] = [
    //             'item' => $package->item_id,
    //             'qty' => $package->qty,
    //             'rate' => $package->rate,
    //             'vat' => $package->vat,
    //         ];
    //     }

    //     $subTotal = 0;

    //     foreach ($data as $item) {
    //         $subTotal += $item['qty'] * $item['rate'] + (($item['qty'] * $item['rate']) * $item['vat'] / 100);
    //     }

    //     $purchaseLastData = BandwidthSaleInvoice::latest('id')->pluck('id')->first() ?? "0";
    //     $invoice_no = 'BS' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);

    //     $invoice = new BandwidthSaleInvoice();
    //     $invoice->customer_id = $customer->id;
    //     $invoice->invoice_no = $invoice_no;
    //     $invoice->billing_month = date('F Y');
    //     $invoice->due = $subTotal;
    //     $invoice->total = $subTotal;
    //     $invoice->save();

    //     foreach ($data as $item) {
    //         $invoiceDetail = new BandwidthSaleInvoiceDetails();
    //         $invoiceDetail->bandwidth_sale_invoice_id = $invoice->id;
    //         $invoiceDetail->item_id = $item['item'];
    //         $invoiceDetail->qty = $item['qty'];
    //         $invoiceDetail->rate = $item['rate'];
    //         $invoiceDetail->vat = $item['vat'];
    //         $invoiceDetail->total = $item['qty'] * $item['rate'];
    //         $invoiceDetail->save();
    //     }
        return redirect()->route('cap_level3.index')->with('success', 'Assign successfully!');
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
