<?php

namespace App\Http\Controllers\Admin\Crm;

use App\Http\Controllers\Controller;
use App\Models\AccountTransaction;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\BandwidthSaleInvoice;
use App\Models\BandwidthSaleInvoiceDetails;
use App\Models\Business;
use App\Models\Item;
use App\Models\ResellerDiscontinue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenerateBillingApproveController extends Controller
{
    /**
     * String property
     */

    protected $routeName =  'generate_billing';
    protected $viewName =  'admin.pages.generate_billing';

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
                'searchable' => true,
                // 'relation' => 'lead',
            ],
            [
                'label' => 'Owner name',
                'data' => 'company_owner_name',
                'searchable' => true,
                // 'relation' => 'lead',
            ],
            [
                'label' => 'Owner phone',
                'data' => 'company_owner_phone',
                'searchable' => true,
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
        $disconnect = ResellerDiscontinue::where('confirm_bill_approve',2)->pluck('customer_id');

       $invoice = BandwidthSaleInvoice::where('billing_month',date('F Y'))->pluck('customer_id');
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->whereNotIn('id',$invoice)->where('level_confirm','2')->whereNotIn('id',$disconnect),
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
        $page_heading = "Billing Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $billingRemarks = ApprovalRemarks::where('type', 'billing_approve')->where('customer_id', $customer->id)->where('created_by', Auth::user()->id)->get();
        $businesses = Business::all();
        $items = Item::all();
        return view($this->viewName.'.check_validity',get_defined_vars());
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
}
