<?php

namespace App\Http\Controllers\Admin\BandwidthSale;

use App\Helpers\bandwidthcustomersaleForCustomer;
use App\Http\Controllers\Controller;
use App\Mail\SaleInvoice;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\ApprovalRemarks;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\BandwidthSaleInvoice;
use App\Models\BandwidthSaleInvoiceDetails;
use App\Models\Business;
use App\Models\Company;
use App\Models\Item;
use App\Models\TransactionHistory;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CustomerBandwidthSaleInvoiceController extends Controller
{
    /**
     * String property
     */

    use bandwidthcustomersaleForCustomer;

    protected $routeName =  'bandwidthcustomer.bandwidthsaleinvoice';
    protected $viewName =  'customer.pages.bandwidthsale.bandwidthsaleinvoice';

    protected function getModel()
    {
        return new BandwidthSaleInvoice();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'SN',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Invoice',
                'data' => 'invoice_no',
                'searchable' => true,
            ],
            [
                'label' => 'Company',
                'data' => 'company_name',
                'searchable' => true,
                'relation' => 'customer',
            ],
            [
                'label' => 'Contact Person',
                'data' => 'contact_person_name',
                'searchable' => true,
                'relation' => 'customer',
            ],
            [
                'label' => 'Month',
                'data' => 'billing_month',
                'searchable' => false,
            ],
            [
                'label' => 'Total Amount',
                'data' => 'total',
                'searchable' => false,
            ],
            [
                'label' => 'Received Amount',
                'data' => 'received_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Discount',
                'data' => 'discount',
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

    public function index()
    {
        $page_title = "Invoice";
        $page_heading = "Invoice List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $bandwidthsales = BandwidthSaleInvoice::get();

        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );

        return view($this->viewName . '.index', get_defined_vars());
    }

    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where("customer_id",auth()->guard("bandwidthcustomer")->id()),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'invoice',
                    'class' => 'btn-info  btn-sm',
                    'fontawesome' => '',
                    'text' => 'invoice',
                    'title' => 'invoice',
                ],
                // [
                //     'method_name' => 'edit',
                //     'class' => 'btn-primary  btn-sm',
                //     'fontawesome' => '',
                //     'text' => 'edit',
                //     'title' => 'edit',
                // ],
                // [
                //     'method_name' => 'destroy',
                //     'class' => 'btn-danger  btn-sm',
                //     'fontawesome' => '',
                //     'text' => 'Delete',
                //     'title' => 'Delete',
                // ],
                // [
                //     'method_name' => 'destroy',
                //     'class' => 'btn-danger  btn-sm',
                //     'fontawesome' => '',
                //     'text' => 'Delete',
                //     'title' => 'Delete',
                // ],
            ]
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Invoice Create";
        $page_heading = "Invoice Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = BandwidthCustomer::get();
        $items = Item::where('status', 'active')->get();
        $accounts = Account::getaccount()->where('parent_id', 9)->whereNotIn('id', [10])->get();
        $purchaseLastData = BandwidthSaleInvoice::latest('id')->pluck('id')->first() ?? "0";
        $invoice_no = 'BS' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);
        return view($this->viewName . '.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */

    public function invoice(BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        $page_title = "Invoice Edit";
        $page_heading = "Invoice Edit";
        $back_url = route($this->routeName . '.index');
        $editinfo = $banseidthsaleinvoice;
        $customers = BandwidthCustomer::get();
        $items = Item::where('status', 'active')->get();
        $detals = $banseidthsaleinvoice->detaile->groupBy('business_id');
        $companyInfo = Company::first();
        $business = Business::where('id', $banseidthsaleinvoice->customer->business_id)->first();
        return view($this->viewName . '.invoice', get_defined_vars());
    }


    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */

    function check_validity(BandwidthCustomer $customer) {
        $page_heading = "Billing Approve";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.index');
        $billingRemarks = ApprovalRemarks::where('type', 'billing_approve')->where('customer_id', $customer->id)->where('created_by', Auth::user()->id)->get();
        $businesses = Business::all();
        $items = Item::all();
        return view($this->viewName.'.check_validity',get_defined_vars());
    }

    public function update(Request $request, BandwidthSaleInvoice $banseidthsaleinvoice) {

        AccountTransaction::where('type',5)->where('table_id', $banseidthsaleinvoice->id)->delete();

        $banseidthsaleinvoice->detaile()->delete();

        // $banseidthsaleinvoice->delete();

        $customer = $banseidthsaleinvoice->customer;
        BandwidthCustomerPackage::where("bandwidht_customer_id",$customer->id)->delete();

      for($j=0;$j < count($request->item_id); $j++){
          $package['bandwidht_customer_id'] = $customer->id;
          $package['item_id'] = $request->item_id[$j];
          $package['qty'] = $request->qty[$j];
          $package['rate'] = $request->rate[$j];
          $package['vat'] = $request->vat[$j];
          BandwidthCustomerPackage::create($package);
      }

    //   $purchaseLastData = BandwidthSaleInvoice::latest('id')->pluck('id')->first() ?? "0";
    //   $invoice_no = 'BS' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);

    //   $valideted['customer_id'] = $customer->id;
    //   $valideted['invoice_no'] = $invoice_no;
    //   $valideted['billing_month'] = date('F Y');
      $valideted['due'] = array_sum($request->total);
      $valideted['total'] = array_sum($request->total);
      $valideted['created_by'] = auth()->id();
      $bandwidthsaleinvoice = $banseidthsaleinvoice->update($valideted);

    // dd($bandwidthsaleinvoice);
      for ($i = 0; $i < count($request->item_id); $i++) {
          $details[] = [
              'bandwidth_sale_invoice_id' => $banseidthsaleinvoice->id,
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
      $transactionPay['table_id'] = $banseidthsaleinvoice->id;
      $transactionPay['account_id'] = $request->account_id ?? 0;
      $transactionPay['type'] = 5;
      $transactionPay['company_id'] = auth()->user()->company_id;
      $transactionPay['credit'] = array_sum($request->total);
      $transactionPay['remark'] = $request->remark;
      $transactionPay['customer_id'] = $customer->id;
      $transactionPay['created_by'] = Auth::id();
      AccountTransaction::create($transactionPay);

      $transactionPa['invoice'] = $invoice;
      $transactionPa['table_id'] = $banseidthsaleinvoice->id;
      $transactionPa['account_id'] = 5;
      $transactionPa['type'] = 5;
      $transactionPa['company_id'] = auth()->user()->company_id;
      $transactionPa['debit'] =  array_sum($request->total);
      $transactionPa['remark'] = $request->remark;
      $transactionPa['customer_id'] = $customer->id;
      $transactionPa['created_by'] = Auth::id();
      AccountTransaction::create($transactionPa);
      return redirect()->route('bandwidthsaleinvoice.index')->with('success', 'Bill Generate successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function itemval(Request $request)
    {
        $itels = Item::select('unit', 'vat')->find($request->item_id);
        return response()->json($itels);
    }

    public function destroy(BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        AccountTransaction::where('type',5)->where('table_id', $banseidthsaleinvoice->id)->delete();
        $banseidthsaleinvoice->detaile()->delete();
        $banseidthsaleinvoice->delete();

        return back()->with('success', 'Data deleted successfully.');
    }

    public function getAvailableBalance(Request $request)
    {

        $account = AccountTransaction::where('type', 5)->where('customer_id', $request->customer_id)->whereNotIn('account_id', [5])
            ->selectRaw('SUM(credit) as credit, SUM(debit) as debit')->first();

        return response()->json([
            'amount' => $account->credit - $account->debit,
        ]);
    }

    public function pay()
    {
        $accounts = Account::getaccount()->get();
        $back_url = route($this->routeName . '.index');
        $customers = BandwidthCustomer::get();
        $paymentMethods = Account::whereIn('id', [2, 3, 4])->get();
        $accounts = Account::getaccount()->where('parent_id', 9)->whereNotIn('id', [10,14])->get();
        return view($this->viewName . '.pay', get_defined_vars());
    }

    public function paystore(Request $request)
    {
        // dd($request->all());
        $valideted = $this->validate($request, [
            "date_" => ["required"],
            "amount" => ["nullable"],
            "customer_id" => ["required"],
            "discount" => ["nullable"],
            "payment_method" => ["nullable"],
            "account_id" => ["required"],
            "paid_by" => ["nullable"],
            "description" => ["nullable"],
        ]);

        try {
            DB::beginTransaction();

            $valideted['model_id'] = $request->customer_id;
            $valideted['amount'] = $request->amount ?? 0;
            $pay = TransactionHistory::create($valideted);

            $invoice = AccountTransaction::accountInvoice();
           if($request->amount){
               $transactionAval['invoice'] = $invoice;
               $transactionAval['table_id'] = $pay->id;
               $transactionAval['account_id'] = $request->payment_method;
               $transactionAval['type'] = 5;
               $transactionAval['company_id'] = auth()->user()->company_id;
               $transactionAval['debit'] = $request->amount;
               $transactionAval['remark'] = $request->description . ' Paid By ' . $request->paid_by;
               $transactionAval['customer_id'] = $request->customer_id;
               $transactionAval['created_by'] = Auth::id();
               AccountTransaction::create($transactionAval);
           }

           if($request->discount){
               $transactionAval['invoice'] = $invoice;
               $transactionAval['table_id'] = $pay->id;
               $transactionAval['account_id'] = 14;
               $transactionAval['type'] = 5;
               $transactionAval['company_id'] = auth()->user()->company_id;
               $transactionAval['debit'] = $request->discount;
               $transactionAval['remark'] = $request->description . ' Paid By ' . $request->paid_by;
               $transactionAval['customer_id'] = $request->customer_id;
               $transactionAval['created_by'] = Auth::id();
               AccountTransaction::create($transactionAval);
           }

           if($request->amount){
               $transactionsf['invoice'] = $invoice;
               $transactionsf['table_id'] = $pay->id;
               $transactionsf['account_id'] = 5; //account receivable id;
               $transactionsf['type'] = 5;
               $transactionsf['company_id'] = auth()->user()->company_id;
               $transactionsf['credit'] = $request->amount;
               $transactionsf['remark'] = $request->description . ' Paid By ' . $request->paid_by;
               $transactionsf['customer_id'] = $request->customer_id;
               $transactionsf['created_by'] = Auth::id();
               AccountTransaction::create($transactionsf);
            }



            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
}
