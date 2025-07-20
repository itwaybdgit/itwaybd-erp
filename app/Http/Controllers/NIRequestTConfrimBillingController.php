<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountTransaction;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\BandwidthSaleInvoice;
use App\Models\BandwidthSaleInvoiceDetails;
use App\Models\Business;
use App\Models\Device;
use App\Models\GatewayNoc;
use App\Models\Item;
use App\Models\Pop;
use App\Models\PopConnection;
use App\Models\ResellerDiscontinue;
use App\Models\ResellerDowngradation;
use App\Models\ResellerNIRequest;
use App\Models\ResellerOptimize;
use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NIRequestTConfrimBillingController extends Controller
{
    /**
     * String property
     */

    protected $routeName =  'nirequest_confrim_billing';
    protected $viewName =  'admin.pages.crm.nirequest_confrim_billing';

    protected function getModel()
    {
        return new ResellerNIRequest();
    }
    protected function getBandwidthCustomerModel()
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
//                'relation' => 'customer',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => false,
//                'relation' => 'customer',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => false,
//                'relation' => 'customer',
            ],

            [
                'label' => 'KAM',
                'data' => 'name',
                'searchable' => false,
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

//    public function index()
//    {
//        $page_title = "Customer";
//        $page_heading = "Customer List";
//        $ajax_url = route($this->routeName . '.dataProcessing');
//        $is_show_checkbox = false;
//        $data = $this->getModel()->with('customer')->where('confirm_bill_approve' , 1)->get();
//        $list = ResellerNIRequest::where('confirm_bill_approve' , 1)->select('id', 'package', 'customer_id')->get();
//
////        foreach ($list as $ls) {
////            $bcp = [];
////            foreach ($ls->package->item_id as $ii) {
////                $bcp[] = BandwidthCustomerPackage::where('item_id', $ii)->where('bandwidht_customer_id', $customer->id)->select('id', 'billing_frequency')->first();
////            }
////        }
//
//        $columns = $this->reformatForRelationalColumnName(
//            $this->tableColumnNames()
//        );
//        return view($this->viewName.'.index', get_defined_vars());
//    }


//    public function dataProcessing()
//    {
//        return $this->getDataResponse(
//            //Model Instance
//            $this->getModel()->where('confirm_bill_approve' , 1),
//            //Table Columns Name
//            $this->tableColumnNames(),
//            //Route name
//            $this->routeName,
//
//            true,
//            [
//                [
//                    'method_name' => 'check_validity',
//                    'class' => 'btn-warning btn-sm',
//                    'fontawesome' => 'fa fa-edit',
//                    'text' => '',
//                    'title' => 'Update Data',
//                ],
//                [
//                    'method_name' => 'check_validity',
//                    'class' => 'btn-success btn-sm',
//                    'fontawesome' => 'fa fa-eye',
//                    'text' => '',
//                    'title' => 'Check Validity',
//                ],
//            ]
//        );
//    }

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

        return view($this->viewName.'.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dataProcessing(Request $request)
    {
        $billingMonth = $request->input('billing_month'); // e.g., 2025-07
        $month = $billingMonth ? date('m', strtotime($billingMonth)) : date('m');
        $year = $billingMonth ? date('Y', strtotime($billingMonth)) : date('Y');
        $monthYear = $billingMonth ?: date('Y-m');

        $disconnect = ResellerDiscontinue::where('confirm_bill_approve', 2)->pluck('customer_id');
        $invoice = BandwidthSaleInvoice::where('billing_month', date('F Y'))->pluck('customer_id');

        $query = $this->getBandwidthCustomerModel()
            ->whereNotIn('id', $invoice)
            ->whereNotIn('id', $disconnect)
            ->whereHas('package', function ($q) use ($month, $year, $monthYear) {
                $q->where(function ($sub) use ($month, $year) {
                    $sub->where('billing_frequency', 'monthly')
                        ->whereMonth('payment_date_monthly', $month)
                        ->whereYear('payment_date_monthly', $year);
                })
                    ->orWhere(function ($sub) use ($month, $year) {
                        $sub->where('billing_frequency', 'yearly')
                            ->whereMonth('payment_date_yearly', $month)
                            ->whereYear('payment_date_yearly', $year);
                    })
                    ->orWhere(function ($sub) use ($monthYear) {
                        $sub->where('billing_frequency', 'onetime')
                            ->where(function ($q) use ($monthYear) {
                                $q->whereRaw("
                EXISTS (
                    SELECT 1
                    FROM (
                        SELECT TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(installment_date, ',', numbers.n), ',', -1)) AS date_val
                        FROM (
                            SELECT 1 n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION
                            SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
                        ) numbers
                        WHERE numbers.n <= 1 + LENGTH(installment_date) - LENGTH(REPLACE(installment_date, ',', ''))
                    ) AS parsed_dates
                    WHERE DATE_FORMAT(parsed_dates.date_val, '%Y-%m') = ?
                )
            ", [$monthYear]);
                            });
                    });

            });

        return $this->getDataResponse(
            $query,
            $this->tableColumnNames(),
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
        $page_heading = "Billing Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $billingRemarks = ApprovalRemarks::where('type', 'billing_approve')->where('customer_id', $customer->id)->where('created_by', Auth::user()->id)->get();
        $businesses = Business::all();
        $items = Item::all();
        return view('admin.pages.generate_billing.check_validity',get_defined_vars());
    }

    public function confirm(Request $request, BandwidthCustomer $customer) {
        for($j=0;$j < count($request->item_id); $j++){
            $package['bandwidht_customer_id'] = $customer->id;
            $package['item_id'] = $request->item_id[$j];
            $package['qty'] = $request->qty[$j];
            $package['rate'] = $request->rate[$j];
            $package['vat'] = $request->vat[$j];
            BandwidthCustomerPackage::create($package);
        }

        $purchaseLastData = BandwidthSaleInvoice::latest('id')->pluck('id')->first() ?? "0";
        $invoice_no = 'BS' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);

        $valideted['customer_id'] = $customer->id;
        $valideted['invoice_no'] = $invoice_no;
        $valideted['billing_month'] = date('F Y');
        $valideted['due'] = array_sum($request->total);
        $valideted['total'] = array_sum($request->total);
        $valideted['created_by'] = auth()->id();
        $bandwidthsaleinvoice = BandwidthSaleInvoice::create($valideted);

        // dd($bandwidthsaleinvoice);
        for ($i = 0; $i < count($request->item_id); $i++) {
            $details[] = [
                'bandwidth_sale_invoice_id' => $bandwidthsaleinvoice->id,
                'description' => $request->remarks,
                'item_id' => $request->item_id[$i],
                'qty' => $request->qty[$i],
                'business_id' => $request->business_id[$i],
                'rate' => $request->rate[$i],
                'vat' => $request->vat[$i],
                'from_date' => $request->from_date[$i],
                'to_date' => $request->to_date[$i],
                'total' => $request->total[$i],
            ];
        }

        BandwidthSaleInvoiceDetails::insert($details);
        $invoice = AccountTransaction::accountInvoice();
        $transactionPay['invoice'] = $invoice;
        $transactionPay['table_id'] = $bandwidthsaleinvoice->id;
        $transactionPay['account_id'] = $request->account_id ?? 15;
        $transactionPay['type'] = 5;
        $transactionPay['company_id'] = auth()->user()->company_id;
        $transactionPay['credit'] = array_sum($request->total);
        $transactionPay['remark'] = $request->remark;
        $transactionPay['customer_id'] = $customer->id;
        $transactionPay['created_by'] = Auth::id();
        AccountTransaction::create($transactionPay);

        $transactionPa['invoice'] = $invoice;
        $transactionPa['table_id'] = $bandwidthsaleinvoice->id;
        $transactionPa['account_id'] = 5;
        $transactionPa['type'] = 5;
        $transactionPa['company_id'] = auth()->user()->company_id;
        $transactionPa['debit'] =  array_sum($request->total);
        $transactionPa['remark'] = $request->remark;
        $transactionPa['customer_id'] = $customer->id;
        $transactionPa['created_by'] = Auth::id();
        AccountTransaction::create($transactionPa);
        return redirect()->route('generate_billing.index')->with('success', 'Bill Generate successfully!');
    }

    function updatedata(ResellerNIRequest $optimize) {
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
