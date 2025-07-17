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
use App\Models\Item;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OptimizePendingBillingController extends Controller
{

    /**
     * String property
     */

    protected $routeName =  'optimize_pending_billing';
    protected $viewName =  'admin.pages.crm.optimize_pending_billing';

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
                'label' => 'Apply Date',
                'data' => 'apply_date',
                'searchable' => false,
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
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->whereDate('apply_date', "<=",date('Y-m-d'))->where('status','pending')->where('pending_status', 1),
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
        $page_heading = "Billing Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $businesses = Business::all();
        $items = Item::all();
        $customerDetail = $optimize->customer;
        $package = json_decode($optimize->package);
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function confirm(Request $request, ResellerOptimize $optimize) {
     try {
     DB::beginTransaction();

     $bandwidthsaleinvoice = BandwidthSaleInvoice::where('customer_id', $optimize->customer_id)->where('billing_month',date('F Y'))->first();

     if($bandwidthsaleinvoice){
         $bandwidthsaleinvoice->due = array_sum($request->total) + array_sum($request->totalnew);
         $bandwidthsaleinvoice->total = array_sum($request->total) + array_sum($request->totalnew);
         $bandwidthsaleinvoice->save();
         $bandwidthsaleinvoice->detaile()->delete();
     }else{
         $purchaseLastData = BandwidthSaleInvoice::latest('id')->pluck('id')->first() ?? "0";
         $invoice_no = 'BS' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);

         $valideted['customer_id'] = $optimize->customer_id;
         $valideted['invoice_no'] = $invoice_no;
         $valideted['billing_month'] = date('F Y');
         $valideted['due'] = array_sum($request->total);
         $valideted['total'] = array_sum($request->total);
         $valideted['created_by'] = auth()->id();
         $bandwidthsaleinvoice = BandwidthSaleInvoice::create($valideted);
     }

    $optimize->update(['status'=> "approve"]);
    // BandwidthCustomerPackage::where('bandwidht_customer_id',$optimize->customer_id)->delete();
    // for ($i = 0; $i < count($request->item_id); $i++) {
    //     BandwidthSaleInvoiceDetails::where('bandwidth_sale_invoice_id',$bandwidthsaleinvoice->id)->where('item_id',$request->item_id[$i])->update([
    //         'from_date' => $request->from_date[$i],
    //         'to_date' => $request->to_date[$i],
    //         'total' => $request->total[$i],
    //     ]);
    // }

    for ($i = 0; $i < count($request->item_id); $i++) {
        $detailsold[] = [
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
    BandwidthSaleInvoiceDetails::insert($detailsold);

    for ($i = 0; $i < count($request->item_idnew); $i++) {
        $details[] = [
            'bandwidth_sale_invoice_id' => $bandwidthsaleinvoice->id,
            'description' => $request->remarks,
            'item_id' => $request->item_idnew[$i],
            'qty' => $request->qtynew[$i],
            'business_id' => $request->business_idnew[$i],
            'rate' => $request->ratenew[$i],
            'vat' => $request->vatnew[$i],
            'from_date' => $request->from_datenew[$i],
            'to_date' => $request->to_datenew[$i],
            'total' => $request->totalnew[$i],
        ];
        $package['qty'] = $request->qtynew[$i];
        $package['rate'] = $request->ratenew[$i];
        $package['vat'] = $request->vatnew[$i];
        BandwidthCustomerPackage::where('bandwidht_customer_id',$optimize->customer_id)->where('item_id',$request->item_idnew[$i])->update($package);
    }
    BandwidthSaleInvoiceDetails::insert($details);

    AccountTransaction::where('type',5)->where('table_id',$bandwidthsaleinvoice->id)->delete();

    $invoice = AccountTransaction::accountInvoice();
    $transactionPay['invoice'] = $invoice;
    $transactionPay['table_id'] = $bandwidthsaleinvoice->id;
    $transactionPay['account_id'] = $request->account_id ?? 0;
    $transactionPay['type'] = 5;
    $transactionPay['company_id'] = auth()->user()->company_id;
    $transactionPay['credit'] = array_sum($request->total) + array_sum($request->totalnew);
    $transactionPay['remark'] = $request->remark;
    $transactionPay['customer_id'] = $optimize->customer_id;
    $transactionPay['created_by'] = Auth::id();
    AccountTransaction::create($transactionPay);

    $transactionPa['invoice'] = $invoice;
    $transactionPa['table_id'] = $bandwidthsaleinvoice->id;
    $transactionPa['account_id'] = 5;
    $transactionPa['type'] = 5;
    $transactionPa['company_id'] = auth()->user()->company_id;
    $transactionPa['debit'] =  array_sum($request->total) + array_sum($request->totalnew);
    $transactionPa['remark'] = $request->remark;
    $transactionPa['customer_id'] = $optimize->customer_id;
    $transactionPa['created_by'] = Auth::id();
    AccountTransaction::create($transactionPa);

    DB::commit();
} catch (\Throwable $th) {
    DB::rollBack();
    dd($th->getMessage(),$th->getLine());
}

    return redirect()->route('upgradtion_pending_billing.index')->with('success', 'Bill Generate successfully!');
    }
}
