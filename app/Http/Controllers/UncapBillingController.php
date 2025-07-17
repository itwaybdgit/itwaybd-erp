<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\Business;
use App\Models\ResellerCapUncap;
use App\Models\ResellerUpgradation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UncapBillingController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'uncap_billing';
    protected $viewName =  'admin.pages.crm.uncap_billing_approv';

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
            $this->getModel()->where('billing_approve' , 1),
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
        $page_heading = "Billing Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $customerDetails = $customer->customer;
        $businesses = Business::all();
        $resellerUpgradation = ResellerCapUncap::where('status','pending')->where('customer_id',$customerDetails->id)->first();
        $package = json_decode($resellerUpgradation->package);
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function approve(Request $request, $id) {
        $billingApprove = ResellerCapUncap::findOrFail($id);
        $billingApprove->billing_approve = '0';
        $billingApprove->level4_approve = '1';
        $billingApprove->save();
        setNotification("level_4","New level_4 Aprrove Request",route('uncap_level4_approv.index'));

        // $packages = BandwidthCustomerPackage::where('bandwidht_customer_id', $id)->get();
        // $data = [];

        // foreach ($packages as $package) {
        //     $data[] = [
        //         'item' => $package->item_id,
        //         'qty' => $package->qty,
        //         'rate' => $package->rate,
        //         'vat' => $package->vat,
        //     ];
        // }

        // $subTotal = 0;

        // foreach ($data as $item) {
        //     $subTotal += $item['qty'] * $item['rate'] + (($item['qty'] * $item['rate']) * $item['vat'] / 100);
        // }

        // $purchaseLastData = BandwidthSaleInvoice::latest('id')->pluck('id')->first() ?? "0";
        // $invoice_no = 'BS' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);

        // $invoice = new BandwidthSaleInvoice();
        // $invoice->customer_id = $id;
        // $invoice->invoice_no = $invoice_no;
        // $invoice->billing_month = date('F Y');
        // $invoice->due = $subTotal;
        // $invoice->total = $subTotal;
        // $invoice->save();

        // foreach ($data as $item) {
        //     $invoiceDetail = new BandwidthSaleInvoiceDetails();
        //     $invoiceDetail->bandwidth_sale_invoice_id = $invoice->id;
        //     $invoiceDetail->item_id = $item['item'];
        //     $invoiceDetail->qty = $item['qty'];
        //     $invoiceDetail->rate = $item['rate'];
        //     $invoiceDetail->vat = $item['vat'];
        //     $invoiceDetail->total = $item['qty'] * $item['rate'];
        //     $invoiceDetail->save();
        // }

        return response()->json(['code' => 200, 'message' => 'Billing approved successfully', 'redirect_url' => route('uncap_billing.index')]);
    }
}
